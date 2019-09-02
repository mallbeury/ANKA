var app = app || {};

define([
  'underscore',
  'backbone',
  'bootstrap',
  'modernizr',
  'cookie',
  'imageScale',
  'views/SocialFeedView'
], function(_, Backbone, bootstrap, modernizr, cookie, imageScale, SocialFeedView){
  app.dispatcher = _.clone(Backbone.Events);

  _.templateSettings = {
      evaluate:    /\{\{(.+?)\}\}/g,
      interpolate: /\{\{=(.+?)\}\}/g,
      escape:      /\{\{-(.+?)\}\}/g
  };

  var initialize = function() {
    $('.loader-view').show();

    $(window).resize(function() {
      handleResize();
    });
    handleResize();

    setupUI();

    $('img.scale').imageScale({'rescaleOnResize': true, 'fadeInDuration': 500});

    app.dispatcher.on("SocialFeatureView:feedready", onSocialFeedReady);

    var socialFeedView = new SocialFeedView({ el: '#journal-view', strFeedURL: FEED_URL });
    socialFeedView.loadFeed();

    $('#signup').submit(function(evt){
      evt.preventDefault();

      processSubscriptionForm($(this));
    });

    function onSocialFeedReady() {
      $('.loader-view').hide();
      socialFeedView.render();
    }
  };

  return { 
    initialize: initialize
  };
});

