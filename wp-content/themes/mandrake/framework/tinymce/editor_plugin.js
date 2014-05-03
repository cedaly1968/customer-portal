(function() {

var URI;
	
tinymce.create('tinymce.plugins.ShortCode', {
	init : function(ed, url) {
		URI = url;
	},
    createControl: function(n, cm) {
        switch (n) {
            case 'layout':
                var layout_button = cm.createSplitButton('layout', {
                     title : 'Column Layout',
					 image : URI+'/images/layout.png',
                });
                layout_button.onRenderMenu.add(function(c, m) {
                    m.add({title : 'Columns', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
                    m.add({title : 'One Half', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[one_half]' + tinyMCE.activeEditor.selection.getContent() + '[/one_half]');
                    }});
                    m.add({title : 'One Half Last', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[one_half_last]' + tinyMCE.activeEditor.selection.getContent() + '[/one_half_last]');
                    }});
					m.add({title : 'One Third', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[one_third]' + tinyMCE.activeEditor.selection.getContent() + '[/one_third]');
                    }});
                    m.add({title : 'One Third Last', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[one_third_last]' + tinyMCE.activeEditor.selection.getContent() + '[/one_third_last]');
                    }});
					m.add({title : 'One Fourth', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[one_fourth]' + tinyMCE.activeEditor.selection.getContent() + '[/one_fourth]');
                    }});
                    m.add({title : 'One Fourth Last', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[one_fourth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/one_fourth_last]');
                    }});
					m.add({title : 'One Fifth', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[one_fifth]' + tinyMCE.activeEditor.selection.getContent() + '[/one_fifth]');
                    }});
                    m.add({title : 'One Fifth Last', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[one_fifth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/one_fifth_last]');
                    }});
					m.add({title : 'One Sixth', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[one_sixth]' + tinyMCE.activeEditor.selection.getContent() + '[/one_sixth]');
                    }});
                    m.add({title : 'One Sixth Last', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[one_sixth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/one_sixth_last]');
                    }});
					m.add({title : 'Two Third', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[two_third]' + tinyMCE.activeEditor.selection.getContent() + '[/two_third]');
                    }});
                    m.add({title : 'Two Third Last', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[two_third_last]' + tinyMCE.activeEditor.selection.getContent() + '[/two_third_last]');
                    }});
					m.add({title : 'Three Fourth', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[three_fourth]' + tinyMCE.activeEditor.selection.getContent() + '[/three_fourth]');
                    }});
                    m.add({title : 'Three Fourth Last', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[three_fourth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/three_fourth_last]');
                    }});
					m.add({title : 'Two Fifth', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[two_fifth]' + tinyMCE.activeEditor.selection.getContent() + '[/two_fifth]');
                    }});
                    m.add({title : 'Two Fifth Last', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[two_fifth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/two_fifth_last]');
                    }});
					m.add({title : 'Three Fifth', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[three_fifth]' + tinyMCE.activeEditor.selection.getContent() + '[/three_fifth]');
                    }});
                    m.add({title : 'Three Fifth Last', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[three_fifth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/three_fifth_last]');
                    }});
					m.add({title : 'Four Fifth', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[four_fifth]' + tinyMCE.activeEditor.selection.getContent() + '[/four_fifth]');
                    }});
                    m.add({title : 'Four Fifth Last', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[four_fifth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/four_fifth_last]');
                    }});
					m.add({title : 'Five Sixth', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[five_sixth]' + tinyMCE.activeEditor.selection.getContent() + '[/five_sixth]');
                    }});
                    m.add({title : 'Five Sixth Last', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[five_sixth_last]' + tinyMCE.activeEditor.selection.getContent() + '[/five_sixth_last]');
                    }});
                });
			return layout_button;
			
			case 'divider':
                var divider_button = cm.createSplitButton('divider', {
                     title : 'Dividers',
					 image : URI+'/images/divider.png',
                });
                divider_button.onRenderMenu.add(function(c, m) {
                    m.add({title : 'Dividers', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
                    m.add({title : 'Divider', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[divider/]');
                    }});
                    m.add({title : 'Divider Top', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[divider_top/]');
                    }});
					m.add({title : 'Clear', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[clear/]');
                    }});
                });
			return divider_button;
			
			case 'box':
                var box_button = cm.createSplitButton('box', {
                     title : 'Styled Boxes',
					 image : URI+'/images/boxes.png',
                });
                box_button.onRenderMenu.add(function(c, m) {
                    m.add({title : 'Styled Boxes', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
					m.add({title : 'Frame Box', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[frame_box]' + tinyMCE.activeEditor.selection.getContent() + '[/frame_box]');
                    }});
                    m.add({title : 'Tip Box', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[tip_box]' + tinyMCE.activeEditor.selection.getContent() + '[/tip_box]');
                    }});
					m.add({title : 'Tip Box Icon', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[tip_box_icon]' + tinyMCE.activeEditor.selection.getContent() + '[/tip_box_icon]');
                    }});
					m.add({title : 'Error Box', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[error_box]' + tinyMCE.activeEditor.selection.getContent() + '[/error_box]');
                    }});
					m.add({title : 'Error Box Icon', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[error_box_icon]' + tinyMCE.activeEditor.selection.getContent() + '[/error_box_icon]');
                    }});
					m.add({title : 'Note Box', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[note_box]' + tinyMCE.activeEditor.selection.getContent() + '[/note_box]');
                    }});
					m.add({title : 'Note Box Icon', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[note_box_icon]' + tinyMCE.activeEditor.selection.getContent() + '[/note_box_icon]');
                    }});
					m.add({title : 'Info Box', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[info_box]' + tinyMCE.activeEditor.selection.getContent() + '[/info_box]');
                    }});
					m.add({title : 'Info Box Icon', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[info_box_icon]' + tinyMCE.activeEditor.selection.getContent() + '[/info_box_icon]');
                    }});

                });
			return box_button;
			
			case 'typography':
                var typography_button = cm.createSplitButton('typography', {
                     title : 'Typography',
					 image : URI+'/images/typography.png',
                });
                typography_button.onRenderMenu.add(function(c, m) {
					m.add({title : 'Paragraph', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
                    m.add({title : 'Paragraph', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[p]' + tinyMCE.activeEditor.selection.getContent() + '[/p]');
                    }});
                    m.add({title : 'Dropcaps', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
                    m.add({title : 'Dropcap Normal', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[dropcap2]' + tinyMCE.activeEditor.selection.getContent() + '[/dropcap2]');
                    }});
                    m.add({title : 'Dropcap Circle', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[dropcap1]' + tinyMCE.activeEditor.selection.getContent() + '[/dropcap1]');
                    }});
					m.add({title : 'Blockquote', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
					m.add({title : 'Blockquote', onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
							file : URI+'/blockquote_window.php',
							width : 400,
							height : 200,
							inline : 1,
							title : 'Blockquote'
						});
                    }});
					m.add({title : 'Highlights', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
					m.add({title : 'Highlight Yellow', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[highlight color="yellow"]' + tinyMCE.activeEditor.selection.getContent() + '[/highlight]');
                    }});
					m.add({title : 'Highlight Gray', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[highlight color="gray"]' + tinyMCE.activeEditor.selection.getContent() + '[/highlight]');
                    }});

                });
			return typography_button;
			
			case 'list':
                var list_button = cm.createSplitButton('list', {
                     title : 'Styled List',
					 image : URI+'/images/list.png',
                });
                list_button.onRenderMenu.add(function(c, m) {
                    m.add({title : 'Styled List', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
                    m.add({title : 'Check List', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[list style="list1"]' + tinyMCE.activeEditor.selection.getContent() + '[/list]');
                    }});
					m.add({title : 'Arrow List', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[list style="list2"]' + tinyMCE.activeEditor.selection.getContent() + '[/list]');
                    }});
					m.add({title : 'Star List', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[list style="list3"]' + tinyMCE.activeEditor.selection.getContent() + '[/list]');
                    }});
					m.add({title : 'Circle List', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[list style="list4"]' + tinyMCE.activeEditor.selection.getContent() + '[/list]');
                    }});
					m.add({title : 'Plus List', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[list style="list5"]' + tinyMCE.activeEditor.selection.getContent() + '[/list]');
                    }});
					m.add({title : 'Heart List', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[list style="list6"]' + tinyMCE.activeEditor.selection.getContent() + '[/list]');
                    }});
					m.add({title : 'Tag List', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[list style="list7"]' + tinyMCE.activeEditor.selection.getContent() + '[/list]');
                    }});
					m.add({title : 'Pencil List', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[list style="list8"]' + tinyMCE.activeEditor.selection.getContent() + '[/list]');
                    }});
					m.add({title : 'Flag List', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[list style="list9"]' + tinyMCE.activeEditor.selection.getContent() + '[/list]');
                    }});
					m.add({title : 'Chain List', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[list style="list10"]' + tinyMCE.activeEditor.selection.getContent() + '[/list]');
                    }});
					m.add({title : 'Lifebelt List', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[list style="list11"]' + tinyMCE.activeEditor.selection.getContent() + '[/list]');
                    }});
					m.add({title : 'Balloon List', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[list style="list12"]' + tinyMCE.activeEditor.selection.getContent() + '[/list]');
                    }});
                });
			return list_button;
			
			case 'table':
                var table_button = cm.createSplitButton('table', {
                     title : 'Tables',
					 image : URI+'/images/table.png',
                });
                table_button.onRenderMenu.add(function(c, m) {
                    m.add({title : 'Tables', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
                    m.add({title : 'Styled Table', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[styled_table]' + tinyMCE.activeEditor.selection.getContent() + '[/styled_table]');
                    }});
					m.add({title : 'Code', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[code]' + tinyMCE.activeEditor.selection.getContent() + '[/code]');
                    }});
					m.add({title : 'Pre', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[pre]' + tinyMCE.activeEditor.selection.getContent() + '[/pre]');
                    }});
                });
			return table_button;
			
			case 'tab':
                var tab_button = cm.createSplitButton('tab', {
                     title : 'Tabs',
					 image : URI+'/images/tab.png',
                });
                tab_button.onRenderMenu.add(function(c, m) {
                    m.add({title : 'Tabs', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
                    m.add({title : 'Tabs', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[tabs] [tab title="Tab 1"] Insert your text here [/tab] [tab title="Tab 2"] Insert your text here [/tab] [/tabs]');
                    }});
					m.add({title : 'Mini Tabs', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[mini_tabs] [tab title="Tab 1"] Insert your text here [/tab] [tab title="Tab 2"] Insert your text here [/tab] [/mini_tabs]');
                    }});
					m.add({title : 'Accordion', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[accordions] [accordion title="Accordion 1"] Insert your text here [/accordion] [accordion title="Accordion 2"] Insert your text here [/accordion] [/accordions]');
                    }});
					m.add({title : 'Expand', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[expand title="Expand"] Insert your text here [/expand]');
                    }});
					m.add({title : 'Toggle', onclick : function() {
                        tinyMCE.activeEditor.selection.setContent('[toggle title="Toggle"] Insert your text here [/toggle]');
                    }});
                });
			return tab_button;
			
			
			case 'button':
                var button_button = cm.createSplitButton('button', {
                     title : 'Buttons',
					 image : URI+'/images/button.png',
                });
                button_button.onRenderMenu.add(function(c, m) {
					m.add({title : 'Buttons', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
					m.add({title : 'Button', onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
							file : URI+'/button_window.php',
							width : 400,
							height : 340,
							inline : 1,
							title : 'Button'
						});
                    }});
					m.add({title : 'Button More', onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
							file : URI+'/button_more_window.php',
							width : 400,
							height : 270,
							inline : 1,
							title : 'Button More'
						});
                    }});
                });
			return button_button;
			
			case 'image':
                var image_button = cm.createSplitButton('image', {
                     title : 'Images',
					 image : URI+'/images/image.png',
                });
                image_button.onRenderMenu.add(function(c, m) {
					m.add({title : 'Images', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
					m.add({title : 'Image', onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
							file : URI+'/image_window.php',
							width : 400,
							height : 540,
							inline : 1,
							title : 'Image'
						});
                    }});
					m.add({title : 'Frame Image', onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
							file : URI+'/image_frame_window.php',
							width : 400,
							height : 205,
							inline : 1,
							title : 'Frame Image'
						});
                    }});
                });
			return image_button;
			
			case 'video':
			    var video_button = cm.createSplitButton('video', {
                     title : 'Videos',
					 image : URI+'/images/video.png',
                });
            	video_button.onRenderMenu.add(function(c, m) {
					m.add({title : 'Videos', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
					m.add({title : 'HTML5', onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
							file : URI+'/video_html5_window.php',
							width : 400,
							height : 600,
							inline : 1,
							title : 'HTML5 Video'
						});
                    }});
					m.add({title : 'Flash', onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
							file : URI+'/video_flash_window.php',
							width : 400,
							height : 270,
							inline : 1,
							title : 'Flash Video'
						});
                    }});
					m.add({title : 'Youtube', onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
							file : URI+'/video_youtube_window.php',
							width : 400,
							height : 270,
							inline : 1,
							title : 'Youtube Video'
						});
                    }});
					m.add({title : 'Vimeo', onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
							file : URI+'/video_vimeo_window.php',
							width : 400,
							height : 270,
							inline : 1,
							title : 'Vimeo Video'
						});
                    }});
					m.add({title : 'Dailymotion', onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
							file : URI+'/video_dailymotion_window.php',
							width : 400,
							height : 270,
							inline : 1,
							title : 'Dailymotion Video'
						});
                    }});
                });
			return video_button;
			
			case 'widget':
                var widget_button = cm.createSplitButton('widget', {
                     title : 'Widgets',
					 image : URI+'/images/widget.png',
                });
                widget_button.onRenderMenu.add(function(c, m) {
					m.add({title : 'Widgets', 'class' : 'mceMenuItemTitle'}).setDisabled(1);
					m.add({title : 'Contact Form', onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
							file : URI+'/contact_form_window.php',
							width : 400,
							height : 135,
							inline : 1,
							title : 'Contact Form'
						});
                    }});
					m.add({title : 'Contact Info', onclick : function() {
                        tinyMCE.activeEditor.windowManager.open({
							file : URI+'/contact_info_window.php',
							width : 400,
							height : 400,
							inline : 1,
							title : 'Contact Info'
						});
                    }});
                });
			return widget_button;
			
        }
        return null;
    },
	getInfo : function() {
		return {
			longname : "Shortcode Builder",
			author : 'Janar Frei',
			authorurl : 'http://www.wordpressmonsters.com',
			infourl : 'http://www.wordpressmonsters.com',
			version : "1.0"
		};
	}
});
tinymce.PluginManager.add('shortcode', tinymce.plugins.ShortCode);
})();