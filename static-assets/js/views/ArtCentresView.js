define([
  'underscore', 
  'backbone',
  'imagesLoaded'
], function(_, Backbone, imagesLoaded){

  var ArtCentresView = Backbone.View.extend({
    initialize: function(options){
      this.template = _.template($('#artCentresViewTemplate').text());

      this.options = options;
    },

    showImages: function(strFilte){
      var self = this;

      var elImages = $(this.el);
      var imgLoad = imagesLoaded(elImages);
      imgLoad.on('always', function(instance) {
        $(self.el).addClass('ready');
      });    
    },

    render: function(jsonResults){
      var self = this;

      $(this.el).html('');
      $(this.el).removeClass('ready');

      $(self.el).html(self.template({data: jsonResults}));

      self.showImages();

      return this;
    }

  });

  return ArtCentresView;
});
