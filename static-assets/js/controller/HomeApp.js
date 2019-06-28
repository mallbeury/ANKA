var app = app || {};

define([
  'underscore',
  'backbone',
  'bootstrap',
  'modernizr',
  'visible',
  'imageScale',
  'parallax',
  'views/MapView',
  'views/BrowseSlickView'
], function(_, Backbone, bootstrap, modernizr, visible, imageScale, parallax, MapView, BrowseSlickView){
  app.dispatcher = _.clone(Backbone.Events);

  _.templateSettings = {
      evaluate:    /\{\{(.+?)\}\}/g,
      interpolate: /\{\{=(.+?)\}\}/g,
      escape:      /\{\{-(.+?)\}\}/g
  };

  var initialize = function() {
    var bFirstResize = true;

    function handleCustomResize() {
      handleResize();

      var nWindowHeight = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);

      if (bFirstResize) {
        bFirstResize = false;

        $('#hero-view').show();
        $('#hero-view').css('height', nWindowHeight - $('#menu-view').height());
      }
    }

    app.dispatcher.on("MapView:ready", onMapReady);

    var mapView = new MapView({ el: '#map-view' });
    mapView.render();

    $('#browse-view').show();
    var browseSlickView = new BrowseSlickView({ el: '#browse-slick-view' });

    $(window).resize(function() {
      handleCustomResize();
    });
    handleCustomResize();

    setupUI();

    $('img.scale').imageScale({'rescaleOnResize': true, 'fadeInDuration': 500});

    // for the parallax
    jQuery(window).trigger('resize').trigger('scroll');

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
          browseSlickView.render(data);
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

