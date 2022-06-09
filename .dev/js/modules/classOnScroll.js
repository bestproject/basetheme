/* 
 * Copyright (C) 2016 Artur Stępień
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

import $ from 'jquery';

/**
 * Changes elements class on scroll
 */
$.fn.classOnScroll = function (distance = 0, scrolledClass = "scrolled") {

    // Check element position
    let checkElement = function () {
        const $element = $(this);

        if ($(window).scrollTop() > distance) {
            $element.addClass(scrolledClass);
        } else {
            $element.removeClass(scrolledClass);
        }
    }

    // Process each element in set
    this.each(function (idx, el) {

        // Check position on load
        let checkOnLoad = $.proxy(checkElement, el);
        checkOnLoad();

        // On scroll check position
        $(window).scroll($.proxy(checkElement, el));
    });

};