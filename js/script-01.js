// First we get the viewport height and we multiple it by 1% to get a value for a vh unit
let vh = window.innerHeight * 0.01;
// Then we set the value in the --vh custom property to the root of the document
document.documentElement.style.setProperty('--vh', `${vh}px`);

// // We listen to the resize event
// window.addEventListener('resize', () => {
//     // We execute the same script as before
//     let vh = window.innerHeight * 0.01;
//     document.documentElement.style.setProperty('--vh', `${vh}px`);
//   });




$(document).ready(function() {

// //  click on h3, and change his color to red. 
//     $('h3').click(function() {
//         $(this).css('background-color','#ff0000');
//     })

//     $('.services__box').click(function() {
//         $(this).css('background-color','#ff0000');
//     })

//     // WAYPOINTS EXAMPLE
//     var waypoints = $('services__box').waypoint(function(direction) {
//         notify(this.element.id + ' hit 25% from top of window') 
//     }, {
//      offset: '25%'
//     })


/*For the sticky navigation */
    $('.js--section-services').waypoint(function(direction) {
        if (direction == "down") {
            $('nav').addClass('sticky');
            $('.js--container-nav').removeClass('container__nav-color');
            // $('.js--container-nav').removeClass('hide-mobile');
            $('.js--container-nav').addClass('show-mobile');
        } else {
            $('nav').removeClass('sticky');
            $('.js--container-nav').addClass('container__nav-color');
            $('.js--container-nav').addClass('hide-mobile');
            $('.js--container-nav').removeClass('show-mobile');
        }
    }, { /*para que empiece 80px antes de donde le digo */
        offset: '50px'
       });
/*END Sticky navigation */
/*Animations on Scroll */
    /*SPECIALS*/
    $('.js--wp-3').waypoint(function(direction) {
        $('.js--wp-3').addClass('animated specials__img--animated');
    }, { 
        offset: '90%'
        });  
    /*DISTINCTIONS*/
    $('.js--wp-4').waypoint(function(direction) {
        $('.js--wp-4').addClass('animated distinctions__contentrow--animated');
    }, { 
        offset: '90%'
        });  
    /*SERVICES*/
    $('.js--wp-1').waypoint(function(direction) {
        $('.js--wp-1').addClass('animated fadeIn');
    }, { 
        offset: '60%'
       });
    /*ECO-FRIENDLY*/
    $('.js--wp-2').waypoint(function(direction) {
        $('.js--wp-2').addClass('animated ecofriendly__img--animated');
    }, { 
        offset: '90%'
        });  
/*END Animations on Scroll */
/*Navigation Scroll*/
    // Select all links with hashes
    $('a[href*="#"]')
    // Remove links that don't actually link to anything
    .not('[href="#"]')
    .not('[href="#0"]')
    .click(function(event) {
    // On-page links
    if (
        location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') 
        && 
        location.hostname == this.hostname
    ) {
        // Figure out element to scroll to
        var target = $(this.hash);
        target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
        // Does a scroll target exist?
        if (target.length) {
        // Only prevent default if animation is actually gonna happen
        event.preventDefault();
        $('html, body').animate({
            scrollTop: target.offset().top
        }, 1000, function() {
            // Callback after animation
            // Must change focus!
            var $target = $(target);
            $target.focus();
            if ($target.is(":focus")) { // Checking if the target was focused
            return false;
            } else {
            $target.attr('tabindex','-1'); // Adding tabindex for elements not focusable
            $target.focus(); // Set focus again
            };
        });
        }
    }
    });
/*END Navigation Scroll*/    
/*MOBILE NAVIGATION -- HIDE MENU WHEN CLICK ON ICON*/
// $('.js--nav-icon').click(function() {
//     var nav = $('.js--main-nav');
//     var icon = $('.js--nav-icon svg');

//     nav.slideToggle(200);
//     if (icon.hasClass('js--bars-icon')) {
//         icon.addClass('fas fa-times');
//         icon.addClass('js--times-icon');
//         icon.removeClass('fas fa-bars');
//         icon.removeClass('js--bars-icon');
        
//     } else {
//         icon.addClass('fas fa-bars');
//         icon.addClass('js--bars-icon');
//         icon.removeClass('fas fa-times');
//         icon.removeClass('js--times-icon');
//     }
// })
//  END MOBILE NAVIGATION
    
});