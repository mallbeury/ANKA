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
      this.markersAdded = false;
    },

    filter(jsonResults){
      if (!this.mainMap) return;

      var self = this;

      if (self.markersAdded) {
        self.mainMap.removeLayer('circles1');
        self.mainMap.removeSource('markers');
        self.markersAdded = false;
      }

      self.markersAdded = true;

      geojson = {
        "type": "geojson",
        "data": {
          "type": "FeatureCollection",          
          features: []
        }
      };

      $.each(jsonResults.results, function(index, item){
        var jsonFeature = {
          type: 'Feature',
          geometry: {
            type: 'Point',
            coordinates: [item.location.lat, item.location.lng]
          },
          "properties": {
            "modelId": 1,
          }              
        };
        geojson.data.features.push(jsonFeature);
      });

      self.mainMap.addSource('markers', geojson);

      self.mainMap.addLayer({
        "id": "circles1",
        "source": "markers",
        "type": "circle",
        "paint": {
          'circle-radius': [
            'interpolate',
            ['linear'],
            ['zoom'],
            2, 2,
            5, 5,
            10, 10,
            15, 15,
            20, 20
          ],      
          "circle-color": "#f2685f",
          "circle-opacity": 1,
          "circle-stroke-width": 0,
        },
        "filter": ["==", "modelId", 1],
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

      this.mainMap.on('load', function () {
        app.dispatcher.trigger("MapView:ready");          
      });

      return this;
    }

  });

  return MapView;
});
