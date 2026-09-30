(function ($) {
    "use strict";

    // data color
    $("[data-color]").each(function () {
        $(this).css("color", $(this).attr("data-color"))
    })

    // data bg img
    $("[data-bg-img]").each(function () {
        $(this).css("background-image", "url(" + $(this).attr("data-bg-img") + ")")
    })

    // data border color
    $("[data-border-color]").each(function () {
        $(this).css("border-color", $(this).attr("data-border-color"))
    })

    // data bg color
    $("[data-bg-color]").each(function () {
        $(this).css("background-color", $(this).attr("data-bg-color"))
    })

    // header-menu
    $(".tp-header-menu-icon").on('click', function () {
        $(".tp-sidebar-overlay").addClass("tp-sidebar-overlay-open");
    });
    $(".tp-sidebar-overlay").on('click', function () {
        $(".tp-sidebar-overlay").removeClass("tp-sidebar-overlay-open");
        $(".tp-sidebar-area").removeClass("tp-sidebar-area-open"); // sidebar hide
    });



    //mobile-menu
    let tpMenuHTML = $('.tp-mobile-menu-active > ul').clone();
    let tpOffcanvasMenu = $('.tp-offcanvas-menu > nav');
    tpOffcanvasMenu.append(tpMenuHTML);

    tpOffcanvasMenu.find('li').each(function () {
        if ($(this).find('.rs-hero-dropdown__menu').length) {
            $(this).addClass('has-dropdown');
            $(this).append('<button class="tp-sidemenu-close"><i class="fas fa-chevron-right"></i></button>');
        }
    });

    tpOffcanvasMenu.on('click', 'li.has-dropdown > a, li.has-dropdown > button.tp-sidemenu-close', function (e) {
        e.preventDefault();
        let parentLi = $(this).closest('li');
        let subMenu = parentLi.children('.rs-hero-dropdown__menu');

        if (parentLi.hasClass('active')) {
            subMenu.slideUp();
            parentLi.removeClass('active');
        } else {
            parentLi.siblings('.active').removeClass('active').children('.rs-hero-dropdown__menu').slideUp();
            parentLi.addClass('active');
            subMenu.slideDown();
        }
    });


    //offcanvas
    $(".rs-offcanvas-btn").on('click', function () {
        $(".tp-offcanvas-area").addClass("tp-offcanvas-area-open");
        $(".tp-offcanvas-overlay").addClass("tp-offcanvas-overlay-open");
    });
    $(".tp-offcanvas-close,.tp-offcanvas-overlay").on('click', function () {
        $(".tp-offcanvas-area").removeClass("tp-offcanvas-area-open");
        $(".tp-offcanvas-overlay").removeClass("tp-offcanvas-overlay-open");
    });


    // Toggle dropdown on click
    $(".tp-header-lang").on("click", function (e) {
        e.stopPropagation();
        $(this).toggleClass("tp-header-lang-open");
    });
    $(document).on("click", function () {
        $(".tp-header-lang").removeClass("tp-header-lang-open");
    });

    // Author dropdown toggle
    $(".tp-header-author").on("click", function (e) {
        e.stopPropagation();
        $(this).toggleClass("tp-header-author-open");
    });

    $(document).on("click", function () {
        $(".tp-header-lang, .tp-header-author").removeClass("tp-header-lang-open tp-header-author-open");
    });

    $(document).on("click", ".tp-dropdown-toggle", function () {
        $(".tp-deashboard-form-open").removeClass("tp-deashboard-form-open");
    });

    $(document).on("click", ".tp-deashboard-form-icon", function () {
        $(".tp-dropdown-toggle").removeClass("active");
    });
    $(document).on("click", ".tp-deashboard-form-icon", function () {
        $(".tp-dropdown__menu").removeClass("tp-dropdown-menu-open");
    });






    $(".tp-header-menu-icon").on("click", function () {
        $(".tp-sidebar-area").toggleClass("tp-sidebar-area-open");
    });
    $(".tp-deashboard-form-icon").on("click", function () {
        $(".tp-deashboard-form").toggleClass("tp-deashboard-form-open");
    });
    $(document).on("click", ".tp-header-menu-icon", function () {
        $(".tp-dropdown__menu").removeClass("tp-dropdown-menu-open");
    });

    $(document).on("click", ".tp-header-menu-icon", function () {
        $(".tp-dropdown-toggle").removeClass("active");
        $(".tp-dropdown__menu-item").removeClass("open");
    });

    $(document).on("click", ".tp-header-menu-icon", function () {
        $(".tp-dropdown__menu li").removeClass("active");
    });
    $(document).on("click", ".tp-header-menu-icon", function () {
        $(".tp-deashboard-form").removeClass("tp-deashboard-form-open");
    });

    $(document).on("click", ".tp-dropdown__menu li", function (e) {
        e.preventDefault();
        $(".tp-dropdown__menu li").removeClass("active");
        $(this).addClass("active");
    });

    $(document).on("click", ".tp-sidebar-area.collapsed .tp-dropdown-toggle", function () {
        $(".tp-sidebar-area.collapsed .tp-dropdown-toggle").not(this).removeClass("active");
        $(this).toggleClass("active");
    });








    $(".tp-deashboard-close-icon").on("click", function () {
        $(".tp-sidebar-area").toggleClass("tp-sidebar-area-open");
        $(".tp-sidebar-overlay").removeClass("tp-sidebar-overlay-open");
    });

    $("#sidebar__active").on("click", function () {
        if (window.innerWidth > 0 && window.innerWidth <= 991) {
            $(".tp-sidebar-area").toggleClass("open");
        } else {
            $(".tp-sidebar-area").toggleClass("collapsed");
        }
    });
    $(".app__sidebar-overlay").on("click", function () {
        $(".tp-sidebar-area").removeClass("collapsed");
        $(".tp-sidebar-area").removeClass("open");
    });


    $(document).ready(function () {
        $(".tp-dropdown-toggle").on("click", function (e) {
            var isDropdown = $(this).data("toggle") === "dropdown";

            if (isDropdown) {
                e.preventDefault();

                var parentLi = $(this).parent();
                var dropdownMenu = parentLi.find('.tp-dropdown__menu');
                var sidebar = $(".tp-sidebar-area");

                if (dropdownMenu.length === 0) return;

                if (sidebar.hasClass("collapsed")) {

                    if (dropdownMenu.hasClass("tp-dropdown-menu-open")) {
                        dropdownMenu.css({ 'max-height': '0', 'opacity': '0' });
                        dropdownMenu.removeClass("tp-dropdown-menu-open");
                    } else {

                        $(".tp-dropdown__menu")
                            .removeClass("tp-dropdown-menu-open")
                            .css({ 'max-height': '0', 'opacity': '0' });

                        var scrollHeight = dropdownMenu.get(0).scrollHeight;
                        dropdownMenu
                            .addClass("tp-dropdown-menu-open")
                            .css({ 'max-height': scrollHeight + 'px', 'opacity': '1' });
                    }

                } else {

                    if (parentLi.hasClass('open')) {

                        dropdownMenu.css({ 'max-height': '0', 'opacity': '0' });
                        dropdownMenu.on('transitionend', function () {
                            parentLi.removeClass("open");
                            dropdownMenu.off('transitionend');
                        });

                    } else {

                        $(".tp-dropdown__menu").css({ 'max-height': '0', 'opacity': '0' });
                        $(".tp-dropdown__menu").parent().removeClass("open");

                        parentLi.addClass("open");
                        var scrollHeight = dropdownMenu.get(0).scrollHeight;
                        dropdownMenu.css({ 'max-height': scrollHeight + 'px', 'opacity': '1' });
                    }
                }
            }
        });

        $(".tp-dropdown__menu a").on("click", function (e) {
            e.stopPropagation();
        });
    });



document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.getElementById("darkModeToggle");
    const title = document.querySelector(".tp-header-icon-title");
    if (!toggle) return;

    if (localStorage.getItem("darkMode") === "enabled") {
        document.body.classList.add("dark-theme");
        toggle.classList.add("dark-mode");
        if (title) title.textContent = "Dark";
    } else {
        if (title) title.textContent = "Light";
    }
    toggle.addEventListener("click", function (e) {
        e.preventDefault();
        document.body.classList.toggle("dark-theme");
        toggle.classList.toggle("dark-mode");

        if (document.body.classList.contains("dark-theme")) {
            localStorage.setItem("darkMode", "enabled");
            if (title) title.textContent = "Dark";
        } else {
            localStorage.setItem("darkMode", "disabled");
            if (title) title.textContent = "Light";
        }
    });
});




    new PureCounter();
    new PureCounter({
        filesizing: true,
        selector: ".filesizecount",
        pulse: 2,
    });

    var series = {
        monthDataSeries1: {
            prices: [
                8107.85, 8128.0, 8122.9, 8165.5, 8340.7,
                8423.7, 8423.5, 8514.3, 8481.85, 8487.7,
                8506.9, 8626.2, 8668.95, 8602.3, 8607.55,
                8512.9, 8496.25, 8600.65, 8881.1, 9340.85
            ],
            dates: [
                "2018-01-01", "2018-01-02", "2018-01-03", "2018-01-04",
                "2018-01-05", "2018-01-06", "2018-01-07", "2018-01-08",
                "2018-01-09", "2018-01-10", "2018-01-11", "2018-01-12",
                "2018-01-13", "2018-01-14", "2018-01-15", "2018-01-16",
                "2018-01-17", "2018-01-18", "2018-01-19", "2018-01-20"
            ]
        }
    };

    const lightTheme = {
        strokeColor: '#1469B5',
        gridColor: '#EDEDEC',
        labelColor: '#000'
    };

    const darkTheme = {
        strokeColor: '#5BA4D0',
        gridColor: '#444',
        labelColor: '#f6f7f9cc'
    };

    const darkModeToggle = document.getElementById("darkModeToggle");
    if (darkModeToggle && typeof chart !== "undefined") {
        darkModeToggle.addEventListener("click", function () {
            const isDark = document.body.classList.contains("dark-theme");

            chart.updateOptions({
                stroke: {
                    colors: [!isDark ? darkTheme.strokeColor : lightTheme.strokeColor]
                },
                xaxis: {
                    labels: {
                        style: {
                            colors: isDark ? darkTheme.labelColor : lightTheme.labelColor
                        }
                    }
                },
                grid: {
                    borderColor: !isDark ? darkTheme.gridColor : lightTheme.gridColor
                }
            });
        });
    }



    var options = {
        series: [{
            name: "STOCK ABC",
            data: series.monthDataSeries1.prices
        }],
        chart: {
            type: 'area',
            height: 150,
            width: 305,
            zoom: { enabled: false },
            toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        stroke: {
            curve: 'straight',
            colors: [lightTheme.strokeColor],
            width: 2
        },
        labels: series.monthDataSeries1.dates,
        xaxis: {
            type: 'datetime',
            labels: {
                style: { colors: lightTheme.labelColor }
            }
        },
        yaxis: {
            opposite: false,
            labels: { show: false }
        },
        grid: {
            show: true,
            borderColor: lightTheme.gridColor,
            strokeSolid: 3,
            xaxis: { lines: { show: true } }
        },
        legend: { horizontalAlign: 'center' }
    };
    // var chart = new ApexCharts(document.querySelector("#chart"), options);
    // chart.render();



    // Back to top
    var amountScrolled = 200;
    var amountScrolledNav = 25;

    $(window).scroll(function () {
        if ($(window).scrollTop() > amountScrolled) {
            $('button.back-to-top').addClass('show');
        } else {
            $('button.back-to-top').removeClass('show');
        }
    });

    $('button.back-to-top').click(function () {
        $('html, body').scrollTop(0);
        return false;
    });


    $(window).on("load", function () {
        $("#loading").fadeOut(500, function () {
            $(this).remove();
        });
    });


    $(document).ready(function () {
        // Inline datepicker init
        $("#datepicker-inline").datepicker({
            dateFormat: 'dd-mm-yy',
            onSelect: function (dateText) {
                $("#date-text").text(dateText);  // update span
                $("#datepicker-inline").hide();  // hide after select
            }
        });

        // Trigger datepicker on click (span text or svg)
        $("#date-trigger, #date-trigger svg").on("click", function (e) {
            e.preventDefault();
            $("#datepicker-inline").toggle(); // show/hide
        });

        // Click outside hides datepicker
        $(document).on("click", function (e) {
            if (!$(e.target).closest("#date-trigger, #datepicker-inline").length) {
                $("#datepicker-inline").hide();
            }
        });
    });

    // borderRadius
    // const wrapper = document.querySelector(".ride-table-wrapper");
    // wrapper.addEventListener("scroll", function () {
    //     const maxScrollLeft = wrapper.scrollWidth - wrapper.clientWidth;
    //     if (wrapper.scrollLeft >= maxScrollLeft) {
    //         wrapper.style.borderRadius = "0 10px 10px 0";
    //     } else if (wrapper.scrollLeft > 0) {
    //         wrapper.style.borderRadius = "0 0 0 0";
    //     } else {
    //         wrapper.style.borderRadius = "10px 0 0 10px";
    //     }
    // });

    document.addEventListener("DOMContentLoaded", () => {
    const wrapper = document.querySelector(".ride-table-wrapper");
    if (wrapper) {
        wrapper.addEventListener("scroll", function () {
            const maxScrollLeft = wrapper.scrollWidth - wrapper.clientWidth;
            if (wrapper.scrollLeft >= maxScrollLeft) {
                wrapper.style.borderRadius = "0 10px 10px 0";
            } else if (wrapper.scrollLeft > 0) {
                wrapper.style.borderRadius = "0 0 0 0";
            } else {
                wrapper.style.borderRadius = "10px 0 0 10px";
            }
        });
    }
});


    $(document).ready(function () {
        console.log("Notification wrapper:", $(".tp-header-notification"));

        $(".tp-header-lang").on("click", function (e) {
            console.log("Notification clicked!");
            e.stopPropagation();
            $(".tp-header-notification").removeClass("tp-header-notification-open");
            $(this).toggleClass("tp-header-lang-open");
        });
        $(".tp-header-notification").on("click", function (e) {
            e.stopPropagation();
            $(".tp-header-lang").removeClass("tp-header-lang-open");
            $(this).toggleClass("tp-header-notification-open");
        });
        $(".tp-header-notification-show").on("click", function (e) {
            e.stopPropagation();
        });
        $(document).on("click", function () {
            $(".tp-header-lang, .tp-header-notification")
                .removeClass("tp-header-lang-open tp-header-notification-open");
        });
    });




})(jQuery);
