var app = app || {};

define([
  'underscore',
  'backbone',
  'bootstrap',
  'modernizr',
  'visible',
  'imageScale',
  'views/MapView'
], function(_, Backbone, bootstrap, modernizr, visible, imageScale, MapView){
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

    // do we have a map?
    if ($('#map-view').length) {
      var mapView = new MapView({ el: '#map-view' });
      mapView.render();
    }

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
  };

  return { 
    initialize: initialize
  };
});

