$(document).ready(function() {

    // If page contains form then @attachOnbeforeunloadEvent function will be called
    if ( $(document).find('form').length >= 1 ) {
        attachOnbeforeunloadEvent();
    }

    // Attach the onbeforeunload event on window object
    function attachOnbeforeunloadEvent() {
        $(window).on('beforeunload', function(e) {
            e.preventDefault();
            return 'Are you sure you want to leave?';
        })

        $('form').submit(function() {
            $(window).off('beforeunload');
        });
    }

    if ($('.flash-message').length > 0) {
        $('.flash-message').animate({'top': '12%',  'opacity': '100'}, 1000);

        //var alertStart = setInterval(alertClose, 8000);
        
        function alertClose() {
            $('.flash-message').animate({'top': '-12%', 'opacity': '0'}, '1000', function() {
                $(this).fadeOut();
            });

            clearInterval(alertStart);
        }
    }


    // Plus, minus icons change for collapsible menu
    $(document).on('click', '[data-toggle="collapse"]', function() {
        var id = $(this).data('target');
        $(id).on('hidden.bs.collapse', function () {
            $('i[data-target="'+ id +'"]').animateRotate(360, 'slow', '', function() {
                $('i[data-target="'+ id +'"]').removeClass('fa fa-minus-circle').addClass('fa fa-plus-circle');
            });
            
        });

        $(id).on('shown.bs.collapse', function () {
            $('i[data-target="'+ id +'"]').animateRotate(360, 'slow', '', function() {
                $('i[data-target="'+ id +'"]').removeClass('fa fa-plus-circle').addClass('fa fa-minus-circle');
            });
        });
    });

    // Checks whether side menu has collapsible class or not
    if ( $('#side-menu').hasClass('collapsed-side-menu')) {
        var sidemenuWidth = '0';
        var mainContainerWidth = '100%';

        $('footer').removeClass('ml-20');

        collapseMenu(sidemenuWidth, mainContainerWidth);
    }

    // Get device
    $('#side-menu').attr('data-device', getDevice());
    var device = $('#side-menu').data('device');

    // On mobile and Tablet hide side menu on page load
    if (device == 'Mobile' || device == 'Tablet') {
        $('#side-menu').addClass('collapsed-side-menu');
    }

    $(document).on('click', '.navbar-stack-icon', function() {
        $('#side-menu').toggleClass('collapsed-side-menu');

        if ( $('#side-menu').hasClass('collapsed-side-menu')) {

            if (device == 'Mobile' || device == 'Tablet') {
                var sidemenuWidth = '0';
                var mainContainerWidth = '100%';

                var sidemenuLabelVisibility = true;
            }
            else {
                var sidemenuWidth = '5%';
                var mainContainerWidth = '95%';

                $('footer').removeClass('ml-20');
                var sidemenuLabelVisibility = false;
            }
            
        }
        else {
            $('#side-menu').attr('data-device', getDevice());
            
            device = $('#side-menu').data('device');

            if (device == 'Mobile' || device == 'Tablet') {
                var sidemenuWidth = '100%';
                var mainContainerWidth = '100%';

                var sidemenuLabelVisibility = true;
            }
            else {
                var sidemenuWidth = '15%';
                var mainContainerWidth = '85%';

                $('footer').addClass('ml-20');

                var sidemenuLabelVisibility = true;
            }
        }

        collapseMenu(sidemenuWidth, mainContainerWidth, sidemenuLabelVisibility);
               
    });


    $(document).on('click', '.sample-img-visibility-btn', function() {
        if ($(this).hasClass('btn-success')) {
            $('.sample-image-container').removeClass('hide');
            $(this).text('Hide Sample Images').removeClass('btn-success').addClass('btn-danger');
        }
        else {
            $('.sample-image-container').addClass('hide');
            $(this).text('Show Sample Images').removeClass('btn-danger').addClass('btn-success'); 
        }
    });


    /******  User defined functions area  ******/

    // Make menu as collapsible
    function collapseMenu(sidemenuWidth, mainContainerWidth, sidemenuLabelVisibility) {

        if (!sidemenuLabelVisibility) {
            $('#side-menu .side-menu-label, #side-menu .caret').fadeOut('fast');
            $('.nav .nav-icon').css({'padding-left': '10px'});

            $(document).on('click', '.collapsed-side-menu[data-device="Desktop"] a[data-toggle="collapse"]', function() {
                var dropDownID = $(this).data('target');
                if (!$(dropDownID).hasClass('collapse in')) {
                    $('.nav-collapse-container').not(dropDownID).removeClass('in');
                }
            });
        }
        

        $('#side-menu').animate({
            'width': sidemenuWidth
        }, 'slow', function() {
            if (sidemenuLabelVisibility) {
                $('#side-menu .side-menu-label, #side-menu .caret').fadeIn('Slow');
                $('.nav .nav-icon').css({'padding-left': '0px'});
            }
        });
        $('.main-container').animate({
            'width': mainContainerWidth
        }, 'slow');
    }

    // Get device function
    function getDevice() {
        var deviceWidth = $(window).width() || $(document).width();

        if (deviceWidth >= 1200) 
            return 'Desktop';
        else if (deviceWidth >= 992) 
            return 'Laptop';
        else if (deviceWidth >= 767) 
            return 'Tablet';
        else if (deviceWidth < 767) 
            return 'Mobile';
    }

    // Rotate animation function
    $.fn.animateRotate = function(angle, duration, easing, complete) {
        return this.each(function() {
          var $elem = $(this);
      
          $({deg: 0}).animate({deg: angle}, {
            duration: duration,
            easing: easing,
            step: function(now) {
              $elem.css({
                 transform: 'rotate(' + now + 'deg)'
               });
            },
            complete: complete || $.noop
          });
        });
      };
})