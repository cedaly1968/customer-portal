<?php 
/**
 * Columns Adder TinyMCE Plugin
 *
 * @package Qualeb
 * @since Qualeb 1.0
 */
 
	require_once('../../../../../../wp-load.php');
	require_once('../../../../../../wp-admin/includes/admin.php');
	do_action('admin_init');
	
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');
	
?>

(function() {
	tinymce.create('tinymce.plugins.<?php echo $dmShortcodes->shortcodesButton; ?>', {
		createControl : function(n, cm) {
			if(n=='<?php echo $dmShortcodes->shortcodesButton; ?>'){
                var cols = cm.createListBox('<?php echo $dmShortcodes->shortcodesButton; ?>List', {
                     title : 'Shortcodes',
                     onselect : function(value) {
                     	if(value == 'dropcap'){
                         	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[dropcap] [/dropcap]');
                        }
                        else if(value == 'backtotop'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[backtotop]');
                        }
						else if(value == 'divider'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[divider]');
                        }
						else if(value == 'aside'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[aside] [/aside]');
                        }
						else if(value == 'tabgro'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[tabgroup] [tab title="First tab" id="tab1" class="active"] Tab1 Content [/tab] [tab title="Second Tab" id="tab2"] Tab2 Content [/tab] [tab title="Third Tab" id="tab3"] Tab3 Content [/tab] [/tabgroup]');
                        }
						else if(value == 'tab'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[tab title="" id="" class=""] Tab Content [/tab]');
                        }
						else if(value == 'box'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[box color="none, red, orange, green"] This is an alert box (pick your color). [/box]');
                        }
						else if(value == 'clear'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[clear]');
                        }
						else if(value == 'arrowlink'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[arrowlink link=""] Link Title [/arrowlink]');
                        }
						else if(value == 'vimeo'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[vimeo id=""]');
                        }
						else if(value == 'youtube'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[youtube]');
                        }
						else if(value == 'dailymotion'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[dailymotion]');
                        }
						else if(value == 'homeslider'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[homeslider]');
                        }
						else if(value == 'portfolioitems'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[portfolioitems count="" cat="" order=""]');
                        }
						else if(value == 'homesidebar'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[homesidebar] [/homesidebar]');
                        }
						else if(value == 'homeintro'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[homeintro] [/homeintro]');
                        }
						else if(value == 'showposts'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[showposts ids="" count="" order=""]');
                        }
                        else if(value == 'hometitle'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[hometitle] [/hometitle]');
                        }
                     }
                });
				cols.add('-- TYPOGRAPHY --', '-');
				
				cols.add('Dropcap', 'dropcap');
				cols.add('Back to top', 'backtotop');
				cols.add('Divider', 'divider');
				cols.add('Aside', 'aside');
				cols.add('Tabs', 'tabgro');
				cols.add('Tab', 'tab');
				cols.add('Alert Box', 'box');
				cols.add('Clear', 'clear');
				cols.add('Arrow Link', 'arrowlink');
				
				cols.add('-- VIDEO --', '-');
				cols.add('Vimeo Video', 'vimeo');
				cols.add('Youtube Video', 'youtube');
				cols.add('Dailymotion Video', 'dailymotion');
				
				cols.add('-- HOME -- ', '-');
                cols.add('Home Slider', 'homeslider');
				cols.add('Portfolio Items', 'portfolioitems');
				cols.add('Home Sidebar', 'homesidebar');
				cols.add('Home Intro', 'homeintro');
				cols.add('Show Blog Posts', 'showposts');
                cols.add('Home Title', 'hometitle');


                return cols;
             }
             
             return null;
		},

	});

	// Register plugin
	tinymce.PluginManager.add('<?php echo $dmShortcodes->shortcodesButton; ?>', tinymce.plugins.<?php echo $dmShortcodes->shortcodesButton; ?>);
	
})();