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
 * Scroll to section if link starts with #
 */
$.fn.scrollToSection = function (speed = 700, defaultOffset = 16) {
    const $elements = $('a[href*="#"]');
    const [currentUrl, currentHash] = window.location.toString().split('#', 2);
    const $adminbar = $('#wpadminbar');
    const offset = 0 + ($adminbar.length ? $adminbar.outerHeight() : 0) + defaultOffset; // Add height of any sticky elements

    console.log('scrollToSection.window.location:', currentUrl, currentHash);
    console.log('scrollToSection.offset:', offset);

    for (let i = 0, ic = $elements.length; i < ic; i++) {

        $($elements[i]).click(function (e) {
            let [url, hash] = $($elements[i]).attr('href').split('#', 2);
            let $target = $('#'+hash);

            // Prepare link URL
            if( url.charAt(0) === '/' || url.charAt(0) === '#' || url.length === 0 ) {
                url = currentUrl;
            }

            if( url !== currentUrl || hash.length < 1 || !$target.length ) {
                return;
            }

            console.log('scrollToSection.clickedLink.location:', url, hash);

            e.preventDefault();

            $('html,body').animate({
                scrollTop: $target.offset().top - offset
            }, speed);
        });
    }

};