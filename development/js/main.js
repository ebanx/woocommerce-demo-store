import aos from 'aos';

(function(window, document, $, aos) {
  // Hambuerger Menu
  let hamburger = $('.hamburger');
  let mobileMenu = $('.mobile-menu');
  let header = $('.header');

  hamburger.on('click', e => {
    e.preventDefault();

    header.toggleClass('header--is-active');
    hamburger.toggleClass('is-active');
    mobileMenu.toggleClass('mobile-menu--is-active');
  });

  // Animations
  aos.init({
    offset: 250,
    duration: 800
  });

  // Product Quantity
  let minus = $('.product-single__qty-minus');
  let plus = $('.product-single__qty-plus');
  let qty = $('.product-single__qty-input');

  minus.on('click', e => {
    e.preventDefault();

    let value = parseInt(qty.val()) == 1 ? 1 : (parseInt(qty.val())) - 1;

    qty.val(value);
  });

  plus.on('click', e => {
    e.preventDefault();

    let value = (parseInt(qty.val())) + 1;

    qty.val(value);
  });

})(window, document, jQuery, aos);
