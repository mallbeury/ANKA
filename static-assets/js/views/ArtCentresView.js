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

    render: function(strFilter){
      var self = this;

      $(this.el).html('');
      $(this.el).removeClass('ready');

      var jsonData = [ { item: 1 } ];

      if (strFilter == 'all') {
        jsonData = [ { item: 1 }, { item: 2 } ];
      }

      setTimeout(function() {
        $(self.el).html(self.template({items: jsonData}));

        self.showImages();
      }, 500);

      return this;
    }

  });

  return ArtCentresView;
});
