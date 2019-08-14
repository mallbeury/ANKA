define([
  'underscore', 
  'backbone',
  'slick'
], function(_, Backbone, slick){

  var BrowseSlickView = Backbone.View.extend({
    initialize: function(options){
      this.template = _.template($('#browseSlickViewTemplate').text());

      this.options = options;
    },

    render: function(jsonResults){
      var self = this;

      $(self.el).html(self.template({data: jsonResults}));

      $('.slick-view', $(this.el)).slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 6,
        slidesToScroll: 3,
        prevArrow: $('.nav-left'),
        nextArrow: $('.nav-right'),
        responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 2,
              infinite: true,
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          }    
        ]
      });

      return this;
    }

  });

  return BrowseSlickView;
});
