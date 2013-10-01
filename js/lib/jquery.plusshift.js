/*
* jQuery PlusShift 0.2
* By Jamy Golden
* http://css-plus.com
* @jamygolden
*
* Copyright 2011
* Free to use under the MIT license.
* http://www.opensource.org/licenses/mit-license.php
*/
( function( $ ) {

	$.plusShift = function( el, options ) {

		// To avoid scope issues, use 'base' instead of 'this'
		// To reference this class from internal events and functions.
		var base = this;

		// Access to jQuery and DOM versions of element
		base.$el = $( el );
		base.el = el;

		// Add a reverse reference to the DOM object
		base.$el.data('plusShift', base);
		
		base.init = function () {

			// Essential DOM additions
				base.$el.wrap( function() {

					return $('<div />', {
						'class': 'plusshift plusshift-' + base.$el.attr('id')
					});

				});

			////////////////////////////////////////////////// Settings
			base.options = $.extend( {}, $.plusShift.defaults, options );

			base.$wrap			  = base.$el.parent();
			base.$navWrap		   = null;
			base.$navPrev		   = null;
			base.$navNext		   = null;
			base.$slides			= base.$el.children();
			base.currentSlideIndex  = base.options.defaultSlide;
			base.$currentSlide	  = base.$slides.eq( base.currentSlideIndex );
			base.sliderWidth		= 0;
			base.slideCount		 = base.$slides.length;
			base.slideIndexCount	= base.slideCount - 1;
			base.slidePosition	  = null;
			base.sliderPosition	 = null;
			base.slidePositionMax   = null;
			base.animating		  = false;
			base.slideWidth		 = null;

			base.$pagination		= null;
			base.$paginationWrap	= null;
			base.$paginationItems   = null;
			base.paginationThumb	= function( i ) {
			   return base.$slides.eq( i ).attr('data-plusshift-thumbnail') ? true : false;
			}
			base.paginationTitle	= function( i ){
				return base.$slides.eq( i ).attr('data-plusshift-title') ? true : false;
			}

			// Conditional Settings
				//base.options.createControls =false; /*manual override*/
				
				if ( base.options.createControls ) {

					base.$navWrap = $('<ul />', {
						'class': 'plusshift-controls'
					});

					base.$navPrev = $('<li />', {
						'class': 'plusshift-controls-arrow plusshift-controls-prev',
						text: base.options.prevText ? base.options.prevText : 'Previous'
					}).appendTo(base.$navWrap);

					base.$navNext = $('<li />', {
						'class': 'plusshift-controls-arrow plusshift-controls-next',
						text: base.options.nextText ? base.options.nextText : 'Next'
					}).appendTo(base.$navWrap);

				} // base.options.createControls			

			// base.functions
			base.beginTimer = function() {

				base.timer = window.setInterval( function () {
					base.toSlide('next');
				}, base.options.displayTime);

			}; // base.beginTimer

			base.clearTimer = function() {
				
				if ( base.timer) { // If the timer is set, clear it
					window.clearInterval(base.timer);
				};

			}; // base.clearTimer
			
			base.toSlide = function( slide, buttonType ) {

				if ( base.animating == false ) {

					base.animating = true;

					if ( base.options.disableWhiteSpace && buttonType == 'arrow') {

					// Set values
					base.$currentSlide = base.$slides.eq( base.currentSlideIndex );

					// Handle arrow control navigation
						if ( slide === 'next' || slide === '' ) {

							if (base.slidePosition >= base.slidePositionMax) {
								base.slidePosition = 0;
							} else {
								base.slidePosition = parseFloat( base.$el.position().left ) * -1;
								base.slidePosition += base.slideWidth * base.options.arrowJump;
								if ( base.slidePosition > base.slidePositionMax ) base.slidePosition = base.slidePositionMax;
							}

						} else if ( slide === 'prev' ) {

							if (base.slidePosition <= 0) {
								base.slidePosition = base.slidePositionMax;
							} else {
								base.slidePosition = parseFloat( base.$el.position().left ) * -1;
								base.slidePosition -= base.slideWidth * base.options.arrowJump;
								if ( base.slidePosition < 0 ) base.slidePosition = base.slidePositionMax;
							}

						}

					} else { // Normal toSlide() functionality

						if ( slide === 'next' || slide === '' ) {

							base.currentSlideIndex += base.options.arrowJump;
						
						} else if ( slide === 'prev' ) {

							base.currentSlideIndex -= base.options.arrowJump;
						
						} else {

							base.currentSlideIndex = parseInt(slide);
						}

						// Handle possible slide values
						if ( base.currentSlideIndex > base.slideIndexCount ) {

							base.currentSlideIndex = 0;
							if ( base.options.disableLoop ) base.currentSlideIndex = base.slideIndexCount;
						
						} else if ( base.currentSlideIndex < 0 ) {

							base.currentSlideIndex = base.slideIndexCount;
							if ( base.options.disableLoop ) base.currentSlideIndex = 0;
						
						}; // Handle possible slide values

						// Set values
						base.$currentSlide = base.$slides.eq( base.currentSlideIndex );
						base.sliderPosition = parseFloat( base.$el.position().left ) * -1;
						base.slidePosition = base.$currentSlide.position().left;

						// Set slide position values
							if ( base.options.disableWhiteSpace && ( base.slidePosition > base.slidePositionMax ) ){
								base.slidePosition = base.slidePositionMax;
							}
						// Values set

						base.$currentSlide.addClass('plusshift-active').siblings().removeClass('plusshift-active');

						// onSlide callback
						if ( base.options.onSlide && typeof( base.options.onSlide ) == 'function' ) base.options.onSlide( base );
						// End onSlide callback

						if ( base.options.createPagination ) base.$paginationItems.removeClass('plusshift-active').eq( base.currentSlideIndex ).addClass('plusshift-active');

					} // Normal toSlide() functionality

					base.$el.animate({

						left: base.slidePosition * -1 + 'px'
					
					}, base.options.speed, base.options.sliderEasing, function() {

						// Set values
						base.animating = false;
						// Values set

						// afterSlide callback
						if ( base.options.afterSlide && typeof( base.options.afterSlide ) == 'function' ) base.options.afterSlide( base );
						// End afterSlide callback

					});

				} // !animated

				// Clear Timer
				if ( base.options.autoPlay ) {

					base.clearTimer();
					base.beginTimer();

				}; // if base.options.autoPlay 

			} // slide

			////////////////////////////////////////////////// Begin

			// Dom Manipulation
				base.$el.addClass('plusshift-target');
				base.$slides.addClass('plusshift-child').eq( base.options.defaultSlide ).addClass('plusshift-active');

				base.$slides.each( function( i ) {

					if ( i == 0 ) base.sliderWidth = 0; // Reset base.sliderWidth
					base.sliderWidth = base.sliderWidth + $(this).outerWidth(true);

				});

				base.slideWidth		 = base.$slides.eq(0).outerWidth(true);
				base.slidePosition	  = base.$currentSlide.position().left;
				base.slidePositionMax   = base.sliderWidth - base.$wrap.width();

			// Handle dependant options
				if ( base.slideCount === 1 ) {

					base.options.autoPlay = false;
					base.options.createControls = false;
					base.options.createPagination = false;

				}; // base.slideCount === 1

			// Begin pagination
				if ( base.options.createPagination ) {

					base.$pagination = $('<ul />', {

						'class': 'plusshift-pagination'

					}).wrap( 
						$('<div />', {
							'class': 'plusshift-pagination-wrap'
						})
					);

					base.$paginationWrap = base.$pagination.parent('div');

					switch (base.options.paginationPosition) {

						case 'before':
							base.$paginationWrap.addClass( 'plusshift-' + base.$el.attr('id') ).insertBefore( base.$wrap );
							break;

						case 'prepend':
							base.$paginationWrap.prependTo( base.$wrap );
							break;

						case 'append':
							base.$paginationWrap.appendTo( base.$wrap );
							break;

						default: //'after'
							base.$paginationWrap.addClass( 'plusshift-' + base.$el.attr('id') ).insertAfter( base.$wrap );
							break;

					}; // End switch

				// Create Pagination
					for ( var i = 0; i < base.slideCount; i++ ) {

						var thumb = new Image();

						if ( base.paginationThumb( i ) ) {

							if ( base.paginationTitle ) thumb.title =  base.$slides.eq( i ).attr('data-plusshift-title');
							thumb.src =  base.$slides.eq( i ).attr('data-plusshift-thumbnail');

						};

						if ( thumb.src != '' ) { // If thumb exists

							$('<li />', {

								'data-index': i,
								'html': thumb

							}).appendTo(base.$pagination);
														
						} else { // fallback

							$('<li />', {

								'data-index': i,
								text: base.paginationTitle( i ) ? base.$slides.eq( i ).attr('data-plusshift-title') : i + 1

							}).appendTo(base.$pagination);

						} // if thumb.src


					}; // Pagination appended

					base.$paginationItems = base.$pagination.children();
					base.$paginationItems.eq( base.currentSlideIndex ).addClass('plusshift-active');

					// Dynamic pagination width
					if ( base.options.paginationWidth ) base.$pagination.width( base.$pagination.find('li').outerWidth(true) * base.slideCount );

					// Pagination functionality
					base.$pagination.find('li').click( function( ) {

						var $this = $(this), 
							controlIndex = $this.index();

							
						base.toSlide( controlIndex );

					});
					// base.$pagination.find('li').click

				}; // End settings.pagination

				if ( base.options.createControls ) {

					switch (base.options.controlPosition) {

						case 'before':
							base.$navWrap.addClass( 'plusshift-' + base.$el.attr('id') ).insertBefore( base.$wrap );
							break;

						case 'prepend':
							base.$navWrap.prependTo( base.$wrap );
							break;

						case 'append':
							base.$navWrap.appendTo( base.$wrap );
							break;

						default: //'after'
							base.$navWrap.addClass( 'plusshift-' + base.$el.attr('id') ).insertAfter( base.$wrap );
							break;

					}
					
				}

				base.$el.width(base.sliderWidth);

				// onInit callback
				if ( base.options.onInit && typeof( base.options.onInit ) == 'function' ) base.options.onInit( base );
				// End onInit callback

				base.$navNext.click(function() {

					base.toSlide('next', 'arrow');
					
				});

				base.$navPrev.click(function() {

					base.toSlide('prev', 'arrow');
					
				});

				// base.options.autoPlay
				if ( base.options.autoPlay ) {

					// Reset Timer
					base.clearTimer();
					base.beginTimer();

					// Pause on hover
					if ( base.options.pauseOnHover) {

						base.$el.hover( function () {

							base.clearTimer();

						}, function() {

							base.beginTimer();

						}); // base.$el.hover

					}; // base.options.pauseOnHover

				}; // if base.options.autoPlay

		}; // base.init

		// Run initializer
		base.init();

	};

	$.plusShift.defaults = {

		/* General */
		disableLoop : false, // Disables prev or next buttons if they are on the first or last slide respectively. 'first' only disables the previous button, 'last' disables the next and 'both' disables both
		disableWhiteSpace : true,
		
		/* Display related */
		defaultSlide : 0, // Sets the default starting slide - Number based on item index
		displayTime : 8000, // The amount of time the slide waits before automatically moving on to the next one. This requires 'autoPlay: true'
		sliderEasing : 'linear', // Anything other than 'linear' and 'swing' requires the easing plugin
		speed : 500, // The amount of time it takes for a slide to fade into another slide

		/* Functioanlity related */
		autoPlay : false, // Creats a times, looped 'slide-show'
		keyboardNavigation : true, // The keyboard's directional left and right arrows function as next and previous buttons
		pauseOnHover : true, // AutoPlay does not continue ifsomeone hovers over Plus Slider.

		/* Arrow related */
		createControls : true, // Creates forward and backward navigation
		controlPosition : 'after', //Where to insert arrows in relation to the slider ('before', 'prepend', 'append', or 'after')
		nextText : 'Next', // Adds text to the 'next' trigger
		prevText : 'Previous', // Adds text to the 'prev' trigger
		arrowJump : 1,

		/* Pagination related */
		createPagination : false, // Creates Numbered pagination
		paginationPosition : 'after', // Where to insert pagination in relation to the slider element ('before', 'prepend', 'append', or 'after')
		paginationWidth : false, // Automatically gives the pagination a dynamic width

		/* Callbacks */
		onInit : null, // Callback function: On slider initialize
		onSlide : null, // Callback function: As the slide starts to animate
		afterSlide : null // Callback function: As the slide completes the animation

	}; // $.plusShift

	$.fn.plusShift = function(options) {

		return this.each( function () {

			(new $.plusShift(this, options));

		}); // this.each

	}; // $.fn.plusShift

})(jQuery);