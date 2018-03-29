window.DH = window.DH || {};

+function($){
  'use strict';
  var dhLoadmore = function(element, options,callback){
     this.$element    = $(element);
     this.callback = callback;
     this.options = $.extend({},dhLoadmore.defaults, options);
     this.contentSelector = this.options.contentSelector || this.$element.find('.loadmore-wrap');
     this.options.contentSelector = this.contentSelector;
     this.init();
  }
  dhLoadmore.defaults = {
      contentSelector: null,
      nextSelector: "div.navigation a:first",
      navSelector: "div.navigation",
      itemSelector: "div.post",
      dataType: 'html',
      finishedMsg: "<em>Congratulations, you've reached the end of the internet.</em>",
      maxPage: undefined,
      loading:{
        speed:0,
        start: undefined
      },
      state: {
            isDuringAjax: false,
            isInvalidPage: false,
            isDestroyed: false,
            isDone: false, // For when it goes all the way through the archive.
          isPaused: false,
          isBeyondMaxPage: false,
          currPage: 1
      }
  };
  dhLoadmore.prototype.init = function(){
    this.create();
  }
  dhLoadmore.prototype.create = function(){
   var self          = this, 
     $this           = this.$element,
     contentSelector = this.contentSelector,
     action          = this.action,
     btn             = this.btn,
     loading         = this.loading,
     options         = this.options;
    
    var _determinepath = function(path){
      if (path.match(/^(.*?)\b2\b(.*?$)/)) {
              path = path.match(/^(.*?)\b2\b(.*?$)/).slice(1);
          } else if (path.match(/^(.*?)2(.*?$)/)) {
              if (path.match(/^(.*?page=)2(\/.*|$)/)) {
                  path = path.match(/^(.*?page=)2(\/.*|$)/).slice(1);
                  return path;
              }
              path = path.match(/^(.*?)2(.*?$)/).slice(1);

          } else {
              if (path.match(/^(.*?page=)1(\/.*|$)/)) {
                  path = path.match(/^(.*?page=)1(\/.*|$)/).slice(1);
                  return path;
              } else {
                options.state.isInvalidPage = true;
              }
          }
      return path;
    }
    if(!$(options.nextSelector).length){
      return;
    }
    
    // callback loading
    options.callback = function(data, url) {
          if (self.callback) {
            self.callback.call($(options.contentSelector)[0], data, options, url);
          }
      };
      
      options.loading.start = function($btn) {
         if(options.state.isBeyondMaxPage)
           return;
          $btn.hide();
              $(options.navSelector).hide();
              $btn.closest('.loadmore-action').find('.loadmore-loading').show(options.loading.speed, $.proxy(function() {
                loadAjax(options,$btn);
              }, self));
       };
    
    var loadAjax = function(options,$btn){
      var path = $(options.nextSelector).attr('href'),
          path = _determinepath(path),
          callback=options.callback,
          desturl,frag,box,children,data;
      
      options.state.currPage++;
      options.maxPage = $(options.contentSelector).data('maxpage') || options.maxPage;
      // Manually control maximum page
          if ( options.maxPage !== undefined && options.state.currPage > options.maxPage ){
            options.state.isBeyondMaxPage = true;
              return;
          }
          desturl = path.join(options.state.currPage);
          box = $('<div/>');
          box.load(desturl + ' ' + options.itemSelector,undefined,function(responseText){
            children = box.children();
            if (children.length === 0) {
              $btn.closest('.loadmore-action').find('.loadmore-loading').hide(options.loading.speed,function(){
                options.state.isBeyondMaxPage = true;
                $btn.html(options.finishedMsg).show();
              });
                  return ;
              }
            frag = document.createDocumentFragment();
              while (box[0].firstChild) {
                  frag.appendChild(box[0].firstChild);
              }
              $(options.contentSelector)[0].appendChild(frag);
              data = children.get();
              $btn.closest('.loadmore-action').find('.loadmore-loading').hide();
              if(options.maxPage !== undefined && options.maxPage == options.state.currPage ){
                options.state.isBeyondMaxPage = true;
                $btn.html(options.finishedMsg);
              }
              $btn.show(options.loading.speed);
              options.callback(data);
             
          });
    }
    $(document).on('click','[data-paginate="loadmore"] .btn-loadmore',function(e){
       e.stopPropagation();
       e.preventDefault();
       options.loading.start.call($(options.contentSelector)[0],$(this));
    });
  }
  dhLoadmore.prototype.update = function(key){
    if ($.isPlainObject(key)) {
          this.options = $.extend(true,this.options,key);
      }
  }
  $.fn.dhLoadmore = function(options,callback){
    var thisCall = typeof options;
    switch (thisCall) {
           // method
           case 'string':
               var args = Array.prototype.slice.call(arguments, 1);
               this.each(function () {
                   var instance = $.data(this, 'dhloadmore');
                   if (!instance) {
                       return false;
                   }
                   if (!$.isFunction(instance[options]) || options.charAt(0) === '_') {
                       return false;
                   }
                   instance[options].apply(instance, args);
               });
  
           break;
           case 'object':
               this.each(function () {
                 var instance = $.data(this, 'dhloadmore');
                 if (instance) {
                     instance.update(options);
                 } else {
                     instance = new dhLoadmore(this, options, callback);
                     $.data(this, 'dhloadmore', instance);
                 }
             });
           break;
       }
    return this;
  };
}(jQuery);

+function($){
  'use strict';
  $.fn.dh_mediaelementplayer = function(options){
    var defaults = {};
    var options = $.extend(defaults, options);
    
    return this.each(function() {
      var el        = $(this);
      el.attr('width','100%').attr('height','100%'); 
      $(el).closest('.video-embed-wrap').each(function(){
        var aspectRatio = $(this).height() / $(this).width();
        $(this).attr('data-aspectRatio',aspectRatio).css({'height': $(this).width()*aspectRatio + 'px', 'width': '100%'});
      });
      el.mediaelementplayer({
        // none: forces fallback view
        mode: 'auto',
        // if the <video width> is not specified, this is the default
        defaultVideoWidth: '100%',
        // if the <video height> is not specified, this is the default
        defaultVideoHeight: '100%',
        // if set, overrides <video width>
        videoWidth: '100%',
        // if set, overrides <video height>
        videoHeight: '100%',
        // width of audio player
        audioWidth: "100%",
        // height of audio player
        audioHeight: 30,
        // initial volume when the player starts
        startVolume: 0.8,
        // useful for <audio> player loops
        loop: false,
        // enables Flash and Silverlight to resize to content size
        enableAutosize: true,
        // the order of controls you want on the control bar (and other plugins below)
        features: ['playpause','progress','duration','volume','fullscreen'],
        // Hide controls when playing and mouse is not over the video
        alwaysShowControls: false,
        // force iPad's native controls
        iPadUseNativeControls: false,
        // force iPhone's native controls
        iPhoneUseNativeControls: false,
        // force Android's native controls
        AndroidUseNativeControls: false,
        // forces the hour marker (##:00:00)
        alwaysShowHours: false,
        // show framecount in timecode (##:00:00:00)
        showTimecodeFrameCount: false,
        // used when showTimecodeFrameCount is set to true
        framesPerSecond: 25,
        // turns keyboard support on and off for this instance
        enableKeyboard: true,
        // when this player starts, it will pause other players
        pauseOtherPlayers: true,
        // array of keyboard commands
        keyActions: [],
        /*mode: 'shim'*/
      });
      window.setTimeout(function(){
        $(el).closest('.video-embed-wrap').css({'height': '100%', 'width': '100%'});
      },1000);
      $(el).closest('.mejs-container').css({'height': '100%', 'width': '100%'});
    });
    
  };
}(jQuery);


+function($){
  'use strict';
  DH.stickySize = function (){
    return 60;
  };
  DH.init = function(){
    // Tooltip
    $('[data-toggle="popover"]').popover();
    $('[data-toggle="tooltip"]').tooltip();
    
    var adminbarHeight = 0;
    if ( $( '#wpadminbar' ).length ) {
      adminbarHeight = parseInt($( '#wpadminbar' ).outerHeight());
    }
    
    $(window).on('resize', function() {
      if( $( '#wpadminbar' ).length ) {
        adminbarHeight = parseInt($( '#wpadminbar' ).outerHeight());
      }
    });
    
    
    if (navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0) {
      $(document.documentElement).addClass('dh-ie');
    }else{
      $(document.documentElement).addClass('dh-no-ie');
    }
    $(document.documentElement).addClass(DH.enableAnimation() ? 'dh-enable-animation':'dh-disable-animation');
    $(document.documentElement).addClass(DH.history() ? 'dh-history':'');
    //enable Retina Logo
    if (window.devicePixelRatio > 1 && dhL10n.logo_retina != '') {
      $('.navbar-brand img').each(function(){
        $(this).attr('src',dhL10n.logo_retina);
      });
    }
    
    //Navbar collapse
    $('.primary-navbar-collapse').on('hide.bs.collapse', function () {
        $(this).closest('.header-container').find('.navbar-toggle').removeClass('x');
    });
    $('.primary-navbar-collapse').on('show.bs.collapse', function () {
      $(this).closest('.header-container').find('.navbar-toggle').addClass('x');
       
    });
    
    //Fixed Main Nav
    if($('.header-container').length) {
      var $window = $( window );
      var $body   = $( 'body' ) ;
      
      
      var navTop = $('.header-container').hasClass('header-fixed') ? ( $('.topbar').length ? $('.topbar').height() : 0 ) :  $( '.navbar' ).offset().top;
      var dh_menu_categories_height = $('.dh-menu').length ? $('#menu-product-categories').height() + 150 : 0;
      var navScrollListener = function($this,isResize){
        if(isResize){
          if ( $body.hasClass( 'admin-bar' ) ) {
            adminbarHeight = $( '#wpadminbar' ).height();
          }
        }
        var $navbar = $( '.navbar' );
//          if(!$( '.boxed-wrap' ).length && $('.header-container').hasClass('header-absolute') && self.getViewport().width > dhL10n.nav_breakpoint){
//            $('.header-container').css({'top': adminbarHeight + 'px'});
//          }else{
//            $('.header-container').css({'top': ''});
//          }
        
        if(($('.header-container').hasClass('header-fixed') || $navbar.hasClass('navbar-scroll-fixed')) && DH.enableAnimation()){
          
          var scrollTop = parseInt($this.scrollTop(), 10),
            navHeight = 0,
            topbarOffset = 0;
          
          if($('.header-container').hasClass('header-fixed')){
            $('.header-container').css({'top': adminbarHeight + 'px'});
            if($('.topbar').length ){
              if(scrollTop > 0){
                if(scrollTop < $('.topbar').height()){
                  topbarOffset = - scrollTop;
                  $('.header-container').css({'top': topbarOffset + 'px'});
                }else{
                  $('.header-container').css({'top': - $('.topbar').height() + 'px'});
                }
              }else{
                $('.header-container').css({'top': adminbarHeight + 'px'});
              }
            }
          }
          var navTopScroll = navTop;
          if($('.header-container').hasClass('header-fixed') || $('.header-container').hasClass('header-absolute'))
            navTopScroll += adminbarHeight;
          
          if($('.header-container').hasClass('always-show-categories'))
            navTopScroll += dh_menu_categories_height;
          
          if(($this.scrollTop() + adminbarHeight ) > (navTopScroll + 50)){
            if(!$('.navbar-default').hasClass('navbar-fixed-top')){
              $('.navbar-default').addClass('navbar-fixed-top');
              $('.header-container').addClass('header-navbar-fixed');
              setTimeout(function() {
                          $('.navbar-default').addClass("fixed-transition")
                      }, 50);
              $navbar.css({'top': adminbarHeight + 'px'});
              $('.minicart').stop(true,true).fadeOut();
            }
            
          }else{
            if($('.navbar-default').hasClass('navbar-fixed-top')){
              $('.navbar-default').removeClass('navbar-fixed-top');
              $('.navbar-default').removeClass('fixed-transition');
              $('.header-container').removeClass('header-navbar-fixed');
            }
            $navbar.css({'top': ''});
            $('.minicart').stop(true,true).fadeOut();
          }
        }else{
          if($('.navbar-default').hasClass('navbar-fixed-top')){
            $('.navbar-default').removeClass('navbar-fixed-top');
            $('.navbar-default').removeClass('fixed-transition');
            $('.header-container').removeClass('header-navbar-fixed');
          }
          $navbar.css({'top': ''});
          $('.minicart').stop(true,true).fadeOut();
        }
      }
      navScrollListener( $window );
      $window.resize(function(){
        navScrollListener( $(this),true );
      });
      $window.scroll( function () {
        var $this = $(this);
        navScrollListener($this,false);
      });
    }
    
    //Off Canvas menu
    $('.navbar-toggle-fixed-btn,.navbar-toggle,.navbar-offcanvas-btn').on('click',function(e){
      e.stopPropagation();
      e.preventDefault();
      if($('body').hasClass('open-offcanvas')){
        $('body').removeClass('open-offcanvas').addClass('close-offcanvas');
        $('.navbar-toggle').removeClass('x');
      }else{
        $('body').removeClass('close-offcanvas').addClass('open-offcanvas');
        $('.navbar-toggle').addClass('x');
      }
      
    });
    $('body').on('mousedown', $.proxy( function(e){
      var element = $(e.target);
      if($('.offcanvas').length && $('body').hasClass('open-offcanvas')){
        if(!element.is('.offcanvas') && element.parents('.offcanvas').length === 0 && !element.is('.navbar-toggle') && element.parents('.navbar-toggle').length === 0 && !element.is('.navbar-offcanvas-btn') && element.parents('.navbar-offcanvas-btn').length === 0 )
        {
          $('body').removeClass('open-offcanvas');
          $('.navbar-toggle').removeClass('x');
        }
      }
    }, this) );
    
    $('.offcanvas-nav .dropdown-hover .caret,.offcanvas-nav .dropdown-submenu > a > .caret,.offcanvas-nav .megamenu-title .caret').off('click').on('click',function(e){
      e.stopPropagation();
      e.preventDefault();
      var dropdown = $(this).closest(".dropdown, .dropdown-submenu");
      if (dropdown.hasClass("open")) {
        dropdown.removeClass("open");
      } else {
        dropdown.addClass("open");
      }
    });
    
    if(DH.enableAnimation()){
      var __popover_timeout;
      var elAppear = function(){
        if(DH.getViewport().width > dhL10n.breakpoint){
          $('.el-appear').each(function(){
            $(this).appear(function(){
              $(this).addClass('animate-appear');
              if($(this).hasClass('show-first')){
                var __popover = $(this);
                setTimeout(function () {
                   __popover.popover('show');
                   }, 1000)
                
              }
            });
          });
        }
      }
      elAppear();
      $(window).resize(function(){
        elAppear();
      });
      $('.animate-box[data-animate="1"]').each(function(){
        var $this = $(this);
        if(DH.enableAnimation() && DH.getViewport().width > dhL10n.breakpoint){
          $this.appear(function(){
            $this.addClass('go');
          });
        }else{
          $this.css('visibility', 'visible');
        }
      });
    }
    
    //Go to top
    $(window).scroll(function () {
      if ($(this).scrollTop() > 500) {
        $('.go-to-top').addClass('on');
      }
      else {
        $('.go-to-top').removeClass('on');
      }
    });
    $('body').on( 'click', '.go-to-top', function () {
      $("html, body").animate({
        scrollTop: 0
      }, 800);
      return false;
    });
    
    //offcanvas-footer-newsletter
    if("undefined" != typeof $.cookie && $.cookie("offcanvas_newsletter")){
    	$('.offcanvas-footer-newsletter').addClass('off');
    }
    $(document).on('click','.offcanvas-footer-newsletter .close',function(){
    	var _wrap = $(this.closest('.offcanvas-footer-newsletter'));
    	if(_wrap.hasClass('off')){
    		_wrap.removeClass('off');
    		_wrap.find('input[name="email"]').focus();
    		_wrap.find('input[name="email"]').select();
    	}else{
    		_wrap.addClass('off');
    		if("undefined" != typeof $.cookie){
    			 $.cookie('offcanvas_newsletter',1,{
                     expires: 1,
                     path: dhL10n.cookie_path
                 });
    		}
    	}
    });
    
    //full page
    if("undefined" != typeof $.fn.fullpage){
    	$(".main-content").fullpage({
    		navigation:true,
    		sectionSelector:".main-content .vc_row-o-full-height",
    		navigationPosition:"right",
    		lockAnchors:false
    	});
    	$(window).resize(function(){$.fn.fullpage.reBuild();});
    }
    
    //fitVids
    if($().fitVids){
      $(".main-content").fitVids();
    }
    
    //Media element player
    DH.mediaelementplayerInit();
    //DH Slider
    DH.dhSliderInit();

    
    //Nav Dropdown
    DH.navDropdown();
    $(window).resize(function(){
      DH.navDropdown();
    })
    //Heading Parallax
    DH.headingInit();
    
    //PopUp
    DH.magnificpopupInit();
    
    //Carousel
    DH.carouselInit();
    
    //Responsive embed iframe
    DH.responsiveEmbedIframe();
    $(window).resize(function(){
      DH.responsiveEmbedIframe();
    });
    //Woocommerce
    if(parseInt(dhL10n.woocommerce))
      DH.woocommerceInit();
    //isotope
    DH.isotopeInit();
    $(window).resize(function(){
      $('[data-layout="masonry"]').each(function(){
        var $this = $(this),
          container = $this.find('.masonry-wrap');
          container.isotope( 'layout' );
      });
    });
    //Load more
    DH.loadmoreInit();
    //Infinite Scrolling
    DH.infiniteScrollInit();
    
    //Ajax Search
    DH.ajaxSearchInit();
    
    //User Login and register account.
    DH.userInit();
    
    //Short code
    DH.shortcodeInit();
    
    //SmartSidebar
    DH.SmartSidebar();
    
  };
  
  DH.initScrollspy = function(){
    $('[data-spy="scroll"]').scrollspy({
       target: '.primary-navbar-collapse',
       offset: DH.stickySize()
    });
    //One Page
    setTimeout(function () {
      $('[data-spy="scroll"]').each(function () {
        var $spy = $('body').scrollspy('refresh');
      });
    },1000);
    $(window).on('resize',function(){
      //onePage();
      $('[data-spy="scroll"]').each(function () {
        var $spy = $('body').scrollspy('refresh');
      });
    });
    
    $('[data-spy="scroll"]').on('activate.bs.scrollspy', function () {
      var scrollspy = $(this).data('bs.scrollspy');
      if(scrollspy){
        $(scrollspy.selector)
          .parents('.open')
          .removeClass('open');
        var selector = scrollspy.selector +
              '[data-target="' + scrollspy.activeTarget + '"],' +
              scrollspy.selector + '[href="' + scrollspy.activeTarget + '"]'
              
        var active = $(selector)
          .parents('li')
          .addClass('open');
        
        if (active.parent('.dropdown-menu').length) {
          active = active
          .closest('li.dropdown')
          .addClass('open');
        }
      }
    });
    
    if($('[data-spy="scroll"]').length){
      $('.mobile-offcanvas-navbar .offcanvas-nav a:not([href="#"]),.primary-nav a:not([href="#"], .megamenu-sidebar a, .navbar-search-button, .search-form-wrap a, .minicart a, .minicart-link), .top-menu .topbar-nav a:not([href="#"])').click(function() {          
        if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname) {
          if(this.hash) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
            if (target.length && this.hash.slice(1) != '' ) {
              $( '.primary-nav li' ).removeClass( 'open' );
              if(DH.getViewport().width <= dhL10n.nav_breakpoint && $('.offcanvas').length && $('body').hasClass('open-offcanvas')){
                $('body').removeClass('open-offcanvas');
                $('.navbar-toggle').removeClass('x');
              };
              $('html, body').animate({
                 scrollTop: target.offset().top - (DH.stickySize() - 2)
              }, 850, 'easeInOutExpo');
              return false;
            }
          }
        }
      });
    }
  };
  
  DH.SmartSidebar = function(){
    if($().dhSmartSidebar){
      $('.main-sidebar').dhSmartSidebar({
        _main_content: $('.main-wrap')
      });
    }
  };
  
  DH.shortcodeInit = function(){
    "undefined" != typeof jQuery.fn.waypoint && jQuery(".vc_progress_bar").waypoint(function(){
      $('.vc_single_bar').each(function(index){
        var $this=jQuery(this),
          bar=$this.find(".vc_bar"),
          val=bar.data("percentage-value");
          $this.find('.vc_label_units span').countTo({
            from: 0,
            to: val,
            speed: 1100,
            refreshInterval: 30
          });
      });
    },{
      offset: "85%",
            triggerOnce: true
    });
    
    var counter = function(){
      if(!DH.enableAnimation()){
        return;
      }
      $('.counter').each(function(){
        var $this = $(this);
        var counter_number = $this.find('.counter-number');
        counter_number.text('0');
        "undefined"!=typeof jQuery.fn.waypoint && $this.waypoint(function(){
          counter_number.countTo({
            from: 0,
            to: counter_number.data('to'),
            speed: counter_number.data('speed'),
            decimals:counter_number.data('num-decimals'),
            decimal: counter_number.data('decimal-sep'),
            thousand: counter_number.data('thousand-sep'),
            refreshInterval: 30,
            formatter: function (value, options) {
              value = value.toFixed(options.decimals);
              value += '';
                  var x, x1, x2, rgx;
                  x = value.split('.');
                  x1 = x[0];
                  x2 = x.length > 1 ? options.decimal + x[1] : '';
                  rgx = /(\d+)(\d{3})/;
                  if(typeof(options.thousand) === 'string' && options.thousand !=''){
                    while (rgx.test(x1)) {
                          x1 = x1.replace(rgx, '$1' + options.thousand + '$2');
                      }
                  }
                  return x1 + x2;
                }
          });  
        }, {
                  offset: "85%",
                  triggerOnce: true
              });
      });
    }
    counter();
    
    $('[data-toggle="countdown"]').each(function(){
      var _this = $(this);
      _this.find('.countdown-content').countdown(_this.data('end'), function(event) {
        $(this).html(event.strftime(_this.data('html')));
      });
    });
    
    //DH Typed
    $('.dh-typed').each(function(){
      var typed_text = $(this).find('.dh-typed-text');
      typed_text.typed(typed_text.data('options'));
    });
    //DH Tabs
    var load_product_tab = function($this,selector){
      $.post(dhL10n.ajax_url,{action:'dh_get_product_tab',query:$this.data('query'),columns:$this.data('columns'),cat_slug:$this.data('cat_slug')},function(response){
        if(response.status){
          $(selector).html(response.content);
          DH.woocommerceLazyLoading();
          $this.addClass('tab-loaded');
        }
      });
    }
    $('[data-toggle="tab"], [data-toggle="pill"]').each(function(e){
      
      var $this = $(this);
      var selector = $this.attr('href') && $this.attr('href').replace(/.*(?=#[^\s]*$)/, '');
      
      if($this.parent().hasClass('active') && $this.hasClass('product-tab-control') && !$this.hasClass('tab-loaded')){
        load_product_tab($this,selector);
      };
      $this.on('shown.bs.tab', function (e) {
        if($this.data('color')){
          $this.parents('li').css('color',$this.data('color'));
        }
        if($this.hasClass('product-tab-control') && !$this.hasClass('tab-loaded')){
          load_product_tab($this,selector);
        }else{
          DH.isotopeInit();
          DH.woocommerceLazyLoading();
        }
        $(selector).find('.caroufredsel').find('ul').trigger('updateSizes').trigger('resize');
      })
      $('[data-spy="scroll"]').each(function () {
        var $spy = $(this).scrollspy('refresh');
      });
    });
    
    $( document ).on( 'show.vc.accordion', function(e){
       var $this = $(e.target),
              selector;
          selector = $this.data( 'vcTarget' );
          if ( ! selector ) {
              selector = $this.attr( 'href' );
          }
          //$this.data('carouseloptions',carouselOptions);carousel.trigger("destroy").carouFredSel(carouselOptions);
          var carousel = $(selector).find('.caroufredsel'),
            carouselOptions = carousel.data('carouseloptions') ;
          if(carousel.length)
            $(selector).find('.caroufredsel').find('ul').trigger("destroy").carouFredSel(carousel.data('carouseloptions'));
    
    } );
    
    $('.btn.btn-custom-color').each(function(){
      var $this = $(this);
      //hover background color
      if(typeof $this.data('hover-background-color') !== 'undefined' && $this.data('hover-background-color') !== false && $this.data('hover-background-color') != '') {
                var hover_background_color = $this.data('hover-background-color');
                var initial_background_color = $this.css('background-color');
                $this.hover(
                function() {
                    $this.css('background-color', hover_background_color);
                },
                function() {
                    $this.css('background-color', initial_background_color);
                });
            }
      //hover border color
      if(typeof $this.data('hover-border-color') !== 'undefined' && $this.data('hover-border-color') !== false && $this.data('hover-border-color') != '') {
                var hover_border_color = $this.data('hover-border-color');
                var initial_border_color = $this.css('border-top-color');
                $this.hover(
                function() {
                    $this.css('border-color', hover_border_color);
                },
                function() {
                    $this.css('border-color', initial_border_color);
                });
            }
      //hover color
      if(typeof $this.data('hover-color') !== 'undefined' && $this.data('hover-color') !== false && $this.data('hover-color') != '') {
                var hover_color = $this.data('hover-color');
                var initial_color = $this.css('color');
                $this.hover(
                function() {
                    $this.css('color', hover_color);
                },
                function() {
                    $this.css('color', initial_color);
                });
            }
    });
  };
  DH.userInit = function(){
    //User Nav
    $(document).on("mouseenter", ".navuser-nav", function() {
      window.clearTimeout($(this).data('timeout'));
      $('.navuser-dropdown').fadeIn(50);
    });
    $(document).on("mouseleave", ".navuser-nav", function() {
        var t = setTimeout(function() {
          $('.navuser-dropdown').fadeOut(50);
        }, 400);
        $(this).data('timeout', t);
    });
    
    if($('#newsletterModal').length){
      if($.cookie && !$.cookie("dh_newsletter_modal")){
    	setTimeout(function(){
            $('#newsletterModal').modal('show');
    	},1200);
        var interval  = parseInt($('#newsletterModal').data('interval'));
        if(interval){
          $.cookie("dh_newsletter_modal", 1, {
                      expires: interval,
                      path: dhL10n.cookie_path
                  });
        }else{
          $.cookie('dh_newsletter_modal','',{
                      expires: -1,
                      path: dhL10n.cookie_path
                  });
        }
      }
      $('form#newsletterModalForm').on('submit', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var _this = $(this);
        _this.find('.ajax-modal-result').show().html('<i class="fa fa-spinner spinner-loading"></i> ' + dhL10n.loadingmessage);
        $.ajax({
                  type: 'POST',
                  dataType: 'json',
                  url: dhL10n.ajax_url,
                  data: {
                      action      : 'dh_newsletter_ajax',
                      email      : _this.find('#newsletter-modal-email').val(),
                      _subscribe_nonce: _this.find('#_subscribe_nonce').val()
                  },
                  success: function (data) {
                    _this.find('.ajax-modal-result').show().html(data.message);
                      if (data.success == true) {
                        window.setTimeout(function(){
                          $('#newsletterModal').modal('hide');
                          $('#newsletterModal').on('hidden.bs.modal',function(){
                            $('#newsletterModal').remove();
                          });
                        },1500);
                      }
                  },
                  complete: function () {

                  },
                  error: function () {
                    return;
                  }
                  
              });
      });
    }
    
    if(parseInt(dhL10n.user_logged_in) != 1){
      $(document).on('click','[rel=registerModal]',function(e){
        e.stopPropagation();
        e.preventDefault();
        if($('#userloginModal').length){
          $('#userloginModal').modal('hide');
        }
        if($('#userlostpasswordModal').length){
          $('#userlostpasswordModal').modal('hide');
        }
        if($('#userregisterModal').length){
          $('#userregisterModal').modal('show');
        }
      });
      $(document).on('click','[rel=loginModal]',function(e){
        e.stopPropagation();
        e.preventDefault();
        if($('#userregisterModal').length){
          $('#userregisterModal').modal('hide');
        }
        if($('#userlostpasswordModal').length){
          $('#userlostpasswordModal').modal('hide');
        }
        if($('#userloginModal').length){
          $('#userloginModal').modal('show');
        }
      });
      $(document).on('click','[rel=lostpasswordModal]',function(e){
        e.stopPropagation();
        e.preventDefault();
        if($('#userregisterModal').length){
          $('#userregisterModal').modal('hide');
        }
        if($('#userloginModal').length){
          $('#userloginModal').modal('hide');
        }
        if($('#userlostpasswordModal').length){
          $('#userlostpasswordModal').modal('show');
        }
      });
      $('form#userregisterModalForm').on('submit', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var _this = $(this);
        _this.find('.user-modal-result').show().html('<i class="fa fa-spinner spinner-loading"></i> ' + dhL10n.loadingmessage);
        $.ajax({
                  type: 'POST',
                  dataType: 'json',
                  url: dhL10n.ajax_url,
                  data: {
                      action: 'dh_register_ajax',
                      user_login  : _this.find('#user_login').val(),
                      user_email  : _this.find('#user_email').val(),
                      user_password: _this.find('#user_password').val(),
                      cuser_password: _this.find('#cuser_password').val(),
                      security: _this.find('#register-security').val()
                  },
                  success: function (data) {
                    _this.find('.user-modal-result').show().html(data.message);
                      if (data.success == true) {
                          if (data.redirecturl == null) {
                              document.location.reload();
                          }
                          else {
                              document.location.href = data.redirecturl;
                          }
                      }
                  },
                  complete: function () {

                  },
                  error: function () {
                    _this.off('submit');
                    _this.submit();
                  }
                  
              });
      });
      $('form#userloginModalForm').on('submit', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var _this = $(this);
        _this.find('.user-modal-result').show().html('<i class="fa fa-spinner spinner-loading"></i> ' + dhL10n.loadingmessage);
        $.ajax({
                  type: 'POST',
                  dataType: 'json',
                  url: dhL10n.ajax_url,
                  data: {
                      action: 'dh_login_ajax',
                      log: _this.find('#username').val(),
                      pwd: _this.find('#password').val(),
                      remember: (_this.find('#rememberme').is(':checked') ? true : false),
                      security: _this.find('#login-security').val()
                  },
                  success: function (data) {
                    _this.find('.user-modal-result').show().html(data.message);
                      if (data.loggedin == true) {
                          if (data.redirecturl == null) {
                              document.location.reload();
                          }
                          else {
                              document.location.href = data.redirecturl;
                          }
                      }
                  },
                  complete: function () {

                  },
                  error: function () {
                    _this.off('submit');
                    _this.submit();
                  }
                  
              });
      });
      
      $('form#userlostpasswordModalForm').on('submit', function (e) {
        e.stopPropagation();
        e.preventDefault();
        var _this = $(this);
        _this.find('.user-modal-result').show().html('<i class="fa fa-spinner spinner-loading"></i> ' + dhL10n.loadingmessage);
        $.ajax({
                  type: 'POST',
                  url: dhL10n.ajax_url,
                  data: {
                      action: 'dh_lostpassword_ajax',
                      user_login: _this.find('#user_login').val(),
                      security: _this.find('#lostpassword-security').val()
                  },
                  success: function (data) {
                    _this.find('.user-modal-result').show().html(data);
                  },
                  complete: function () {
                    
                  },
                  error: function () {
                    _this.off('submit');
                    _this.submit();
                  }
                  
              });
      });
    }
  };
  
  DH.ajaxSearchInit = function(){
    DH.searching = false;
    DH.lastSearchQuery = "";
    DH.searchTimeout = false;
    DH.doSearch = function(e){
      $('.searchform.search-ajax').each(function(){
        var form =  $(this),
          wrapper = form.parent(),
          result = wrapper.find('.searchform-result');
        
        if(this.searching && e.currentTarget.value.indexOf(this.lastSearchQuery) != -1){
          return;
        }
        this.lastSearchQuery = e.currentTarget.value;
        var query =  form.serialize() + "&action=dh_search_ajax";
        $.ajax({
          url: dhL10n.ajax_url,
          type: "POST",
          data: query ,
          beforeSend: function(){
            form.addClass('loading');
            this.searching = true;
          },
          success: function(response){
            if(response == 0) 
              response = "";
            result.html(response);
          },
          complete: function(){
            form.removeClass('loading');
            this.searching = false;
          }
        });
      });
    }
    $(document).on('click','.navbar-search-button',function(e){
      e.stopPropagation();
      e.preventDefault();
      if($('.header-search-overlay').length){
        $('.header-search-overlay').stop(true,true).removeClass('hide').css('opacity',0).animate({'opacity' :1},600,'swing',function(){
          $(this).find('.searchinput').focus();
        });
        $('body').addClass('overflow-hidden');
      }else if($('.search-form-wrap').length){
        if ($('.search-form-wrap').hasClass('hide'))
        {
          $('.search-form-wrap').removeClass('hide').addClass('show');
          $('.search-form-wrap .searchinput').focus();
        }
      }
      
    });
    $('body').on('mousedown', $.proxy( function(e){
      var element = $(e.target);
      if($('.header-search-overlay').length){
        if(!element.is('.searchinput') && element.parents('.searchinput').length === 0 )
        {
          $('.header-search-overlay').removeClass('show').addClass('hide');
          $('body').removeClass('overflow-hidden');
        }
      }else{
        if(!element.is('.search-form-wrap') && element.parents('.search-form-wrap').length === 0 )
        {
          $('.search-form-wrap').removeClass('show').addClass('hide');
          $('body').removeClass('overflow-hidden');
        }
      }
    }, this) );
    
    $('.searchform.search-ajax').on('keyup', '.searchinput' , $.proxy( function(e){
      window.clearTimeout(DH.searchTimeout);
      if(e.currentTarget.value.length >= 3 && this.lastSearchQuery != $.trim(e.currentTarget.value))
      {
        this.searchTimeout = window.setTimeout($.proxy( DH.doSearch, this, e),350);
      }

    }, this));
    $(document).on('click','.header-search-overlay .close',function(){
      $('.header-search-overlay').stop(true,true).animate({'opacity' :0},600,'swing',function(){
        $(this).addClass('hide');
      });
    });
  };
  DH.mediaelementplayerInit = function(){
    if($().mediaelementplayer) {
      $(".video-embed:not(.video-embed-popup),.audio-embed:not(.audio-embed-popup)").dh_mediaelementplayer();
    }
  };
  DH.loadmoreInit = function(){
    $('[data-paginate="loadmore"]').each(function(){
      var $this = $(this);
      $this.dhLoadmore({
        contentSelector : $this.data('contentselector') || null,
        navSelector  : $this.find('div.paginate'),            
             nextSelector : $this.find('div.paginate a.next'),
             itemSelector : $this.data('itemselector'),
             finishedMsg  : $this.data('finishedmsg') || dhL10n.ajax_finishedMsg
      },function(newElements){
        DH.woocommerceLazyLoading();
        $(newElements).find(".video-embed:not(.video-embed-popup),.audio-embed:not(.audio-embed-popup)").dh_mediaelementplayer();
        
        if($this.hasClass('masonry')){
          $this.find('.masonry-wrap').isotope('appended', $(newElements));
          if($this.find('.masonry-filter').length){
            var selector = $this.find('.masonry-filter').find('a.selected').data('filter-value');
            $this.find('.masonry-wrap').isotope({ filter: selector });
          }
        }
        imagesLoaded(newElements,function(){
          DH.magnificpopupInit();
          DH.responsiveEmbedIframe();
          DH.carouselInit();
          if($this.hasClass('masonry')){
            $this.find('.masonry-wrap').isotope('layout');
          }
        });
      });
    });
  };
  DH.infiniteScrollInit = function(){
    //Posts
    $('[data-paginate="infinite_scroll"]').each(function(){
      var $this = $(this);
      var finishedmsg = $this.data('finishedmsg') || dhL10n.ajax_finishedMsg,
        msgtext = $this.data('msgtext') || dhL10n.ajax_msgText,
        maxPage = $this.data('contentselector') ? $($this.data('contentselector')).data('maxpage') : undefined;
      $this.find('.infinite-scroll-wrap').infinitescroll({
        navSelector  : $this.find('div.paginate'),            
             nextSelector : $this.find('div.paginate a.next'),    
             itemSelector :  $this.data('itemselector'),
             contentSelector : $this.data('contentselector') || $this.find('.infinite-scroll-wrap'),
            msgText: " ", 
            maxPage:maxPage,
            loading: {
              finishedMsg: finishedmsg,
          msgText: $this.data('msgtext') || dhL10n.ajax_msgText,
          selector: $this,
          msg: $('<div class="infinite-scroll-loading"><div class="fade-loading"><i></i><i></i><i></i><i></i></div><div class="infinite-scroll-loading-msg">' + msgtext +'</div></div>')
        },
        errorCallback: function(){
          $this.find('.infinite-scroll-loading-msg').html(finishedmsg).animate({ opacity: 1 }, 2000, function () {
                    $(this).parent().fadeOut('fast');
                });
        }
      },function(newElements){
        DH.woocommerceLazyLoading();
        $(newElements).find(".video-embed:not(.video-embed-popup),.audio-embed:not(.audio-embed-popup)").dh_mediaelementplayer();
        
        if($this.hasClass('masonry')){
          $this.find('.masonry-wrap').isotope('appended', $(newElements));
          if($this.find('.masonry-filter').length){
            var selector = $this.find('.masonry-filter').find('a.selected').data('filter-value');
            $this.find('.masonry-wrap').isotope({ filter: selector });
          }
        }
        imagesLoaded(newElements,function(){
          DH.magnificpopupInit();
          DH.responsiveEmbedIframe();
          DH.carouselInit();
          if($this.hasClass('masonry')){
            $this.find('.masonry-wrap').isotope('layout');
          }
        });
      });
    });
    
  };
  DH.carouselInit = function(destroy){
    destroy = destroy || false;
    //related post carousel
    $('.caroufredsel').each(function(){
      var $this = $(this),
        $visible = 3,
        $height = 'auto',
        $circular = false,
        $auto_play = false,
        $scroll_fx = 'scroll',
        $duration = 2000,
        $items_height = 'variable',
        $auto_pauseOnHover = 'resume',
        $items_width = '100%',
        $infinite = false,
        $responsive = false,
        $scroll_item = 1,
        $easing = 'swing',
        $scrollDuration = 600,
        $direction = 'left';
      if($this.hasClass('product-slider')){
        $visible = {
          min: $(this).data('visible-min'),
          max: $(this).find('ul.products').data('columns')
        };
      }else{
        if($(this).data('visible-min') && $(this).data('visible-max')){
          $visible = {
            min: $(this).data('visible-min'),
            max: $(this).data('visible-max')
          };
        }
      }
      if($(this).data('visible')){
        $visible = $(this).data('visible');
      }
      if($(this).data('height')){
        $height = $(this).data('height');
      }
      if($(this).data('direction')){
        $direction = $(this).data('direction');
      }
      if($(this).data('scrollduration')){
        $scrollDuration = $(this).data('scrollduration');
      }
      if ($(this).data("speed") ) {
        $duration = parseInt($(this).data("speed"));
      }
      if ($(this).data("scroll-fx") ) {
        $scroll_fx = $(this).data("scroll-fx");
      }
      if ($(this).data("circular")) {
        $circular = true;
      }
      if ($(this).data("infinite")) {
        $infinite = true;
      }
      if ($(this).data("responsive")) {
        $responsive = true;
      }
      if ($(this).data("autoplay")) {
        $auto_play = true;
      }
      if($(this).data('scroll-item')){
        $scroll_item = parseInt($(this).data('scroll-item'));
      }
      if($(this).data('easing')){
        $easing = $(this).data('easing');
      }
      var carousel = $(this).children('.caroufredsel-wrap').children('ul.caroufredsel-items').length ? $(this).children('.caroufredsel-wrap').children('ul.caroufredsel-items') :  $(this).children('.caroufredsel-wrap').find('ul');
      var carouselOptions = {
        responsive: $responsive,
        circular: $circular,
        infinite:$infinite,
        width: '100%',
        height: $height,
        direction:$direction,
        auto: {
          play : $auto_play,
          pauseOnHover: $auto_pauseOnHover
        },
        swipe: {
           onMouse: false,
                 onTouch: true
        },
        scroll: {
          items: $scroll_item,
          duration: $scrollDuration,
          mousewheel: true,
          fx: $scroll_fx,
          timeoutDuration: $duration,
          easing: $easing,
          wipe: true
        },
        items: {
          height: $items_height,
          visible: $visible
        }
      };
      if($(this).data('scroll-item')){
        carouselOptions.scroll.items = $(this).data('scroll-item');
      }
      if($this.data('synchronise')){
        carouselOptions.synchronise = [$this.data('synchronise'),false];
        var synchronise = $this.data('synchronise');
        $(synchronise).find('li').each(function(i){
          $(this).addClass( 'synchronise-index-'+i );
          $(this).on('click',function(){
            carousel.trigger('slideTo',[i, 0, true]);
            return false;
          });
        });
        carouselOptions.scroll.onBefore = function(){
          $(synchronise).find('.selected').removeClass('selected');
          var pos = $(this).triggerHandler( 'currentPosition' );
          $(synchronise).find('.synchronise-index-' + pos).addClass('selected');
        };
        
      }
      
      if($this.children('.caroufredsel-pagination').length){
        carouselOptions.pagination = {container:$this.children('.caroufredsel-pagination')};
      }
      if($(this).children('.caroufredsel-wrap').children('.caroufredsel-prev').length && $(this).children('.caroufredsel-wrap').children('.caroufredsel-next').length){
        carouselOptions.prev = $(this).children('.caroufredsel-wrap').children('.caroufredsel-prev');
        carouselOptions.next = $(this).children('.caroufredsel-wrap').children('.caroufredsel-next');
      }
      
      if(destroy)
        carousel.trigger('destroy');
      
      carousel.carouFredSel(carouselOptions);
      $this.data('carouseloptions',carouselOptions);
      var $element = $this;
      if($this.find('img').length == 0) $element = $('body');
      
      imagesLoaded($element,function(){
        carousel.carouFredSel(carouselOptions);
        $('[data-spy="scroll"]').each(function () {
          var $spy = $(this).scrollspy('refresh');
        });
      });
      
      $this.css('opacity','1' );
    });
  };
  DH.responsiveEmbedIframe = function(){
  };
  DH.isotopeInit = function(){
    $('[data-layout="masonry"]').each(function(){
      var $this = $(this),
        container = $this.find('.masonry-wrap'),
        itemColumn = $this.data('masonry-column'),
        itemWidth,
        container_width = container.width();
        if(DH.getViewport().width > 992){
          itemWidth = container_width / itemColumn;
        }else if(DH.getViewport().width <= 992 && DH.getViewport().width >= 768){
          itemWidth = container_width / 2;
        }else {
          itemWidth = container_width / 1;
        }
        var iso = container.isotope({
          layoutMode: 'masonry',
          itemSelector: '.masonry-item',
          transitionDuration : '0.8s',
          getSortData : { 
            title : function (el) { 
              return $(el).data('title');
            }, 
            date : function (el) { 
              return parseInt($(el).data('date'));
            } 
          },
          masonry : {
            columnWidth:itemWidth,
            gutter : 0
          }
        }).isotope( 'layout' );
        imagesLoaded($this,function(){
          container.isotope( 'layout' );
          $('[data-spy="scroll"]').each(function () {
            var $spy = $(this).scrollspy('refresh');
          });
        });
      if(!$this.hasClass('masonry-inited')){
        $this.addClass('masonry-inited');
        var filter = $this.find('.masonry-filter ul a');
        filter.on('click',function(e){
          e.stopPropagation();
          e.preventDefault();
          
          var $this = jQuery(this);
          // don't proceed if already selected
          if ($this.hasClass('selected')) {
            return false;
          }
          
          var filters = $this.closest('ul');
          filters.find('.selected').removeClass('selected');
          $this.addClass('selected');
          $this.closest('.masonry-filter').find('.filter-heaeding h3').text($this.text());
          var options = {
            layoutMode : 'masonry',
            transitionDuration : '0.8s',
            getSortData : { 
              title : function (el) { 
                return $(el).data('title');
              }, 
              date : function (el) { 
                return parseInt($(el).data('date'));
              } 
            }
          }, 
          key = filters.attr('data-filter-key'), 
          value = $this.attr('data-filter-value');
    
          value = value === 'false' ? false : value;
          options[key] = value;
          container.isotope(options);
          $('[data-spy="scroll"]').each(function () {
            var $spy = $(this).scrollspy('refresh');
          });
        });
        $('[data-masonry-toogle="selected"]').trigger('click');
      }
    });
    
  };
  DH.easyZoomInit = function(){
    if($().easyZoom) {
      $('.easyzoom').easyZoom();
    }
  };
  DH.woocommerce_variations_form_init = function(wrap){
    wrap = wrap || $('body');
    var single_product_images_slider = wrap.find('.single-product-images-slider'),
      has_single_product_thumbnails = false,
      single_product_thumbnails = wrap.find('.single-product-thumbnails'),
      main_product_image_item_template = single_product_images_slider.data('item_template'),
      thumbnail_product_image_item_template =  single_product_thumbnails.data('item_template');
      if(single_product_thumbnails.length){
        has_single_product_thumbnails = true;
      }
      if(!single_product_images_slider.length){
			return;
	   }
      var caroufredsel_fixed = function() {
          if (has_single_product_thumbnails) {
              var single_product_thumbnails_length = single_product_thumbnails.find('li').length;
              if (single_product_thumbnails_length > 0 && single_product_thumbnails_length < 3) {
                  single_product_thumbnails.addClass('caroufredsel-fixed');
                  if(single_product_thumbnails_length == 1){
                      single_product_thumbnails.addClass('hide');
                  }else{
                      single_product_thumbnails.removeClass('hide');
                  }
              } else {
                  single_product_thumbnails.removeClass('caroufredsel-fixed hide');
              }
          }
      };
    var reload_variations_images = function(images){
    var d_width = single_product_images_slider.find('li:eq(0)').width();
       single_product_images_slider.find('.caroufredsel-items').empty();
       if(has_single_product_thumbnails){
         single_product_thumbnails.find('.caroufredsel-items').empty();
       }
       $.each( images, function( index, image ){
         var main_product_image_item_html = main_product_image_item_template.replace('__image_full__',image.full).replace('__width__','width:'+d_width +'px;').replace('__image_title__',image.title).replace('__image__','<img src="' + image.single  + '" />');
           single_product_images_slider.find('.caroufredsel-items').append( main_product_image_item_html );
         if(has_single_product_thumbnails){
           var thumbnail_product_image_item_html = thumbnail_product_image_item_template.replace('__image_title__',image.title).replace('__image__','<img src="' + image.thumb  + '" />');
           single_product_thumbnails.find('.caroufredsel-items').append( thumbnail_product_image_item_html );
         }
       });
       setTimeout(function() {
           caroufredsel_fixed();
       }, 200);
       single_product_images_slider.addClass('loading');
       if(has_single_product_thumbnails){
         single_product_thumbnails.addClass('loading')
       }
       $(document).trigger('before_woocommerce_variations_form_init',[wrap]);
       imagesLoaded(single_product_images_slider,function(){
         single_product_images_slider.removeClass('loading');
         if(has_single_product_thumbnails){
           single_product_thumbnails.removeClass('loading')
         }
         single_product_images_slider.find('li:eq(0)').addClass('selected');
         if(has_single_product_thumbnails){
           single_product_thumbnails.find('li:eq(0)').addClass('selected');
         }
         DH.easyZoomInit();
         DH.magnificpopupInit();
         DH.carouselInit(true);
       });
       $(document).trigger('after_woocommerce_variations_form_init',[wrap]);
    };
    
    wrap.find( '.variations_form' ).each( function() {
      var variations_form = $(this),
        product_images = single_product_images_slider.data('product_images');
      if(single_product_images_slider.data('dh_disable_variation_gallery') === "yes")
        return;
      
      variations_form.data('dh_variation_current',variations_form.data('product_id'))
        .data('dh_variation_changed',false)
        .data('dh_variation_need_change',false);
      if(!isNaN(parseInt(variations_form.find('input[name=variation_id]').val()))){
        variations_form.data('dh_variation_need_change',true);
      }
      setTimeout(function() {
          caroufredsel_fixed();
      }, 200);
      variations_form.on('reset_image',function(event){
        if(variations_form.data('dh_variation_changed')){
          reload_variations_images(product_images);
          variations_form.data('dh_variation_changed',false);
        }
      }).on('show_variation',function(event, variation){
        
        var single_variation_wrap = variations_form.find( '.single_variation_wrap' ),
          _variation_current = variations_form.data('dh_variation_current'),
          _variation_value = parseInt(variations_form.find('input[name=variation_id]').val());
        
        _variation_current  = parseInt(_variation_current);
        
        var _variation_id = parseInt(variation.variation_id);
        if ((!isNaN(_variation_value) && single_variation_wrap.is( ':visible' ) && _variation_current != _variation_value) || variations_form.data('dh_variation_need_change')) {
          var additional_images =  variation.additional_images;
          if($.isEmptyObject(additional_images)){
            additional_images = product_images;
          }
          reload_variations_images(additional_images);
          variations_form.data('dh_variation_current',variation.variation_id).data('dh_variation_changed',true);
        }
      });
    });
  };
  DH.woocommerceLazyLoading = function(){
   
  };
  DH.woocommerceInit = function(){
    DH.easyZoomInit();
    DH.woocommerceLazyLoading();
    $( 'body' ).on( 'click', '#respond p.stars a', function() {
      $(this).closest('p.stars').addClass('has-active');
    });
    
    if($('.minicart-side').length){
      $('.minicart-link').on('click',function(e){
        e.preventDefault();
        e.stopPropagation();
        
        if($('.minicart-side').hasClass("open")){
          $('.minicart-side').removeClass("open");
        }else{
          $('.minicart-side').addClass("open");
        }
        
      });
      $('body').on('click', $.proxy( function(e){
        var element = $(e.target);
        if($('.minicart-side').length && $('.minicart-side').hasClass('open')){
          if(!element.is('.minicart-side') && element.parents('.minicart-side').length === 0 )
          {
            $('.minicart-side').removeClass('open');
          }
        }
      }, this) );
      
    }
      
      
    var isShop = ($('.woo-content').length) ? true : false,
      hasPushState = false;
    
    this.added_to_cart_timeout;
    
    if(isShop){
       $(window).on('popstate.dhshop', function(e) {
        if (!e.originalEvent.state) { 
          return; 
        }
        if (e.originalEvent.state.dhShop) {
          get_shop_ajax(window.location.href,true);
        }
      });
    }
    
    if (isShop && $('html').hasClass('dh-history')) {
      hasPushState = true;
      window.history.replaceState({dhShop: true}, '', window.location.href);
    }
    
    var filter_ajax_scroll = function(){
      var shop_position = Math.round($('.woo-content').offset().top - 70);
      var to = 0;
      if (($(document).scrollTop() + 100) < shop_position) {
        to = 400;
        $('html, body').animate({'scrollTop': shop_position}, to);
      }
      return to;
    } 
    
    var setPushState = function(_url){
       if (hasPushState) {
        window.history.pushState({dhShop: true}, '', _url);
       }
    }
    var show_hide_filter_ajax_loading = function(){
      if($('.filter-ajax-loading').hasClass('show')){
        $('.filter-ajax-loading').removeClass('show');
      }else{
        $('.filter-ajax-loading').addClass('show');
      }
    }
    
    
    var check_current_filter = function(){
//    	$('.sidebar-shop-filter .widget_layered_nav').each(function(){
//	       	 if($(this).find('.chosen').length){
//	       		 $(this).addClass('current-filter');
//	       		 $(this).find('.widget-title').append('<span class="clear-filter"></span>');
//	       	 } 
//         });
    }
    
    var get_shop_ajax = function(_url ,pushstate , _shop_filter_wrap){
      _shop_filter_wrap =  _shop_filter_wrap || $('[data-toggle="shop-filter-ajax"]');
      if( _shop_filter_wrap.data('loading'))
        return;
      
      _url = _url.replace(/\/?(\?|#|$)/, '/$1');
      
      if(!pushstate)
        setPushState(_url);
      //Add Flag loading
      _shop_filter_wrap.data('loading',true);
      
      $.ajax({
        url:_url,
        data: {
          dh_shop_ajax_filter: '1'
        },
        dataType: 'html',
        cache: false,
        headers: {
          'cache-control': 'no-cache'
        },
        method: 'POST',
        beforeSend: function(){
          show_hide_filter_ajax_loading();
            },
        error: function(XMLHttpRequest, status, error) {
          show_hide_filter_ajax_loading();
          _shop_filter_wrap.data('loading',false);
        },
        success: function(response) {
          //Fix ERROR: $(html) HTML strings must start with '<' character
          response = $('<div>' + response + '</div>');
          if($('.sidebar-shop-filter').length){
            $('.sidebar-shop-filter .sidebar-shop-filter-wrap').replaceWith(response.find('.sidebar-shop-filter-wrap'));
          }else{
            $('[data-toggle="shop-filter-ajax"]').find('.widget_layered_nav').each(function(){
              var _id = $(this).attr('id');
              if(response.find('#' + _id).length){
                $(this).replaceWith(response.find('#' + _id));
              }else{
                $(this).remove();
              }
            });
          }
          check_current_filter();
          
          $('.woo-content').find('.shop-loop').replaceWith(response.find('.shop-loop'));
          var scroll_speed = filter_ajax_scroll();
          setTimeout(function() {
            show_hide_filter_ajax_loading();
          }, scroll_speed);
          _shop_filter_wrap.data('loading',false);
          DH.woocommerceLazyLoading();
          if($('.woo-content').data('paginate') == 'infinite_scroll'){
            $('.woo-content').find('.infinite-scroll-wrap').infinitescroll('update',{maxPage: $('.woo-content').find('ul.products').data('maxpage') ,path : DH.determinepath($('.woo-content').find('div.paginate a.next').attr('href')),state:{
                    isDuringAjax: false,
                    isInvalidPage: false,
                    isDestroyed: false,
                    isDone: false, // For when it goes all the way through the archive.
                    isPaused: false,
                    isBeyondMaxPage: false,
                    currPage: 1
                }}).infinitescroll('bind');
          }else if($('.woo-content').data('paginate') == 'loadmore'){
            $('.woo-content').dhLoadmore('update',{navSelector  : $('.woo-content').find('div.paginate'),nextSelector  : $('.woo-content').find('div.paginate a.next'),state:{
                    currPage: 1,
                    maxPage:undefined,
                    isBeyondMaxPage:false,
                    isDestroyed: false
                }});
          }
        }
      })
    }
     
     
     if($('[data-toggle="shop-filter-ajax"]').length){
       var _shop_filter_wrap = $('[data-toggle="shop-filter-ajax"]');
       _shop_filter_wrap.data('loading',false);
       $('[data-toggle="shop-filter-ajax"]').on('click', '.widget_layered_nav a', function(e) {
        e.preventDefault();
        var _this = $(this),
          _url = _this.attr('href');
        get_shop_ajax(_url,false,_shop_filter_wrap);
      });
     }
     
    if($('.sidebar-shop-filter').length){
    	check_current_filter();
    	$(document).on('click','.sidebar-shop-filter .widget-title',function(e){
        var _this = $(this);
        e.preventDefault();
        e.stopPropagation();
        $('.sidebar-shop-filter').find('.widget.open').removeClass('open');
        $(this).closest('.widget').toggleClass('open');
      });
    }
    
    $('.product-container .add_to_wishlist,.product-container .yith-wcwl-wishlistexistsbrowse a,.product-container .yith-wcwl-wishlistaddedbrowse a').each(function(){
      var $this = $(this);
      if($this.hasClass('add_to_wishlist'))
        $this.tooltip({title:dhL10n.add_to_wishlist_text,html: true,container:$('body'),placement:'top'});
      else
        $this.tooltip({title:$this.text(),html: true,container:$('body'),placement:'top'});
    });
    $('.shop-toolbar .view-mode a').on('click',function(e){
      e.preventDefault();
      e.stopPropagation();
      $(this).parent().find('.active').removeClass('active');
      $(this).addClass('active');
      if($(this).hasClass('list-mode')){
        $('.shop-loop').addClass('list');
      }else{
        $('.shop-loop').removeClass('list');
      }
    });
    $( '.woocommerce-ordering' ).on( 'change', 'select.per_page', function() {
      $( this ).closest( 'form' ).submit();
    });
    
    $('.shop-loop-quickview a').tooltip({html: true,container:$('body'),placement:'top'});
    $('body').on('added_to_cart',function(){
      //$('.minicart').fadeIn(500);
      if($('.navbar-default').hasClass('navbar-fixed-top')){
        $('.navbar-minicart-nav .minicart').fadeIn(500);
      }else{
        $('.navbar-minicart-topbar .minicart').fadeIn(500);
      }
      window.clearTimeout(DH.added_to_cart_timeout);
      DH.added_to_cart_timeout = window.setTimeout(function(){
        if($('.navbar-default').hasClass('navbar-fixed-top')){
          $('.minicart').stop(true,true).fadeOut(500);
        }else{
          $('.minicart').stop(true,true).fadeOut(500);
        }
      },5000);
    });
    
    //Shop QuickView
    $(document).on('click','.shop-loop-quickview a',function(e){
      e.preventDefault();
      e.stopPropagation();
      var $this = $(this);
      if($this.hasClass('loading'))
        return;
      $('body').addClass('shop-quick-view-loading');
      $this.addClass('loading');
      $.post(dhL10n.ajax_url,{
        action: 'wc_loop_product_quickview',
        product_id: $(this).data('product_id')
      },function(respon){
        $this.removeClass('loading');
        $('body').removeClass('shop-quick-view-loading');
        var $modal = $(respon);
        $('body').append($modal);
        $modal.modal('show');
        if ( typeof wc_add_to_cart_variation_params !== 'undefined' ) {
          $modal.find('.variations_form').each( function() {
            $( this ).wc_variation_form().find('.variations select:eq(0)').change();
          });
        }
        DH.woocommerce_variations_form_init($modal);
        setTimeout(function() {
          DH.carouselInit();
        },500);
        $modal.on('hidden.bs.modal',function(){
          $modal.remove();
        });
      });
    });
    //Shop remove item in mini cart
    $(document).on('click','.minicart .remove',function(e){
        e.stopPropagation();
        e.preventDefault();
        var $this = $(this),
          data = {action: 'wc_minicart_remove_item'},
          params = DH.getURLParameters($this.attr('href'));
        
        $.extend( data, params );
        var remove_item = { item : data.remove_item };
        delete data.remove_item;
        $.extend( data, remove_item );
        $.ajax({
          url: dhL10n.ajax_url,
          type: "GET",
          dataType: "json",
          data: data,
          beforeSend: function(){
            $this.parent().addClass('minicart-product-remove');
          },
          success: function(response){
            $(".minicart").html(response.minicart);
            $(".minicart-icon span").html(response.minicart_text);
            $(".cart-icon-mobile span").html(response.minicart_text);
          },
          complete: function(){
            $this.parent().removeClass('minicart-product-remove');
          }
      });
    });
    //search in nav
//      $('.navbar-fixed-search-button').on('click',function(e){
//        e.stopPropagation();
//        e.preventDefault();
//        $("html, body").animate({
//          scrollTop: 0
//        }, 800,'swing',function(){
//          $('.navbar-search-button').trigger('click');
//        });
//      });
    //Shop mini cart
    $(document).on("mouseenter", ".navbar-minicart-nav", function() {
      window.clearTimeout($(this).data('timeout'));
      $(this).parent().find('.navbar-minicart .minicart').fadeIn(50);
    });
    $(document).on("mouseleave", ".navbar-minicart-nav", function() {
        var _this = $(this);
        var t = setTimeout(function() {
          _this.parent().find('.navbar-minicart .minicart').fadeOut(50);
        }, 400);
        $(this).data('timeout', t);
    });
    $(document).on("mouseenter", ".navbar-minicart-topbar", function() {
      window.clearTimeout($(this).data('timeout'));
      $(this).parent().find('.navbar-minicart .minicart').fadeIn(50);
    });
    $(document).on("mouseleave", ".navbar-minicart-topbar", function() {
        var _this = $(this);
        var t = setTimeout(function() {
          _this.parent().find('.navbar-minicart .minicart').fadeOut(50);
        }, 400);
        $(this).data('timeout', t);
    });
  };
  DH.magnificpopupInit = function(){
    if($().magnificPopup){
      $("a[data-rel='magnific-popup-video']").each(function(){
        $(this).magnificPopup({
          type: 'inline',
          mainClass: 'dh-mfp-popup',
          fixedContentPos: true,
          callbacks : {
              open : function(){
                $(this.content).find(".video-embed.video-embed-popup,.audio-embed.audio-embed-popup").dh_mediaelementplayer();
                $(this.content).find('iframe:visible').each(function(){
                if(typeof $(this).attr('src') != 'undefined'){
                  if( $(this).attr('src').toLowerCase().indexOf("youtube") >= 0 || $(this).attr('src').toLowerCase().indexOf("vimeo") >= 0  || $(this).attr('src').toLowerCase().indexOf("twitch.tv") >= 0 || $(this).attr('src').toLowerCase().indexOf("kickstarter") >= 0 || $(this).attr('src').toLowerCase().indexOf("dailymotion") >= 0) {
                    $(this).attr('data-aspectRatio', this.height / this.width).removeAttr('height').removeAttr('width');
                    if($(this).attr('src').indexOf('wmode=transparent') == -1) {
                      if($(this).attr('src').indexOf('?') == -1){
                        $(this).attr('src',$(this).attr('src') + '?wmode=transparent');
                      } else {
                        $(this).attr('src',$(this).attr('src') + '&wmode=transparent');
                      }
                    }
                  }
                } 
              });
                $(this.content).find('iframe[data-aspectRatio]').each(function() {
                 var newWidth = $(this).parent().width();
                var $this = $(this);
                $this.width(newWidth).height(newWidth * $this.attr('data-aspectRatio'));
                
               });
              },
              close: function() {
                $(this.st.el).closest('.video-embed-shortcode').find('.video-embed-shortcode').html($(this.st.el).data('video-inline'));
              }
          }
        });
      });
      $("a[data-rel='magnific-popup']").magnificPopup({
        type: 'image',
        mainClass: 'dh-mfp-popup',
        gallery:{
          enabled: true
        }
      });
      $("a[data-rel='magnific-popup-verticalfit']").magnificPopup({
        type: 'image',
        mainClass: 'dh-mfp-popup',
        overflowY: 'scroll',
        fixedContentPos: true,
        image: {
          verticalFit: false
        },
        gallery:{
          enabled: true
        }
      });
      $("a[data-rel='magnific-single-popup']").magnificPopup({
        type: 'image',
        mainClass: 'dh-mfp-popup',
        gallery:{
          enabled: false
        }
      });
    }
  };
  DH.navDropdown = function(){
    var superfishInit = function(){
      if(DH.getViewport().width > dhL10n.nav_breakpoint){
        $('.topbar-nav').superfish({
            anchorClass: '.dropdown',      // selector within menu context to define the submenu element to be revealed
            hoverClass:    'open',          // the class applied to hovered list items
            pathClass:     'overideThisToUse', // the class you have applied to list items that lead to the current page
            pathLevels:    1,                  // the number of levels of submenus that remain open or are restored using pathClass
            delay:         650,                // the delay in milliseconds that the mouse can remain outside a submenu without it closing
            animation:     {opacity:'show'},   // an object equivalent to first parameter of jQueryâ€™s .animate() method. Used to animate the submenu open
            animationOut:  {opacity:'hide'},   // an object equivalent to first parameter of jQueryâ€™s .animate() method Used to animate the submenu closed
            speed:         'fast',           // speed of the opening animation. Equivalent to second parameter of jQueryâ€™s .animate() method
            speedOut:      'fast',             // speed of the closing animation. Equivalent to second parameter of jQueryâ€™s .animate() method
            cssArrows:     true,               // set to false if you want to remove the CSS-based arrow triangles
            disableHI:     false,              // set to true to disable hoverIntent detection
            
        });
        $('.primary-nav').superfish({
          anchorClass: '.dropdown',      // selector within menu context to define the submenu element to be revealed
            hoverClass:    'open',          // the class applied to hovered list items
            pathClass:     'overideThisToUse', // the class you have applied to list items that lead to the current page
            pathLevels:    1,                  // the number of levels of submenus that remain open or are restored using pathClass
            delay:         650,                // the delay in milliseconds that the mouse can remain outside a submenu without it closing
            animation:     {opacity:'show'},   // an object equivalent to first parameter of jQueryâ€™s .animate() method. Used to animate the submenu open
            animationOut:  {opacity:'hide'},   // an object equivalent to first parameter of jQueryâ€™s .animate() method Used to animate the submenu closed
            speed:         'fast',           // speed of the opening animation. Equivalent to second parameter of jQueryâ€™s .animate() method
            speedOut:      'fast',             // speed of the closing animation. Equivalent to second parameter of jQueryâ€™s .animate() method
            cssArrows:     true,               // set to false if you want to remove the CSS-based arrow triangles
            disableHI:     false,              // set to true to disable hoverIntent detection
         });
      }else{
        $('.primary-nav').superfish('destroy');  // yup
      }
    }
    superfishInit();
    $(window).on('resize',function(){
      superfishInit();
    });
    
    $('.primary-nav .dropdown-hover .caret,.primary-nav .dropdown-submenu > a > .caret,.primary-nav .megamenu-title .caret').off('click').on('click',function(e){
      e.stopPropagation();
      e.preventDefault();
      var dropdown = $(this).closest(".dropdown, .dropdown-submenu");
      if (dropdown.hasClass("open")) {
        dropdown.removeClass("open");
      } else {
        dropdown.addClass("open");
      }
    });
  };
  DH.headingInit = function(){
    if(DH.enableAnimation()){
      if($('.heading-parallax').length){
        $('.heading-parallax').parallax('50%', .5, true,'translate');
      }
    }
  };
  DH.dhSliderInit = function(){
    var old = $.fn.carousel;
    $.fn.carousel.noConflict();
    $.fn.dhCarousel = $.fn.carousel;
    if("undefined" === typeof $.fn.dhCarousel){
      $.fn.dhCarousel = old;
    }
    $('.dhslider').each(function(){
      var $this = $(this),
        isIOS = /iPhone|iPad|iPod/.test( navigator.userAgent ),
        or_height = $this.height(),
        min_height = 250,
        startwidth = $this.width(),
        startheight = $this.data('height');
      
      
      var dynamicHeight = function(){
        var slider_height = startheight,
          slider_width = startwidth;
        
        if(!$this.hasClass('dhslider-fullscreen')){
          if($this.width() > DH.getViewport().width){
            $this.css('width','100%');
          }
        }
        
        if($this.hasClass('dhslider-fullscreen') && DH.getViewport().width > dhL10n.breakpoint){
          slider_width = DH.getViewport().width;
          slider_height = DH.getViewport().height;
        }else{
          var scale_slider = $(window).width() / 1600;
          //min height
          if( DH.getViewport().width <= dhL10n.breakpoint ){
            if( startheight*scale_slider <= min_height ){
              slider_height = min_height;
            } else {
              slider_height = Math.round(startheight*scale_slider);
            }
          }
        }
        
        var heading_height = 0;
        
        if($('body').find('.header-container').hasClass('header-transparent') && DH.getViewport().width > dhL10n.breakpoint){
          heading_height = $('body').find('.header-container').height();
        }
        $this.css({'height': slider_height + 'px'});
        //$this.find('.dhslider-wrap').css({'height': slider_height + 'px'});
        $this.find('.item').css({'height': slider_height + 'px'});
        
        var slider_width = $this.width(),
          slider_height = $this.height(),
          scale_h = slider_width / 1280,
          scale_v = (slider_height - $('.header-container').height()) / 720,
          scale = scale_h > scale_v ? scale_h : scale_v,
          min_w = 1280/720 * (slider_height+20);
      
        if (scale * 1280 < min_w) {
          scale = min_w / 1280;
        }
        $this.find('.video-embed-wrap').css('width',($this.width()+2)).css('height',($this.height()+2));
        $this.find('.slider-video').width(Math.ceil(scale * 1280 +2));
        $this.find('.slider-video').height(Math.ceil(scale * 720 +2));
        
        var active_cation = $this.find('.active .slider-caption');
        
        $this.find('.slider-caption').each(function(){
          $(this).css('top', (((slider_height + heading_height)/2) - ($(this).height()/2)) + 'px');
        });
      }
      
      dynamicHeight();
      $(window).resize(function(){
        dynamicHeight();
      });
      if($this.data('autorun') == 'yes'){
        $this.dhCarousel({
          interval: parseInt($this.data('duration')),
          pause: false
        });
      }else{
        $this.dhCarousel({
          interval: 0,
          pause: false
        });
      }
      
      $this.on('slide.bs.carousel', function () {
        $this.find('.active .slider-caption').fadeTo(800,0);
      });
      $this.on('slid.bs.carousel', function () {
        $this.find('.active .slider-caption').fadeTo(0,1);
      });
      
      imagesLoaded($this,function(){
        $this.find('.dhslider-loader').fadeOut(500);
      });
      if(DH.enableAnimation()){
        $this.find('.slider-caption').parallax('50%', .3, true,'translate',$this);
      }
      
    });
    $.fn.carousel = old;
  };
  DH.getURLParameters = function(url) {
      var result = {};
      var searchIndex = url.indexOf("?");
      if (searchIndex == -1 ) return result;
      var sPageURL = url.substring(searchIndex +1);
      var sURLVariables = sPageURL.split('&');
      for (var i = 0; i < sURLVariables.length; i++)
      {       
          var sParameterName = sURLVariables[i].split('=');      
          result[sParameterName[0]] = sParameterName[1];
      }
      return result;
  };
  DH.getViewport = function() {
      var e = window, a = 'inner';
      if (!('innerWidth' in window )) {
          a = 'client';
          e = document.documentElement || document.body;
      }
      return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
  };
  DH.hex2rgba = function(hex,opacity){
    hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
    var rgb = {
      r: hex >> 16,
      g: (hex & 0x00FF00) >> 8,
      b: (hex & 0x0000FF)
    };
    if( !rgb ) return null;
    if( opacity === undefined ) opacity = 1;
    return 'rgba(' + rgb.r + ', ' + rgb.g + ', ' + rgb.b + ', ' + parseFloat(opacity) + ')';
  };
  DH.enableAnimation = function(){
    return DH.getViewport().width > 992 && !DH.isTouch();
  };
  DH.isTouch = function(){
    return !!('ontouchstart' in window) || ( !! ('onmsgesturechange' in window) && !! window.navigator.maxTouchPoints);
  };
  DH.history = function() {
      return !!window.history && !!history.pushState;
  };
  $(document).ready(function(){
    // Resize event
    //$( window ).resize();
    if($('.header-transparent').length){
      $('.heading-background').css('padding-top',$('.header-transparent').height());
    }
  });
  
  $(document).ready(function() { // start document_ready_1
    DH.initScrollspy();
    $( '.shipping-calculator-form' ).show();
  });
  $(window).load(function(){
    DH.init();
  });
  DH.woocommerce_variations_form_init();
  
  $(document).bind('dh-change-layout',function(){
    $('#newsletterModal').remove();
    setTimeout(function(){
      DH.init();
    },500);
  });
  
}(jQuery);
