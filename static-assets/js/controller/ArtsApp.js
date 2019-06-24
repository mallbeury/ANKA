var app = app || {};

define([
  'underscore',
  'backbone',
  'bootstrap',
  'modernizr',
  'visible',
  'macy',
  'imageScale',
  'views/MapView',
  'views/ArtCentresView'
], function(_, Backbone, bootstrap, modernizr, visible, Macy, imageScale, MapView, ArtCentresView){
  app.dispatcher = _.clone(Backbone.Events);

  _.templateSettings = {
      evaluate:    /\{\{(.+?)\}\}/g,
      interpolate: /\{\{=(.+?)\}\}/g,
      escape:      /\{\{-(.+?)\}\}/g
  };

  var initialize = function() {
    var bFirstResize = true;
    var mapView = null;

    function getBootstrapDeviceSize() {
      return $('#users-device-size').find('div:visible').first().attr('id');
    }

    function handleResize() {
      var nWindowHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);

      if (getBootstrapDeviceSize() != 'xs') {
        closeSmallMenuSubmenu();
      }
    }

    function checkInView() {
      var bVisible = false;
      $('#journal-view .journal-post').each(function(index){
        bVisible = $(this).visible(true);
        if (bVisible) {
          $(this).css('opacity', 1);
          $('.post-container', $(this)).css('top', 0);
        }
      });
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

    // do we want macy?
    if ($('#macy-container').length) {
      var masonry = new Macy({
          container: '#macy-container',
          columns: 1,
          waitForImages: true,
          mobileFirst: true,
          breakAt: {
            768: 2
          },
      });

      masonry.on(masonry.constants.EVENT_IMAGE_COMPLETE, function (ctx) {
        checkInView();

        $(window).scroll(function() {
          checkInView();
        });
      });
    }
    
    var artCentresView = new ArtCentresView({ el: '#art-centres-view' });

    // do we have a map?
    if ($('#map-view').length) {
      app.dispatcher.on("MapView:ready", onMapReady);

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

    $('#art-centres-nav-view .filters li').click(function(evt){
      if (mapView) {
        mapView.filter($(this).attr('data-filter'));
        artCentresView.render($(this).attr('data-filter'));
      }
    });

    function onMapReady() {
      // initial view
      mapView.filter('all');
      artCentresView.render('all');
    }
  };

  return { 
    initialize: initialize
  };
});

