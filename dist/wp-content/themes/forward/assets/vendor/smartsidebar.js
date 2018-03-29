;(function($){
	$.fn.dhSmartSidebar = function(options){
			var defaults = {
					_main_content: $('.main-wrap')
				};
			var options = $.extend(defaults, options);
			options._main_content = $(options._main_content);
			if(!options._main_content.length)
				return false;
			
			var isTouch = function(){
				return !!('ontouchstart' in window) || ( !! ('onmsgesturechange' in window) && !! window.navigator.maxTouchPoints);
			}
			
			if(isTouch())
				return;
			
			return this.each(function(){
				var _this = $(this),
					_scroll_top_last,
					_case = '',
					_this_sidebar_with = _this.width(),
					isWebkit = (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1);
				var _get_view_port = function() {
				    var e = window, a = 'inner';
				    if (!('innerWidth' in window )) {
				        a = 'client';
				        e = document.documentElement || document.body;
				    }
				    return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
				};
				var _is_smaller_or_equal = function(b, c) {
			       return 1 <= Math.abs(b - c) ? b < c ? true : false : true
			    };
			    var _is_smaller = function(b, c) {
			    	return 1 <= Math.abs(b - c) ? b < c ? true : false : false
			    };
				var _run = function(){
					if(!_this.data('sidebar_is_enabled'))
						return;
					
					var _w_top = $(window).scrollTop(),
						_w_height = _get_view_port().height,
						_navbar_height = 0,
						_dir = '';
					var $navbar = $( '.header-container' );
					if ( $navbar.hasClass( 'header-navbar-fixed' ) ) {
						_navbar_height = 60;
					}
					var adminbarHeight = 0;
					if ( $('body').hasClass( 'admin-bar' ) ) {
						adminbarHeight = $( '#wpadminbar' ).outerHeight();
					}
					_navbar_height += adminbarHeight;
					
					_w_top != _scroll_top_last && (_dir = _w_top > _scroll_top_last ? "down" : "up"); 
					_scroll_top_last = _w_top;
					
					_w_top += _navbar_height;
					var	_this_content_top = options._main_content.offset().top,
						_this_sidebar_height2 = options._main_content.outerHeight(),
						_this_content_height = _this_sidebar_height2,
						_this_content_bottom = _this_content_top + _this_sidebar_height2,
						_this_sidebar_top = _this.offset().top,
						_this_sidebar_height = _this.outerHeight(),
						_this_sidebar_bottom = _this_sidebar_top + _this_sidebar_height;
					if(options._main_content.css('margin-top') == '-175px'){
						_this_content_top += 175;
					}
					if(_this_content_height <= _this_sidebar_height)
						_case = '6';
					else if (_this_sidebar_height < _w_height) _is_smaller_or_equal(_w_top, _this_content_top) ? _case = "2" : 
							true === _is_smaller(_this_sidebar_bottom, _w_top) ? _is_smaller(_w_top, (_this_content_bottom - _this_sidebar_height)) ? _case = "4" : _case = "3" :
								_is_smaller_or_equal(_this_content_bottom, _this_sidebar_bottom) ? "up" == _dir && _is_smaller_or_equal(_w_top,_this_sidebar_top) ? _case = "4" : _case = "3" : 
									_case = _this_content_bottom - _w_top >= _this_sidebar_height ? "4" : "3";
					else if (true === _is_smaller(_this_sidebar_bottom, _w_top) ? _case = "3" : 
						true === _is_smaller(_this_sidebar_bottom, (_w_top + _w_height)) && true === _is_smaller(_this_sidebar_bottom, _this_content_bottom) && "down" == _dir && _this_content_bottom >= (_w_top + _w_height) ? _case = "1" : 
							true === _is_smaller_or_equal(_this_sidebar_top, _this_content_top) && "up" == _dir && _this_content_bottom >= (_w_top + _w_height) ? _case = "2" : 
								true === _is_smaller_or_equal(_this_content_bottom, _this_sidebar_bottom) && "down" == _dir || _this_content_bottom < (_w_top + _w_height) ? _case = "3" : 
									true === _is_smaller_or_equal(_w_top, _this_sidebar_top) && "up" == _dir && true === _is_smaller_or_equal(_this_content_top, _w_top) && (_case = "4"), "1" == _case  && "up" == _dir || "4" == _case && "down" == _dir) _case = "5";
					var _fix_width = Math.max(_this.data('fix-width'),200);
	
					switch(_case){
						case '1':
							 if (1 === _this.data('s-case-1')) break;
							 _this.data('s-case-1',1);
							 _this.data('s-case-2',0);
							 _this.data('s-case-3',0);
							 _this.data('s-case-4',0);
							 _this.data('s-case-5',0);
							 _this.data('s-case-6',0);
	                         _this.css({
	                             width: _fix_width,
	                             position: "fixed",
	                             top: "auto",
	                             bottom: "0",
	                             "z-index": "1"
	                         });
	                         break;
						case '2':
							 if (1 === _this.data('s-case-2')) break;
							 _this.data('s-case-1',0);
							 _this.data('s-case-2',1);
							 _this.data('s-case-3',0);
							 _this.data('s-case-4',0);
							 _this.data('s-case-5',0);
							 _this.data('s-case-6',0);
	                         _this.css({
	                             width: "auto",
	                             position: "static",
	                             top: "auto",
	                             bottom: "auto",
	                         });
							break;
						case '3':
							if (1 === _this.data('s-case-3') && _this.data('last-sidebar-height') == _this_sidebar_height && _this.data('last-content-height') == _this_sidebar_height2) break;
							 _this.data('s-case-1',0);
							 _this.data('s-case-2',0);
							 _this.data('s-case-3',1);
							 _this.data('last-sidebar-height',_this_sidebar_height);
							 _this.data('last-content-height',_this_sidebar_height2)
							 _this.data('s-case-4',0);
							 _this.data('s-case-5',0);
							 _this.data('s-case-6',0);
	                        _this.css({
	                            width: _fix_width,
	                            position: "absolute",
	                            top: _this_content_bottom - _this_sidebar_height - _this_content_top,
	                            bottom: "auto",
	                        });
							break;
						case '4':
							 if (1 === _this.data('s-case-4') && _this.data('last-menu-offset') == _navbar_height) break;
							 _this.data('s-case-1',0);
							 _this.data('s-case-2',0);
							 _this.data('s-case-3',0);
							 _this.data('s-case-4',1);
							 _this.data('last-menu-offset',_navbar_height);
							 _this.data('s-case-5',0);
							 _this.data('s-case-6',0);
	                        _this.css({
	                            width: _fix_width,
	                            position: "fixed",
	                            top: _navbar_height,
	                            bottom: "auto",
	                        });
							break;
						case '5':
							 if (1 === _this.data('s-case-5')) break;
							 _this.data('s-case-1',0);
							 _this.data('s-case-2',0);
							 _this.data('s-case-3',0);
							 _this.data('s-case-4',0);
							 _this.data('s-case-5',1);
							 _this.data('s-case-6',0);
	                         _this.css({
	                             width: _fix_width,
	                             position: "absolute",
	                             top: _this_sidebar_top - _this_content_top,
	                             bottom: "auto",
	                         });
							break;
						case '6':
							 if (1 === _this.data('s-case-6')) break;
							 _this.data('s-case-1',0);
							 _this.data('s-case-2',0);
							 _this.data('s-case-3',0);
							 _this.data('s-case-4',0);
							 _this.data('s-case-5',0);
							 _this.data('s-case-6',1);
	                         _this.css({
	                             width: "auto",
	                             position: "static",
	                             top: "auto",
	                             bottom: "auto",
	                         });
							break;
					}
				};
				var _resize = function(){
					var _w_with = 0;
					_w_with = _get_view_port().width;
					if(_w_with >= 992 ){
						_this.data('fix-width',_this.parent().width());
						_this.data('sidebar_is_enabled',1);
						_run();
					}else{
						 _this.data('fix-width',0);
						 _this.data('sidebar_is_enabled',0);
						 _this.data('s-case-1',0);
						 _this.data('s-case-2',0);
						 _this.data('s-case-3',0);
						 _this.data('s-case-4',0);
						 _this.data('s-case-5',0);
						 _this.data('s-case-6',0);
						 _this.data('last-menu-offset',0);
						 _this.data('last-sidebar-height',0);
						 _this.data('last-content-height',0)
						 _this.css({
	                         width: "auto",
	                         position: "static",
	                         top: "auto",
	                         bottom: "auto",
	                     });
					}
				};
				
				$(window).bind('resize',function(){
					_resize();
				});
				$(window).scroll(function(){
					if (window.requestAnimationFrame) {
						window.requestAnimationFrame(function() {
							_run();
					        }, document);
					}else{
						_run();
					}
				});
				setTimeout(function(){
					_resize();
				},100);
				return true;
			});
		};
})(jQuery);