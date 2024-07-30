/**
 * Sticky header when scroll.
 */
jQuery(document).ready(function ($) {
    var $window = $(window);
    var $document = $(document);

    // Other scroll to elements
    jQuery(
        '.scrollto a'
    ).on("click", function (event) {
        console.log(this);
        console.log(jQuery(this.hash));
        document.getElementById('active-menu').checked = false;
        event.preventDefault();
        smoothScroll(jQuery(this.hash));
    });

    // Smooth scroll animation
    function smoothScroll(element) {
        if (element.length <= 0) {
            return false;
        }
        console.log(element + '-' + jQuery(element).offset().top);
        jQuery("html, body").animate(
            {
                scrollTop: jQuery(element).offset().top + "px"
            },
            {
                duration: 800,
                easing: "swing",
                complete: function () {
                    window.current_nav_item = false;
                }
            }
        );
    }

    if (profipaints_js_settings.is_home) {
        // custom-logo-link
        jQuery(".site-branding .site-brand-inner").on("click", function (e) {
            e.preventDefault();
            jQuery("html, body").animate(
                {
                    scrollTop: "0px"
                },
                {
                    duration: 300,
                    easing: "swing"
                }
            );
        });
    }

    if (isMobile.any()) {
        jQuery("body")
            .addClass("body-mobile")
            .removeClass("body-desktop");
    } else {
        jQuery("body")
            .addClass("body-desktop")
            .removeClass("body-mobile");
    }

    /**
     * Reveal Animations When Scrolling
     */
    if (profipaints_js_settings.profipaints_disable_animation != "1") {
        var wow = new WOW({
            offset: 50,
            mobile: false,
            live: false
        });
        wow.init();
    }

    var text_rotator = function () {
        /**
         * Text rotator
         */
        jQuery(".js-rotating").Morphext({
            // The [in] animation type. Refer to Animate.css for a list of available animations.
            animation: profipaints_js_settings.hero_animation,
            // An array of phrases to rotate are created based on this separator. Change it if you wish to separate the phrases differently (e.g. So Simple | Very Doge | Much Wow | Such Cool).
            separator: "|",
            // The delay between the changing of each phrase in milliseconds.
            speed: parseInt(profipaints_js_settings.hero_speed),
            complete: function () {
                // Called after the entrance animation is executed.
            }
        });
    };

    text_rotator();

    $document.on("header_view_changed", function () {
        text_rotator();
    });

    /**
     * Responsive Videos
     */
    jQuery(".site-content").fitVids({
        ignore: ".wp-block-embed iframe, .wp-block-embed object"
    });

    /**
     * Video lightbox
     */

    if ($.fn.lightGallery) {
        $(".videolightbox-popup").lightGallery({});
    }

    // Counter Up
    $(".counter").counterUp({
        delay: 10,
        time: 1000
    });

    /**
     * Center vertical align for navigation.
     */
    if (profipaints_js_settings.profipaints_vertical_align_menu == "1") {
        var header_height = jQuery(".site-header").height();
        jQuery(".site-header .profipaints-menu").css(
            "line-height",
            header_height + "px"
        );
    }

    /**
     * Section: Hero Full Screen Slideshow
     */
    function hero_full_screen(no_trigger) {
        if ($(".hero-slideshow-fullscreen").length > 0) {
            var wh = $window.height();
            var top = getAdminBarHeight();
            var $header = jQuery("#masthead");
            var is_transparent = $header.hasClass("is-t");
            var headerH;
            if (is_transparent) {
                headerH = 0;
            } else {
                headerH = $header.height();
            }
            headerH += top;
            jQuery(".hero-slideshow-fullscreen").css(
                "height",
                wh - headerH + 1 + "px"
            );
            if (typeof no_trigger === "undefined" || !no_trigger) {
                $document.trigger("hero_ready");
            }
        }
    }

    $window.on("resize", function () {
        hero_full_screen();
    });
    hero_full_screen();

    $document.on("header_view_changed", function () {
        hero_full_screen();
    });

    $document.on("hero_ready", function () {
        hero_full_screen(true);
    });

    /**
     * Hero sliders
     */
    var heroSliders = function () {
        if ($("#parallax-hero").length <= 0) {
            jQuery(".hero-slideshow-wrapper").each(function () {
                var hero = $(this);
                if (hero.hasClass("video-hero")) {
                    return;
                }
                var images = hero.data("images") || false;
                if (typeof images == "string") {
                    images = jQuery.parseJSON(images);
                }

                if (images) {
                    preload_images(images, function () {
                        hero.backstretch(images, {
                            fade: _to_number(profipaints_js_settings.hero_fade),
                            duration: _to_number(
                                profipaints_js_settings.hero_duration
                            )
                        });
                        //
                        hero.addClass("loaded");
                        hero.removeClass("loading");
                        setTimeout(function () {
                            hero.find(".slider-spinner").remove();
                        }, 600);
                    });
                } else {
                    hero.addClass("loaded");
                    hero.removeClass("loading");
                    hero.find(".slider-spinner").remove();
                }
            });
        }
    };
    heroSliders();

    $document.on("header_view_changed", function () {
        heroSliders();
    });

    $(".section-parallax, .parallax-hero").bind("inview", function (
        event,
        visible
    ) {
        if (visible == true) {
        } else {
        }
    });

    var lastScrollTop = 0;
    // Parallax effect
    function parrallaxHeight() {
        $(".section-parallax ").each(function () {
            var $el = $(this);
            $(".parallax-bg", $el).height("");
            var w = $el.width();
            var h = $el.height();
            if (h <= 0) {
                h = 500;
            }
            h = h * 1.5;
            $(".parallax-bg", $el).height(h);
        });
    }

    function parallaxPosition(direction) {
        var scrollTop = $(window).scrollTop();
        //var top = $( window ).scrollTop();
        var wh = $(window).height();
        var ww = $(window).width();
        $(".section-parallax, .parallax-hero").each(function () {
            var $el = $(this);
            var pl = $(".parallax-bg", $el);

            var w = $el.width();
            var h = $el.height();
            var img = $("img", pl);

            if (img.length) {
                var imageNaturalWidth = img.prop("naturalWidth");
                var imageNaturalHeight = img.prop("naturalHeight");

                var containerHeight = h > 0 ? h : 500;
                var imgHeight = img.height();
                var parallaxDist = imgHeight - containerHeight;
                var top = $el.offset().top;
                var windowHeight = window.innerHeight;
                var windowBottom = scrollTop + windowHeight;
                var percentScrolled =
                    (windowBottom - top) / (containerHeight + windowHeight);

                var parallaxTop = parallaxDist * percentScrolled;
                var l;
                var max_width = imageNaturalWidth;

                if (imageNaturalWidth > w) {
                } else {
                    max_width = ww;
                }

                if (
                    max_width > ww * 2 &&
                    imageNaturalHeight > containerHeight * 2
                ) {
                    max_width = max_width - ww;
                }

                l = (max_width - ww) / 2;
                if (l < 0) {
                    l = 0;
                }

                img.css({
                    top: "-" + parallaxTop + "px",
                    left: "-" + l + "px",
                    //maxWidth: ww+'px'
                    maxWidth: max_width + "px"
                });
            } else {
                //var sh = $el.height();
                var r = 0.3;
                if (wh > w) {
                    r = 0.3;
                } else {
                    r = 0.6;
                }

                $(".parallax-bg", $el).addClass("no-img");

                var is_inview = $el.data("inview");
                if (is_inview) {
                    var offsetTop = $el.offset().top;
                    var diff, bgTop;
                    diff = scrollTop - offsetTop;
                    bgTop = diff * r;
                    $(".parallax-bg", $el).css(
                        "background-position",
                        "50% " + bgTop + "px"
                    );
                }
            }
        });
    }

    $(window).scroll(function (e) {
        var top = $(window).scrollTop();
        var direction = "";
        if (top > lastScrollTop) {
            direction = "down";
        } else {
            direction = "up";
        }
        lastScrollTop = top;
        parallaxPosition();
    });

    parallaxPosition();
    $(window).resize(function () {
        parallaxPosition();
    });

    // Parallax hero
    $(".parallax-hero").each(function () {
        var hero = $(this);
        hero.addClass("loading");

        var bg = true;
        if (hero.find("img").length > 0) {
            bg = false;
        }
        $(".parallax-bg", hero)
            .imagesLoaded({ background: bg }, function () {
                hero.find(".hero-slideshow-wrapper").addClass("loaded");
                hero.removeClass("loading");
                setTimeout(function () {
                    hero.find(".hero-slideshow-wrapper")
                        .find(".slider-spinner")
                        .remove();
                }, 600);
            })
            .fail(function (instance) {
                hero.removeClass("loading");
                hero.find(".hero-slideshow-wrapper").addClass("loaded");
                hero.find(".hero-slideshow-wrapper")
                    .find(".slider-spinner")
                    .remove();
            });
    });

    $(".section-parallax").each(function () {
        var hero = $(this);
        var bg = true;
        if (hero.find("img").length > 0) {
            bg = false;
        }
        $(".parallax-bg", hero)
            .imagesLoaded({ background: bg }, function () { })
            .fail(function (instance) { });
    });

    // Trigger when site load
    setTimeout(function () {
        $(window).trigger("scroll");
    }, 500);

    /**
     * Gallery
     */
    function profipaints_gallery_init($context) {
        // justified
        if ($.fn.justifiedGallery) {
            $(".gallery-justified", $context).imagesLoaded(function () {
                $(".gallery-justified", $context).each(function () {
                    var margin = $(this).attr("data-spacing") || 20;
                    var row_height = $(this).attr("data-row-height") || 120;
                    margin = _to_number(margin);
                    row_height = _to_number(row_height);
                    $(this).justifiedGallery({
                        rowHeight: row_height,
                        margins: margin,
                        selector: "a, div:not(.spinner), .inner"
                    });
                });
            });
        }

        var is_rtl = profipaints_js_settings.is_rtl;

        // Slider
        if ($.fn.owlCarousel) {
            $(".gallery-slider", $context).owlCarousel({
                items: 1,
                itemsCustom: false,
                itemsDesktop: 1,
                itemsDesktopSmall: 1,
                itemsTablet: 1,
                itemsTabletSmall: false,
                itemsMobile: 1,
                singleItem: true,
                itemsScaleUp: false,

                slideSpeed: 200,
                paginationSpeed: 800,
                rewindSpeed: 1000,
                autoPlay: 4000,
                stopOnHover: true,

                nav: true,
                navText: ["<i class='lg-icon'></i>", "<i class='lg-icon'></i>"],

                autoHeight: true,
                rtl: is_rtl == 0 ? false : true,
                dots: false
            });

            $(".gallery-carousel", $context).each(function () {
                var n = $(this).attr("data-col") || 5;
                n = _to_number(n);
                if (n <= 0) {
                    n = 5;
                }

                $(this).owlCarousel({
                    items: n,
                    responsive: {
                        0: {
                            items: 2
                        },
                        768: {
                            items: n > 2 ? 2 : n
                        },
                        979: {
                            items: n > 3 ? 3 : n
                        },
                        1199: {
                            items: n
                        }
                    },
                    rtl: is_rtl == 0 ? false : true,
                    navSpeed: 800,
                    autoplaySpeed: 4000,
                    autoplayHoverPause: true,
                    nav: true,
                    navText: [
                        "<i class='lg-icon'></i>",
                        "<i class='lg-icon'></i>"
                    ],
                    dots: false
                });
            });
        }

        function isotope_init() {
            if ($.fn.isotope) {
                $(".gallery-masonry", $context).each(function () {
                    var m = $(this);
                    var gutter = m.attr("data-gutter") || 10;
                    var columns = m.attr("data-col") || 5;

                    gutter = _to_number(gutter);
                    columns = _to_number(columns);

                    var w = $(window).width();
                    if (w <= 940) {
                        columns = columns > 2 ? columns - 1 : columns;
                    }

                    if (w <= 720) {
                        columns = columns > 3 ? 3 : columns;
                    }

                    if (w <= 576) {
                        columns = columns > 2 ? 2 : columns;
                    }

                    //gutter = gutter / 2;
                    // m.parent().css({'margin-left': -gutter, 'margin-right': -gutter});
                    m.find(".g-item").css({
                        width: 100 / columns + "%",
                        float: "left",
                        padding: 0
                    });
                    // m.find('.g-item .inner').css({'padding': gutter / 2});
                    m.isotope({
                        // options
                        itemSelector: ".g-item",
                        percentPosition: true,
                        masonry: {
                            columnWidth: ".inner"
                        }
                    });
                });
            }
        }
        $(".gallery-masonry", $context).imagesLoaded(function () {
            isotope_init();
        });

        $(window).resize(function () {
            isotope_init();
        });

        if ($.fn.lightGallery) {
            var wrap_tag = $(".enable-lightbox", $context).find('.g-item').first();
            var tag_selector = 'a';
            if (wrap_tag.is('div')) {
                tag_selector = 'div';
            }

            $(".enable-lightbox", $context).lightGallery({
                mode: "lg-fade",
                selector: tag_selector
                //cssEasing : 'cubic-bezier(0.25, 0, 0.25, 1)'
            });
        }
    }

    profipaints_gallery_init($(".gallery-content"));

    if (
        "undefined" !== typeof wp &&
        wp.customize &&
        wp.customize.selectiveRefresh
    ) {
        wp.customize.selectiveRefresh.bind("partial-content-rendered", function (
            placement
        ) {
            if (placement.partial.id == "section-gallery") {
                profipaints_gallery_init(
                    placement.container.find(".gallery-content")
                );

                // Trigger resize to make other sections work.
                $(window).resize();
            }
        });
    }
});
