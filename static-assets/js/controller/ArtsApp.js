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
    var mapView = null;

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

    $('#signup').submit(function(evt){
      evt.preventDefault();

      processSubscriptionForm($(this));
    });

    $(window).resize(function() {
      handleResize();
    });
    handleResize();

    setupUI();

    $('img.scale').imageScale({'rescaleOnResize': true, 'fadeInDuration': 500});

    $('#art-centres-nav-view .filters li').click(function(evt){
      if (mapView) {
        filterArt($(this).attr('data-filter'));
      }
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
          artCentresView.render(data);
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

