/**
 * Herbalist
 * Herbalist – is a website template created for selling the cannabis, medical marijuana and CBD products, cannabis blogging and others
 * Exclusively on https://1.envato.market/herbalist-html
 *
 * @encoding        UTF-8
 * @version         1.0.0
 * @copyright       (C) 2018 - 2024 Merkulove ( https://merkulov.design/ ). All rights reserved.
 * @license         Envato License https://1.envato.market/KYbje
 * @contributors    Lamber Lilit (winter.rituel@gmail.com)
 * @support         help@merkulov.design
 **/
'use strict';

import {initSwiperSlider} from "./modules/slider";

document.addEventListener('DOMContentLoaded', () => {
    initSwiperSlider('.viewed_slider', {
        slidesPerView: 1,
        spaceBetween: 15,
        autoplay: true,
        speed: 1500,
        loop: true,
        breakpoints: {
            576: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            992: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 40,
            }
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },
    })
})