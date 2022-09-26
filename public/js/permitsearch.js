(function($) {
    'use strict';
    AOS.init();
    var url = window.location.origin; /*'http://localhost/permitsearch/public';*/


    /*-- table-popusps --*/

    $('body').on("click",".close-popup", function() {
        $(this).parent().parent().css('display','none');
        if(is_search_result_page == true)
            window.location.href = url;
        //$(".popup-table").addClass("active-popup");
    });


     $('body').on("click",".close-popup-coupon-code", function() {
        $(this).parent().parent().css('display','none');
    });

    $("#popupCloseNoAddress").on("click", function() {
        $(".errorPOP").css("display","none");
    });  

    /*$("#popupClose").on("click", function() {
        $("body.popup-open").removeClass();
    });


    /*-- table-popusps-end --*/


    /*-- Faq-arrow --*/


    // Add down arrow icon for collapse element which is open by default
    $(".collapse.show").each(function() {
        $(this).prev(".card-header").find(".fa").addClass("fa-angle-up").removeClass("fa-angle-down");
    });

    // Toggle right and down arrow icon on show hide of collapse element
    $(".collapse").on('show.bs.collapse', function() {
        $(this).prev(".card-header").find(".fa").removeClass("fa-angle-down").addClass("fa-angle-up");
    }).on('hide.bs.collapse', function() {
        $(this).prev(".card-header").find(".fa").removeClass("fa-angle-up").addClass("fa-angle-down");
    });



    /*-- password-eye --*/

    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("fa-eye-slash");
            $('#show_hide_password i').removeClass("fa-eye");
        } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("fa-eye-slash");
            $('#show_hide_password i').addClass("fa-eye");
        }
    });



    /*-- login-hover-popusp-1 --*/

    jQuery('.btnn, .back-login, a.back-login').click(function(event) {
        jQuery('.popup').addClass('is-active');
        jQuery('.popup-sign-up').removeClass('is-active');
        //   jQuery('.overlay').addClass('is-active');
        return false;
    });
    jQuery('.popup__close, .btn-forgot, .open-signup').click(function(event) {
        jQuery('.popup').removeClass('is-active');
        //   jQuery('.overlay').removeClass('is-active');
        return false;
    });


    /*-- login-hover-popusp-2 --*/

    jQuery('.btn-forgot').click(function(event) {
        jQuery('.popup-recover').addClass('is-active');
        //   jQuery('.overlay').addClass('is-active');
        return false;
    });
    jQuery('.popup__close, .back-login').click(function(event) {
        jQuery('.popup-recover').removeClass('is-active');
        //   jQuery('.overlay').removeClass('is-active');
        return false;
    });


    /*-- login-hover-popusp-3 --*/

    jQuery('a.open-signup').click(function(event) {
        jQuery('.popup-sign-up').addClass('is-active');
        //   jQuery('.overlay').addClass('is-active');
        return false;
    });
    jQuery('.popup__close, a.back-login').click(function(event) {
        jQuery('.popup-sign-up').removeClass('is-active');
        //   jQuery('.overlay').removeClass('is-active');
        return false;
    });



    /*-- login-hover-popusps-end --*/

    $(".accordion").click(function() {
        $(this).find(".rotate").toggleClass("down");
    });
    
    /** show the popup for enter coupon code **/
    $('body').on('click','.coupon-code-link', function(){ 
        $('.apply-couponcode-popup').css('display','block');
    });

    //Avoid pinch zoom on iOS
    document.addEventListener('touchmove', function(event) {
        if (event.scale !== 1) {
            event.preventDefault();
        }
    }, false);
})(jQuery)

window.setTimeout(function () { 
 $(".alert-danger").alert('close'); 
}, 2200); 