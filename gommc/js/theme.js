"use strict";

is_visible_init();
gommc_slick_navigation_init();

jQuery(document).ready(function($) {
    gommc_sticky_init();
    gommc_search_init();
    gommc_side_panel_init();
    gommc_mobile_header();
    gommc_woocommerce_helper();
    gommc_woocommerce_login_in();
    gommc_init_timeline_appear();
    gommc_accordion_init();
    gommc_services_accordion_init();
    gommc_progress_bars_init();
    gommc_carousel_slick();
    gommc_image_comparison();
    gommc_counter_init();
    gommc_countdown_init();
    gommc_img_layers();
    gommc_page_title_parallax();
    gommc_extended_parallax();
    gommc_portfolio_parallax();
    gommc_message_anim_init();
    gommc_scroll_up();
    gommc_link_scroll();
    gommc_skrollr_init();
    gommc_sticky_sidebar();
    gommc_videobox_init();
    gommc_parallax_video();
    gommc_tabs_init();
    gommc_circuit_service();
    gommc_select_wrap();
    jQuery( '.tpc_module_title .carousel_arrows' ).gommc_slick_navigation();
    jQuery( '.tpc-filter_wrapper .carousel_arrows' ).gommc_slick_navigation();
    jQuery( '.tpc-products > .carousel_arrows' ).gommc_slick_navigation();
    jQuery( '.gommc_module_custom_image_cats > .carousel_arrows' ).gommc_slick_navigation();
    gommc_scroll_animation();
    gommc_woocommerce_mini_cart();
    gommc_text_background();
    gommc_dynamic_styles();
});

jQuery(window).load(function () {
    gommc_images_gallery();
    gommc_isotope();
    gommc_blog_masonry_init();
    setTimeout(function(){
        jQuery('#preloader-wrapper').fadeOut();
    },1100);

    gommc_particles_custom();
    gommc_particles_image_custom();
    gommc_menu_lavalamp();
    jQuery(".tpc-currency-stripe_scrolling").each(function(){
        jQuery(this).simplemarquee({
            speed: 40,
            space: 0,
            handleHover: true,
            handleResize: true
        });
    })
});





(function($) {
    "use strict";


//===== Global LMS course filter 
    $(document).on('change', '.gommc-course-filter-form', function(e) {
        e.preventDefault();
        $(this).closest('form').submit();
    });
    $('.gommc-pagination ul li a.prev, .gommc-pagination ul li a.next').closest('li').addClass('pagination-parent');
    // category menu
    $('.header-cat-menu ul.children').closest('li.cat-item').addClass('category-has-childern');
    $(".gommc-archive-single-cat .category-toggle").on('click', function() {
        $(this).next('.gommc-archive-childern').slideToggle();
        if ($(this).hasClass('fa-plus')) {
            $(this).removeClass('fa-plus').addClass('fa-minus');
        } else {
            $(this).removeClass('fa-minus').addClass('fa-plus');
        }
    });
    $('.gommc-archive-childern input').each(function() {
        if ($(this).is(':checked')) {
            var aChild = $(this).closest('.gommc-archive-childern');
            aChild.show();
            aChild.siblings('.fa').removeClass('fa-plus').addClass('fa-minus');
        }
    });
    $('.gommc-sidebar-filter input').on('change', function() {
        $('.gommc-sidebar-filter').submit();
    });


    //===== Grid view/List view
    $(function() {
        $('#gommc_showdiv1').click(function() {
            $('div[id^=gommcdiv]').hide();
            $('#gommcdiv1').show();
        });
        $('#gommc_showdiv2').click(function() {
            $('div[id^=gommcdiv]').hide();
            $('#gommcdiv2').show();
        });
    })


// ======= Filter top show/hide

// Handler that uses various data-* attributes to trigger
// specific actions, mimicing bootstraps attributes
const triggers = Array.from(document.querySelectorAll('[data-toggle="collapse"]'));

window.addEventListener('click', (ev) => {
  const elm = ev.target;
  if (triggers.includes(elm)) {
    const selector = elm.getAttribute('data-target');
    collapse(selector, 'toggle');
  }
}, false);

const fnmap = {
  'toggle': 'toggle',
  'show': 'add',
  'hide': 'remove'
};
const collapse = (selector, cmd) => {
  const targets = Array.from(document.querySelectorAll(selector));
  targets.forEach(target => {
    target.classList[fnmap[cmd]]('show');
  });
}



$(document).ready(function() {
// Swiper: Slider
    new Swiper('.my_active_classs', {
        loop: true,
        slidesPerView: 3,
       // paginationClickable: true,
        spaceBetween: 20,
          pagination: {
            el: ".swiper-pagination",
            clickable: true
          },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev"
        },
        breakpoints: {
            1920: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            1028: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            480: {
                slidesPerView: 1,
                spaceBetween: 10
            }
        }
    });
});

// // ======= AOS.init();
// $( document ).ready(function() {
//     AOS.init({
//         duration: 1200,
//         once: true,
//     });
// });

})(jQuery);
