jQuery(window).load(function () {
    jQuery(".flexslider").flexslider({
        animation: "slide",
        touch: true,
        directionNav: false,
        smoothHeight: false,
        controlNav: SLIDER_OPTIONS.controlNav,
    });
});
