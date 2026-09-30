(function ($) {
    "use strict";

    // data color
    $("[data-color]").each(function () {
        $(this).css("color", $(this).attr("data-color"));
    });

    // data bg img
    $("[data-bg-img]").each(function () {
        $(this).css(
            "background-image",
            "url(" + $(this).attr("data-bg-img") + ")",
        );
    });

    // data border color
    $("[data-border-color]").each(function () {
        $(this).css("border-color", $(this).attr("data-border-color"));
    });

    // data bg color
    $("[data-bg-color]").each(function () {
        $(this).css("background-color", $(this).attr("data-bg-color"));
    });

    //profile offcanvas
    $(".profile-side-bar").on("click", function () {
        $(".rs-profile-offcanvas").addClass("rs-profile-offcanvas-open");
        $(".tp-offcanvas-overlay").addClass("tp-offcanvas-overlay-open");
    });
    $(".tp-offcanvas-close,.tp-offcanvas-overlay").on("click", function () {
        $(".rs-profile-offcanvas").removeClass("rs-profile-offcanvas-open");
        $(".tp-offcanvas-overlay").removeClass("tp-offcanvas-overlay-open");
    });

    //  Smooth Scroll Js
    // gsap.registerPlugin(ScrollTrigger, ScrollSmoother, ScrollToPlugin);
    // if ($('#smooth-wrapper').length && $('#smooth-content').length) {
    //     ScrollSmoother.create({
    //         smooth: 1.35,
    //         effects: true,
    //         smoothTouch: .1,
    //         ignoreMobileResize: false
    //     })
    // }

    // Overlay
    const overlay = document.querySelector(".tp-offcanvas-overlay");

    // --- Offer Modal --- //
    const offerModal = document.getElementById("offerModal");
    const offerBtns = document.querySelectorAll(".makeOfferBtn");
    const closeOffer = document.getElementById("closeOffer");

    offerBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            offerModal.style.display = "block";
            overlay?.classList.add("tp-offcanvas-overlay-open");
        });
    });
    closeOffer?.addEventListener("click", () => {
        offerModal.style.display = "none";
        overlay?.classList.remove("tp-offcanvas-overlay-open");
    });

    // --- Verified Modal --- //
    const verifiedModal = document.getElementById("verifiedModal");
    const verifiedBtns = document.querySelectorAll(".verifiedBtn");
    const closeVerified = document.getElementById("closeVerified");

    verifiedBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            verifiedModal.style.display = "block";
            overlay?.classList.add("tp-offcanvas-overlay-open");
        });
    });
    closeVerified?.addEventListener("click", () => {
        verifiedModal.style.display = "none";
        overlay?.classList.remove("tp-offcanvas-overlay-open");
    });

    // --- Payment Modal --- //
    const paymentModal = document.getElementById("paymentModal");
    const openPayment = document.getElementById("openPayment");
    const closePayment = document.getElementById("closePayment");
    const cancelPayment = paymentModal?.querySelector(
        ".rs-payment-method-cancel-btn",
    );

    openPayment?.addEventListener("click", () => {
        paymentModal.style.display = "flex";
        overlay?.classList.add("tp-offcanvas-overlay-open");
    });
    closePayment?.addEventListener("click", () => {
        paymentModal.style.display = "none";
        overlay?.classList.remove("tp-offcanvas-overlay-open");
    });
    cancelPayment?.addEventListener("click", () => {
        paymentModal.style.display = "none";
        overlay?.classList.remove("tp-offcanvas-overlay-open");
    });
    paymentModal?.addEventListener("click", (e) => {
        if (e.target === paymentModal) {
            paymentModal.style.display = "none";
            overlay?.classList.remove("tp-offcanvas-overlay-open");
        }
    });

    // --- Add Balance Modal --- //
    const addBalanceModal = document.getElementById("addBalanceModal");
    const addBalanceBtns = document.querySelectorAll(".rs-wallet-balance-add");
    const closeAddBalance = document.getElementById("closeAddBalance");
    const cancelAddBalance = document.getElementById("cancelAddBalance");

    addBalanceBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            addBalanceModal.style.display = "block";
            overlay?.classList.add("tp-offcanvas-overlay-open");
        });
    });

    closeAddBalance?.addEventListener("click", () => {
        addBalanceModal.style.display = "none";
        overlay?.classList.remove("tp-offcanvas-overlay-open");
    });

    cancelAddBalance?.addEventListener("click", () => {
        addBalanceModal.style.display = "none";
        overlay?.classList.remove("tp-offcanvas-overlay-open");
    });

    // --- Report Seller Modal --- //
    const reportModal = document.getElementById("reportModal");
    const reportBtns = document.querySelectorAll(".reportSellerBtn");
    const closeReport = document.getElementById("closeReport");
    const cancelReport = document.getElementById("cancelReport");

    // ✅ চেক করো modal টা আসলেই আছে কিনা
    if (reportModal && overlay) {
        // Modal open
        reportBtns.forEach((btn) => {
            btn?.addEventListener("click", () => {
                reportModal.style.display = "block";
                overlay.classList.add("tp-offcanvas-overlay-open");
            });
        });

        // Modal close
        closeReport?.addEventListener("click", () => {
            reportModal.style.display = "none";
            overlay.classList.remove("tp-offcanvas-overlay-open");
        });

        cancelReport?.addEventListener("click", () => {
            reportModal.style.display = "none";
            overlay.classList.remove("tp-offcanvas-overlay-open");
        });

        // Overlay click → modal close
        overlay.addEventListener("click", () => {
            reportModal.style.display = "none";
            overlay.classList.remove("tp-offcanvas-overlay-open");
        });
    }

    // --- Sold Out Modal --- //
    const soldOutModal = document.getElementById("soldOutModal");
    const soldOutBtns = document.querySelectorAll(".soldOutBtn");
    const closeSoldOut = document.getElementById("closeSoldOut");
    const cancelSoldOut = document.getElementById("cancelSoldOut");
    soldOutBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            soldOutModal.style.display = "block";
            overlay?.classList.add("tp-offcanvas-overlay-open");
        });
    });
    closeSoldOut?.addEventListener("click", () => {
        soldOutModal.style.display = "none";
        overlay?.classList.remove("tp-offcanvas-overlay-open");
    });
    cancelSoldOut?.addEventListener("click", () => {
        soldOutModal.style.display = "none";
        overlay?.classList.remove("tp-offcanvas-overlay-open");
    });

    soldOutModal?.addEventListener("click", (e) => {
        if (e.target === soldOutModal) {
            soldOutModal.style.display = "none";
            overlay?.classList.remove("tp-offcanvas-overlay-open");
        }
    });

    // --- Give Review Modal --- //
    const reviewModal = document.getElementById("reviewModal");
    const openReviewBtn = document.getElementById("openReviewModal");
    const closeReviewBtn = document.getElementById("closeReviewModal");

    if (reviewModal && overlay) {
        openReviewBtn?.addEventListener("click", () => {
            reviewModal.style.display = "block";
            overlay.classList.add("tp-offcanvas-overlay-open");
        });

        closeReviewBtn?.addEventListener("click", () => {
            reviewModal.style.display = "none";
            overlay.classList.remove("tp-offcanvas-overlay-open");
        });

        overlay.addEventListener("click", () => {
            reviewModal.style.display = "none";
            overlay.classList.remove("tp-offcanvas-overlay-open");
        });
    }

    // --- Overlay click --- //
    overlay?.addEventListener("click", () => {
        offerModal?.style && (offerModal.style.display = "none");
        verifiedModal?.style && (verifiedModal.style.display = "none");
        paymentModal?.style && (paymentModal.style.display = "none");
        addBalanceModal?.style && (addBalanceModal.style.display = "none");
        soldOutModal?.style && (soldOutModal.style.display = "none");
        reviewModal?.style && (reviewModal.style.display = "none");
        overlay?.classList.remove("tp-offcanvas-overlay-open");
    });
    //=================== date ===================//
    const expDateInput = document.getElementById("expDate");
    const calendarIcon = document.getElementById("calendarIcon");

    if (expDateInput && calendarIcon) {
        const fp = flatpickr(expDateInput, {
            dateFormat: "d/m/Y",
            allowInput: true,
        });

        calendarIcon.addEventListener("click", () => {
            fp.open();
        });
    }
    const soldDateInput = document.getElementById("soldDate");
    const soldDateIcon = document.getElementById("soldDateIcon");

    if (soldDateInput && soldDateIcon) {
        const fp2 = flatpickr(soldDateInput, {
            dateFormat: "d/m/Y",
            allowInput: true,
        });

        soldDateIcon.addEventListener("click", () => {
            fp2.open();
        });
    }

    // Author dropdown toggle
    $(".tp-header-author").on("click", function (e) {
        e.stopPropagation();
        $(this).toggleClass("tp-header-author-open");
    });

    //-- backToTop --//
    let windowHeight = 0;
    let documentHeight = 0;
    function updateDimensions() {
        windowHeight = window.innerHeight;
        documentHeight = document.documentElement.scrollHeight - windowHeight;
    }
    updateDimensions();
    $(window).on("resize", updateDimensions);

    let $box = $(".scrollToTop");
    if ($box.length) {
        let $water = $box.find(".water");

        $(window).on("scroll", function () {
            let scrollPosition = $(window).scrollTop();
            let percent = Math.min(
                Math.floor((scrollPosition / documentHeight) * 100),
                100,
            );

            $water.css("transform", "translate(0," + (100 - percent) + "%)");

            if (scrollPosition >= 200) {
                $box.fadeIn();
            } else {
                $box.fadeOut();
            }
        });

        // Scroll to top
        $box.on("click", function () {
            $("html, body").animate({ scrollTop: 0 }, "smooth");
        });
    }

    // --- Overlay click closes all modals safely --- //
    window.onclick = function (e) {
        if (e.target === overlay) {
            if (offerModal) offerModal.style.display = "none";
            if (verifiedModal) verifiedModal.style.display = "none";
            overlay?.classList.remove("tp-offcanvas-overlay-open");
        }
    };

    //pasword show
    document.addEventListener("DOMContentLoaded", () => {
        const passwordInput = document.getElementById("passwordInput");
        const togglePassword = document.getElementById("togglePassword");
        if (passwordInput && togglePassword) {
            togglePassword.addEventListener("click", () => {
                passwordInput.type =
                    passwordInput.type === "password" ? "text" : "password";
            });
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        const passwordInputs = document.querySelectorAll(".passwordInput");
        const togglePasswords = document.querySelectorAll(".togglePassword");

        togglePasswords.forEach((toggle, index) => {
            toggle.addEventListener("click", () => {
                const input = passwordInputs[index];
                input.type = input.type === "password" ? "text" : "password";
            });
        });
    });

    const visiblePasswordCheckbox = document.querySelector(
        '#Visible_Password input[type="checkbox"]',
    );
    const passwordInputs = document.querySelectorAll(".passwordInput");

    if (visiblePasswordCheckbox && passwordInputs.length) {
        visiblePasswordCheckbox.addEventListener("change", function () {
            passwordInputs.forEach((input) => {
                input.type = this.checked ? "text" : "password";
            });
        });
    }

    //mobile-menu
    let tpMenuHTML = $(".tp-mobile-menu-active > ul").clone();
    let tpOffcanvasMenu = $(".tp-offcanvas-menu > nav");
    tpOffcanvasMenu.append(tpMenuHTML);

    tpOffcanvasMenu.find("li").each(function () {
        if ($(this).find(".rs-hero-dropdown__menu").length) {
            $(this).addClass("has-dropdown");
            $(this).append(
                '<button class="tp-sidemenu-close"><i class="fas fa-chevron-right"></i></button>',
            );
        }
    });

    tpOffcanvasMenu.on(
        "click",
        "li.has-dropdown > a, li.has-dropdown > button.tp-sidemenu-close",
        function (e) {
            e.preventDefault();
            let parentLi = $(this).closest("li");
            let subMenu = parentLi.children(".rs-hero-dropdown__menu");

            if (parentLi.hasClass("active")) {
                subMenu.slideUp();
                parentLi.removeClass("active");
            } else {
                parentLi
                    .siblings(".active")
                    .removeClass("active")
                    .children(".rs-hero-dropdown__menu")
                    .slideUp();
                parentLi.addClass("active");
                subMenu.slideDown();
            }
        },
    );

    //offcanvas
    $(".rs-offcanvas-btn").on("click", function () {
        $(".tp-offcanvas-area").addClass("tp-offcanvas-area-open");
        $(".tp-offcanvas-overlay").addClass("tp-offcanvas-overlay-open");
    });
    $(".tp-offcanvas-close,.tp-offcanvas-overlay").on("click", function () {
        $(".tp-offcanvas-area").removeClass("tp-offcanvas-area-open");
        $(".tp-offcanvas-overlay").removeClass("tp-offcanvas-overlay-open");
    });

    //list-view
    $(document).ready(function () {
        $(".rs-product-list-view-2").hide();
        $(".rs-product-menu__icon-1").on("click", function () {
            $(".rs-product-menu__icon-1, .rs-product-menu__icon-2").removeClass(
                "active",
            );
            $(this).addClass("active");

            $(".rs-product-list-view-1").fadeOut(350, function () {
                $(".rs-product-list-view-2").fadeIn(350, function () {
                    $(".grid").isotope("layout");
                });
            });
        });
        $(".rs-product-menu__icon-2").on("click", function () {
            $(".rs-product-menu__icon-1, .rs-product-menu__icon-2").removeClass(
                "active",
            );
            $(this).addClass("active");

            $(".rs-product-list-view-2").fadeOut(350, function () {
                $(".rs-product-list-view-1").fadeIn(350, function () {
                    $(".grid").isotope("layout");
                });
            });
        });
    });

    // profile lang toggle
    $(document).ready(function () {
        $(".rs-profile-side-bar-list-items").on("click", function () {
            $(".rs-profile-side-bar-list-items").removeClass("active");
            $(this).addClass("active");
        });

        $(".rs-profile-language").on("click", function (e) {
            e.stopPropagation();
            $(this).find(".rs-profile-lang-menu").toggleClass("open");
        });

        $(document).on("click", function () {
            $(".rs-profile-lang-menu").removeClass("open");
        });

        $(".rs-profile-lang-menu a").on("click", function (e) {
            e.stopPropagation();
            window.location.href = $(this).attr("href");
        });
    });

    // Filter offcanvas toggle
    $(document).ready(function () {
        $(".rs-profile-side-bar-list-items").on("click", function () {
            $(".rs-profile-side-bar-list-items").removeClass("active");
            $(this).addClass("active");
        });
    });

    // Filter offcanvas toggle
    $(document).ready(function () {
        function initOffcanvasFilter() {
            if ($(window).width() < 992) {
                let filterHTML = $(".rs-product-filter-area").clone();
                filterHTML.find("#progress").attr("id", "progress-mobile");
                filterHTML.find("#minVal").attr("id", "minVal-mobile");
                filterHTML.find("#maxVal").attr("id", "maxVal-mobile");
                filterHTML.find(".min-range").addClass("min-range-mobile");
                filterHTML.find(".max-range").addClass("max-range-mobile");

                let offcanvasFilter = $(
                    ".rs-filter-offcanvas .rs-filter-inner",
                );
                offcanvasFilter.html(filterHTML);
                $(".rs-filter-open-btn").on("click.offcanvas", function () {
                    $(".rs-filter-offcanvas").addClass("open");
                    $(".rs-filter-overlay").addClass("show");
                });
                $(".rs-filter-close, .rs-filter-overlay").on(
                    "click.offcanvas",
                    function () {
                        $(".rs-filter-offcanvas").removeClass("open");
                        $(".rs-filter-overlay").removeClass("show");
                    },
                );
                $(".tp-sidemenu-close").on("click.offcanvas", function () {
                    $(this).toggleClass("active");
                });
                const minRange = document.querySelector(".min-range-mobile");
                const maxRange = document.querySelector(".max-range-mobile");
                const progress = document.getElementById("progress-mobile");
                const minValText = document.getElementById("minVal-mobile");
                const maxValText = document.getElementById("maxVal-mobile");

                if (
                    minRange &&
                    maxRange &&
                    progress &&
                    minValText &&
                    maxValText
                ) {
                    const minGap = 500;
                    function updateSlider(e) {
                        let minVal = parseInt(minRange.value);
                        let maxVal = parseInt(maxRange.value);
                        if (maxVal - minVal <= minGap) {
                            if (
                                e.target.classList.contains("min-range-mobile")
                            ) {
                                minRange.value = maxVal - minGap;
                            } else {
                                maxRange.value = minVal + minGap;
                            }
                        }
                        progress.style.left =
                            (minRange.value / minRange.max) * 100 + "%";
                        progress.style.right =
                            100 - (maxRange.value / maxRange.max) * 100 + "%";
                        minValText.textContent = minRange.value;
                        maxValText.textContent = maxRange.value;
                    }
                    minRange.addEventListener("input", updateSlider);
                    maxRange.addEventListener("input", updateSlider);
                    updateSlider({ target: minRange });
                }
            } else {
                $(
                    ".rs-filter-open-btn, .rs-filter-close, .rs-filter-overlay, .tp-sidemenu-close",
                ).off(".offcanvas");
                $(".rs-filter-offcanvas .rs-filter-inner").empty();
            }
        }
        initOffcanvasFilter();
        $(window).resize(function () {
            initOffcanvasFilter();
        });
    });

    //active
    $(".tp-sidemenu-close").click(function () {
        $(this).toggleClass("active");
    });

    //more-option
    $(".rs-more-option").on("click", function (e) {
        e.stopPropagation();
        $(".rs-more-option").not(this).removeClass("active");

        $(this).toggleClass("active");
    });
    $(document).on("click", function () {
        $(".rs-more-option").removeClass("active");
    });

    // sidiebar show
    $(".rs-profile-side-bar-list-items").on("click", function (e) {
        e.preventDefault();
        const target = $(this).data("target");
        $(".my-page").stop(true, true).fadeOut(200).removeClass("active");
        $("." + target)
            .stop(true, true)
            .fadeIn(300)
            .addClass("active");
        $(".rs-profile-side-bar-list-items").removeClass("active");
        $(this).addClass("active");
    });

    //love
    const loveItems = document.querySelectorAll(".rs-product-thumb-love");
    loveItems.forEach((item) => {
        item.addEventListener("click", () => {
            item.classList.toggle("active");
            const icon = item.querySelector(".love-icon");
            icon.classList.toggle("active");
        });
    });

    //================ star ===============//
    const stars = document.querySelectorAll("#starRating i");
    const ratingValue = document.getElementById("ratingValue");
    let currentRating = 0;

    stars.forEach((star) => {
        star.addEventListener("click", () => {
            const value = parseInt(star.getAttribute("data-value"));
            if (currentRating === value) {
                currentRating = 0;
                ratingValue.value = 0;
                stars.forEach((s) => {
                    s.classList.remove("fas", "active");
                    s.classList.add("fal");
                });
                return;
            }
            currentRating = value;
            ratingValue.value = value;
            stars.forEach((s, index) => {
                if (index < value) {
                    s.classList.remove("fal");
                    s.classList.add("fas", "active");
                } else {
                    s.classList.remove("fas", "active");
                    s.classList.add("fal");
                }
            });
        });
    });

    //dropdown
    document.addEventListener("DOMContentLoaded", function () {
        const dropdownLinks = document.querySelectorAll(
            ".rs-product-price-dropdown a",
        );
        const mainButton = document.querySelector(
            ".rs-product-price-menu > ul > li > a",
        );
    });

    //product-name-slide
    var swiper = new Swiper(".rs-product-name-slide", {
        slidesPerView: 6.9,
        spaceBetween: 16,
        loop: true,
        navigation: {
            nextEl: ".rs-product-button-next",
            prevEl: ".rs-product-button-prev",
        },
        breakpoints: {
            1200: {
                slidesPerView: 5.3,
                spaceBetween: 12,
            },
            992: {
                slidesPerView: 4,
            },
            768: {
                slidesPerView: 4,
            },
            1: {
                slidesPerView: 3,
            },
        },
    });

    //product-slide
    var swiper = new Swiper(".rs-product-slide", {
        slidesPerView: 1.2,
        spaceBetween: 16,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            441: {
                slidesPerView: 1.3,
            },
            475: {
                slidesPerView: 1.4,
            },
            511: {
                slidesPerView: 1.6,
            },
            576: {
                slidesPerView: 1.7,
                spaceBetween: 20,
            },
            620: {
                slidesPerView: 1.8,
                spaceBetween: 20,
            },
        },
    });

    //product-slide-2
    var swiper = new Swiper(".rs-product-slide-2", {
        slidesPerView: 4,
        spaceBetween: 16,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".rs-product-button-next-2",
            prevEl: ".rs-product-button-prev-2",
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            1200: {
                slidesPerView: 4,
            },
            992: {
                slidesPerView: 3,
            },
            768: {
                slidesPerView: 2,
            },
            451: {
                slidesPerView: 1.5,
                spaceBetween: 12,
            },
            370: {
                slidesPerView: 1.2,
                spaceBetween: 10,
            },
            0: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
        },
    });

    //details-slide
    var swiper = new Swiper(".rs-details-slide", {
        loop: true,
        spaceBetween: 10,
        slidesPerView: 4.2,
        freeMode: true,
        watchSlidesProgress: true,
        initialSlide: 1,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        breakpoints: {
            1200: {
                slidesPerView: 4.2,
            },
            992: {
                slidesPerView: 6.2,
            },
            768: {
                slidesPerView: 5.2,
            },
            576: {
                slidesPerView: 7.2,
            },
        },
    });
    var swiper2 = new Swiper(".rs-details-slide-2", {
        loop: true,
        spaceBetween: 10,
        initialSlide: 1,
        thumbs: {
            swiper: swiper,
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
    });

    //wallet-slide
    const walletBox = document.querySelector(
        ".rs-wallet-box,.rs-category-wrapper",
    );

    if (walletBox) {
        walletBox.addEventListener("wheel", (e) => {
            const maxScrollLeft = walletBox.scrollWidth - walletBox.clientWidth;
            const maxScrollTop =
                walletBox.scrollHeight - walletBox.clientHeight;

            let scrollLeftBefore = walletBox.scrollLeft;
            let scrollTopBefore = walletBox.scrollTop;

            walletBox.scrollLeft += e.deltaY;
            walletBox.scrollTop += e.deltaX;

            const scrollLeftAfter = walletBox.scrollLeft;
            const scrollTopAfter = walletBox.scrollTop;

            if (
                (scrollLeftAfter !== scrollLeftBefore &&
                    scrollLeftAfter < maxScrollLeft) ||
                (scrollTopAfter !== scrollTopBefore &&
                    scrollTopAfter < maxScrollTop)
            ) {
                e.preventDefault();
            }
        });
    }

    // min.js
    (function () {
        const offerModal = document.getElementById("offerModal");
        if (!offerModal) return;
        const closeBtn = document.getElementById("closeBtn");
        const otpBoxes = document.querySelectorAll(".otp-box");
        const timerEl = document.getElementById("timer");
        const resentOtpBtn = document.getElementById("resendOTPBtn");
        let countdown;

        // Close button
        if (closeBtn) {
            closeBtn.addEventListener("click", () => {
                offerModal.style.display = "none";
                clearInterval(countdown);
            });
        }

        // Format time for countdown
        function formatTime(seconds) {
            const m = String(Math.floor(seconds / 60)).padStart(2, "0");
            const s = String(seconds % 60).padStart(2, "0");
            return `${m}:${s}`;
        }

        // Start countdown
        function startCountdown(seconds) {
            if (!timerEl) {
                console.error("Timer element not found!");
                return;
            }

            let timeLeft = seconds;
            timerEl.textContent = `Resend code in ${formatTime(timeLeft)} sec`;

            // Clear any existing countdown
            clearInterval(countdown);

            // Hide Resend OTP button when timer starts
            if (resentOtpBtn) {
                resentOtpBtn.classList.add("d-none");
                resentOtpBtn.classList.remove("d-block");
            }

            countdown = setInterval(() => {
                timeLeft--;
                if (timeLeft > 0) {
                    timerEl.textContent = `Resend code in ${formatTime(
                        timeLeft,
                    )} sec`;
                } else {
                    clearInterval(countdown);
                    timerEl.textContent = "";
                    if (resentOtpBtn) {
                        resentOtpBtn.classList.remove("d-none");
                        resentOtpBtn.classList.add("d-block");
                    } else {
                        console.error("Resend OTP button not found!");
                    }
                }
            }, 1000);
        }

        // OTP input handling
        if (otpBoxes.length > 0) {
            otpBoxes.forEach((box, index) => {
                box.addEventListener("input", () => {
                    if (box.value.length === 1 && index < otpBoxes.length - 1) {
                        otpBoxes[index + 1].focus();
                    }
                });

                box.addEventListener("keydown", (e) => {
                    if (
                        e.key === "Backspace" &&
                        box.value === "" &&
                        index > 0
                    ) {
                        otpBoxes[index - 1].focus();
                    }
                });
            });
        }

        // Expose startCountdown to be called externally
        window.startCountdown = startCountdown;
    })();

    //img-animation
    document.addEventListener("DOMContentLoaded", () => {
        const bigImage = document.getElementById("bigImage");
        const smallImages = document.querySelectorAll(".small-img");

        if (bigImage && smallImages.length > 0) {
            const container = bigImage.parentElement;

            function getFinalSize() {
                if (window.innerWidth >= 1200) {
                    return { finalWidth: 350, finalHeight: 456 };
                } else if (window.innerWidth >= 992) {
                    return { finalWidth: 250, finalHeight: 300 };
                } else if (window.innerWidth >= 768) {
                    return { finalWidth: 350, finalHeight: 450 };
                } else if (window.innerWidth >= 576) {
                    return { finalWidth: 300, finalHeight: 355 };
                } else if (window.innerWidth >= 460) {
                    return { finalWidth: 300, finalHeight: 355 };
                } else {
                    return { finalWidth: 200, finalHeight: 240 };
                }
            }

            function animateImage(img) {
                const containerRect = container.getBoundingClientRect();
                const smallRect = img.getBoundingClientRect();
                const bigRect = bigImage.getBoundingClientRect();

                const clone = img.cloneNode(true);
                clone.classList.add("image-clone");
                container.appendChild(clone);

                clone.style.top = smallRect.top - containerRect.top + "px";
                clone.style.left = smallRect.left - containerRect.left + "px";
                clone.style.width = smallRect.width + "px";
                clone.style.height = smallRect.height + "px";

                const { finalWidth, finalHeight } = getFinalSize();
                clone.offsetHeight;
                requestAnimationFrame(() => {
                    clone.style.top = bigRect.top - containerRect.top + "px";
                    clone.style.left = bigRect.left - containerRect.left + "px";
                    clone.style.width = finalWidth + "px";
                    clone.style.height = finalHeight + "px";
                });
                [
                    "transitionend",
                    "webkitTransitionEnd",
                    "oTransitionEnd",
                ].forEach((eventName) => {
                    clone.addEventListener(
                        eventName,
                        () => {
                            bigImage.src = img.src;
                            bigImage.style.width = finalWidth + "px";
                            bigImage.style.height = finalHeight + "px";

                            setTimeout(() => clone.remove(), 200);
                        },
                        { once: true },
                    );
                });
            }
            smallImages.forEach((img) => {
                img.addEventListener("click", () => {
                    animateImage(img);
                });
            });
            let autoIndex = 0;
            function autoAnimate() {
                const img = smallImages[autoIndex];
                animateImage(img);
                autoIndex = (autoIndex + 1) % smallImages.length;
                setTimeout(autoAnimate, 5000);
            }

            setTimeout(autoAnimate, 5000);
        }
    });

    //rs-chat-users-active
    document.querySelectorAll(".rs-chat-users li").forEach(function (item) {
        item.addEventListener("click", function () {
            document
                .querySelectorAll(".rs-chat-users li")
                .forEach((li) => li.classList.remove("active"));
            this.classList.add("active");
        });
    });

    // Message-mobile
    const chatWrapper = document.querySelector(".rs-chat-wrapper");
    const userList = document.querySelectorAll(".rs-chat-users li");

    userList.forEach((user) => {
        user.addEventListener("click", () => {
            // For mobile only
            if (window.innerWidth <= 767) {
                chatWrapper.classList.add("chat-open");
            }
        });
    });

    // Optionally, add a back button inside chat to return to user list
    const backBtn = document.createElement("button");
    backBtn.innerHTML = '<i class="fal fa-arrow-left"></i>';
    backBtn.classList.add("chat-back-btn", "d-md-none");

    const target = document.querySelector(".rs-massage-right-area ul li a");
    if (target) {
        target.prepend(backBtn);

        backBtn.addEventListener("click", () => {
            chatWrapper.classList.remove("chat-open");
        });
    }

    // isotope
    var $grid = $(".grid")?.imagesLoaded(function () {
        $grid.isotope({
            itemSelector: ".grid-item",
            percentPosition: true,
            masonry: {
                columnWidth: ".grid-item",
            },
        });
    });

    $(".rs-product-filter").on("click", function () {
        var filterValue = $(this).attr("data-filter");
        $grid.isotope({ filter: filterValue });
        $(".rs-product-filter").removeClass("active");
        $(this).addClass("active");
    });

    // PreLoader Js
    $(window).on("load", function () {
        var body = $("body");
        body.addClass("loaded");
        setTimeout(function () {
            body.removeClass("loaded");
        }, 1500);
    });

    document.addEventListener("DOMContentLoaded", () => {
        const svg = document.getElementById("svg");
        if (!svg) return;

        const tls = gsap.timeline();
        const curve = "M0 502S175 272 500 272s500 230 500 230V0H0Z";
        const flat = "M0 2S175 1 500 1s500 1 500 1V0H0Z";

        // Loader heading text
        if (document.querySelector(".loader-wrap-heading")) {
            tls.to(
                ".loader-wrap-heading .load-text , .loader-wrap-heading .cont",
                {
                    delay: 0.5,
                    y: -100,
                    opacity: 0,
                },
            );
        }

        // SVG animation
        tls.to(svg, {
            duration: 0.5,
            attr: { d: curve },
            ease: "power2.in",
        }).to(svg, {
            duration: 0.5,
            attr: { d: flat },
            ease: "power2.out",
        });

        // Loader wrap
        if (document.querySelector(".loader-wrap")) {
            tls.to(".loader-wrap", { y: -1500 }).to(".loader-wrap", {
                zIndex: -1,
                display: "none",
            });
        }

        // Pre-header animation (safe check)
        const preHeader = document.querySelector(".pre-header");
        if (preHeader) {
            tls.from(preHeader, { y: 200 }, "-=1.5");

            const preHeaderCont = preHeader.querySelector(".containers");
            if (preHeaderCont) {
                tls.from(
                    preHeaderCont,
                    {
                        y: 40,
                        opacity: 0,
                        delay: 0.1,
                    },
                    "-=1.5",
                );
            }
        }
    });

    //pasword show
    document.addEventListener("DOMContentLoaded", () => {
        const passwordInput = document.getElementById("passwordInput");
        const togglePassword = document.getElementById("togglePassword");
        if (passwordInput && togglePassword) {
            togglePassword.addEventListener("click", () => {
                passwordInput.type =
                    passwordInput.type === "password" ? "text" : "password";
            });
        }
    });

    document.addEventListener("DOMContentLoaded", () => {
        const passwordInputs = document.querySelectorAll(".passwordInput");
        const togglePasswords = document.querySelectorAll(".togglePassword");

        togglePasswords.forEach((toggle, index) => {
            toggle.addEventListener("click", () => {
                const input = passwordInputs[index];
                input.type = input.type === "password" ? "text" : "password";
            });
        });
    });

    // range
    document.addEventListener("DOMContentLoaded", () => {
        const minRange = document.querySelector(".min-range");
        const maxRange = document.querySelector(".max-range");
        const progress = document.getElementById("progress");
        const minValText = document.getElementById("minVal");
        const maxValText = document.getElementById("maxVal");

        if (minRange && maxRange && progress && minValText && maxValText) {
            const minGap = 500;

            function updateSlider(e) {
                let minVal = parseInt(minRange.value);
                let maxVal = parseInt(maxRange.value);

                if (maxVal - minVal <= minGap) {
                    if (e.target.classList.contains("min-range")) {
                        minRange.value = maxVal - minGap;
                    } else {
                        maxRange.value = minVal + minGap;
                    }
                }

                progress.style.left =
                    (minRange.value / minRange.max) * 100 + "%";
                progress.style.right =
                    100 - (maxRange.value / maxRange.max) * 100 + "%";
                minValText.textContent = minRange.value;
                maxValText.textContent = maxRange.value;
            }

            minRange.addEventListener("input", updateSlider);
            maxRange.addEventListener("input", updateSlider);

            updateSlider({ target: minRange });
        }
    });

    //jarallax
    if ($(".jarallax").length) {
        $(".jarallax").jarallax({
            speed: 0.2,
        });
    }

    //PureCounter
    new PureCounter();
    new PureCounter({
        filesizing: true,
        selector: ".filesizecount",
        pulse: 2,
    });

    // notification
    document.addEventListener("DOMContentLoaded", function () {
        document
            .querySelectorAll(".rs-notification-card")
            .forEach(function (card) {
                const p = card.querySelector(".rs-notification-text");
                const btn = card.querySelector(".rs-notification-toggle");
                const full = p.dataset.full || "";
                const short = full.slice(0, 102);
                p.textContent = short + (full.length > 102 ? "..." : "");
                function toggleText() {
                    const expanded = p.classList.toggle("expanded");
                    p.textContent = expanded
                        ? full
                        : short + (full.length > 90 ? "..." : "");
                    btn.textContent = expanded ? "Show less" : "See more";
                }
                btn.addEventListener("click", function (e) {
                    e.stopPropagation();
                    toggleText();
                });
                card.addEventListener("click", function (e) {
                    if (e.target === btn) return;
                    toggleText();
                });
            });
    });

    //---- promote-text ----//
    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll(".rs-promote-box").forEach((card) => {
            const title = card.querySelector(".rs-promote-text p");
            if (!title) return;

            const link = title.querySelector("a");
            const fullText = (
                link ? link.textContent : title.textContent
            ).trim();
            const limit = 150;
            const shortText =
                fullText.length > limit
                    ? fullText.slice(0, limit) + " ..."
                    : fullText;
            let expanded = false;

            const updateText = () => {
                (link || title).textContent = expanded ? fullText : shortText;
            };

            updateText();

            title.addEventListener("click", (e) => {
                e.preventDefault();
                expanded = !expanded;
                updateText();
            });
        });
    });

    //================ checkout ==================//
    const changeBtn = document.querySelector(".rs-payment-change-item-btn");
    const dropdown = document.querySelector(".rs-payment-dropdown-list");
    const items = dropdown ? dropdown.querySelectorAll("li") : [];
    const daysElement = document.querySelector(".rs-payment-days span");
    const priceElement = document.querySelector(".rs-payment-price");
    if (changeBtn && dropdown && daysElement && priceElement) {
        changeBtn.addEventListener("click", () => {
            dropdown.classList.toggle("active");
        });

        items.forEach((item) => {
            item.addEventListener("click", () => {
                const [daysPart, pricePart] = item.textContent.split(" - ");
                changeBtn.innerHTML = `${item.textContent} <i class="far fa-angle-down"></i>`;
                dropdown.classList.remove("active");
                const dayNumber = daysPart.match(/\d+/)?.[0] || "0";
                const dayText = daysPart.replace(/[0-9]/g, "").trim();
                daysElement.textContent = dayNumber.padStart(2, "0");
                document.querySelector(
                    ".rs-payment-days",
                ).childNodes[1].textContent = ` ${dayText}`;
                priceElement.textContent = pricePart;
            });
        });
        document.addEventListener("click", (e) => {
            if (!e.target.closest(".rs-payment-change")) {
                dropdown.classList.remove("active");
            }
        });
    }

    //================= header-sticky =================//
    $(window).on("scroll", function () {
        if ($(this).scrollTop() > 300) {
            $(".rs-header-sticky").addClass("active");
        } else {
            $(".rs-header-sticky").removeClass("active");
        }
    });

    //popup
    $(".popup-image").magnificPopup({
        type: "image",
        // other options
    });
    $(".popup-video").magnificPopup({
        type: "iframe",
        // other options
    });

    // wow animation
    new WOW().init();
})(jQuery);

//=================  password toggle =================//

document.querySelectorAll(".toggle-password").forEach(toggle => {
    toggle.addEventListener("click", function () {
        const input = this.previousElementSibling;

        if (!input) return;

        const type = input.type === "password" ? "text" : "password";
        input.type = type;

        if (type === "password") {
            this.classList.remove("fa-eye");
            this.classList.add("fa-eye-slash");
        } else {
            this.classList.remove("fa-eye-slash");
            this.classList.add("fa-eye");
        }
    });
});

