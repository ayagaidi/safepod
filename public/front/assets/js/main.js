/* =========================================================================
 * main.js — SAFE (null-proof) version for your theme
 * - No crashes when optional elements (like .modal-cart-block) are missing
 * - Keeps jQuery ($) intact for Slick usage
 * - Uses small helpers (qs/qsa/on) and optional chaining
 * ========================================================================= */

(() => {
  "use strict";

  /* ----------------------- Helpers (do NOT shadow jQuery) ---------------------- */
  const qs  = (sel, root = document) => root.querySelector(sel);
  const qsa = (sel, root = document) => Array.from(root.querySelectorAll(sel));
  const on  = (el, evt, fn, opts) => { if (el) el.addEventListener(evt, fn, opts); };
  const has = (sel, root = document) => !!qs(sel, root);

  /* --------- Modal Cart scoped selector (returns null if modal missing) -------- */
  const MC = (sel) => qs(".modal-cart-block " + sel);

  /* --------------------------------- Top Nav ---------------------------------- */
  // Select language, currency top nav (if exists)
  (() => {
    const chooseType = qsa(".top-nav .choose-type");
    const optionItems = qsa(".top-nav .choose-type .list-option li");

    chooseType.forEach(item => {
      on(item, "click", () => {
        item.querySelector(".list-option")?.classList.toggle("open");
      });
    });

    optionItems.forEach(li => {
      on(li, "click", () => {
        const list = li.parentElement;
        list?.querySelector(".active")?.classList.remove("active");
        li.classList.add("active");
        const dataItem = li.getAttribute("data-item");
        li.closest(".choose-type")?.querySelector(".selected")?.replaceChildren(document.createTextNode(dataItem || ""));
        li.closest(".choose-type")?.classList.remove("open");
      });
    });
  })();

  /* ------------------------------ Fixed header -------------------------------- */
  (() => {
    // Fallback: .header-menu or .header (your Blade uses .header)
    const headerMain = qs(".header-menu") || qs(".header");
    on(window, "scroll", () => {
      if (!headerMain) return;
      if (window.scrollY > 100) headerMain.classList.add("fixed");
      else headerMain.classList.remove("fixed");
    });
  })();

  /* ------------------------------ Marquee top --------------------------------- */
  (() => {
    if (!window.Swiper) return; // Swiper may not be loaded on some pages
    if (!qs(".marquee-block")) return;
    try {
      /* eslint-disable no-new */
      new Swiper(".marquee-block", {
        spaceBetween: 0,
        centeredSlides: true,
        speed: 5000,
        autoplay: { delay: 1 },
        loop: true,
        slidesPerView: "auto",
        allowTouchMove: false,
        disableOnInteraction: true,
      });
      /* eslint-enable no-new */
    } catch {}
  })();

  /* ------------------------------- Menu mobile -------------------------------- */
  (() => {
    const menuMobileIcon     = qs(".menu-mobile-icon");
    const menuMobileBlock    = qs("#menu-mobile");
    const closeMenuMobileBtn = qs("#menu-mobile .close-menu-mobile-btn");

    const openMenuMobile  = () => menuMobileBlock?.classList.add("open");
    const closeMenuMobile = () => menuMobileBlock?.classList.remove("open");

    on(menuMobileIcon, "click", openMenuMobile);
    on(closeMenuMobileBtn, "click", closeMenuMobile);
    qsa("#menu-mobile .list-nav>ul>li").forEach(li => {
      on(li, "click", () => { if (!li.classList.contains("open")) li.classList.add("open"); });
    });
    qsa("#menu-mobile .list-nav>ul>li .back-btn").forEach(btn => {
      on(btn, "click", (e) => { e.stopPropagation(); btn.parentElement?.parentElement?.classList.remove("open"); });
    });
  })();

  /* ------------------------------ Modal Newsletter ---------------------------- */
  (() => {
    const modalNewsletter     = qs(".modal-newsletter");
    const modalNewsletterMain = qs(".modal-newsletter .modal-newsletter-main");
    const closeBtnNewsletter  = qs(".modal-newsletter .close-newsletter-btn");

    if (!modalNewsletter || !modalNewsletterMain) return;

    setTimeout(() => modalNewsletterMain.classList.add("open"), 3000);
    on(modalNewsletter, "click", () => modalNewsletterMain.classList.remove("open"));
    on(closeBtnNewsletter, "click", () => modalNewsletterMain.classList.remove("open"));
    on(modalNewsletterMain, "click", (e) => e.stopPropagation());
  })();

  /* -------------------------------- Modal Search ------------------------------ */
  (() => {
    const searchIcon     = qs(".search-icon");
    const modalSearch    = qs(".modal-search-block");
    const modalSearchMain= qs(".modal-search-block .modal-search-main");

    on(searchIcon, "click", () => modalSearchMain?.classList.add("open"));
    on(modalSearch, "click", () => modalSearchMain?.classList.remove("open"));
    on(modalSearchMain, "click", (e) => e.stopPropagation());
  })();

  /* ------------------------------ Search redirects ---------------------------- */
  (() => {
    qsa(".form-search").forEach(form => {
      const formInput = qs("input", form);
      const searchIcon = qs("i.ph-magnifying-glass", form);
      const searchBtn  = qs("button", form);

      on(formInput, "keyup", (e) => {
        if (e.key === "Enter") window.location.href = `search-result.html?query=${formInput.value}`;
      });
      on(searchIcon, "click", () => window.location.href = `search-result.html?query=${formInput.value}`);
      on(searchBtn, "click",  () => window.location.href = `search-result.html?query=${formInput.value}`);
    });

    qsa(".list-keyword .item").forEach(item => {
      on(item, "click", () => {
        const query = item.textContent.toLowerCase().replace(/\s+/g, "");
        window.location.href = `search-result.html?query=${query}`;
      });
    });
  })();

  /* ------------------------------- Modal login -------------------------------- */
  (() => {
    const loginIcon  = qs(".user-icon i");
    const loginPopup = qs(".login-popup");
    on(loginIcon, "click", () => loginPopup?.classList.toggle("open"));
  })();

  /* ----------------------- Init localStorage buckets -------------------------- */
  (() => {
    const ensure = (k, v) => { if (localStorage.getItem(k) === null) localStorage.setItem(k, JSON.stringify(v)); };
    ensure("cartStore", []);
    ensure("wishlistStore", []);
    ensure("compareStore", []);
    ensure("quickViewStore", []);
  })();

  /* ------------------------------- Modal Wishlist ----------------------------- */
  (() => {
    const wishlistIcon        = qs(".wishlist-icon");
    const modalWishlist       = qs(".modal-wishlist-block");
    const modalWishlistMain   = qs(".modal-wishlist-block .modal-wishlist-main");
    const closeWishlistIcon   = qs(".modal-wishlist-main .close-btn");
    const continueWishlist    = qs(".modal-wishlist-main .continue");
    const addWishlistBtns     = qsa(".add-wishlist-btn");

    const openModalWishlist  = () => modalWishlistMain?.classList.add("open");
    const closeModalWishlist = () => modalWishlistMain?.classList.remove("open");

    addWishlistBtns.forEach(btn => {
      on(btn, "click", (e) => {
        e.stopPropagation();
        btn.classList.toggle("active");
        const ic = qs("i", btn);
        if (btn.classList.contains("active")) {
          ic?.classList.remove("ph"); ic?.classList.add("ph-fill");
          openModalWishlist();
        } else {
          ic?.classList.add("ph"); ic?.classList.remove("ph-fill");
        }
      });
    });

    on(wishlistIcon,      "click", openModalWishlist);
    on(modalWishlist,     "click", closeModalWishlist);
    on(closeWishlistIcon, "click", closeModalWishlist);
    on(continueWishlist,  "click", closeModalWishlist);
    on(modalWishlistMain, "click", (e) => e.stopPropagation());

    // Render items & badge
    const handleItemModalWishlist = () => {
      let wishlistStore = JSON.parse(localStorage.getItem("wishlistStore") || "[]");

      if (wishlistIcon) wishlistIcon.querySelector("span").textContent = String(wishlistStore.length);

      const listItem = qs(".modal-wishlist-block .list-product");
      if (!listItem) return;
      listItem.innerHTML = "";

      if (wishlistStore.length === 0) {
        listItem.innerHTML = `<p class='mt-1'>No product in wishlist</p>`;
      } else {
        wishlistStore.forEach(item => {
          const prd = document.createElement("div");
          prd.setAttribute("data-item", item.id);
          prd.className = "item py-5 flex items-center justify-between gap-3 border-b border-line";
          prd.innerHTML = `
            <div class="infor flex items-center gap-5">
              <div class="bg-img"><img src="${item.thumbImage?.[0] || ""}" alt="product" class="w-[100px] aspect-square flex-shrink-0 rounded-lg"/></div>
              <div>
                <div class="name text-button">${item.name || ""}</div>
                <div class="flex items-center gap-2 mt-2">
                  <div class="product-price text-title">$${item.price ?? 0}.00</div>
                  <div class="product-origin-price text-title text-secondary2"><del>$${item.originPrice ?? 0}.00</del></div>
                </div>
              </div>
            </div>
            <div class="remove-wishlist-btn remove-btn caption1 font-semibold text-red underline cursor-pointer">Remove</div>
          `;
          listItem.appendChild(prd);
        });
      }

      qsa(".modal-wishlist-block .list-product .item").forEach(prd => {
        const removeBtn = qs(".remove-wishlist-btn", prd);
        on(removeBtn, "click", () => {
          const prdId = prd.getAttribute("data-item");
          wishlistStore = wishlistStore.filter(i => i.id !== prdId);
          localStorage.setItem("wishlistStore", JSON.stringify(wishlistStore));
          handleItemModalWishlist();
          updateWishlistIcons();
        });
      });
    };

    const updateWishlistIcons = () => {
      const wishlistIcons = qsa(".add-wishlist-btn");
      let wishlistStore = JSON.parse(localStorage.getItem("wishlistStore") || "[]");
      wishlistIcons.forEach(icon => {
        const productItem = icon.closest(".product-item");
        const productId = productItem?.getAttribute("data-item");
        const exists = wishlistStore.some(i => i.id === productId);
        const i = qs("i", icon);
        if (exists) {
          icon.classList.add("active"); i?.classList.remove("ph"); i?.classList.add("ph-fill");
        } else {
          icon.classList.remove("active"); i?.classList.add("ph"); i?.classList.remove("ph-fill");
        }
      });
    };

    handleItemModalWishlist();
    window.__updateWishlistIcons = updateWishlistIcons; // (optional) expose if you need it
  })();

  /* --------------------------------- Modal Cart -------------------------------- */
  (() => {
    // Accept both .cart-icon (old) and .cart-bubble (your Blade)
    const cartIcon          = qs(".cart-icon") || qs(".cart-bubble");
    const modalCart         = qs(".modal-cart-block");
    const modalCartMain     = qs(".modal-cart-block .modal-cart-main");
    const closeCartIcon     = qs(".modal-cart-main .close-btn");
    const continueCartIcon  = qs(".modal-cart-main .continue");
    const addCartBtns       = qsa(".add-cart-btn");

    const openModalCart  = () => modalCartMain?.classList.add("open");
    const closeModalCart = () => modalCartMain?.classList.remove("open");

    addCartBtns.forEach(btn => on(btn, "click", openModalCart));
    on(cartIcon,        "click", openModalCart);
    on(modalCart,       "click", closeModalCart);
    on(closeCartIcon,   "click", closeModalCart);
    on(continueCartIcon,"click", closeModalCart);
    on(modalCartMain,   "click", (e) => e.stopPropagation());

    // Render items & counters inside modal (null-safe)
    const handleItemModalCart = () => {
      if (!modalCart) return; // page without modal = do nothing

      let cartStore = JSON.parse(localStorage.getItem("cartStore") || "[]");
      // Set cart badge if we have an icon with <span>
      const cartIconSpan = cartIcon?.querySelector("span");
      if (cartIconSpan) cartIconSpan.textContent = String(cartStore.length);

      const listItemCart = qs(".modal-cart-block .list-product");
      if (!listItemCart) return;

      listItemCart.innerHTML = "";

      if (cartStore.length === 0) {
        listItemCart.innerHTML = `<p class='mt-1'>No product in cart</p>`;
        MC(".more-price")?.replaceChildren(document.createTextNode("0"));
        const prog = MC(".tow-bar-block .progress-line");
        if (prog) prog.style.width = "0%";
        MC(".total-cart")?.replaceChildren(document.createTextNode("$0.00"));
        return;
      }

      let totalCart = 0;
      const moneyForFreeship = 150;

      cartStore.forEach(item => {
        totalCart += Number(item.price) || 0;

        const prd = document.createElement("div");
        prd.setAttribute("data-item", item.id);
        prd.className = "item py-5 flex items-center justify-between gap-3 border-b border-line";
        prd.innerHTML = `
          <div class="infor flex items-center gap-3 w-full">
            <div class="bg-img w-[100px] aspect-square flex-shrink-0 rounded-lg overflow-hidden">
              <img src="${item.thumbImage?.[0] || ""}" alt="product" class="w-full h-full"/>
            </div>
            <div class="w-full">
              <div class="flex items-center justify-between w-full">
                <div class="name text-button">${item.name || ""}</div>
                <div class="remove-cart-btn remove-btn caption1 font-semibold text-red underline cursor-pointer">Remove</div>
              </div>
              <div class="flex items-center justify-between gap-2 mt-3 w-full">
                <div class="flex items-center text-secondary2 capitalize">${item.sizes?.[0] ?? ""}/${item.variation?.[0]?.color ?? ""}</div>
                <div class="product-price text-title">$${item.price ?? 0}.00</div>
              </div>
            </div>
          </div>
        `;
        listItemCart.appendChild(prd);
      });

      // Update totals safely
      const morePriceEl = MC(".more-price");
      const progEl      = MC(".tow-bar-block .progress-line");
      const totalEl     = MC(".total-cart");

      if (morePriceEl) morePriceEl.textContent = Math.max(0, moneyForFreeship - totalCart);
      if (progEl)      progEl.style.width     = Math.min(100, (totalCart / moneyForFreeship) * 100) + "%";
      if (totalEl)     totalEl.textContent    = "$" + totalCart + ".00";

      // Remove handlers
      qsa(".modal-cart-block .list-product .item").forEach(prd => {
        const removeBtn = qs(".remove-cart-btn", prd);
        on(removeBtn, "click", () => {
          const id = prd.getAttribute("data-item");
          cartStore = cartStore.filter(i => i.id !== id);
          localStorage.setItem("cartStore", JSON.stringify(cartStore));
          handleItemModalCart();
        });
      });
    };

    handleItemModalCart();
    // expose if needed
    window.__handleItemModalCart = handleItemModalCart;

    // Countdown cart (if UI exists)
    (() => {
      let timeLeft = 600;
      const tick = () => {
        let minutes = Math.floor(timeLeft / 60);
        if (minutes < 10) minutes = `0${minutes}`;
        let seconds = timeLeft % 60;
        if (seconds < 10) seconds = `0${seconds}`;

        qsa(".countdown-cart .minute").forEach(n => n.textContent = String(minutes));
        qsa(".countdown-cart .second").forEach(n => n.textContent = String(seconds));

        timeLeft--;
        if (timeLeft < 0) timeLeft = 600;
      };
      setInterval(tick, 1000);
    })();

    // note / shipping / coupon popups (null-safe)
    (() => {
      const noteBtn       = MC(".note-btn");
      const shippingBtn   = MC(".shipping-btn");
      const couponBtn     = MC(".coupon-btn");

      const notePopup     = MC(".note-block");
      const shippingPopup = MC(".shipping-block");
      const couponPopup   = MC(".coupon-block");

      on(noteBtn, "click", () => notePopup?.classList.toggle("active"));
      on(notePopup?.querySelector(".button-main"), "click", () => notePopup?.classList.remove("active"));
      on(notePopup?.querySelector(".cancel-btn"),  "click", () => notePopup?.classList.remove("active"));

      on(shippingBtn, "click", () => shippingPopup?.classList.toggle("active"));
      on(shippingPopup?.querySelector(".button-main"), "click", () => shippingPopup?.classList.remove("active"));
      on(shippingPopup?.querySelector(".cancel-btn"),  "click", () => shippingPopup?.classList.remove("active"));

      on(couponBtn, "click", () => couponPopup?.classList.toggle("active"));
      on(couponPopup?.querySelector(".button-main"), "click", () => couponPopup?.classList.remove("active"));
      on(couponPopup?.querySelector(".cancel-btn"),  "click", () => couponPopup?.classList.remove("active"));
    })();
  })();

  /* ------------------------------- Sub menus ---------------------------------- */
  (() => {
    const menuDepartmentBtn = qs(".menu-department-btn");
    const subMenuDepartment = qs(".sub-menu-department");
    on(menuDepartmentBtn, "click", () => subMenuDepartment?.classList.toggle("open"));

    const menuCategoryBtn = qs(".category-block .category-btn");
    const subMenuCategory = qs(".category-block .sub-menu-category");
    on(menuCategoryBtn, "click", () => subMenuCategory?.classList.toggle("open"));
  })();

  /* ------------------------------ Swipers / Sliders --------------------------- */
  (() => {
    if (!window.Swiper) return;

    // Banner top
    if (qs(".swiper-banner-top")) {
      try {
        /* eslint-disable no-new */
        new Swiper(".swiper-banner-top", {
          spaceBetween: 0,
          slidesPerView: 1,
          navigation: { prevEl: ".swiper-button-custom-prev", nextEl: ".swiper-button-custom-next" },
          loop: true,
          autoplay: { delay: 5000, disableOnInteraction: false },
        });
        /* eslint-enable no-new */
      } catch {}
    }

    // Generic slider
    if (qs(".swiper-slider")) {
      try {
        new Swiper(".swiper-slider", {
          spaceBetween: 0,
          slidesPerView: 1,
          pagination: { el: ".swiper-pagination", clickable: true },
          loop: true,
          autoplay: { delay: 4000, disableOnInteraction: false },
        });
      } catch {}
    }

    // Collection sliders
    if (qs(".swiper-collection")) {
      try {
        new Swiper(".swiper-collection", {
          navigation: { prevEl: ".swiper-button-prev", nextEl: ".swiper-button-next" },
          loop: true,
          autoplay: { delay: 3500, disableOnInteraction: false },
          slidesPerView: 2, spaceBetween: 16,
          breakpoints: { 640:{slidesPerView:3,spaceBetween:16},768:{slidesPerView:3,spaceBetween:20},1280:{slidesPerView:4,spaceBetween:20} }
        });
      } catch {}
    }

    if (qs(".swiper-collection-scroll")) {
      try {
        new Swiper(".swiper-collection-scroll", {
          scrollbar: { el: ".swiper-scrollbar", hide: true },
          loop: true, slidesPerView: 2, spaceBetween: 16,
          breakpoints: { 640:{slidesPerView:3,spaceBetween:16},768:{slidesPerView:3,spaceBetween:20},1280:{slidesPerView:4,spaceBetween:20} }
        });
      } catch {}
    }

    if (qs(".swiper-img-scroll")) {
      try {
        new Swiper(".swiper-img-scroll", {
          scrollbar: { el: ".swiper-scrollbar", hide: true },
          loop: false, slidesPerView: 2, spaceBetween: 16,
          breakpoints: { 640:{slidesPerView:3,spaceBetween:16},1024:{slidesPerView:2,spaceBetween:20} }
        });
      } catch {}
    }

    if (qs(".swiper-list-trending")) {
      try {
        new Swiper(".swiper-list-trending", {
          navigation: { prevEl: ".swiper-button-prev", nextEl: ".swiper-button-next" },
          loop: true, autoplay: { delay: 3500, disableOnInteraction: false },
          slidesPerView: 2, spaceBetween: 16,
          breakpoints: { 640:{slidesPerView:3,spaceBetween:16},768:{slidesPerView:4,spaceBetween:20},1024:{slidesPerView:5,spaceBetween:20},1280:{slidesPerView:6,spaceBetween:30} }
        });
      } catch {}
    }

    if (qs(".swiper-collection-eight")) {
      try {
        new Swiper(".swiper-collection-eight", {
          navigation: { prevEl: ".swiper-button-prev", nextEl: ".swiper-button-next" },
          loop: true, autoplay: { delay: 3500, disableOnInteraction: false },
          slidesPerView: 2, spaceBetween: 16,
          breakpoints: { 640:{slidesPerView:3,spaceBetween:16},768:{slidesPerView:3,spaceBetween:20},1024:{slidesPerView:4,spaceBetween:20},1280:{slidesPerView:5,spaceBetween:30} }
        });
      } catch {}
    }

    if (qs(".swiper-list-product")) {
      try {
        new Swiper(".swiper-list-product", {
          navigation: { prevEl: ".swiper-button-prev2", nextEl: ".swiper-button-next2" },
          loop: true, slidesPerView: 2, spaceBetween: 16,
          breakpoints: { 640:{slidesPerView:3,spaceBetween:16},768:{slidesPerView:3,spaceBetween:30},1280:{slidesPerView:4,spaceBetween:30} }
        });
      } catch {}
    }

    if (qs(".swiper-list-three-product")) {
      try {
        new Swiper(".swiper-list-three-product", {
          navigation: { prevEl: ".swiper-button-prev2", nextEl: ".swiper-button-next2" },
          loop: true, slidesPerView: 2, spaceBetween: 16,
          breakpoints: { 640:{slidesPerView:3,spaceBetween:16},768:{slidesPerView:3,spaceBetween:30},1280:{slidesPerView:3,spaceBetween:30} }
        });
      } catch {}
    }

    // Underwear thumbs
    if (qs(".mySwiper") && qs(".mySwiper2")) {
      try {
        const swiperUnderwear = new Swiper(".mySwiper", {
          spaceBetween: 0, slidesPerView: 1, watchSlidesProgress: true,
        });
        const swiper2 = new Swiper(".mySwiper2", {
          spaceBetween: 0,
          thumbs: { swiper: swiperUnderwear },
          on: {
            slideChange: function () {
              const idx = this.activeIndex;
              qsa(".mySwiper .swiper-slide").forEach(s => s.classList.remove("swiper-slide-thumb-active"));
              const slides = qsa(".mySwiper .swiper-slide");
              slides[idx]?.classList.add("swiper-slide-thumb-active");
            }
          }
        });
        // expose if other code needs
        window.__swiperUnderwear = swiperUnderwear;
        window.__swiper2 = swiper2;
      } catch {}
    }
  })();

  /* ------------------------------- Slick sliders ------------------------------ */
  (() => {
    if (!window.jQuery || !window.jQuery.fn || !window.jQuery.fn.slick) return;
    if (qs(".slider-toys-kid")) {
      window.jQuery(".slider-toys-kid").slick({
        dots: false, arrows: false, infinite: true, speed: 300,
        autoplay: false, autoplaySpeed: 4000, slidesToShow: 1, slidesToScroll: 1,
        touchThreshold: 100, draggable: true, useTransform: false,
      });
    }

    if (qs(".list-testimonial-yoga")) {
      window.jQuery(".list-testimonial-yoga").slick({
        dots: false, arrows: false, infinite: true, centerMode: true, centerPadding: "220px",
        speed: 300, autoplay: true, autoplaySpeed: 5000, slidesToShow: 3, slidesToScroll: 3,
        touchThreshold: 100, swipe: true, swipeToSlide: true, draggable: true, useTransform: false,
        responsive: [
          { breakpoint:1600, settings:{slidesToShow:3, slidesToScroll:3, centerPadding:"120px"} },
          { breakpoint:1400, settings:{slidesToShow:2, slidesToScroll:2, centerPadding:"160px"} },
          { breakpoint:1024, settings:{slidesToShow:1, slidesToScroll:1, centerPadding:"160px"} },
          { breakpoint:640,  settings:{slidesToShow:1, slidesToScroll:1, centerPadding:"16px"} },
        ],
      });
    }
  })();

  /* --------------------------- Tabs indicator movement ------------------------ */
  (() => {
    const tabItems  = qsa(".menu-tab .tab-item");
    const itemActive= qsa(".menu-tab .tab-item.active");
    itemActive.forEach(item => {
      const indicator = item.parentElement?.querySelector(".indicator");
      if (indicator) {
        const rect = item.getBoundingClientRect();
        const parentRect = item.parentElement.getBoundingClientRect();
        indicator.style.width = rect.width + "px";
        indicator.style.left  = (rect.left - parentRect.left) + "px";
      }
    });
    tabItems.forEach(item => {
      on(item, "click", () => {
        const indicator = item.parentElement?.querySelector(".indicator");
        if (indicator) {
          const rect = item.getBoundingClientRect();
          const parentRect = item.parentElement.getBoundingClientRect();
          indicator.style.width = rect.width + "px";
          indicator.style.left  = (rect.left - parentRect.left) + "px";
        }
        item.parentElement?.querySelector(".active")?.classList.remove("active");
        item.classList.add("active");
      });
    });
  })();

  /* -------------------------------- Countdown -------------------------------- */
  (() => {
    const countDown = new Date("October 15, 2024 00:00:00").getTime();
    const timer = setInterval(() => {
      const now = Date.now();
      const distance = countDown - now;

      let days    = Math.floor(distance / (1000 * 60 * 60 * 24));
      let hours   = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000*60*60));
      let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000*60));
      let seconds = Math.floor((distance % (1000 * 60)) / 1000);

      const pad = (n) => n < 10 ? `0${n}` : String(n);
      days = pad(days); hours = pad(hours); minutes = pad(minutes); seconds = pad(seconds);

      qsa(".countdown-day").forEach(el => el.textContent    = days);
      qsa(".countdown-hour").forEach(el => el.textContent   = hours);
      qsa(".countdown-minute").forEach(el => el.textContent = minutes);
      qsa(".countdown-second").forEach(el => el.textContent = seconds);

      if (distance < 0) {
        clearInterval(timer);
        qsa(".countdown-day,.countdown-hour,.countdown-minute,.countdown-second").forEach(el => el.textContent = "00");
      }
    }, 1000);
  })();

  /* ----------------------------- Product utilities ---------------------------- */
  const createProductItem = (product) => {
    const wrap = document.createElement("div");
    wrap.className = "product-item grid-type";
    wrap.setAttribute("data-item", product.id);

    // tags
    let tags = "";
    if (product.new)  tags += `<div class="product-tag text-button-uppercase bg-green px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">New</div>`;
    if (product.sale) tags += `<div class="product-tag text-button-uppercase text-white bg-red px-3 py-0.5 inline-block rounded-full absolute top-3 left-3 z-[1]">Sale</div>`;

    // images
    const imgs = (product.thumbImage || []).map((img, i) => `<img key="${i}" class="w-full h-full object-cover duration-700" src="${img}" alt="img">`).join("");

    const ratePct = Math.max(0, Math.floor(100 - (product.price / product.originPrice) * 100)) || 0;
    const soldPct = product.quantity ? Math.floor((product.sold / product.quantity) * 100) : 0;

    // colors (image or plain)
    let colorsBlock = "";
    if (product.variation?.length) {
      if (product.action === "add to cart") {
        colorsBlock = `
          <div class="list-color py-2 max-md:hidden flex items-center gap-3 flex-wrap duration-500">
            ${product.variation.map((v,i)=>`
              <div key="${i}" class="color-item w-8 h-8 rounded-full duration-300 relative" style="background-color:${v.colorCode};">
                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">${v.color}</div>
              </div>
            `).join("")}
          </div>
        `;
      } else {
        colorsBlock = `
          <div class="list-color list-color-image max-md:hidden flex items-center gap-3 flex-wrap duration-500">
            ${product.variation.map((v,i)=>`
              <div class="color-item w-12 h-12 rounded-xl duration-300 relative" key="${i}">
                <img src="${v.colorImage}" alt="color" class="rounded-xl w-full h-full object-cover"/>
                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">${v.color}</div>
              </div>
            `).join("")}
          </div>
        `;
      }
    }

    wrap.innerHTML = `
      <div class="product-main cursor-pointer block" data-item="${product.id}">
        <div class="product-thumb bg-white relative overflow-hidden rounded-2xl">
          ${tags}
          <div class="list-action-right absolute top-3 right-3 max-lg:hidden">
            <div class="add-wishlist-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative">
              <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Add To Wishlist</div>
              <i class="ph ph-heart text-lg"></i>
            </div>
            <div class="compare-btn w-[32px] h-[32px] flex items-center justify-center rounded-full bg-white duration-300 relative mt-2">
              <div class="tag-action bg-black text-white caption2 px-1.5 py-0.5 rounded-sm">Compare Product</div>
              <i class="ph ph-arrow-counter-clockwise text-lg compare-icon"></i>
              <i class="ph ph-check-circle text-lg checked-icon"></i>
            </div>
          </div>
          <div class="product-img w-full h-full aspect-[3/4]">${imgs}</div>

          ${product.sale ? `
            <div class="countdown-time-block py-1.5 flex items-center justify-center">
              <div class="text-xs font-semibold uppercase text-red">
                <span class='countdown-day'>24</span><span>D : </span>
                <span class='countdown-hour'>14</span><span>H : </span>
                <span class='countdown-minute'>36</span><span>M : </span>
                <span class='countdown-second'>51</span><span>S</span>
              </div>
            </div>
          ` : ""}

          <div class="list-action grid grid-cols-2 gap-3 px-5 absolute w-full bottom-5">
            <div class="quick-view-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
              <span class="max-lg:hidden">Quick View</span><i class="ph ph-eye lg:hidden text-xl"></i>
            </div>
            ${product.action === "add to cart" ? `
              <div class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white">
                <span class="max-lg:hidden">Add To Cart</span><i class="ph ph-shopping-bag-open lg:hidden text-xl"></i>
              </div>
            ` : `
              <div class="quick-shop-btn text-button-uppercase py-2 text-center rounded-full duration-500 bg-white hover:bg-black hover:text-white max-lg:hidden">Quick Shop</div>
              <div class="add-cart-btn w-full text-button-uppercase py-2 text-center rounded-full duration-300 bg-white hover:bg-black hover:text-white lg:hidden">
                <span class="max-lg:hidden">Add To Cart</span><i class="ph ph-shopping-bag-open lg:hidden text-xl"></i>
              </div>
              <div class="quick-shop-block absolute left-5 right-5 bg-white p-5 rounded-[20px]">
                <div class="list-size flex items-center justify-center flex-wrap gap-2">
                  ${(product.sizes || []).map((s,i)=>`<div key="${i}" class="size-item w-10 h-10 rounded-full flex items-center justify-center text-button bg-white border border-line">${s.trim()}</div>`).join("")}
                </div>
                <div class="add-cart-btn button-main w-full text-center rounded-full py-3 mt-4">Add To cart</div>
              </div>
            `}
          </div>
        </div>

        <div class="product-infor mt-4 lg:mb-7">
          <div class="product-sold sm:pb-4 pb-2">
            <div class="progress bg-line h-1.5 w-full rounded-full overflow-hidden relative">
              <div class="progress-sold bg-red absolute left-0 top-0 h-full" style="width:${soldPct}%"></div>
            </div>
            <div class="flex items-center justify-between gap-3 gap-y-1 flex-wrap mt-2">
              <div class="text-button-uppercase"><span class='text-secondary2 max-sm:text-xs'>Sold:</span> <span class='max-sm:text-xs'>${product.sold ?? 0}</span></div>
              <div class="text-button-uppercase"><span class='text-secondary2 max-sm:text-xs'>Available:</span> <span class='max-sm:text-xs'>${(product.quantity ?? 0) - (product.sold ?? 0)}</span></div>
            </div>
          </div>
          <div class="product-name text-title duration-300">${product.name || ""}</div>
          ${colorsBlock}
          <div class="product-price-block flex items-center gap-2 flex-wrap mt-1 duration-300 relative z-[1]">
            <div class="product-price text-title">$${product.price ?? 0}.00</div>
            ${ratePct > 0 ? `
              <div class="product-origin-price caption1 text-secondary2"><del>$${product.originPrice ?? 0}.00</del></div>
              <div class="product-sale caption1 font-medium bg-green px-3 py-0.5 inline-block rounded-full">-${ratePct}%</div>
            ` : ""}
          </div>
        </div>
      </div>
    `;
    return wrap;
  };

  const createProductItemMarketplace = (product) => {
    const wrap = document.createElement("div");
    wrap.className = "product-item style-marketplace p-4 border border-line rounded-2xl";
    wrap.setAttribute("data-item", product.id);

    let stars = "";
    for (let i = 0; i < 5; i++) {
      stars += i >= (product.rate || 0)
        ? '<i class="ph-fill ph-star text-sm text-secondary"></i>'
        : '<i class="ph-fill ph-star text-sm text-yellow"></i>';
    }

    wrap.innerHTML = `
      <div class="bg-img relative w-full aspect-1/1">
        <img src="${product.thumbImage?.[0] || ""}" alt="">
        <div class="list-action flex flex-col gap-1 absolute top-0 right-0">
          <span class="add-wishlist-btn w-8 h-8 bg-white flex items-center justify-center rounded-full box-shadow-small duration-300"><i class="ph ph-heart"></i></span>
          <span class="compare-btn w-8 h-8 bg-white flex items-center justify-center rounded-full box-shadow-small duration-300"><i class="ph ph-repeat"></i></span>
          <span class="quick-view-btn w-8 h-8 bg-white flex items-center justify-center rounded-full box-shadow-small duration-300"><i class="ph ph-eye"></i></span>
          <span class="add-cart-btn w-8 h-8 bg-white flex items-center justify-center rounded-full box-shadow-small duration-300"><i class="ph ph-shopping-bag-open"></i></span>
        </div>
      </div>
      <div class="product-infor mt-4">
        <span class="text-title">${product.name || ""}</span>
        <div class="flex gap-0.5 mt-1">${stars}</div>
        <span class="text-title inline-block mt-1">$${product.price ?? 0}.00</span>
      </div>
    `;
    return wrap;
  };

  /* ---------------------- Product list builders from JSON --------------------- */
  (() => {
    // Defensive: fetch only if we see any of the target lists in DOM
    const needsProducts =
      qsa(".list-product.four-product").length ||
      qs(".list-product.six-product .swiper .swiper-wrapper") ||
      qs(".list-product.eight-product") ||
      qsa(".list-product.three-product").length ||
      qs(".tab-features-block.style-marketplace .list-product");

    if (!needsProducts) return;

    fetch("./assets/data/Product.json")
      .then(r => r.json())
      .then(products => {
        // FOUR PRODUCT (multiple lists)
        qsa(".list-product.four-product").forEach(list => {
          const parent = list.parentElement;
          const activeTab = parent?.querySelector(".menu-tab .active");
          if (!activeTab) {
            products.slice(0,4).forEach(p => list.appendChild(createProductItem(p)));
            return;
          }
          const menuItemActive = activeTab.getAttribute("data-item");
          const menuItems = parent.querySelectorAll(".menu-tab .tab-item");

          const pump = () => {
            // clear old
            qsa(".product-item", list).forEach(el => el.remove());
            if (list.getAttribute("data-type") === "underwear") {
              if (menuItemActive === "best sellers") {
                products
                  .filter(p => (p.type === "underwear" || p.type === "swimwear"))
                  .sort((a,b)=> (b.sold||0)-(a.sold||0)).slice(0,4)
                  .forEach(p => list.appendChild(createProductItem(p)));
              }
            } else {
              products.filter(p => p.type === menuItemActive).slice(0,4)
                .forEach(p => list.appendChild(createProductItem(p)));
            }
          };
          pump();

          menuItems.forEach(mi => on(mi, "click", () => {
            const key = mi.getAttribute("data-item");
            // clear
            qsa(".product-item", list).forEach(el => el.remove());
            if (list.getAttribute("data-type") === "underwear") {
              if (key === "best sellers") {
                products.filter(p => p.type === "underwear" || p.type === "swimwear")
                        .sort((a,b)=> (b.sold||0)-(a.sold||0)).slice(0,4)
                        .forEach(p => list.appendChild(createProductItem(p)));
              }
              if (key === "on sale") {
                products.filter(p => p.sale && (p.type === "underwear" || p.type === "swimwear"))
                        .slice(0,4).forEach(p => list.appendChild(createProductItem(p)));
              }
              if (key === "new arrivals") {
                products.filter(p => p.new && (p.type === "underwear" || p.type === "swimwear"))
                        .slice(0,4).forEach(p => list.appendChild(createProductItem(p)));
              }
            } else {
              products.filter(p => p.type === key).slice(0,4)
                .forEach(p => list.appendChild(createProductItem(p)));
            }
          }));
        });

        // SIX PRODUCT (swiper wrapper)
        (() => {
          const wrap = qs(".list-product.six-product .swiper .swiper-wrapper");
          if (!wrap) return;
          const parent = wrap.parentElement?.parentElement?.parentElement;
          const activeTab = parent?.querySelector(".menu-tab .active");
          const fillSlides = (items) => {
            qsa(".swiper-slide", wrap).forEach(sl => sl.remove());
            items.forEach(p => {
              const slide = document.createElement("div");
              slide.className = "swiper-slide";
              slide.appendChild(createProductItem(p));
              wrap.appendChild(slide);
            });
          };

          if (activeTab) {
            const menuItems = parent.querySelectorAll(".menu-tab .tab-item");
            const type = wrap.getAttribute("data-type");
            const seed = activeTab.getAttribute("data-item");

            const seedFill = () => {
              if (seed === "best sellers") {
                const base = type ? products.filter(p => p.category === type) : products.filter(p => p.category === "fashion");
                fillSlides(base.sort((a,b)=> (b.sold||0)-(a.sold||0)).slice(0,6));
              }
            };
            seedFill();

            menuItems.forEach(mi => on(mi, "click", () => {
              const key = mi.getAttribute("data-item");
              const base = type ? products.filter(p => p.category === type) : products.filter(p => p.category === "fashion");
              if (key === "best sellers") fillSlides(base.sort((a,b)=> (b.sold||0)-(a.sold||0)).slice(0,6));
              if (key === "on sale")     fillSlides(base.filter(p => p.sale).slice(0,6));
              if (key === "new arrivals") fillSlides(base.filter(p => p.new).slice(0,6));
            }));
          } else {
            const type = wrap.getAttribute("data-type");
            if (type) fillSlides(products.filter(p => p.category === type).slice(0,6));
            else      fillSlides(products.slice(5,11));
          }
        })();

        // EIGHT PRODUCT
        (() => {
          const list = qs(".list-product.eight-product");
          if (!list) return;
          const parent = list.parentElement;
          const activeTab = parent?.querySelector(".menu-tab .active");
          const fill = (items) => {
            qsa(".product-item", list).forEach(el => el.remove());
            items.forEach(p => list.appendChild(createProductItem(p)));
          };
          if (activeTab) {
            const menuItems = parent.querySelectorAll(".menu-tab .tab-item");
            const seed = activeTab.getAttribute("data-item");
            if (seed === "best sellers") fill(products.filter(p => p.category === "fashion").sort((a,b)=> (b.sold||0)-(a.sold||0)).slice(0,8));
            menuItems.forEach(mi => on(mi, "click", () => {
              const key = mi.getAttribute("data-item");
              if (key === "best sellers") fill(products.filter(p => p.category === "fashion").sort((a,b)=> (b.sold||0)-(a.sold||0)).slice(0,8));
              if (key === "on sale")      fill(products.filter(p => p.sale && p.category === "fashion").slice(0,8));
              if (key === "new arrivals") fill(products.filter(p => p.new && p.category === "fashion").slice(0,8));
            }));
          } else {
            const type = list.getAttribute("data-type");
            if (type) fill(products.filter(p => p.category === type).slice(0,8));
            else      fill(products.slice(11,19));
          }
        })();

        // THREE PRODUCT (home 11)
        qsa(".list-product.three-product").forEach(list => {
          const parent = list.parentElement;
          const gender = list.getAttribute("data-gender");
          const activeTab = parent?.querySelector(".menu-tab .active");
          const menuItems = parent?.querySelectorAll(".menu-tab .tab-item") || [];
          const fill = (typeKey) => {
            qsa(".product-item", list).forEach(el => el.remove());
            products.filter(p => p.gender === gender && p.type === typeKey).slice(0,3)
              .forEach(p => list.appendChild(createProductItem(p)));
          };
          if (activeTab) fill(activeTab.getAttribute("data-item"));
          menuItems.forEach(mi => on(mi, "click", () => fill(mi.getAttribute("data-item"))));
        });

        // Marketplace tab
        (() => {
          const list = qs(".tab-features-block.style-marketplace .list-product");
          if (!list) return;
          const parent = list.parentElement;
          const active = parent.querySelector(".menu-tab .active");
          const menuItems = parent.querySelectorAll(".menu-tab .tab-item");

          const fill = (items) => {
            qsa(".product-item", list).forEach(el => el.remove());
            items.slice(0,5).forEach(p => list.appendChild(createProductItemMarketplace(p)));
          };

          if (active) fill(products.filter(p => p.category === active.getAttribute("data-item")));
          else fill(products.slice(0,5));

          menuItems.forEach(mi => on(mi, "click", () => fill(products.filter(p => p.category === mi.getAttribute("data-item")))));
        })();

        // Helpers depending on built items
        handleActiveColorChange();
        handleActiveSizeChange();
        addEventToProductItem(products);
      })
      .catch(() => {});
  })();

  /* ------------------------- Product item interactions ------------------------ */
  function addEventToProductItem(products) {
    const productItems = qsa(".product-item");
    productItems.forEach(product => {
      const productId = product.getAttribute("data-item");
      on(product, "click", () => window.location.href = `product-default.html?id=${productId}`);

      const compareIcon   = qs(".compare-btn", product);
      const addWishlist   = qs(".add-wishlist-btn", product);
      const addCartIcons  = qsa(".add-cart-btn", product);
      const quickviewIcon = qs(".quick-view-btn", product);
      const quickshopIcon = qs(".quick-shop-btn", product);
      const modalQuickshop= qs(".quick-shop-block", product);

      // Wishlist button
      if (addWishlist) {
        let wishlistStore = JSON.parse(localStorage.getItem("wishlistStore") || "[]");
        const inList = wishlistStore.some(p => p.id === productId);
        if (inList) {
          addWishlist.classList.add("active");
          const i = qs("i", addWishlist); i?.classList.remove("ph"); i?.classList.add("ph-fill");
        }

        on(addWishlist, "click", (e) => {
          e.stopPropagation();
          let store = JSON.parse(localStorage.getItem("wishlistStore") || "[]");
          const idx = store.findIndex(i => i.id === productId);
          const i = qs("i", addWishlist);
          if (idx > -1) {
            store.splice(idx, 1);
            addWishlist.classList.remove("active");
            i?.classList.add("ph"); i?.classList.remove("ph-fill");
          } else {
            const prod = products?.find(p => p.id === productId);
            if (prod) {
              store.push(prod);
              addWishlist.classList.add("active");
              i?.classList.remove("ph"); i?.classList.add("ph-fill");
              qs(".modal-wishlist-block .modal-wishlist-main")?.classList.add("open");
            }
          }
          localStorage.setItem("wishlistStore", JSON.stringify(store));
          (window.__updateWishlistIcons || (()=>{}))();
        });
      }

      // Compare button
      if (compareIcon) {
        let compareStore = JSON.parse(localStorage.getItem("compareStore") || "[]");
        if (compareStore.some(p => p.id === productId)) compareIcon.classList.add("active");
        on(compareIcon, "click", (e) => {
          e.stopPropagation();
          let store = JSON.parse(localStorage.getItem("compareStore") || "[]");
          const idx = store.findIndex(i => i.id === productId);
          if (idx > -1) {
            store.splice(idx, 1);
            compareIcon.classList.remove("active");
          } else {
            if (store.length >= 3) { alert("List compare product must be <= 3"); }
            else {
              const prod = products?.find(p => p.id === productId);
              if (prod) { store.push(prod); compareIcon.classList.add("active"); }
            }
          }
          localStorage.setItem("compareStore", JSON.stringify(store));
          qs(".modal-compare-block .modal-compare-main")?.classList.add("open");
        });
      }

      // Quick view
      if (quickviewIcon) {
        on(quickviewIcon, "click", (e) => {
          e.stopPropagation();
          const prod = products?.find(p => p.id === productId);
          if (!prod) return;
          const block = qs(".modal-quickview-block .modal-quickview-main");
          const host  = qs(".modal-quickview-block");
          if (!block || !host) return;

          block.setAttribute("data-item", prod.id);
          const listImg = qs(".list-img", block);
          if (listImg) {
            listImg.innerHTML = (prod.images || []).map(img => `
              <div class="bg-img w-full aspect-[3/4] max-md:w-[150px] max-md:flex-shrink-0 rounded-[20px] overflow-hidden md:mt-6">
                <img src="${img}" alt="item" class="w-full h-full object-cover"/>
              </div>
            `).join("");
          }

          qs(".product-infor .category", block) && (qs(".product-infor .category", block).textContent = prod.category || "");
          qs(".product-infor .name", block) && (qs(".product-infor .name", block).textContent = prod.name || "");
          // price + sale
          const pPrice = qs(".product-infor .product-price", block);
          const pOrigin = qs(".product-infor .product-origin-price del", block);
          const pSale = qs(".product-infor .product-sale", block);
          if (pPrice) pPrice.textContent = `$${prod.price ?? 0}.00`;
          if (pOrigin) pOrigin.textContent = `$${prod.originPrice ?? 0}.00`;
          if (pSale) pSale.textContent = `-${Math.floor(100 - (prod.price / prod.originPrice) * 100)}%`;
          qs(".product-infor .desc", block) && (qs(".product-infor .desc", block).textContent = prod.description || "");

          const listColor = qs(".list-color", block);
          if (listColor) {
            listColor.innerHTML = (prod.variation || []).map(c => `
              <div class="color-item w-12 h-12 rounded-xl duration-300 relative">
                <img src="${c.colorImage}" alt="color" class="rounded-xl w-full h-full object-cover"/>
                <div class="tag-action bg-black text-white caption2 capitalize px-1.5 py-0.5 rounded-sm">${c.color}</div>
              </div>
            `).join("");
          }

          // Wishlist in quickview
          const wbtn = qs(".add-wishlist-btn", block);
          if (wbtn) {
            let wishlistStore = JSON.parse(localStorage.getItem("wishlistStore") || "[]");
            const idx = wishlistStore.findIndex(p => p.id === prod.id);
            if (idx > -1) { wbtn.classList.add("active"); const i = qs("i", wbtn); i?.classList.remove("ph"); i?.classList.add("ph-fill"); }
            on(wbtn, "click", () => {
              let store = JSON.parse(localStorage.getItem("wishlistStore") || "[]");
              const i = qs("i", wbtn);
              const j = store.findIndex(p => p.id === prod.id);
              if (j > -1) {
                store.splice(j, 1); wbtn.classList.remove("active"); i?.classList.add("ph"); i?.classList.remove("ph-fill");
              } else {
                store.push(prod); wbtn.classList.add("active"); i?.classList.remove("ph"); i?.classList.add("ph-fill");
              }
              localStorage.setItem("wishlistStore", JSON.stringify(store));
              qs(".modal-wishlist-block .modal-wishlist-main")?.classList.add("open");
            });
          }

          // Add to cart in quickview
          const cbtn = qs(".add-cart-btn", block);
          if (cbtn) {
            on(cbtn, "click", (e2) => {
              e2.stopPropagation();
              let cartStore = JSON.parse(localStorage.getItem("cartStore") || "[]");
              const existed = cartStore.findIndex(p => p.id === prod.id) > -1;
              if (!existed) cartStore.push(prod);
              localStorage.setItem("cartStore", JSON.stringify(cartStore));
              (window.__handleItemModalCart || (()=>{}))();
              qs(".modal-cart-block .modal-cart-main")?.classList.add("open");
            });
          }

          // Open quickview
          on(host, "click", () => qs(".modal-quickview-block .modal-quickview-main")?.classList.remove("open"));
          qs(".modal-quickview-block .modal-quickview-main .close-btn") && on(qs(".modal-quickview-block .modal-quickview-main .close-btn"), "click", () => qs(".modal-quickview-block .modal-quickview-main")?.classList.remove("open"));
          qs(".modal-quickview-block .modal-quickview-main")?.addEventListener("click", (ev)=> ev.stopPropagation());
          qs(".modal-cart-block .modal-cart-main")?.classList.remove("open");
          qs(".modal-quickview-block .modal-quickview-main")?.classList.add("open");
        });
      }

      // Add to cart from product tile
      if (addCartIcons?.length) {
        addCartIcons.forEach(icon => on(icon, "click", (e) => {
          e.stopPropagation();
          const prod = products?.find(p => p.id === productId);
          if (!prod) return;
          let cartStore = JSON.parse(localStorage.getItem("cartStore") || "[]");
          const exists = cartStore.findIndex(p => p.id === prod.id) > -1;
          if (!exists) cartStore.push(prod);
          localStorage.setItem("cartStore", JSON.stringify(cartStore));
          (window.__handleItemModalCart || (()=>{}))();
          qs(".modal-cart-block .modal-cart-main")?.classList.add("open");
          if (modalQuickshop?.classList.contains("open")) modalQuickshop.classList.remove("open");
        }));
      }

      // Quick shop
      if (quickshopIcon && modalQuickshop) {
        on(quickshopIcon, "click", (e) => { e.stopPropagation(); modalQuickshop.classList.add("open"); });
      }
    });
  }

  /* -------------------------- Size / Color active UI -------------------------- */
  function handleActiveSizeChange() {
    qsa(".list-size").forEach(list => {
      qsa(".size-item", list).forEach(size => {
        on(size, "click", () => {
          list.querySelector(".active")?.classList.remove("active");
          size.classList.add("active");
        });
      });
      on(list, "click", (e) => {
        e.stopPropagation();
        const chooseBlock = list.parentElement;
        const out = chooseBlock?.querySelector(".size");
        const active = list.querySelector(".size-item.active");
        if (out && active) out.textContent = active.textContent;
      });
    });
  }

  function handleActiveColorChange() {
    qsa(".list-color").forEach(list => {
      qsa(".color-item", list).forEach(color => {
        on(color, "click", () => {
          list.querySelector(".active")?.classList.remove("active");
          color.classList.add("active");
        });
      });
      on(list, "click", (e) => {
        e.stopPropagation();
        const chooseBlock = list.parentElement;
        const out = chooseBlock?.querySelector(".color");
        const active = list.querySelector(".color-item.active .tag-action");
        if (out && active) out.textContent = active.textContent;
      });
    });
  }

  /* ----------------------------- Filter product img --------------------------- */
  (() => {
    const filterProductImg = qs(".filter-product-img");
    if (!filterProductImg) return;

    fetch("./assets/data/Product.json")
      .then(r => r.json())
      .then(data => {
        const pid = qs(".product-infor", filterProductImg)?.getAttribute("data-item");
        const productMain = data.find(p => p.id === pid);
        if (!productMain) return;

        qsa(".color-item", filterProductImg).forEach(item => {
          on(item, "click", () => {
            const selectedColor = qs(".tag-action", item)?.textContent?.trim();
            const variation = productMain.variation?.find(v => v.color === selectedColor);
            const selectedImage = variation?.image;
            if (!selectedImage) return;

            const slides = qsa(".swiper-slide", filterProductImg);
            let targetIndex = slides.findIndex(sl => qs("img", sl)?.getAttribute("src") === selectedImage);
            if (targetIndex === -1) return;

            if (qs(".product-detail")) targetIndex -= 4;
            if (qs(".underwear"))      targetIndex -= 4;

            try { window.__swiper2?.slideTo?.(targetIndex); } catch {}
            try {
              const scroll = document.querySelector(".swiper-img-scroll")?._swiper;
              scroll?.slideTo?.(targetIndex);
            } catch {}
          });
        });
      })
      .catch(() => {});
  })();

  /* ------------------------------- Quantity blocks ---------------------------- */
  (() => {
    const quantityBlocks = qsa(".quantity-block");
    quantityBlocks.forEach(block => {
      const minus = qs(".ph-minus", block);
      const plus  = qs(".ph-plus", block);
      const qty   = qs(".quantity", block);
      if (!qty) return;

      const setDisabled = () => { if (Number(qty.textContent) < 2) minus?.classList.add("disabled"); else minus?.classList.remove("disabled"); };
      setDisabled();

      on(minus, "click", (e) => {
        e.stopPropagation();
        const val = Math.max(1, Number(qty.textContent) - 1);
        qty.textContent = String(val);
        setDisabled();
      });
      on(plus, "click", (e) => {
        e.stopPropagation();
        qty.textContent = String(Number(qty.textContent) + 1);
        setDisabled();
      });
    });
  })();

  /* -------------------------------- Blog items -------------------------------- */
  (() => {
    qsa(".blog-item").forEach(blog => {
      on(blog, "click", () => {
        const id = blog.getAttribute("data-item");
        window.location.href = `blog-detail1.html?id=${id}`;
      });
    });
  })();

  /* ------------------------------- Testimonials ------------------------------- */
  (() => {
    if (!window.Swiper) return;

    if (qs(".swiper-list-testimonial")) {
      try {
        new Swiper(".swiper-list-testimonial", {
          pagination: { clickable: true, el: ".swiper-pagination" },
          loop: true,
          autoplay: { delay: 5000, disableOnInteraction: false },
          touchEventsTarget: "wrapper",
          slidesPerView: 1, spaceBetween: 0,
          breakpoints: { 640:{slidesPerView:2,spaceBetween:16},768:{slidesPerView:2,spaceBetween:16},1280:{slidesPerView:3,spaceBetween:30} }
        });
      } catch {}
    }

    const handleSlideActive = () => {
      const active = qs(".list-testimonial .swiper .swiper-slide-active");
      if (!active) return;
      const dataItem = active.getAttribute("data-item");
      const listAvatar = qs(".list-avatar");
      const avatars = qsa(".list-avatar .bg-img");
      avatars.forEach(a => {
        if (a.getAttribute("data-item") === dataItem) {
          listAvatar?.querySelector(".active")?.classList.remove("active");
          a.classList.add("active");
        }
      });
    };

    if (qs(".swiper-testimonial-four")) {
      try {
        new Swiper(".swiper-testimonial-four", {
          navigation: { prevEl: ".swiper-button-prev", nextEl: ".swiper-button-next" },
          autoplay: { delay: 3000 }, loop: true, slidesPerView: 1, spaceBetween: 0,
          on: { slideChange: handleSlideActive }
        });
      } catch {}
    }
  })();

  /* -------------------------------- Instagram --------------------------------- */
  (() => {
    if (!window.Swiper) return;

    if (qs(".swiper-list-instagram")) {
      try {
        new Swiper(".swiper-list-instagram", {
          pagination: { clickable: true, el: ".swiper-pagination" },
          loop: true,
          autoplay: { delay: 4000, disableOnInteraction: false },
          slidesPerView: 2, spaceBetween: 12,
          breakpoints: { 640:{slidesPerView:3,spaceBetween:12},768:{slidesPerView:3,spaceBetween:16},1024:{slidesPerView:4,spaceBetween:16},1280:{slidesPerView:5,spaceBetween:16} }
        });
      } catch {}
    }

    if (qs(".swiper-instagram-three")) {
      try {
        new Swiper(".swiper-instagram-three", {
          loop: true, autoplay: { delay: 4000, disableOnInteraction: false }, clickable: true,
          slidesPerView: 2, spaceBetween: 0,
          breakpoints: { 640:{slidesPerView:3},768:{slidesPerView:4},1024:{slidesPerView:5},1280:{slidesPerView:6} }
        });
      } catch {}
    }
  })();

  /* --------------------------------- Brands ----------------------------------- */
  (() => {
    if (!window.Swiper) return;

    if (qs(".swiper-list-brand")) {
      try {
        new Swiper(".swiper-list-brand", {
          pagination: { clickable: true, el: ".swiper-pagination" },
          loop: true, autoplay: { delay: 4000, disableOnInteraction: false },
          slidesPerView: 2, spaceBetween: 12,
          breakpoints: { 640:{slidesPerView:3,spaceBetween:12},768:{slidesPerView:4,spaceBetween:16},1024:{slidesPerView:5,spaceBetween:16},1280:{slidesPerView:6,spaceBetween:16} }
        });
      } catch {}
    }

    if (qs(".swiper-list-five-brand")) {
      try {
        new Swiper(".swiper-list-five-brand", {
          pagination: { clickable: true, el: ".swiper-pagination" },
          loop: true, autoplay: { delay: 4000, disableOnInteraction: false },
          slidesPerView: 2, spaceBetween: 12,
          breakpoints: { 640:{slidesPerView:3,spaceBetween:12},768:{slidesPerView:3,spaceBetween:16},1024:{slidesPerView:4,spaceBetween:16},1280:{slidesPerView:5,spaceBetween:16} }
        });
      } catch {}
    }
  })();

  /* -------------------------- Before/After (Cosmetic1) ------------------------ */
  (() => {
    const sc = qs('[data-component="image-comparison-slider"]');
    if (!sc) return;

    const range = qs('[data-image-comparison-range]', sc);
    const slider= qs('[data-image-comparison-slider]', sc);
    const overlay= qs('[data-image-comparison-overlay]', sc);
    const thumb = qs('[data-image-comparison-thumb]', sc);

    const setSliderstate = (e) => {
      if (!range) return;
      if (e.type === "input") range.classList.add("image-comparison__range--active");
      else {
        range.classList.remove("image-comparison__range--active");
        sc.removeEventListener("mousemove", moveSliderThumb);
      }
    };

    const moveSliderThumb = (e) => {
      if (!range || !thumb) return;
      let position = e.layerY - 20;
      if (e.layerY <= range.offsetTop) position = -20;
      if (e.layerY >= range.offsetHeight) position = range.offsetHeight - 20;
      thumb.style.top = `${position}px`;
    };

    const moveSliderRange = (e) => {
      const value = e.target.value;
      if (slider)  slider.style.left = `${value}%`;
      if (overlay) overlay.style.width = `${value}%`;
      sc.addEventListener("mousemove", moveSliderThumb);
      setSliderstate(e);
    };

    if (range) {
      if (!("ontouchstart" in window)) {
        on(range, "mouseup", setSliderstate);
        on(range, "mousedown", moveSliderThumb);
      }
      on(range, "input", moveSliderRange);
      on(range, "change", moveSliderRange);
    }
  })();

  /* ------------------------- Change active video cosmetic2 -------------------- */
  (() => {
    const listCategory = qs(".list-category");
    const categoryItems= qsa(".list-category .item");
    const listFilter   = qs(".list-filter");
    const filterItems  = qsa(".list-filter .item");

    if (!categoryItems.length) return;

    categoryItems.forEach((cat) => {
      on(cat, "click", () => {
        filterItems.forEach(item => {
          if (item.getAttribute("data-item") === cat.getAttribute("data-item")) {
            listCategory?.querySelector(".active")?.classList.remove("active");
            cat.classList.add("active");
            listFilter?.querySelector(".active")?.classList.remove("active");
            item.classList.add("active");
          }
        });
      });
    });
  })();

  /* --------------------------------- Modal Video ------------------------------ */
  (() => {
    const modalVideo = qs(".modal-video-block");
    const modalVideoMain = qs(".modal-video-block .modal-video-main");
    qsa(".btn-play").forEach(btn => {
      on(btn, "click", () => modalVideoMain?.classList.add("open"));
    });
    on(modalVideo, "click", () => modalVideoMain?.classList.remove("open"));
    on(modalVideoMain, "click", (e) => e.stopPropagation());
  })();

  /* ------------------------------- Scroll to top ------------------------------ */
  (() => {
    const btn = qs(".scroll-to-top-btn");
    on(window, "scroll", () => {
      if (!btn) return;
      if (window.scrollY > 600) btn.classList.add("active"); else btn.classList.remove("active");
    });
  })();

  /* ------------------------ Layout cols (wishlist/shop) ----------------------- */
  (() => {
    const layoutList = qs(".list-product-block .list-product");
    const items = qsa(".choose-layout .item");
    if (!layoutList || !items.length) return;

    const apply = (item) => {
      layoutList.classList.remove("lg:grid-cols-3","lg:grid-cols-4","lg:grid-cols-5");
      if (item.classList.contains("three-col")) layoutList.classList.add("lg:grid-cols-3");
      else if (item.classList.contains("four-col")) layoutList.classList.add("lg:grid-cols-4");
      else if (item.classList.contains("five-col")) layoutList.classList.add("lg:grid-cols-5");
    };

    items.forEach(item => {
      if (item.classList.contains("active")) apply(item);
      on(item, "click", () => apply(item));
    });
  })();

  /* ------------------ Display wishlist/cart/compare on pages ------------------ */
  (() => {
    // Wishlist page
    const listProductWishlist = qs(".wishlist-block .list-product");
    if (listProductWishlist) {
      const wishlistStore = JSON.parse(localStorage.getItem("wishlistStore") || "[]");
      wishlistStore.forEach(p => listProductWishlist.appendChild(createProductItem(p)));
    }

    // Compare page
    const listProductCompare = qs(".compare-block .content-main");
    if (listProductCompare) {
      const compareStore = JSON.parse(localStorage.getItem("compareStore") || "[]");
      const listImg   = qs(".list-product .right", listProductCompare);
      const listRate  = qs(".list-rate-block", listProductCompare);
      const listPrice = qs(".list-price-block", listProductCompare);
      const listType  = qs(".list-type-block", listProductCompare);
      const listBrand = qs(".list-brand-block", listProductCompare);
      const listSize  = qs(".list-size-block", listProductCompare);
      const listColor = qs(".list-color-block", listProductCompare);

      if (compareStore.length === 0) {
        listProductCompare.innerHTML = `<div class="flex items-center justify-between w-full"><div><div class="text-title">No product in compare</div></div></div>`;
      } else {
        compareStore.forEach(prod => {
          // images
          const el = document.createElement("div");
          el.setAttribute("data-item", prod.id);
          el.className = "product-item px-10 pt-6 pb-5 border-r border-line cursor-pointer";
          el.innerHTML = `
            <div class="bg-img w-full h-[100%] aspect-[3/4] rounded-lg overflow-hidden flex-shrink-0">
              <img src="${prod.thumbImage?.[0] || ""}" alt="img" class="w-full h-full object-cover"/>
            </div>
            <div class="text-title text-center mt-4">${prod.name || ""}</div>
            <div class="caption2 font-semibold text-secondary2 uppercase text-center mt-1">${prod.brand || ""}</div>
          `;
          listImg?.appendChild(el);

          // rate
          let stars = "";
          for (let i=0;i<5;i++) stars += i >= (prod.rate||0)
            ? '<i class="ph-fill ph-star text-sm text-secondary"></i>'
            : '<i class="ph-fill ph-star text-sm text-yellow"></i>';
          const rateTd = document.createElement("td");
          rateTd.className = "w-full border border-line h-[60px] border-t-0 border-r-0";
          rateTd.innerHTML = `<div class='h-full flex items-center justify-center'><div class="rate flex">${stars}</div><p class='pl-1'>(1.234)</p></div>`;
          listRate?.appendChild(rateTd);

          // price
          const priceTd = document.createElement("td");
          priceTd.className = "w-full border border-line h-[60px] border-t-0 border-r-0";
          priceTd.innerHTML = `<div class='price-item h-full flex items-center justify-center'>$${prod.price ?? 0}.00</div>`;
          listPrice?.appendChild(priceTd);

          // type
          const typeTd = document.createElement("td");
          typeTd.className = "w-full border border-line h-[60px] border-t-0 border-r-0";
          typeTd.innerHTML = `<div class='type-item h-full flex items-center justify-center capitalize'>${prod.type || ""}</div>`;
          listType?.appendChild(typeTd);

          // brand
          const brandTd = document.createElement("td");
          brandTd.className = "w-full border border-line h-[60px] border-t-0 border-r-0";
          brandTd.innerHTML = `<div class='brand-item h-full flex items-center justify-center capitalize'>${prod.brand || ""}</div>`;
          listBrand?.appendChild(brandTd);

          // size
          const sizeTd = document.createElement("td");
          sizeTd.className = "w-full border border-line h-[60px] border-t-0 border-r-0";
          sizeTd.innerHTML = `<div class='list-size h-full flex items-center justify-center capitalize gap-1'>${(prod.sizes||[]).map((s,i,arr)=>`<p>${s}${i<arr.length-1?',':''}</p>`).join("")}</div>`;
          listSize?.appendChild(sizeTd);

          // color
          const colorTd = document.createElement("td");
          colorTd.className = "w-full border border-line h-[60px] border-t-0 border-r-0";
          colorTd.innerHTML = `<div class='list-color h-full flex items-center justify-center capitalize gap-2'>${(prod.variation||[]).map(v=>`<span class='w-6 h-6 rounded-full' style="background-color:${v.colorCode};"></span>`).join("")}</div>`;
          listColor?.appendChild(colorTd);
        });
      }
    }
  })();

  /* --------------------------------- Cart page -------------------------------- */
  (() => {
    const cartPage = qs(".cart-block");
    const listProductCart = qs(".cart-block .list-product-main");
    if (!cartPage || !listProductCart) return;

    const moneyForFreeship = 150;
    const progress = qs(".tow-bar-block .progress-line", cartPage);

    const updateTotals = (store) => {
      const total = store.reduce((acc,p)=> acc + (p.price * (p.quantityPurchase || 1)), 0);
      const totalProductEl = qs(".total-block .total-product", cartPage);
      const totalCartEl    = qs(".total-cart-block .total-cart", cartPage);
      const morePriceEl    = qs(".heading.banner .more-price", cartPage);
      if (totalProductEl) totalProductEl.textContent = String(total);
      if (totalCartEl)    totalCartEl.textContent    = String(total);
      if (morePriceEl)    morePriceEl.textContent    = String(total <= moneyForFreeship ? moneyForFreeship - total : 0);
      if (progress) {
        progress.style.width = (total <= moneyForFreeship) ? `${(total / moneyForFreeship) * 100}%` : "100%";
      }
    };

    const render = () => {
      let cartStore = JSON.parse(localStorage.getItem("cartStore") || "[]");
      // Ensure quantityPurchase default
      cartStore = cartStore.map(p => ({...p, quantityPurchase: p.quantityPurchase || 1}));
      listProductCart.innerHTML = "";

      cartStore.forEach(product => {
        const row = document.createElement("div");
        row.setAttribute("data-item", product.id);
        row.className = "item flex md:mt-7 md:pb-7 mt-5 pb-5 border-b border-line w-full";
        row.innerHTML = `
          <div class="w-1/2">
            <div class="flex items-center gap-6">
              <div class="bg-img md:w-[100px] w-20 aspect-[3/4]"><img src="${product.thumbImage?.[0] || ""}" alt="img" class="w-full h-full object-cover rounded-lg"/></div>
              <div><div class="text-title">${product.name || ""}</div><div class="list-select mt-3"></div></div>
            </div>
          </div>
          <div class="w-1/12 price flex items-center justify-center"><div class="text-title text-center">$${product.price ?? 0}.00</div></div>
          <div class="w-1/6 flex items-center justify-center">
            <div class="quantity-block bg-surface md:p-3 p-2 flex items-center justify-between rounded-lg border border-line md:w-[100px] flex-shrink-0 w-20">
              <i class="ph-bold ph-minus cursor-pointer text-base max-md:text-sm"></i>
              <div class="text-button quantity">${product.quantityPurchase}</div>
              <i class="ph-bold ph-plus cursor-pointer text-base max-md:text-sm"></i>
            </div>
          </div>
          <div class="w-1/6 flex total-price items-center justify-center">
            <div class="text-title text-center">$${(product.price * product.quantityPurchase) ?? 0}.00</div>
          </div>
          <div class="w-1/12 flex items-center justify-center">
            <i class="remove-btn ph ph-x-circle text-xl max-md:text-base text-red cursor-pointer hover:text-black duration-300"></i>
          </div>
        `;
        listProductCart.appendChild(row);

        const minus = qs(".ph-minus", row);
        const plus  = qs(".ph-plus", row);
        const qEl   = qs(".quantity", row);
        const totalEl = qs(".total-price .text-title", row);

        on(plus, "click", () => {
          product.quantityPurchase++;
          qEl.textContent = String(product.quantityPurchase);
          totalEl.textContent = `$${product.quantityPurchase * product.price}.00`;
          localStorage.setItem("cartStore", JSON.stringify(cartStore));
          updateTotals(cartStore);
        });
        on(minus, "click", () => {
          if (product.quantityPurchase > 1) {
            product.quantityPurchase--;
            qEl.textContent = String(product.quantityPurchase);
            totalEl.textContent = `$${product.quantityPurchase * product.price}.00`;
            localStorage.setItem("cartStore", JSON.stringify(cartStore));
            updateTotals(cartStore);
          }
        });

        const removeBtn = qs(".remove-btn", row);
        on(removeBtn, "click", () => {
          cartStore = cartStore.filter(p => p.id !== product.id);
          localStorage.setItem("cartStore", JSON.stringify(cartStore));
          render();
        });
      });

      updateTotals(cartStore);
    };

    render();
  })();

  /* -------------------------------- Checkout page ----------------------------- */
  (() => {
    const checkoutPage = qs(".checkout-block");
    const listProductCheckout = qs(".checkout-block .list-product-checkout");
    if (checkoutPage && listProductCheckout) {
      const cartStore = JSON.parse(localStorage.getItem("cartStore") || "[]").map(p => ({...p, quantityPurchase: p.quantityPurchase || 1}));
      let total = 0;
      cartStore.forEach(prod => {
        const item = document.createElement("div");
        item.className = "item flex items-center justify-between w-full pb-5 border-b border-line gap-6 mt-5";
        item.innerHTML = `
          <div class="bg-img w-[100px] aspect-square flex-shrink-0 rounded-lg overflow-hidden"><img src="${prod.thumbImage?.[0] || ""}" alt="img" class="w-full h-full"/></div>
          <div class="flex items-center justify-between w-full">
            <div>
              <div class="name text-title">${prod.name || ""}</div>
              <div class="caption1 text-secondary mt-2"><span class='size capitalize'>${prod.sizes?.[0] ?? ""}</span><span>/</span><span class='color capitalize'>${prod.variation?.[0]?.color ?? ""}</span></div>
            </div>
            <div class="text-title"><span class='quantity'>${prod.quantityPurchase}</span><span class='px-1'>x</span><span>$${prod.price ?? 0}.00</span></div>
          </div>
        `;
        listProductCheckout.appendChild(item);
        total += (prod.price * prod.quantityPurchase);
      });
      const totalEl = qs(".total-cart-block .total-cart", checkoutPage);
      if (totalEl) totalEl.textContent = `$${total}.00`;
    }

    // Checkout login toggle
    const formLoginHeading = qs(".checkout-block .form-login-block");
    const loginHeading     = qs(".checkout-block .login .left span.text-button");
    const iconDownHeading  = qs(".checkout-block .login .right i");
    const toggleLogin = () => { formLoginHeading?.classList.toggle("open"); iconDownHeading?.classList.toggle("up"); };
    on(loginHeading,    "click", toggleLogin);
    on(iconDownHeading, "click", toggleLogin);

    // Payment accordion
    const listPayment = qs(".payment-block .list-payment");
    const paymentCheckbox = qsa(".payment-block .list-payment .type>input");
    paymentCheckbox.forEach(inp => on(inp, "click", () => {
      listPayment?.querySelector(".open")?.classList.remove("open");
      const parentType = inp.parentElement;
      if (inp.checked) parentType?.classList.add("open");
    }));
  })();

  /* ------------------------------------ FAQs ---------------------------------- */
  (() => {
    const menuTab = qs(".menu-tab");
    const listQuestion = qs(".list-question");
    const tabQuestions = qsa(".tab-question");
    const questionItems= qsa(".question-item");
    const tabs = qsa(".menu-tab .tab-item");

    if (tabs.length && tabQuestions.length && menuTab && listQuestion) {
      tabs.forEach(tabItem => {
        tabQuestions.forEach(q => {
          const active = menuTab.querySelector(".active");
          if (active && active.getAttribute("data-item") === q.getAttribute("data-item")) q.classList.add("active");
          on(tabItem, "click", () => {
            if (tabItem.getAttribute("data-item") === q.getAttribute("data-item")) {
              listQuestion.querySelector(".active")?.classList.remove("active");
              q.classList.add("active");
            }
          });
        });
      });
    }

    if (questionItems.length) {
      questionItems.forEach((item, idx) => {
        on(item, "click", () => {
          item.classList.toggle("open");
          questionItems.forEach((it, j) => { if (idx !== j) it.classList.remove("open"); });
        });
      });
    }
  })();

  /* ----------------------- Tiny utilities used in Blade ----------------------- */
  // Mobile categories toggle (as used in your Blade)
  on(qs("#toggleCats"), "click", () => qs(".side-card")?.classList.toggle("open"));

  // Cart badge refresh from backend route (exists only if route is present on page)
  (() => {
    const badges = qsa(".qty");
    if (!badges.length) return;
    try {
      // If route helper printed URL:
      // fetch('{{ route('cart.items.count') }}', { headers:{'Accept':'application/json'} })
      // Below is a safe fallback if that URL is injected server-side; if not present, do nothing.
      const el = qs('meta[name="cart-count-url"]');
      const url = el?.getAttribute("content") || (typeof CART_COUNT_URL !== "undefined" ? CART_COUNT_URL : null);
      if (!url) return;
      fetch(url, { headers: { "Accept": "application/json" } })
        .then(r => r.json())
        .then(d => { if (d?.success) badges.forEach(b => b.textContent = d.count); })
        .catch(()=>{});
    } catch {}
  })();

})();
