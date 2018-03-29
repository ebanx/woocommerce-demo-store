;(function($) {
    tinymce.create('tinymce.plugins.dh_tooltip', {
       init : function(el, url) {
    	   el.addButton('dh_tooltip_button', {
                title : dhAdminL10n.i18n_tooltip_mce_button,
                image : dhAdminL10n.framework_assets_url + '/images/tooltip.png',
                onclick: function() {
                    var width = $(window).width(), H = $(window).height(), W = (500 < width) ? 500 : width;
                    W = 500;
                    H = 300;
                    tb_show(dhAdminL10n.i18n_tooltip_mce_button, '#TB_inline?width=' + W + '&height=' + H + '&inlineId=dh_tooltip_form');
                    var TB_overlay = $('#TB_overlay');
                    TB_overlay.css({
                    	'z-index':999999
                    });
                    var TB_window = $('#TB_window');
                    TB_window.css({
                    	'z-index':999999
                    });
                    var TB_ajaxContent = $('#TB_ajaxContent');
                    TB_ajaxContent.css({
                    	'height':'100%',
                    	'width':'100%',
                    	'padding':'0',
                    	'margin':'0 auto'
                    });
                }	
            });
        },
    });
    tinymce.PluginManager.add('dh_tooltip', tinymce.plugins.dh_tooltip);
})(jQuery);