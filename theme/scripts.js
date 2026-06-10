$(function() {



    /*

    	Advanced example - Customized layout

    */

	$('a[data-fancybox="cl-group"]').fancybox({

		baseClass : 'fancybox-custom-layout',
        margin    : 0,
		infobar   : false,
        thumbs    : {
            hideOnClosing : false
        },
        touch : {
            vertical : 'auto'
        },
        closeClickOutside : false,
        // Customize caption area - append an ad to the bottom
        caption : function( instance ) {

            var ad = '<div class="ad"><p><a href="//fancyapps.com/fancybox/">fancyBox3</a> - touch enabled, responsive and fully customizable lightbox script</p></div>';

            return ad + ( $(this).data('caption') || '' );

        }
	});



    /*

    	Advanced example - Morphing modal window


        See demo on CodePen: http://codepen.io/fancyapps/pen/vxLVJE

    */



    var Morphing = function( $btn, opts ) {

        this.opts = opts;

        this._init( $btn );

    };

    Morphing.prototype._init = function( $btn ) {
        var that = this;

        that.$btn = $btn.width( $btn.width() ).addClass('morphing-btn');

        // Add wrapping element and set initial width used for positioning
        $btn.wrap(function() {
            var $wrap = $('<div class="morphing-btn-wrap"></div>');

            $wrap.width( $(this).outerWidth( true ) );

            return $wrap;
        });

        that.$clone = $('<div />')
            .hide()
            .addClass('morphing-btn-clone')
            .insertAfter( $btn );

        $btn.on('click', function(e) {
            e.preventDefault();

            that.open();
        });
    };

    Morphing.prototype.open = function() {
    	var that = this;

    	if ( that.$btn.hasClass('morphing-btn_circle') ) {
    		return;
    	}

    	// First, animate button to the circle
        that.$btn.one("transitionend.fm webkitTransitionEnd.fm oTransitionEnd.fm MSTransitionEnd.fm", function(e) {
            if ( e.originalEvent.propertyName !== 'width' ) {
                return;
            }

            $(this).off(".fm");

            that._animate();
        });

        that.$btn.width( that.$btn.width() ).addClass('morphing-btn_circle');

    };

    Morphing.prototype._animate = function() {
        var that   = this;
        var $btn   = that.$btn;
        var $clone = that.$clone;
        var scale  = this._retrieveScale( $btn );
        var pos    = $btn[0].getBoundingClientRect();

        $clone.css({
            top       : pos.top  + $btn.outerHeight() * 0.5 - ( $btn.outerHeight() * scale * 0.5 ),
            left      : pos.left + $btn.outerWidth()  * 0.5 - ( $btn.outerWidth()  * scale * 0.5 ),
            width     : $btn.outerWidth()  * scale,
            height    : $btn.outerHeight() * scale,
            transform : 'scale(' + 1 / scale + ')'
        });

        $clone.one("transitionend.fm webkitTransitionEnd.fm oTransitionEnd.fm MSTransitionEnd.fm", function(e) {
            $(this).off(".fm");

            // Open fancyBox
            $.fancybox.open({ src : $btn.data('src') || $btn.attr('href') }, $.extend({}, that.opts, {
                infobar  : false,
                buttons  : false,
                smallBtn : false,
                touch    : false,
                onInit : function( instance ) {
                    instance.$refs.slider_wrap.append('<button class="morphing-close" data-fancybox-close>X</button>');
                    instance.$refs.bg.remove();
                },
                afterClose : function() {
                    that.close();
                }
            }));

        });

        // Trigger expanding of the cloned element
        $clone.show().addClass('morphing-btn-clone_visible');

    };

    Morphing.prototype.close = function() {
        var that   = this;
        var $btn   = that.$btn;
        var $clone = that.$clone;
        var scale  = that._retrieveScale( $btn );
        var pos    = $btn[0].getBoundingClientRect();

        $clone.css({
            top       : pos.top  + $btn.outerHeight() * 0.5 -  ( $btn.outerHeight() * scale * 0.5 ),
            left      : pos.left + $btn.outerWidth()  * 0.5  - ( $btn.outerWidth()  * scale * 0.5 ),
            width     : $btn.outerWidth()  * scale,
            height    : $btn.outerHeight() * scale,
            transform : 'scale(' + ( 1 / scale ) + ')'
        });

        $clone.one('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd', function(e) {
            $clone.hide();

            $btn.removeClass('morphing-btn_circle');
        });

        $clone.removeClass('morphing-btn-clone_visible');
    };

    Morphing.prototype._retrieveScale = function( $btn ) {
        var rez = Math.max( $(window).height() * 2 / $btn.height() , $(window).width() * 2 / $btn.width() );

        return rez;
    };

    $.fn.fancyMorph = function( opts ) {
        this.each(function() {
            var $this = $(this);

            if ( !$this.data('morphing') ) {
                $this.data('morphing', new Morphing( $this, opts ));
            }

        });

        return this;
    };

    $("[data-morphing]").fancyMorph({
        hash : 'morphing'
    });




    /*

        Advanced example - Confirm dialog

    */

    // Create reusable method
    function myConfirm( opts ) {

        $.fancybox.open(
             '<div class="my_dialog">' +
                    '<h3>' + opts.title + '</h3>' +
                    '<p>' + opts.message + '</p>' +
                    '<p class="tright">' +
                        '<a data-value="0" data-fancybox-close>Cancel</a>' +
                        '<button data-value="1" data-fancybox-close class="btn">Ok</button>' +
                    '</p>' +
             '</div>', {
                 smallBtn   : false,
                 buttons    : false,
                 keyboard   : false,
                 afterClose : function( instance, current, e ) {
                     var button = e ? e.target || e.currentTarget : null;
                     var value  = button ? $(button).data('value') : 0;

                     opts.callback( value );
                 }
             }
        );

    }


    $("#test_confirm").click(function() {

        // Open customized confirmation dialog window
        myConfirm({
            title    : 'Are you sure?',
            message  : 'By the way, there are many possibilities for modal dialog to appear using CSS transitions.',
            callback : function (value) {
                if (value) {
                    $("#test_confirm_rez").html("Let's do this!");

                } else {
                    $("#test_confirm_rez").html("Maybe later.");
                }
            }
        });

    });


    /*

    	Advanced example - Product quick view

    */

	$(".quick_view").fancybox({
		baseClass	: 'quick-view-container',
		infobar		: false,
		buttons		: false,
		thumbs		: false,
        margin      : 0,
        touch       : {
            vertical : false
        },
        closeClickOutside : false,
		baseTpl : '<div class="fancybox-container" role="dialog">' +
					'<div class="quick-view-content">' +
						'<div class="quick-view-carousel">' +
							'<div class="fancybox-slider-wrap"><ul class="fancybox-slider"></ul></div>' +
						'</div>' +
						'<div class="quick-view-aside"></div>' +
						'<button data-fancybox-close class="quick-view-close">X</button>' +
					'</div>' +
				'</div>',

		onInit : function( instance ) {

            /*

                #1 Create bullet navigation links

            */

            var bullets = '<ul class="quick-view-bullets">';

			for ( var i = 0; i < instance.group.length; i++ ) {
				bullets += '<li><a data-index="' + i + '" href="javascript:;"><span>' + ( i + 1 ) + '</span></a></li>';
			}

			bullets += '</ul>';

			$( bullets ).on('click touchstart', 'a', function() {
					var index = $(this).data('index');

					$.fancybox.getInstance(function() {
						this.jumpTo( index );
					});

				})
				.appendTo( instance.$refs.container.find('.quick-view-carousel') );


            /*

                #2 Add product form

            */

			var $element = instance.group[ instance.currIndex ].opts.$orig;
			var form_id = $element.data('qw-form');

			instance.$refs.container.find('.quick-view-aside').append(

                // In this example, this element contains the form
                $( '#' + form_id ).clone( true ).removeClass('hidden')
            );

        },

        beforeMove : function( instance ) {

            /*
                Set active current navigation link
            */

            instance.$refs.container.find('.quick-view-bullets')
                .children().removeClass('active')
                .eq( instance.currIndex ).addClass('active');

        }

    });


});
