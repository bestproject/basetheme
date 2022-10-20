import 'popper.js';
import * as bootstrap from 'bootstrap';
import './modules/classOnScroll';
import 'swiper';
import 'swiper/css';
import $ from 'jquery';

$(()=>{

    // Add body loaded class used in on-load animations
    $('body').addClass('loaded');

    // Setup tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Menu support
    $('.navbar-nav .nav-link[href^="#"]').click(function(e){

        e.preventDefault();

        let target = $(this).attr('href');
        let $target = $(target);
        let $nav = $('#nav');

        if( $target.length ) {
            $([document.documentElement, document.body]).animate({
                scrollTop: parseInt($target.offset().top) - parseInt($nav.height()) - parseInt($nav.position().top) - 20
            }, 500);
        }
    });
});
