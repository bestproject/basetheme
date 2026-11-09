import 'popper.js';
import * as bootstrap from 'bootstrap';
import './modules/classOnScroll.js';
import './modules/scrollToSection.js';
import './modules/contactForm7.js';
import 'swiper';
import $ from 'jquery';

$(()=>{

    // Add body loaded class used in on-load animations
    $('body').addClass('loaded');

    // Setup tooltips
    $('[data-bs-toggle="tooltip"]').tooltip();

    // Anchors scrolling
    $(window).scrollToSection(400, 16);

});
