function dh_trim(str, charlist) {
  //  discuss at: http://phpjs.org/functions/trim/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: mdsjack (http://www.mdsjack.bo.it)
  // improved by: Alexander Ermolaev (http://snippets.dzone.com/user/AlexanderErmolaev)
  // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: Steven Levithan (http://blog.stevenlevithan.com)
  // improved by: Jack
  //    input by: Erkekjetter
  //    input by: DxGx
  // bugfixed by: Onno Marsman
  //   example 1: trim('    Kevin van Zonneveld    ');
  //   returns 1: 'Kevin van Zonneveld'
  //   example 2: trim('Hello World', 'Hdle');
  //   returns 2: 'o Wor'
  //   example 3: trim(16, 1);
  //   returns 3: 6

  var whitespace, l = 0,
    i = 0;
  str += '';

  if (!charlist) {
    // default list
    whitespace =
      ' \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000';
  } else {
    // preg_quote custom list
    charlist += '';
    whitespace = charlist.replace(/([\[\]\(\)\.\?\/\*\{\}\+\$\^\:])/g, '$1');
  }

  l = str.length;
  for (i = 0; i < l; i++) {
    if (whitespace.indexOf(str.charAt(i)) === -1) {
      str = str.substring(i);
      break;
    }
  }

  l = str.length;
  for (i = l - 1; i >= 0; i--) {
    if (whitespace.indexOf(str.charAt(i)) === -1) {
      str = str.substring(0, i + 1);
      break;
    }
  }

  return whitespace.indexOf(str.charAt(0)) === -1 ? str : '';
}

;(function($){
	$(document).ready(function(){
		if ($('#post-formats-select').length > 0) {
			var format = $('#post-formats-select input:checked').attr('value');
			$('#post-body div[id^=dh-metabox-post-]').hide();
			$('#post-body #dh-metabox-post-'+format+'').show();
			$('#post-formats-select').find('input').on('click',function(){
				var format = $(this).attr('value');
				$('#post-body div[id^=dh-metabox-post-]').hide();
				$('#post-body #dh-metabox-post-'+format+'').stop(true,true).fadeIn(500);
			});
		}
		
		
		//page heading
		var dh_page_heading_callback = function(el){
			var $this = $(el);
			var arr = ['_dh_heading_menu_anchor_field','_dh_page_heading_background_image_field','_dh_page_heading_sub_title_field','_dh_page_heading_title_field','_dh_page_heading_button_text','_dh_page_heading_button_url'];
			var harr = ['_dh_heading_menu_anchor_field','_dh_highligh_cat_field','_dh_highligh_intro_cat_field'];
			var defaultarr = ['_dh_heading_menu_anchor_field','_dh_default_sub_heading_title_field'];
			var revarr = ['_dh_heading_menu_anchor_field','_dh_rev_alias_field'];
			var hero = ['_dh_heading_menu_anchor_field'];
			
			$.each(defaultarr,function(i,de){
				$('.'+de).hide();
			});
			$.each(arr,function(i,ar){
				$('.'+ar).hide();
			});
			$.each(harr,function(i,har){
				$('.'+har).hide();
			});
			$.each(revarr,function(i,revar){
				$('.'+revar).hide();
			});
			
			if($this.val() == 'heading'){
				$.each(arr,function(i,ar){
					$('.'+ar).show();
				});
			}else if($this.val() == 'highlighted_post'){
				$.each(harr,function(i,har){
					$('.'+har).show();
				});
			}else if($this.val() == 'rev'){
				$.each(revarr,function(i,revar){
					$('.'+revar).show();
				});
			}else if($this.val() == 'landingHero'){
				$.each(hero,function(i,her){
					$('.'+her).show();
				});
			}else if($this.val() == 'default'){
				$.each(defaultarr,function(i,de){
					$('.'+de).show();
				});
			}
		}
		if($('#_dh_page_heading').length){
			dh_page_heading_callback($('#_dh_page_heading'));
			$('#_dh_page_heading').on('change',function(){
				var $this = $(this);
				dh_page_heading_callback($this);
			});
		}
	});
})(jQuery);