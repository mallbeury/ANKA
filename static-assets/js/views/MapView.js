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

      var geojson = {
        type: 'FeatureCollection',
        features: [{
          type: 'Feature',
          geometry: {
            type: 'Point',
            coordinates: [131.364486, -16.147204]
          },
          properties: {
            title: 'Mapbox',
            description: 'Washington, D.C.'
          }
        }]
      };

      this.mainMap.addControl(new mapboxgl.NavigationControl(), 'bottom-left');

      // add markers to map
      geojson.features.forEach(function(marker) {

        // create a HTML element for each feature
        var el = document.createElement('div');
        el.className = 'marker';

        // make a marker for each feature and add to the map
        new mapboxgl.Marker(el)
          .setLngLat(marker.geometry.coordinates)
          .addTo(self.mainMap);
      }); 
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
