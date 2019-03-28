$(window).on("load", function () {
  "use strict";

  //  ============= SIGNIN SWITCH TAB FUNCTIONALITY =========

  $('.tab-feed ul li').on("click", function () {
    var tab_id = $(this).attr('data-tab');
    $('.tab-feed ul li').removeClass('active');
    $('.product-feed-tab').removeClass('current');
    $(this).addClass('active animated fadeIn');
    $("#" + tab_id).addClass('current animated fadeIn');
    return false;
  });

  //  ============= COVER GAP FUNCTION =========

  var gap = $(".container").offset().left;
  $(".cover-sec > a, .chatbox-list").css({
    "right": gap
  });

  //  ============= OVERVIEW EDIT FUNCTION =========

  $(".overview-open").on("click", function () {
    $("#overview-box").addClass("open");
    $(".wrapper").addClass("overlay");
    return false;
  });
  $(".close-box").on("click", function () {
    $("#overview-box").removeClass("open");
    $(".wrapper").removeClass("overlay");
    return false;
  });
  $("button.cancel").on("click", function (e) {
    e.preventDefault();
    $("#overview-box").removeClass("open");
    $(".wrapper").removeClass("overlay");
    return false;
  });

  //  ============= STATUS EDIT FUNCTION =========

  $(".status-open").on("click", function () {
    $("#status-box").addClass("open");
    $(".wrapper").addClass("overlay");
    return false;
  });
  $(".close-box").on("click", function () {
    $("#status-box").removeClass("open");
    $(".wrapper").removeClass("overlay");
    return false;
  });
  $("button.cancel").on("click", function (e) {
    e.preventDefault();
    $("#status-box").removeClass("open");
    $(".wrapper").removeClass("overlay");
    return false;
  });

  //  ============= COVER EDIT FUNCTION =========

  $(".cover-open").on("click", function () {
    $("#cover-box").addClass("open");
    $(".wrapper").addClass("overlay");
    return false;
  });
  $(".close-box").on("click", function () {
    $("#cover-box").removeClass("open");
    $(".wrapper").removeClass("overlay");
    return false;
  });
  $("button.cancel").on("click", function (e) {
    e.preventDefault();
    $("#cover-box").removeClass("open");
    $(".wrapper").removeClass("overlay");
    return false;
  });

  //  ============= PROFILE PHOTO EDIT FUNCTION =========

  $(".profile-photo-open").on("click", function () {
    $("#profile-photo-box").addClass("open");
    $(".wrapper").addClass("overlay");
    return false;
  });
  $(".close-box").on("click", function () {
    $("#profile-photo-box").removeClass("open");
    $(".wrapper").removeClass("overlay");
    return false;
  });
  $("button.cancel").on("click", function (e) {
    e.preventDefault();
    $("#profile-photo-box").removeClass("open");
    $(".wrapper").removeClass("overlay");
    return false;
  });

  //  ============= EMPLOYEE EDIT FUNCTION =========

  $(".emp-open").on("click", function () {
    $("#total-employes").addClass("open");
    $(".wrapper").addClass("overlay");
    return false;
  });
  $(".close-box").on("click", function () {
    $("#total-employes").removeClass("open");
    $(".wrapper").removeClass("overlay");
    return false;
  });

  //  =============== Ask a Question Popup ============

  $(".ask-question").on("click", function () {
    $("#question-box").addClass("open");
    $(".wrapper").addClass("overlay");
    return false;
  });
  $(".close-box").on("click", function () {
    $("#question-box").removeClass("open");
    $(".wrapper").removeClass("overlay");
    return false;
  });


  //  ============== ChatBox ==============


  $(".chat-mg").on("click", function () {
    $(this).next(".conversation-box").toggleClass("active");
    return false;
  });
  $(".close-chat").on("click", function () {
    $(".conversation-box").removeClass("active");
    return false;
  });

  //  ================== Edit Options Function =================


  $(".ed-opts-open").on("click", function () {
    $(this).next(".ed-options").toggleClass("active");
    return false;
  });


  // ============== Menu Script =============

  $(".menu-btn > a").on("click", function () {
    $("nav").toggleClass("active");
    return false;
  });


  //  ============ Notifications Open =============

  $(".not-box-open").on("click", function () {
    $(this).next(".notification-box").toggleClass("active");
  });

  // ============= User Account Setting Open ===========

  $(".user-info").on("click", function () {
    $(this).next(".user-account-settingss").toggleClass("active");
  });

  //  ============= FORUM LINKS MOBILE MENU FUNCTION =========

  $(".forum-links-btn > a").on("click", function () {
    $(".forum-links").toggleClass("active");
    return false;
  });
  $("html").on("click", function () {
    $(".forum-links").removeClass("active");
  });
  $(".forum-links-btn > a, .forum-links").on("click", function () {
    e.stopPropagation();
  });

  //  ============= PORTFOLIO SLIDER FUNCTION =========

  $('.profiles-slider').slick({
    slidesToShow: 3,
    slck: true,
    slidesToScroll: 1,
    prevArrow: '<span class="slick-previous"></span>',
    nextArrow: '<span class="slick-nexti"></span>',
    autoplay: true,
    dots: false,
    autoplaySpeed: 2000,
    responsive: [
      {
        breakpoint: 1200,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 1,
          infinite: true,
          dots: false
        }
      },
      {
        breakpoint: 991,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
      // You can unslick at a given breakpoint now by adding:
      // settings: "unslick"
      // instead of a settings object
    ]

  });

});
