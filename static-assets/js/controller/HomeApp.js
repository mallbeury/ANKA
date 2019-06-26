var app = app || {};

define([
  'underscore',
  'backbone',
  'bootstrap',
  'modernizr',
  'visible',
  'slick',
  'imageScale',
  'views/MapView'
], function(_, Backbone, bootstrap, modernizr, visible, slick, imageScale, MapView){
  app.dispatcher = _.clone(Backbone.Events);

  _.templateSettings = {
      evaluate:    /\{\{(.+?)\}\}/g,
      interpolate: /\{\{=(.+?)\}\}/g,
      escape:      /\{\{-(.+?)\}\}/g
  };

  var initialize = function() {
    var bFirstResize = true;

    function getBootstrapDeviceSize() {
      return $('#users-device-size').find('div:visible').first().attr('id');
    }

    function handleResize() {
      var nWindowHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);

      if (getBootstrapDeviceSize() != 'xs') {
        closeSmallMenuSubmenu();
      }

      if (bFirstResize) {
        bFirstResize = false;

        $('#hero-view').show();
        $('#hero-view').css('height', nWindowHeight - $('#menu-view').height());
      }
    }

    function closeSmallMenuSubmenu() {
      $('.small-menu-view .mainmenu').removeClass('open');
      $('body').removeClass('lock');
    }

    function changeBigMenuSubmenu() {
      $('.big-menu-view .link').removeClass('open');
    }

    function closeBigMenuSubmenu() {
      changeBigMenuSubmenu();
      $('.big-menu-view .mainmenu').removeClass('open');
    }

    app.dispatcher.on("MapView:ready", onMapReady);

    var mapView = new MapView({ el: '#map-view' });
    mapView.render();

    $('#browse-view').show();
    $('.slick-view').slick({
      dots: false,
      infinite: true,
      speed: 300,
      slidesToShow: 6,
      slidesToScroll: 1,
      prevArrow: $('.nav-left'),
      nextArrow: $('.nav-right'),
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
          }
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1
          }
        }    
      ]
    });

    $(window).resize(function() {
      handleResize();
    });
    handleResize();

    $('img.scale').imageScale({'rescaleOnResize': true, 'fadeInDuration': 500});

    // big menu
    $('.big-menu-view .link').mouseover(function(evt){
      changeBigMenuSubmenu();

      $('.big-menu-view .mainmenu').addClass('open');
      $(this).addClass('open');
    });

    $('.big-menu-view').mouseleave(function(evt){
      closeBigMenuSubmenu();
    });

    // small menu
    $('.small-menu-view .hamburger-menu').click(function(evt){
      $('.small-menu-view .mainmenu').addClass('open');

      $('body').addClass('lock');
    });

    $('.small-menu-view .close-btn').click(function(evt){
      closeSmallMenuSubmenu();
    });

    // head on down
    $('.nav-down').click(function(evt){
      $('html, body').animate({
        scrollTop: $("#message-view").offset().top
      }, 1000);
    });

    // top
    $('.top-link').click(function(evt){
      $('html, body').animate({
        scrollTop: 0
      }, 1000);      
    });

    function filterArt(strFilter) {
      var strURL = 'content/filter/' + strFilter;      
//      console.log(strURL);
      $.ajax({
        type: "GET",
        dataType: "json",
        url: strURL,
        error: function(data) {
//          console.log('error:'+data.responseText);      
//          console.log(data);      
        },
        success: function(data) {      
//          console.log('success');
//          console.log(data);

          mapView.filter(data);
        }
      });
    }

    function onMapReady() {
      filterArt('all');
    }

  };

  return { 
    initialize: initialize
  };
});

