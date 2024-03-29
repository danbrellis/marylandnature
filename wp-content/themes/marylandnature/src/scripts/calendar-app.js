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
  data: function () {
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
        failure: () =>
          (this.notice_msg =
            "Unable to load events, please refresh the page or contact us."),
      },
      eventDetails: {},
      notice_msg: "",
      showEventDetails: false,
      showLoader: false,
      indicatorsInstance: null,
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
        showLoader: this.showLoader,
      },
      //parent: this
    });
    this.indicatorsInstance.$mount(); // pass nothing
    this.$refs.fullCalendar.$el.appendChild(this.indicatorsInstance.$el);

    const filtersComponentClass = Vue.extend(filters);
    const filtersInstance = new filtersComponentClass({
      propsData: {
        filterOptions: this.calArgs.categories,
      },
      parent: this,
    });

    filtersInstance.$mount(); // pass nothing
    filtersInstance.$on("categoryFiltersChanged", (filters) => {
      this.events.extraParams.categories = filters;
    });
    this.$refs.fullCalendar.$el.appendChild(filtersInstance.$el);
  },
  watch: {
    showLoader: function (newValue) {
      this.indicatorsInstance.$props.showLoader = newValue;
    },
    notice_msg: function (newValue) {
      this.indicatorsInstance.$props.noticeMsg = newValue;
    },
  },
  methods: {
    handleEventClick(eventClickInfo) {
      this.eventDetails = eventClickInfo.event;

      let calItem = eventClickInfo.el;

      const calItemBox = calItem.getBoundingClientRect(),
        scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
        scrollTop = window.pageYOffset || document.documentElement.scrollTop;

      const position = {
        top: calItemBox.bottom + scrollTop + "px",
        left: calItemBox.left + scrollLeft + "px",
      };
      this.calItemPosition = position;
      this.showEventDetails = true;
      this.$refs.tooltip.$nextTick(() => {
        let tooltipBox = this.$refs.tooltip.$el.getBoundingClientRect();

        if (
          tooltipBox.bottom >
          (window.innerHeight || document.documentElement.clientHeight)
        ) {
          // Bottom is out of viewport
          // reposition based on the top side of the calItemBox and subtract height of the tooltip box
          position.top = calItemBox.top + scrollTop - tooltipBox.height + "px";
        }

        if (
          tooltipBox.right >
          (window.innerWidth || document.documentElement.clientWidth)
        ) {
          // Right side is out of viewport
          // reposition based on the right side of the calItemBox and subtract width of the tooltip box
          position.left =
            calItemBox.right + scrollLeft - tooltipBox.width + "px";
        }
        this.calItemPosition = position;
      });
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
    },
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
          eventColor="#dddddd"
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
