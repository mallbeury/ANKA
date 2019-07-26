define([
  'underscore', 
  'backbone',
  'visible',
  'macy'
], function(_, Backbone, visible, Macy){

  var SocialFeedView = Backbone.View.extend({
    initialize: function(options){
      this.template = _.template($('#socialFeedViewTemplate').text());

      this.options = options;
      this.result = null;
    },

    checkInView: function() {
      var bVisible = false;
      $('#journal-view .journal-post').each(function(index){
        bVisible = $(this).visible(true);
        if (bVisible) {
          $(this).css('opacity', 1);
          $('.post-container', $(this)).css('top', 0);
        }
      });
    },

    loadFeed: function(){
      var self = this;

      var url = 'https://www.juicer.io/api/feeds/playmountainrush?per=20';
//      console.log(url);
      $.getJSON(url, function(result){
        if(!result || !result.posts){
          return;
        }
        self.result = result;

        app.dispatcher.trigger("SocialFeatureView:feedready", self);          
      });
    },
    
    render: function(){      
      if (!this.result) {
        return;
      }
      var self = this;
      
      var attribs = {};
      attribs.juicer = this.result;
      $(this.el).html(this.template(attribs));

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
          self.checkInView();

          $(window).scroll(function() {
            self.checkInView();
          });
        });
      }

      return this;
    }
    
  });

  return SocialFeedView;
});
