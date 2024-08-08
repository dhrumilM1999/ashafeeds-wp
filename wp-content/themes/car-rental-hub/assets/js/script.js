$('.hero-slider').slick({
    appendArrows: $('.hero-slider-btn'),
    prevArrow: $('.hero-slider-btn .prev'),
    nextArrow: $('.hero-slider-btn .next'),
    centerMode: 1,
    autoplay: 1,
    autoplaySpeed: 3000,
});


$('.why-choose-slider').slick({
    infinite: true,
    slidesToShow: 2,
    slidesToScroll: 1,

    appendArrows: $('.why-choose-section .slider-btn'),
    prevArrow: $('.why-choose-section .slider-btn .prev'),
    nextArrow: $('.why-choose-section .slider-btn .next'),

    autoplay: true,
    autoplaySpeed: 3000,
});
$('.testimonial-slider').slick({
    infinite: true,
    slidesToShow: 1,
    arrows: false,
    fade: true,
    autoplay: true,
    autoplaySpeed: 3000,
});
$('.client-slider').slick({
    infinite: true,
    slidesToShow: 5,

    prevArrow: $('.client-section .slider-btn.prev'),
    nextArrow: $('.client-section .slider-btn.next'),
    autoplay: true,
    centerPadding: '40px',
    autoplaySpeed: 3000,
});