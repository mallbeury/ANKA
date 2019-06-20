require.config({
  waitSeconds: 10,
  paths: {
    jquery: 'libs/jquery-2.1.4.min',
    Modernizr: 'libs/modernizr-custom',
    underscore: 'libs/underscore-min',
    backbone: 'libs/backbone-min',
    async: 'libs/async',
    bootstrap: 'libs/bootstrap.min',
    modernizr: 'libs/modernizr-custom',
    imageScale: 'libs/image-scale.min',
    imagesLoaded: 'https://cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.1.2/imagesloaded.pkgd.min',
    visible: 'libs/jquery.visible.min',
    macy: 'libs/macy',
    slick: '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min',
    mapboxgl: '//api.tiles.mapbox.com/mapbox-gl-js/v1.0.0/mapbox-gl'
  },
  shim: {
    'bootstrap' : {
      deps: ['jquery']
    },
    'visible' : {
      deps: ['jquery']
    },
    'slick' : {
      deps: ['jquery']
    },
    'imageScale': {
      deps: ['jquery'],
      exports: 'imageScale'
    },
    'imagesLoaded': {
      deps: ['jquery'],
      exports: 'imagesLoaded'
    }    
  }
});

// Load our app module and pass it to our definition function
require(['controller/' + APP], function(App){
  App.initialize();
})
