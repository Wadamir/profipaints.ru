document.addEventListener("DOMContentLoaded", function () {
    // When the event DOMContentLoaded occurs, it is safe to access the DOM
    console.log('DOM fully loaded and parsed');
    modalAddLessonEvents();
    modalEvents();
    featureItemsEvents();
    btnSaveLessonEvents();
    btnEditLessonEvents();
    btnRemoveLessonEvents();
    setPhotosEvents();
});

const setPhotosEvents = () => {
    let lessonPhotosWrapper = document.getElementById('lesson_photo__input_wrapper')
    if (lessonPhotosWrapper === undefined || lessonPhotosWrapper === null || lessonPhotosWrapper === '') {
        return false;
    }

    let inputImage = document.getElementById("lesson_photo__input")
    inputImage.addEventListener("change", inputPhoto, false)

    let removeImage = document.getElementsByClassName("lesson-image-remove")
    for (let i = 0, removeImageLength = removeImage.length; i < removeImageLength; i++) {
        let removeImageEl = removeImage[i]
        let mainParent = removeImageEl.parentElement.parentElement.parentElement
        removeImageEl.addEventListener("click", () => {
            let imgId = removeImageEl.dataset.id
            mainParent.remove()
        }, false)
    }
}

const inputPhoto = () => {
    const lessonIdEl = document.getElementById('lessonId'),
        lessonThumbEl = document.getElementById('lessonThumb'),
        lessonThumbIdEl = document.getElementById('lessonThumbId'),
        inputWrapperEl = document.getElementById("lesson_photo__input_wrapper"),
        inputPhotoEl = document.getElementById("lesson_photo__input"),
        photoPreloader = document.getElementById("lesson_photo__preloader"),
        data = new FormData();

    // const inputWrapperHtml = '<div id="lesson_photo__input_wrapper"><label for="lesson_photo__input" id="lesson_photo__input_label" class="lesson-image-input-wrapper cover-image lesson-image-add"><span class="lesson-image-add-text">+ Replace Photo</span><input type="file" class="fm-image-input" aria-label="" id="lesson_photo__input" accept="image/*" multiple="" style="display:none"></label>/div>'

    photoPreloader.style.display = 'flex';
    inputPhotoEl.removeEventListener("change", inputPhoto);

    let lesson_id = lessonIdEl.value;
    let all_files = inputPhotoEl.files;

    // if (lesson_id !== undefined && lesson_id !== null && lesson_id !== '' && lesson_id !== '0' && lesson_id !== 0) {
        if (all_files.length > 0) {
            inputWrapperEl.remove();
            let j = 0;
            for (let i = 0, file; file = all_files[i]; i++) {
                if (file) {
                    let reader = new FileReader();

                    reader.readAsDataURL(file, 'UTF-8');
                    reader.onload = function (e) {

                        data.append('action', 'upload_photo');
                        data.append('lesson_id', lesson_id);
                        data.append('image', reader.result);
                        data.append('image_name', file.name);

                        fetch('/wp-admin/admin-ajax.php', {
                            method: 'POST',
                            body: data
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log('file uploaded', data);
                            if (data.status === 'success' && data.img_src !== undefined && data.img_src !== null && data.img_src !== '' && data.upload_id !== undefined && data.upload_id !== null && data.upload_id !== '') {
                                lessonThumbEl.src = data.img_src;
                                lessonThumbIdEl.value = data.upload_id;
                            }
                        }).catch(function (error) {
                            console.log('file uploading failed!');
                            console.log(error);
                        }).finally(function () {
                            setPhotosEvents();
                            photoPreloader.style.display = 'none';
                            // window.location.reload();
                        });
                    }
                }
            }
        }
    // }
}

const btnEditLessonEvents = () => {
    let editLessonBtns = document.getElementsByClassName('btn-edit');
    for (let i = 0; i < editLessonBtns.length; i++) {
        editLessonBtns[i].addEventListener('click', function (e) {
            e.preventDefault();
            let editLessonBtn = editLessonBtns[i];
            let link = editLessonBtn.getElementsByClassName('elementor-button')[0];
            let href = link.getAttribute('href');
            lessonId = href.replace('#edit-', '');
            editLesson(lessonId);
        });
    }
}

const editLesson = (lessonId) => {
    console.log('edit Lesson' + lessonId);
    let data = new FormData();
    data.append('action', 'get_lesson');
    data.append('lesson_id', lessonId);
    console.log(data);
    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        const modal = document.getElementById('addLesson');
        const modalTitle = document.getElementById('addLessonLabel');
        var myModal = new bootstrap.Modal(modal, {
            keyboard: false
        });
        modalTitle.textContent = 'Edit Lesson';
        myModal.show();
        let lessonIdEl = document.getElementById('lessonId');
        let lessonTitleEl = document.getElementById('lessonTitle');
        let lessonDescriptionEl = document.getElementById('lessonDescription');
        let lessonLanguageEl = document.getElementById('lessonLanguage');
        let lessonStatusEl = document.getElementById('lessonStatus');
        let lessonThumbEl = document.getElementById('lessonThumb');
        lessonIdEl.value = data.lesson_id;
        lessonTitleEl.value = data.lesson_title;
        lessonDescriptionEl.value = data.lesson_content;
        lessonLanguageEl.value = (data.lesson_language !== null) ? data.lesson_language : '';
        lessonStatusEl.checked = data.lesson_status === 'finished' ? true : false;
        lessonThumbEl.src = data.lesson_thumbnail;
    })
    .catch(error => console.error('Error:', error))
}

const btnRemoveLessonEvents = () => {
    let removeLessonBtns = document.getElementsByClassName('btn-remove');
    for (let i = 0; i < removeLessonBtns.length; i++) {
        removeLessonBtns[i].addEventListener('click', function (e) {
            e.preventDefault();
            let removeLessonBtn = removeLessonBtns[i];
            let link = removeLessonBtn.getElementsByClassName('elementor-button')[0];
            let href = link.getAttribute('href');
            lessonId = href.replace('#remove-', '');
            let data = new FormData();
            data.append('action', 'remove_lesson');
            data.append('lesson_id', lessonId);
            fetch ('/wp-admin/admin-ajax.php', {
                method: 'POST',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                console.log('Success:', data);
                if (data.status === 'success') {
                    location.reload();
                }
            })
            .catch(error => console.error('Error:', error))
        });
    }
}

const btnSaveLessonEvents = () => {
    const saveLessonBtn = document.getElementById('save-lesson');
    if (saveLessonBtn) {
        saveLessonBtn.addEventListener('click', function () {
            saveLesson();
        });
    }
}

const saveLesson = () => {
    console.log('save Lesson');
    const   modal = document.getElementById('addLesson'),
            lessonIdEl = document.getElementById('lessonId'),
            lessonThumbIdEl = document.getElementById('lessonThumbId'),
            lessonTitleEl = document.getElementById('lessonTitle'),
            lessonDescriptionEl = document.getElementById('lessonDescription'),
            lessonLanguageEl = document.getElementById('lessonLanguage'),
            lessonStatusEl = document.getElementById('lessonStatus');

    let lessonId = lessonIdEl.value;
    let lessonThumbId = lessonThumbIdEl.value;
    let lessonTitle = lessonTitleEl.value;
    let lessonDescription = lessonDescriptionEl.value;
    let lessonLanguage = lessonLanguageEl.value;
    let lessonStatus = lessonStatusEl.checked ? 'finished' : 'active';
    console.log(lessonStatus);
    let data = new FormData();
    data.append('action', 'save_lesson');
    data.append('lesson_id', lessonId);
    data.append('lesson_thumbnail_id', lessonThumbId);
    data.append('lesson_title', lessonTitle);
    data.append('lesson_description', lessonDescription);
    data.append('lesson_language', lessonLanguage);
    data.append('lesson_status', lessonStatus);
    console.log(data);
    fetch('/wp-admin/admin-ajax.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        console.log('Success:', data);
        if (data.status === 'success') {
            var myModal = new bootstrap.Modal(modal);
            myModal.hide();
        }
    })
    .catch(error => console.error('Error:', error))
    .finally(function () {
        window.location.reload();
    });
}

const modalAddLessonEvents = () => {
    const addLessonBtn = document.getElementById('add_lesson');
    if (addLessonBtn) {
        addLessonBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const modal = document.getElementById('addLesson');
            const modalTitle = document.getElementById('addLessonLabel');
            modalTitle.textContent = 'Add Lesson';
            let lessonIdEl = document.getElementById('lessonId');
            lessonIdEl.value = '';
            let lessonTitleEl = document.getElementById('lessonTitle');
            lessonTitleEl.value = '';
            let lessonDescriptionEl = document.getElementById('lessonDescription');
            lessonDescriptionEl.value = '';
            var myModal = new bootstrap.Modal(modal);
            myModal.show();
        });
    }    
}

const modalEvents = () => {
    var myModalEl = document.getElementById('about-modal')
    // console.log(myModalEl);
    myModalEl.addEventListener('show.bs.modal', function (event) {
        console.log('show.bs.modal');
        const modal_title_el = document.getElementById('modal-title');
        let title = modal_title_el.textContent;
        let opener = document.activeElement;
        let opener_title = opener.getAttribute('data-title');
        if (modal_title_el && opener_title) {
            modal_title_el.textContent = opener_title;
        }
    })
}

const featureItemsEvents = () => {
    const feature_items = document.getElementsByClassName('feature-item');
    for (let i = 0; i < feature_items.length; i++) {
        // feature_items[i].addEventListener('click', function () {
        //     const feature_item = feature_items[i];
        //     const feature_item_content = feature_item.getAttribute('data-target');
        //     const feature_item_content_element = document.getElementById(feature_item_content);
        //     feature_item_content_element.classList.remove('d-none');
        // });
    }
}

var isMobile = {
    Android: function () {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function () {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function () {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function () {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function () {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function () {
        return (
            isMobile.Android() ||
            isMobile.BlackBerry() ||
            isMobile.iOS() ||
            isMobile.Opera() ||
            isMobile.Windows()
        );
    }
};

function preload_images(images, complete_callback) {
    if (profipaints_js_settings.hero_disable_preload) {
        if (complete_callback) {
            complete_callback();
        }
    } else {
        var id = "_img_loading_" + new Date().getTime();
        jQuery("body").append('<div id="' + id + '"></div>');
        jQuery.each(images, function (index, src) {
            var img = jQuery("<img>");
            img.attr("alt", "");
            img.attr("class", "image__preload");
            img.css("display", "none");
            img.attr("src", src);
            jQuery("#" + id).append(img);
        });

        jQuery("#" + id).imagesLoaded(function () {
            if (complete_callback) {
                complete_callback();
            }
            setTimeout(function () {
                jQuery("#" + id).remove();
            }, 5000);
        });
    }
}

function _to_number(string) {
    if (typeof string === "number") {
        return string;
    }
    var n = string.match(/\d+$/);
    if (n) {
        return parseFloat(n[0]);
    } else {
        return 0;
    }
}

function _to_bool(v) {
    if (typeof v === "boolean") {
        return v;
    }

    if (typeof v === "number") {
        return v === 0 ? false : true;
    }

    if (typeof v === "string") {
        if (v === "true" || v === "1") {
            return true;
        } else {
            return false;
        }
    }

    return false;
}

/**
 * skip-link-focus-fix.js
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://github.com/Automattic/ProfiPaints/pull/136
 */
(function () {
    var is_webkit = navigator.userAgent.toLowerCase().indexOf("webkit") > -1,
        is_opera = navigator.userAgent.toLowerCase().indexOf("opera") > -1,
        is_ie = navigator.userAgent.toLowerCase().indexOf("msie") > -1;

    if (
        (is_webkit || is_opera || is_ie) &&
        document.getElementById &&
        window.addEventListener
    ) {
        window.addEventListener(
            "hashchange",
            function () {
                var id = location.hash.substring(1),
                    element;

                if (!/^[A-z0-9_-]+$/.test(id)) {
                    return;
                }

                element = document.getElementById(id);

                if (element) {
                    if (
                        !/^(?:a|select|input|button|textarea)$/i.test(
                            element.tagName
                        )
                    ) {
                        element.tabIndex = -1;
                    }

                    element.focus();
                }
            },
            false
        );
    }
})();

(function () {
    if (isMobile.any()) {
        /**
         * https://css-tricks.com/the-trick-to-viewport-lessons-on-mobile/
         */
        // First we get the viewport height and we multiple it by 1% to get a value for a vh lesson
        let vh = window.innerHeight * 0.01;
        let vw = window.innerWidth * 0.01;
        // Then we set the value in the --vh, --vw custom property to the root of the document
        document.documentElement.style.setProperty("--vh", vh + "px");
        document.documentElement.style.setProperty("--vw", vw + "px");
        window.addEventListener("resize", function () {
            let vh = window.innerHeight * 0.01;
            let vw = window.innerWidth * 0.01;
            document.documentElement.style.setProperty("--vh", vh + "px");
            document.documentElement.style.setProperty("--vw", vw + "px");
        });
    }
})();

/**
 * Sticky header when scroll.
 */
jQuery(document).ready(function ($) {
    var $window = $(window);
    var $document = $(document);

    var getAdminBarHeight = function () {
        var h = 0;
        if ($("#wpadminbar").length) {
            if ($("#wpadminbar").css("position") == "fixed") {
                h = $("#wpadminbar").height();
            }
        }
        return h;
    };

    var stickyHeaders = (function () {
        var $stickies;
        var lastScrollTop = 0;

        var setData = function (stickies, addWrap) {
            var top = 0;

            if (typeof addWrap === "undefined") {
                addWrap = true;
            }
            $stickies = stickies.each(function () {
                var $thisSticky = $(this);
                var p = $thisSticky.parent();
                if (!p.hasClass("followWrap")) {
                    if (addWrap) {
                        $thisSticky.wrap('<div class="followWrap" />');
                    }
                }
                $thisSticky.parent().removeAttr("style");
                // $thisSticky.parent().height($thisSticky.height());
            });
        };

        var load = function (stickies) {
            if (
                typeof stickies === "object" &&
                stickies instanceof jQuery &&
                stickies.length > 0
            ) {
                setData(stickies);
                $window.scroll(function () {
                    _whenScrolling();
                });

                $window.resize(function () {
                    setData(stickies, false);
                    stickies.each(function () {
                        $(this)
                            .removeClass("fixed")
                            .removeAttr("style");
                    });
                    _whenScrolling();
                });

                $document.on("hero_ready", function () {
                    $(".followWrap").removeAttr("style");
                    setTimeout(function () {
                        $(".followWrap").removeAttr("style");
                        setData(stickies, false);
                        _whenScrolling();
                    }, 500);
                });
            }
        };

        var _whenScrolling = function () {
            var top = 0;
            top = getAdminBarHeight();

            var scrollTop = $window.scrollTop();

            $stickies.each(function (i) {
                var $thisSticky = $(this),
                    $stickyPosition = $thisSticky.parent().offset().top;
                if (scrollTop === 0) {
                    $thisSticky.addClass("no-scroll");
                }
                if ($stickyPosition - top <= scrollTop) {
                    if (scrollTop > 50) {
                        $thisSticky.removeClass("no-scroll");
                        $thisSticky.addClass("new-fixed");
                    } else {
                        $thisSticky.removeClass("new-fixed");
                    }
                    $thisSticky.addClass("header-fixed");
                    // $thisSticky.css("top", top);
                } else {
                    $thisSticky
                        .removeClass("header-fixed")
                        .removeClass("new-fixed")
                        .removeAttr("style")
                        .addClass("no-scroll");
                }
            });
        };

        return {
            load: load
        };
    })();
    stickyHeaders.load($("#masthead.is-sticky"));
    // When Header Panel rendered by customizer
    $document.on("header_view_changed", function () {
        stickyHeaders.load($("#masthead.is-sticky"));
    });

    /*
     * Nav Menu & element actions
     *
     * Smooth scroll for navigation and other elements
     */
    var mobile_max_width = 1140; // Media max width for mobile
    var main_navigation = jQuery(".main-navigation .profipaints-menu");
    var site_header = $(".site-header");
    var header = document.getElementById("masthead");
    if (header) {
        var noSticky = header.classList.contains("no-sticky");
    }


    var setNavTop = function () {
        var offset = header.getBoundingClientRect();
        var top = offset.x + offset.height - 1;
        main_navigation.css({
            top: top
        });
    };

    /**
     * Get mobile navigation height.
     *
     * @return number
     */
    var getNavHeight = function (fitWindow) {
        if (typeof fitWindow === "undefined") {
            fitWindow = true;
        }
        if (fitWindow) {
            var offset = header.getBoundingClientRect();
            var h = $(window).height() - (offset.x + offset.height) + 1;
            return h;
        } else {
            main_navigation.css("height", "auto");
            var navOffset = main_navigation[0].getBoundingClientRect();
            main_navigation.css("height", 0);
            return navOffset.height;
        }
    };

    /**
     * Initialise Menu Toggle
     *
     * @since 0.0.1
     * @since 2.2.1
     */
    $document.on("click", "#nav-toggle", function (event) {
        event.preventDefault();
        jQuery("#nav-toggle").toggleClass("nav-is-visible");
        jQuery(".header-widget").toggleClass("header-widget-mobile");
        main_navigation.stop();
        // Open menu mobile.
        if (!main_navigation.hasClass("profipaints-menu-mobile")) {
            main_navigation.addClass("profipaints-menu-mobile");
            $("body").addClass("profipaints-menu-mobile-opening");
            setNavTop();
            var h = getNavHeight(!noSticky);
            if (isNaN(h)) { // when IE 11 & Edge return h is NaN.
                h = $(window).height();
            }
            main_navigation.animate(
                {
                    height: h
                },
                300,
                function () {
                    // Animation complete.
                    if (noSticky) {
                        main_navigation.css({
                            "min-height": h,
                            height: "auto"
                        });
                    }
                }
            );
        } else {
            main_navigation.css({ height: main_navigation.height(), 'min-height': 0, overflow: 'hidden' });
            setTimeout(function () {
                main_navigation.animate(
                    {
                        height: 0
                    },
                    300,
                    function () {
                        main_navigation.removeAttr("style");
                        main_navigation.removeClass("profipaints-menu-mobile");
                        $("body").removeClass("profipaints-menu-mobile-opening");
                    }
                );
            }, 40);
        }
    });

    /**
     * Fix nav height when touch move on mobile.
     *
     * @since 2.2.1
     */
    if (!noSticky && isMobile.any()) {
        $(document).on("scroll", function () {
            if (main_navigation.hasClass("profipaints-menu-mobile")) {
                var newViewportHeight = Math.max(
                    document.documentElement.clientHeight,
                    window.innerHeight || 0
                );
                var offset = header.getBoundingClientRect();
                var top = offset.x + offset.height - 1;
                var h = newViewportHeight - top + 1;
                main_navigation.css({
                    height: h,
                    top: top
                });
            }
        });
    }

    $(window).resize(function () {
        if (
            main_navigation.hasClass("profipaints-menu-mobile") &&
            $(window).width() <= mobile_max_width
        ) {
            if (!noSticky) {
                main_navigation.css({
                    height: getNavHeight(),
                    overflow: "auto"
                });
            }
        } else {
            main_navigation.removeAttr("style");
            main_navigation.removeClass("profipaints-menu-mobile");
            jQuery("#nav-toggle").removeClass("nav-is-visible");
        }
    });

    jQuery(
        ".profipaints-menu li.menu-item-has-children, .profipaints-menu li.page_item_has_children"
    ).each(function () {
        jQuery(this).prepend(
            '<div class="nav-toggle-subarrow"><i class="fa fa-angle-down"></i></div>'
        );
    });

    $document.on(
        "click",
        ".nav-toggle-subarrow, .nav-toggle-subarrow .nav-toggle-subarrow",
        function () {
            jQuery(this)
                .parent()
                .toggleClass("nav-toggle-dropdown");
        }
    );

    // Get the header height and wpadminbar height if enable.
    var h;
    window.current_nav_item = false;
    if (profipaints_js_settings.profipaints_disable_sticky_header != "1") {
        h = jQuery("#wpadminbar").height() + jQuery(".site-header").height();
    } else {
        h = jQuery("#wpadminbar").height();
    }

    // Navigation click to section.
    jQuery('.home #site-navigation li a[href*="#"]').on("click", function (
        event
    ) {
        // console.log('click!!!');
        event.preventDefault();
        // if in mobile mod
        // if (jQuery(".profipaints-menu").hasClass("profipaints-menu-mobile")) {
        jQuery(".menu-btn").trigger("click");
        // }
        smoothScroll(jQuery(this.hash));
    });

    function setNavActive(currentNode) {
        if (currentNode) {
            currentNode = currentNode.replace("#", "");
            if (currentNode)
                jQuery("#site-navigation li").removeClass(
                    "profipaints-current-item"
                );
            if (currentNode) {
                jQuery("#site-navigation li")
                    .find('a[href$="#' + currentNode + '"]')
                    .parent()
                    .addClass("profipaints-current-item");
            }
        }
    }

    function inViewPort($element, offset_top) {
        if (!offset_top) {
            offset_top = 0;
        }
        var view_port_top = jQuery(window).scrollTop();
        if ($("#wpadminbar").length > 0) {
            view_port_top -= $("#wpadminbar").outerHeight() - 1;
            offset_top += $("#wpadminbar").outerHeight() - 1;
        }
        var view_port_h = $("body").outerHeight();

        var el_top = $element.offset().top;
        var eh_h = $element.height();
        var el_bot = el_top + eh_h;
        var view_port_bot = view_port_top + view_port_h;

        var all_height = $("body")[0].scrollHeight;
        var max_top = all_height - view_port_h;

        var in_view_port = false;
        // If scroll maximum
        if (view_port_top >= max_top) {
            if (
                (el_top < view_port_top && el_top > view_port_bot) ||
                (el_top > view_port_top && el_bot < view_port_top)
            ) {
                in_view_port = true;
            }
        } else {
            if (el_top <= view_port_top + offset_top) {
                //if ( eh_bot > view_port_top &&  eh_bot < view_port_bot ) {
                if (el_bot > view_port_top) {
                    in_view_port = true;
                }
            }
        }
        return in_view_port;
    }

    // Add active class to menu when scroll to active section.
    var _scroll_top = $window.scrollTop();
    jQuery(window).scroll(function () {
        var currentNode = null;

        if (!window.current_nav_item) {
            var current_top = $window.scrollTop();

            if (profipaints_js_settings.profipaints_disable_sticky_header != "1") {
                h =
                    jQuery("#wpadminbar").height() +
                    jQuery(".site-header").height();
            } else {
                h = jQuery("#wpadminbar").height();
            }

            if (_scroll_top < current_top) {
                jQuery("section").each(function (index) {
                    var section = jQuery(this);
                    var currentId = section.attr("id") || "";

                    var in_vp = inViewPort(section, h + 10);
                    if (in_vp) {
                        currentNode = currentId;
                    }
                });
            } else {
                var ns = jQuery("section").length;
                for (var i = ns - 1; i >= 0; i--) {
                    var section = jQuery("section").eq(i);
                    var currentId = section.attr("id") || "";
                    var in_vp = inViewPort(section, h + 10);
                    if (in_vp) {
                        currentNode = currentId;
                    }
                }
            }
            _scroll_top = current_top;
        } else {
            currentNode = window.current_nav_item.replace("#", "");
        }

        setNavActive(currentNode);
    });

    // Move to the right section on page load.
    jQuery(window).on("load", function () {
        var urlCurrent = location.hash;
        if (jQuery(urlCurrent).length > 0) {
            smoothScroll(urlCurrent);
        }
    });

    // Other scroll to elements
    jQuery(
        '.scrollto a'
    ).on("click", function (event) {
        console.log(this);
        console.log(jQuery(this.hash));
        document.getElementById('active-menu').checked = false;
        if (profipaints_js_settings.is_home) {
            event.preventDefault();
            smoothScroll(jQuery(this.hash));
        }
    });

    // Other scroll to elements
    jQuery(
        '.hero-slideshow-wrapper a[href*="#"]:not([href="#"]), .parallax-content a[href*="#"]:not([href="#"]), .back-to-top'
    ).on("click", function (event) {
        event.preventDefault();
        smoothScroll(jQuery(this.hash));
    });

    // Smooth scroll animation
    function smoothScroll(element) {
        if (element.length <= 0) {
            return false;
        }
        // console.log(element + '-' + jQuery(element).offset().top);
        jQuery("html, body").animate(
            {
                scrollTop: jQuery(element).offset().top - 70 + "px"
            },
            {
                duration: 300,
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

        // Featured-gallery
        jQuery(document).ready(function () {
            n = 4;
            jQuery(".product-carousel").owlCarousel({
                items: n,
                responsive: {
                    0: {
                        items: 1
                    },
                    // 768: {
                    //     items: n > 2 ? 2 : n
                    // },
                    // 979: {
                    //     items: n > 3 ? 3 : n
                    // }
                },
                margin: 10,
                rtl: is_rtl == 0 ? false : true,
                navSpeed: 800,
                autoplaySpeed: 2000,
                autoplayHoverPause: true,
                nav: false,
                navText: [
                    "<i class='lg-icon'></i>",
                    "<i class='lg-icon'></i>"
                ],
                dots: true
            });
        });

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
// Calculte
jQuery('#calculate').on('submit', function (event) {
    event.preventDefault();
    jQuery('#heat_cost').hide();
    console.log('Calculate click!!!');
    var btn = jQuery('#calculate_btn');
    var btn_text = btn.text();
    btn.text('Загрузка данных');
    btn.addClass('disabled');
    var elements = document.querySelectorAll("#calculate input")
    var parameters = '?';
    var calculation_data = "\n";
    for (var i = 0, element; element = elements[i++];) {
        if (element.closest('.calculate_item') !== null) {
            console.log(element.closest('.calculate_item').getElementsByClassName('counter_title')[0].innerHTML);
            // console.log(element.closest('.calculate_item').getElementsByClassName('counter_title').textContent);
            calculation_data += element.closest('.calculate_item').getElementsByClassName('counter_title')[0].innerHTML;
        } else {
            calculation_data += 'Сумма предварительного расчёта';
        }
        if (element.value === "") {
            // console.log(element.name + " - it's an empty textfield");
            if (element.type === 'checkbox') {
                if (element.checked) {
                    parameters += element.name + "=1&";
                    if (element.closest('.calculate_item') !== null) {
                        calculation_data += ": да; " + "\t\r\n";
                    }
                } else {
                    parameters += element.name + "=0&";
                    if (element.closest('.calculate_item') !== null) {
                        calculation_data += ": нет; " + "\t\r\n";
                    }
                }
            } else {
                parameters += element.name + "=''&";
            }
        } else {
            // console.log(element.name + ' - ' + element.value);
            parameters += element.name + "=" + element.value + '&';
            if (element.closest('.calculate_item') !== null) {
                calculation_data += ': ' + element.value + "; " + "\t\r\n";
            }

        }
    }
    console.log(calculation_data);
    parameters = parameters.substring(0, parameters.length - 1);
    console.log(parameters);
    jQuery.ajax({
        type: "GET",
        crossDomain: true,
        dataType: "json",
        url: 'https://script.google.com/macros/s/AKfycbxWHp9IuFhqEn-nufitiaPUR3ZAHk0Hgu0WZTYrJVxx7nSC1h4sx3qELQPGujgo52Ew/exec' + parameters,
        // data: formData,
        success: function (msg) {
            // jQuery('#calculation_data').val(calculation_data);
            calculation_data += ': ' + msg + "; " + "\t\r\n";
            document.getElementById("calculation_data").setAttribute('value', calculation_data);
            console.log(jQuery('#calculation_data').val());
            btn.text(btn_text);
            btn.removeClass('disabled');
            console.log(msg);
            jQuery('#heat_cost').show();
            jQuery('#heat_cost_text').text(msg);
        }
    });
});