// JavaScript Document

function removeHash () { 
	var scrollV, scrollH, loc = window.location;
	if ("pushState" in history)
		history.pushState("", document.title, loc.pathname + loc.search);
	else {
		// Prevent scrolling by storing the page's current scroll offset
		scrollV = document.body.scrollTop;
		scrollH = document.body.scrollLeft;

		loc.hash = "";

		// Restore the scroll offset, should be flicker free
		document.body.scrollTop = scrollV;
		document.body.scrollLeft = scrollH;
	}
}

(function( $ ) {
	
	"use strict";
	
	//FitText on homepage
	if ($("body").hasClass("home") && $(".collection").length) {
		$(".collection-info .collector").fitText(1.2, { minFontSize: '10px', maxFontSize: '18px' });
		$(".collection-info .collection-title").fitText(1.2, { minFontSize: '14px', maxFontSize: '24px' });
	}
	
	//FitText on pages with .team-card
	if ($(".team-card").length) {
		$('.team-card').each(function(){
			var texp = $(this).find(".team-excerpt p");
			$(this).on('hover', function(){
				texp.css('font-size', Math.max(Math.min(texp.width() / (1.2*10), parseFloat(16)), parseFloat(10)));
			});
				
			texp.fitText(1.2, { minFontSize: '10px', maxFontSize: '16px' });
			
			//console.log(texp.closest('.card-section'), texp.closest('.card-section').outerHeight());
			//texp.css('margin-top', (texp.closest('.card-section').height() - texp.height)/2);
		});
	}
	
	//Motion UI on Homepage
	//Motion UI	console.log(Foundation.Motion.animateOut);
	(function nshm_homepage_mui(){
		
		function animate_scrolling_words(elem){
			var next_elem;
			if(elem.next().length === 1){
				next_elem = elem.next();
			}
			else {
				next_elem = $cont.children(":first");
			}

			if(inViewport($cont)){
				Foundation.Motion.animateOut(elem, 'slideUpAndOut', function() {
					//console.log("'" + elem.text() + "': out");
				});
				Foundation.Motion.animateIn(next_elem, 'slideUpAndIn', function(){
					//console.log("'" + next_elem.text() + "': in");
					setTimeout(function(){
						animate_scrolling_words(next_elem);
					}, 3000);
				});
			}
			else {
				setTimeout(function(){
					animate_scrolling_words(elem);
				}, 3000);
			}
		}

    var $cont = $('.nhsm_scrolling_words');
		
		if($cont.length){
			var cont_width = Math.max.apply(
				Math,
				$cont.children().map(function(){ 
					return $(this).width();
				}).get()
			);
			$cont.width(cont_width);
			//console.log(cont_width);
			$cont.children('li').css('width', cont_width);

			animate_scrolling_words($cont.children(":first"));
		}

	}()); //auto-run
	
	//InViewport Plugin
	//thanks to http://stackoverflow.com/questions/24768795/get-the-visible-height-of-a-div-with-jquery/26831113#26831113
	function inViewport($el) {
    var elH = $el.outerHeight(),
        H   = $(window).height(),
        r   = $el[0].getBoundingClientRect(), t=r.top, b=r.bottom;
    return Math.max(0, t>0? Math.min(elH, H-t) : (b<H?b:H));
	}
	
	//Make map with .so-widget-sow-google-map full width
	var map = $(".so-widget-sow-google-map");
	var windowwidth = $(window).width();
	map.css({
		width: windowwidth,
		marginLeft: -((windowwidth - map.width()) / 2)
	});
	
	
	//set icon width based on height
	function set_icon_width(){
		if($('.nhsm-icon').length) {
			$('.nhsm-icon').each(function(){
				var h = $(this).height();
				$(this).css({width:h, height: h, lineHeight: h+1+"px"});
			});
		}
	}
	set_icon_width();
	window.onresize = function() {
		set_icon_width();
	};
	

})(jQuery);

jQuery( document ).ready( function( $ ) {
	"use strict";
	
	//Add search modal
	if($('.search-handler').length){
		var searchHandler = $('.search-handler a');
		var searchModal = $('#search-modal');
		
		searchHandler.on('click', function(e){
			e.stopPropagation();
			e.preventDefault();
			searchModal.foundation('open');
		});
	}
	
	//Full calendar JS functions
	if($('#events-full-calendar').length){
		var cal = $('#events-full-calendar').fullCalendar('getCalendar');

		cal.on('eventRender', function( event, element, view ) {
			if(event.appendToTitle !== false){
				element.find('.fc-content').after(event.appendToTitle);
			}
		});
		cal.on('eventAfterRender', function(event, element, view) {
			//$(document).foundation();

			//add dropdown pane
			var dropdownPane = '<div class="dropdown-pane top large event-tooltip" id="dropdown'+event.id+'" data-dropdown data-auto-focus="true"><button class="close-button" aria-label="Close event details" type="button"><span aria-hidden="true">&times;</span></button>'+event.tooltip+'</div>';
			$("#events-full-calendar").after( $(dropdownPane) );
			element.attr('data-toggle', 'dropdown'+event.id);
		});
		cal.on('eventAfterAllRender', function(view){
			$(document).foundation();
			
			$('.dropdown-pane .close-button').on('click', function(){
				$(this).closest('.dropdown-pane').foundation('close');
			});
		});

		setTimeout(function() {
			var hash = window.location.hash;
			var data = {
				'action': 'get_event_cat_filters',
				'active': 0,
				'security': nhsm_ajax.cal_security
			};

			//Setup cat filtering dropdown
			$.post(nhsm_ajax.ajax_url, data, function(r) {
				//console.log(r);
				if(r.error) {
					console.log(r.output);
				}
				else {
					$('#events-full-calendar').find('.fc-right').html(r.output);
				}
				$(document).foundation();
				var inputs = $('#event-cat-filter').find('input');
			
				//Refetch events if hash is present and precheck corresponding checkboxes
				if(hash){
					var newSource = nhsm_ajax.ajax_url + '?action=get_events&cats=' + hash.substr(1);
					$('.event-tooltip').remove();
					$('#events-full-calendar').fullCalendar('removeEventSources');
					$('#events-full-calendar').fullCalendar('removeEvents');
					$('#events-full-calendar').fullCalendar('addEventSource', newSource);
					$('#cal-filtered').text('On');

					var toCheck = hash.replace('#', '').split('+');
					inputs.each(function(){
						if($.inArray($(this).attr('id').replace('cat_',''), toCheck) > -1){
							$(this).prop("checked", true);
						}
					});
				}
				
				//Listen for checkboxes to be checked
				inputs.on('change', function(e){

					//gather all checked
					var checked = [];
					inputs.each(function(){
						if($(this).prop('checked')) checked.push($(this).attr('id').replace('cat_',''));
					});
					if(checked.length > 0) {
						$('#cal-filtered').text('On');
						window.location.hash=checked.join('+');
					}
					else {
						$('#cal-filtered').text('Off');
						removeHash();
					}

					var newSource = nhsm_ajax.ajax_url + '?action=get_events&cats=' + checked.join('+');
					$('.event-tooltip').remove();
					$('#events-full-calendar').fullCalendar('removeEventSources');
					$('#events-full-calendar').fullCalendar('removeEvents');
					$('#events-full-calendar').fullCalendar('addEventSource', newSource);
				});
			});


			$('#events-full-calendar').fullCalendar('rerenderEvents');
		});
	}

	//old code (#calendar no longer used, replaced with #events-full-calendar)
	if($('#calendar').length){
		$('#calendar').fullCalendar({
			eventLimit: true,
			header: {
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek,agendaDay,listWeek'
			},
			navLinks: true,
			eventSources: [
				{
					url: fc.endpoint,
					type: 'POST',
					color: '#666666',
					data: {
						start: fc.start,
						end: fc.end,
						cats: fc.cat_ids,
						topics: fc.topics
					},
					error: function() {
						alert('there was an error while fetching events!');
					}
				}
			],
			eventRender: function( event, element, view ) {
				if(event.appendToTitle !== false)
					element.find('.fc-content').after(event.appendToTitle); 
			},
			eventAfterRender: function(event, element, view) {
				//$(document).foundation();

				//add dropdown pane
				var dropdownPane = '<div class="dropdown-pane top large" id="dropdown'+event.id+'" data-dropdown data-auto-focus="true"><button class="close-button" aria-label="Close event details" type="button"><span aria-hidden="true">&times;</span></button>'+event.tooltip+'</div>';
				$("#calendar").after( $(dropdownPane) );
				element.attr('data-toggle', 'dropdown'+event.id);
			},
			eventAfterAllRender: function(view){
				$(document).foundation();
				$('.dropdown-pane .close-button').on('click', function(){
					$(this).closest('.dropdown-pane').foundation('close');
				});
			},
			eventClick: function(calEvent, jsEvent, view) {
				//jsEvent.preventDefault();

			}
		});
	}
	
	//Cross domain iframe height (used for wildapricot widgets)
	if ($(".wildapricotframe").length){
		$('.wildapricotframe').iFrameResize( [{'checkOrigin': false, 'log': true}] );
  }
	
	$('.tabs').on('change.zf.tabs', function() {
		Foundation.reInit('equalizer');
	});
});