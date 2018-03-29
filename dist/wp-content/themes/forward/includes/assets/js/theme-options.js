;(function($){
	'use strict';
	var DHOptions = {
		init: function(){
			var self = this;
			$('.dh-image-select img').tooltip({
				position: {
					my: "center bottom-5",
					at: "center top"
				}
			});
			$(document).on('click','#dh-opt-submit2, #dh-opt-submit',function(e){
				$('#custom-css').val(self.css_editor.getValue());
				//$('#custom-js').val(self.js_editor.getValue());
				return true;
			});
			
			$(document).on('click','#dh-opt-reset',function(e){
				if(window.confirm(dhthemeoptionsL10n.reset_msg)){
					return true;
				}
				return false;
			});
			
			if(window.ace && window.ace.edit){
				this.css_editor = ace.edit('custom-css-editor');
				this.css_editor.getSession().setMode("ace/mode/css");
                this.css_editor.setTheme("ace/theme/chrome");
                this.css_editor.clearSelection();

//				this.js_editor = ace.edit('custom-js-editor');
//				this.js_editor.getSession().setMode("ace/mode/javascript");
//                this.js_editor.setTheme("ace/theme/chrome");
//                this.js_editor.clearSelection();
                
			}
			
			this.navTab();
			this.fieldInit();
			this.dependencyInit();
		},
		navTab: function(){
			var tab = $('#dh-opt-tab'),
				tabControl = tab.find('#dh-opt-menu a'),
				tabContent = tab.find('#dh-opt-content'),
				$supports_html5_storage;
			try {
				$supports_html5_storage = ( 'sessionStorage' in window && window.sessionStorage !== null );
			} catch( err ) {
				$supports_html5_storage = false;
			}
			
			if($supports_html5_storage){
				if (localStorage.getItem('dh-opt-tab')) {
					var hasTab = function(href){
			            return $('#dh-opt-menu a[href*="' + href + '"]').length;
			        };
			        if(!hasTab(localStorage.getItem('dh-opt-tab'))){
			        	localStorage.removeItem('dh-opt-tab');
		                return true;
			        }
			        $('#dh-opt-menu').find('li.current').removeClass('current');
			        var tabhref = localStorage.getItem('dh-opt-tab');
			        var $el = $('#dh-opt-menu a[href*="' + tabhref + '"]');
			        $el.closest('li').addClass('current');
			        tabContent.find('.dh-opt-section').hide();
			        tabContent.find(tabhref).show();
				}
			}
			
			
			tabControl.on('click',function(e){
				e.stopPropagation();
				e.preventDefault();
				
				var $this = $(this),
					target = $this.attr('href');
				
				if($this.closest('li').hasClass('current')){
					return;
				}
				
				target = target && target.replace(/.*(?=#[^\s]*$)/, '');
				
				if (!target) {
					return;
				}
				$this.closest('#dh-opt-menu').find('li.current').removeClass('current');
				$this.closest('li').addClass('current')
				tabContent.find('.dh-opt-section').hide();
				tabContent.find(target).show();
				if($supports_html5_storage){
					window.localStorage.setItem('dh-opt-tab', target);
				}
			});
		},
		dependencyHook:function(e){
			var $this = $(e.currentTarget),
				content = $this.closest('.dh-opt-content'),
				master_container = $this.closest('tr'),
				master_value,
				is_empty;
			
			master_value = $this.is(':checkbox') ? $.map($this.closest('tr').find('dh-opt-value:checked'),
	                function (element) {
						return $(element).val();
	            	})
	            : ($this.is(':radio') ? $this.closest('tr').find('.dh-opt-value:checked').val() : $this.val() );
    	  
	        is_empty = $this.is(':checkbox') ? !$this.closest('tr').find('dh-opt-value:checked').length
                 : ( $this.is(':radio') ? !$this.closest('tr').find('.dh-opt-value:checked').val() : !master_value.length )  ;
    	  
	        if(master_container.hasClass('dh-opt-hidden')){
	        	$.each( $('[data-master=' + $this.data('name') + ']'),function(){
	        		$(this).closest('tr').addClass('dh-opt-hidden');
	        	});   
		    }else{
		    	$.each( $('[data-master=' + $this.data('name') + ']'),function(){
		    	  var dependency_value = $(this).data('master-value').toString();
		    	  dependency_value = dependency_value.split(','); 
		    	  if (_.intersection((_.isArray(dependency_value) ? dependency_value : [dependency_value]), (_.isArray(master_value) ? master_value : [master_value.toString()])).length) {
		    		  $(this).closest('tr').removeClass('dh-opt-hidden');
		           } else {
		             $(this).closest('tr').addClass('dh-opt-hidden');
		           }	
		    	   $(this).find('.dh-opt-value[data-name]').trigger('change');
		    	});
		    }
	           	
		},
		dependencyInit: function(){
			var self = this;
			$.each($('.dh-dependency-field'),function(){
				var masters = $('[data-name=' + $(this).data('master') + ']');
				$(masters).bind('keyup change',self.dependencyHook);
				$.each($(masters),function(){
					self.dependencyHook({currentTarget: $(this) });
				});
			});
		},
		fieldInit: function(){
			
			$("select.dh-chosen-select").chosen();
			
			jQuery("select.dh-chosen-select-nostd").chosen({
				allow_single_deselect: 'true'
			});
			
			$('.dh-image-select li img').click(function(e){
				e.stopPropagation();
				e.preventDefault();
				$(this).closest('.dh-image-select').find('li.selected').removeClass("selected");
				$(this).closest('li').addClass('selected');
				$(this).closest('label').find('input[type="radio"]').prop('checked',false);
				$(this).closest('label').find("input[type='radio']").prop("checked", true);
			});
			$('.dh-field-buttonset').each(function() {
		        $(this).find('.dh-buttonset').buttonset();
		    }); 
			
			$('.dh-field-switch').each(function(){
				var $this = $(this);
				$this.find(".cb-enable").click(function() {
					if ($(this).hasClass('selected')) {
						return;
					}
					var parent = $(this).parents('.dh-field-switch');
					$('.cb-disable', parent).removeClass('selected');
					$(this).addClass('selected');
					$('.switch-input', parent).val('1').trigger('change');
				});
				$this.find(".cb-disable").click(function() {
					if ($(this).hasClass('selected')) {
						return;
					}
					var parent = $(this).parents('.dh-field-switch');
					$('.cb-enable', parent).removeClass('selected');
					$(this).addClass('selected');
					$('.switch-input', parent).val('0').trigger('change');
				});
				$this.find('.cb-enable span, .cb-disable span').find().attr('unselectable', 'on');
			});
		}
	}
	$(window).load(function(){
		DHOptions.init();
	});
})(jQuery);