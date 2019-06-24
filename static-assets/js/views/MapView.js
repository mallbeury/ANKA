define([
  'underscore', 
  'backbone',
  'mapboxgl'
], function(_, Backbone, mapboxgl){

  var MapView = Backbone.View.extend({
    initialize: function(options){
      this.template = _.template($('#mapViewTemplate').text());

      this.options = options;

      mapboxgl.accessToken = 'pk.eyJ1Ijoicm9kZW8tY29tLWNvIiwiYSI6ImNqdWFmc2w1bzAyN3U0NnBxMzB0dmx5OGgifQ.GmOZFYxeayiNRuDMrh5i7g';
      this.mainMap = null;
      this.miniMap = null;
      this.arrMakers = [];
    },

    filter(strFilter){
      if (!this.mainMap) return;

      var self = this;

      var geojson = {};
      if(this.arrMakers.length) {
        for (var nMarker=0; nMarker < this.arrMakers.length-1; nMarker++) {
          // remove from map
          this.arrMakers[nMarker].remove();
        }

        while (this.arrMakers.length) {
          this.arrMakers.pop();
        }        
      }

      if (strFilter == 'all') {
        geojson = {
          type: 'FeatureCollection',
          features: [{
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [131.364486, -16.147204]
            },
          },
          {
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [132.893832, -14.248600]
            }
          }]
        };
      }
      else {
        geojson = {
          type: 'FeatureCollection',
          features: [{
            type: 'Feature',
            geometry: {
              type: 'Point',
              coordinates: [132.893832, -14.248600]
            }
          }]
        };
      }

      // add markers to map
      var marker = null;
      geojson.features.forEach(function(marker) {
        // create a HTML element for each feature
        var el = document.createElement('div');
        el.className = 'marker';

        // make a marker for each feature and add to the map
        marker = new mapboxgl.Marker(el)
          .setLngLat(marker.geometry.coordinates)
          .addTo(self.mainMap);

        self.arrMakers.push(marker);
      });     
    },

    buildMainMap(){
      var self = this;

      this.mainMap = new mapboxgl.Map({
        container: 'main-map',
        style: 'mapbox://styles/rodeo-com-co/cjuafvt0e9q631fqm11pzno6q',
        center: [131.364486, -16.147204],
        zoom: 5,
        scrollZoom: false,
        attributionControl: false
      });


      this.mainMap.addControl(new mapboxgl.NavigationControl(), 'bottom-left');
    },

    buildMiniMap(){
      this.miniMap = new mapboxgl.Map({
        container: 'mini-map',
        style: 'mapbox://styles/rodeo-com-co/cjuafvt0e9q631fqm11pzno6q',
        center: [134.657322, -26.893870],
        zoom: 1,
        interactive: false,
        attributionControl: false
      });
    },

    render: function(){
      $(this.el).html(this.template({}));

      this.buildMainMap();
      this.buildMiniMap();

      return this;
    }

  });

  return MapView;
});
