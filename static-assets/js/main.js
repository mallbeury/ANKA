var COOKIE_PREFIX = 'anka';
var COOKIE_DELIM = '_';

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
    videojs: '//vjs.zencdn.net/4.12/video',
    cookie: 'libs/js.cookie',
    visible: 'libs/jquery.visible.min',
    macy: 'libs/macy',
    slick: '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min',
    parallax: 'libs/parallax.min',
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
    },
    'cookie' : {
      deps: ['jquery']
    },    
    'parallax' : {
      deps: ['jquery']
    }    
  }
});

function getBootstrapDeviceSize() {
  return $('#users-device-size').find('div:visible').first().attr('id');
}

function closeSmallMenuSubmenu() {
  $('.small-menu-view .mainmenu').removeClass('open');
  $('body').removeClass('lock');
}

function changeBigMenuSubmenu() {
  $('.big-menu-view .link').removeClass('open');
}

function closeBigMenuSubmenu() {
  changeBigMenuSubmenu();
  $('.big-menu-view .mainmenu').removeClass('open');
}

function handleResize() {
  if (getBootstrapDeviceSize() != 'xs') {
    closeSmallMenuSubmenu();
  }
}

function updateAckSeenCookie(value) {
  var cookiePrefix = COOKIE_PREFIX + COOKIE_DELIM;

  $.cookie(cookiePrefix + 'acknowledge_seen', value, { expires: 365, path: '/' });
}

function getAckSeenCookie() {
  var cookiePrefix = COOKIE_PREFIX + COOKIE_DELIM;

//  $.removeCookie(cookiePrefix + 'acknowledge_seen', { path: '/' });

  return $.cookie(cookiePrefix + 'acknowledge_seen');
}

function setupUI() {
  // big menu
  $('.big-menu-view .link').mouseover(function(evt){
    changeBigMenuSubmenu();

    $('.big-menu-view .mainmenu').addClass('open');
    $(this).addClass('open');
  });

  $('.big-menu-view').mouseleave(function(evt){
    closeBigMenuSubmenu();
  });

  // small menu
  $('.small-menu-view .hamburger-menu').click(function(evt){
    $('.small-menu-view .mainmenu').addClass('open');

    $('body').addClass('lock');
  });

  $('.small-menu-view .close-btn').click(function(evt){
    closeSmallMenuSubmenu();
  });

  // head on down
  $('.nav-down').click(function(evt){
    $('html, body').animate({
      scrollTop: $("#message-view").offset().top
    }, 1000);
  });

  // top
  $('.top-link').click(function(evt){
    $('html, body').animate({
      scrollTop: 0
    }, 1000);      
  });

  // open search panel
  $('.search-btn').click(function(evt){
    $('#acknowledge-view').hide();
    $('#acknowledge-view').removeClass('active');
    $('#search-view').addClass('active');
  });

  $('.close-btn', $('#search-view')).click(function(evt){
    $('#search-view').removeClass('active');
  });

  // perform search
  $('#SearchForm_SearchForm .submit').click(function(evt){
    $('#SearchForm_SearchForm').submit();
  });

  // inital show
  $('#acknowledge-view').addClass('active');
  if (getAckSeenCookie()) {
    $('#acknowledge-view').removeClass('active');
  }

  $('.close-btn', $('#acknowledge-view')).click(function(evt){
    $('#acknowledge-view').removeClass('active');
    updateAckSeenCookie(true);
  });
}

function validateForm(elForm){
  var bValid = true;

  $('.form-group', elForm).removeClass('has-error');
  $('.help-block', elForm).hide();

  // manage errs
  $('.required', elForm).each(function(){
    if ($(this).val() == '') {
      bValid = false;
      var elParent = $(this).parent();
      elParent.addClass('has-error');
      $('.help-block', elParent).show();
      // highlight that there is at least 1 error
      var elFormErr = $('.form-error', elForm);
      if (elFormErr.length) {
        elFormErr.addClass('has-error');
        $('.help-block', elFormErr).show();
      }
    }
  });
  return bValid;
}

function processSubscriptionForm(elForm) {
  var bValid = false;

  $('.thanks', elForm).hide();
  
  if (validateForm(elForm)) {
    bValid = true;

    $.post("server/mailerproxy.php", elForm.serialize()).success(function(data) {
      console.log(data);
    });
    
    $('.thanks', elForm).show();
  }
  return bValid;
}

// Load our app module and pass it to our definition function
require(['controller/' + APP], function(App){
  App.initialize();
})
