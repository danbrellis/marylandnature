//Full calendar JS functions
import "../styles/calendar.scss";

import Vue from "vue/dist/vue.js";
import "@babel/polyfill";
import FullCalendar from "@fullcalendar/vue";
import dayGridPlugin from "@fullcalendar/daygrid";
import calendarIndicators from "./components/calendar-indicators";
import filters from "./components/filters";
import tooltip from "./components/tooltip";

const cal_args = JSON.parse(emCalendarArgs);

new Vue({
  el: "#events-full-calendar",
  data: function() {
    return {
      calendarApi: null,
      calendarPlugins: [dayGridPlugin],
      calArgs: cal_args,
      calItemPosition: {},
      events: {
        url: cal_args.ajax_url + "?action=get_events",
        method: "POST",
        extraParams: {
          security: cal_args.cal_security,
          categories: [],
        },
        failure: () => this.notice_msg = "Unable to load events, please refresh the page or contact us."
      },
      eventDetails: {},
      notice_msg: "",
      showEventDetails: false,
      showLoader: false,
      indicatorsInstance: null
    };
  },
  components: {
    FullCalendar: FullCalendar, // make the <FullCalendar> tag available
    calendarIndicators,
    filters,
    tooltip,
  },
  created() {},
  mounted() {
    //this.calendarApi = this.$refs.fullCalendar.getApi();

    const indicatorsComponentClass = Vue.extend(calendarIndicators);
    this.indicatorsInstance = new indicatorsComponentClass({
      propsData: {
        notice_msg: this.notice_msg,
        showLoader: this.showLoader
      },
      //parent: this
    });
    this.indicatorsInstance.$mount(); // pass nothing
    this.$refs.fullCalendar.$el.appendChild(this.indicatorsInstance.$el);

    const filtersComponentClass = Vue.extend(filters);
    const filtersInstance = new filtersComponentClass({
      propsData: {
        filterOptions: this.calArgs.categories
      },
      parent: this
    });

    filtersInstance.$mount(); // pass nothing
    filtersInstance.$on('categoryFiltersChanged', filters => {
      this.events.extraParams.categories = filters;
    });
    this.$refs.fullCalendar.$el.appendChild(filtersInstance.$el);
  },
  watch: {
   showLoader: function(newValue){
      this.indicatorsInstance.$props.showLoader = newValue;
    },
    notice_msg: function(newValue){
      this.indicatorsInstance.$props.noticeMsg = newValue;
    }
  },
  methods: {
    handleEventClick(eventClickInfo) {
      this.eventDetails = eventClickInfo.event;

      let calItem = eventClickInfo.el;

      const calItemBox = calItem.getBoundingClientRect(),
          scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
          scrollTop = window.pageYOffset || document.documentElement.scrollTop;

      const position = {
        top: (calItemBox.bottom + scrollTop) + 'px',
        left: (calItemBox.left + scrollLeft) + 'px'
      };
      this.calItemPosition = position;
      this.showEventDetails = true;
      this.$refs.tooltip.$nextTick(() => {
        let tooltipBox = this.$refs.tooltip.$el.getBoundingClientRect();

        if (tooltipBox.bottom > (window.innerHeight || document.documentElement.clientHeight)) {
          // Bottom is out of viewport
          // reposition based on the top side of the calItemBox and subtract height of the tooltip box
          position.top = (calItemBox.top + scrollTop - tooltipBox.height) + 'px';
        }

        if (tooltipBox.right > (window.innerWidth || document.documentElement.clientWidth)) {
          // Right side is out of viewport
          // reposition based on the right side of the calItemBox and subtract width of the tooltip box
          position.left = (calItemBox.right + scrollLeft - tooltipBox.width) + 'px';
        }
        this.calItemPosition = position;
      })
    },
    loading(info) {
      this.showLoader = info;
    },
    goToSite(url) {
      window.location.href = url;
    },
    reset() {
      this.notice_msg = "";
      this.showEventDetails = false;
    }
  },
  template: `
    <div>
      
      
      <FullCalendar
          ref="fullCalendar"
          defaultView="dayGridMonth" 
          :plugins="calendarPlugins"
          :custom-buttons="{
              agendaview: {
                  text: 'List View',
                  click: () => this.goToSite(calArgs.agenda_url)
              }
          }"
          :default-date="calArgs.defaultDate"
          :editable="false"
          @eventClick="handleEventClick"
          :events="events"
          eventColor="transparent"
          eventTextColor="inherit"
          :eventTimeFormat="{
              hour: 'numeric',
              minute: '2-digit',
              omitZeroMinute: true,
              meridiem: 'short'
          }"
          :first-day="calArgs.firstWeekDay"
          :fixed-week-count="false"
          :header="calArgs.header"
          @loading="loading"
          @datesRender="reset"
      />
      <tooltip 
          ref="tooltip"
          :e="eventDetails" 
          :showTooltip="showEventDetails"
          :tooltip-style="calItemPosition"
          @closeTip="showEventDetails = false"
      />
    </div>
  `,
});

/*
jQuery(document).ready(function ($) {
  var calCont = $("#events-full-calendar");
  if (calCont.length) {
    var cal = calCont.fullCalendar("getCalendar");
    var view = calCont.find(".fc-view-container");

    cal.on("eventRender", function (event, element, view) {
      if (event.appendToTitle !== false) {
        element.find(".fc-content").after(event.appendToTitle);
      }
      element.attr("title", event.title);
    });
    cal.on("eventAfterRender", function (event, element, view) {
      //$(document).foundation();
      const ider = "dropdown" + event.id + "_" + event.start.format("X");

      //add dropdown pane
      var dropdownPane =
        '<div class="dropdown-pane top large event-tooltip" id="' +
        ider +
        '" data-dropdown data-auto-focus="true"><button class="close-button" aria-label="Close event details" type="button"><span aria-hidden="true">&times;</span></button>' +
        event.tooltip +
        "</div>";
      $("#events-full-calendar").after($(dropdownPane));
      element.attr("data-toggle", ider); //@todo use event_id + occurance
    });
    cal.on("eventAfterAllRender", function (view) {
      $(document).foundation();

      $(".dropdown-pane .close-button").on("click", function () {
        $(this).closest(".dropdown-pane").foundation("close");
      });
    });

    $(".fc-agendaview-button").on("click", function () {
      window.location.href = nhsm_ajax.agenda_url;
    });

    $(".fc-center .fc-button").on("click", function () {
      var newPath;
      var hash = window.location.hash;
      var m = calCont.fullCalendar("getDate");
      var pathname = window.location.pathname;
      var vars = pathname.split("/");
      newPath = "/" + vars[1] + "/" + vars[2] + "/" + m.format("YYYY[/]MM[/]");
      if (hash) newPath = newPath + hash;
      window.history.pushState(null, null, newPath);
    });

    setTimeout(function () {
      var hash = window.location.hash;
      var data = {
        action: "get_event_cat_filters",
        active: 0,
        security: nhsm_ajax.cal_security,
      };

      //Setup cat filtering dropdown
      $.post(nhsm_ajax.ajax_url, data, function (r) {
        //console.log(r);
        if (r.error) {
          console.log(r.output);
        } else {
          calCont.find(".fc-right").html(r.output);
        }
        $(document).foundation();
        var inputs = $("#event-cat-filter").find("input");

        //Refetch events if hash is present and precheck corresponding checkboxes
        //@todo work this into the PHP request on load so we don't have to refetch events
        if (hash) {
          view.addClass("loading");
          var newSource =
            nhsm_ajax.ajax_url + "?action=get_events&cats=" + hash.substr(1);
          $(".event-tooltip").remove();
          calCont.fullCalendar("removeEventSources");
          calCont.fullCalendar("removeEvents");
          calCont.fullCalendar("addEventSource", newSource);

          var toCheck = hash.replace("#", "").split("+");
          inputs.each(function () {
            if (
              $.inArray($(this).attr("id").replace("cat_", ""), toCheck) > -1
            ) {
              $(this).prop("checked", true);
            }
          });
        }

        //Listen for checkboxes to be checked
        inputs.on("change", function (e) {
          view.addClass("loading");

          //gather all checked
          var checked = [];
          inputs.each(function () {
            if ($(this).prop("checked"))
              checked.push($(this).attr("id").replace("cat_", ""));
          });
          if (checked.length > 0) {
            window.location.hash = checked.join("+");
          } else {
            removeHash();
          }

          var newSource =
            nhsm_ajax.ajax_url + "?action=get_events&cats=" + checked.join("+");
          $(".event-tooltip").remove();
          calCont.fullCalendar("removeEventSources");
          calCont.fullCalendar("removeEvents");
          calCont.fullCalendar("addEventSource", newSource);
        });
      });

      calCont.fullCalendar("rerenderEvents");
    });

    $(".fc-day-header span").each(function () {
      var day = $(this).html();
      var letters = day.split("");
      letters.splice(3, 0, '<span class="show-for-large">');
      letters.push("</span>");
      $(this).html(letters.join(""));
    });

    cal.on("eventsReceived", function () {
      view.removeClass("loading");
    });
  }
});
*/
