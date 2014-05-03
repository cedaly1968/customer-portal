(function() {
    tinymce.create('tinymce.plugins.swpTesti', {
        init : function(ed, url) {
             ed.addButton('testimonial', {
                title : 'Testmonial',
                cmd : 'testimonial',
                image : url + '/../images/icon.png'
            });

            ed.addCommand('testimonial', function() {
                ed.windowManager.open(
                    {
                        file : ajaxurl+'?action=show_testimonial_diaglogbox',
                        width : 400,
                        height : 225,
                        inline : 1
                    },
                    {
                        plugin_url : url,                        
                    }
                );                  
            });
        },
        
    });

    tinymce.PluginManager.add('swptesti', tinymce.plugins.swpTesti);
})();