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
	tinymce.create('tinymce.plugins.<?php echo $dmColumns->colsButton; ?>', {
		createControl : function(n, cm) {
			if(n=='<?php echo $dmColumns->colsButton; ?>'){
                var cols = cm.createListBox('<?php echo $dmColumns->colsButton; ?>List', {
                     title : 'Columns',
                     onselect : function(value) {
                     	if(value == 'twocols'){
                         	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[one_half]One Half[/one_half] [one_half_last]One Half[/one_half_last]');
                        }
                        else if(value == 'threecols'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[one_third]One Third[/one_third] [one_third]One Third[/one_third] [one_third_last]One Third[/one_third_last]');
                        }
						else if(value == 'fourcols'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[one_fourth]One Fourth[/one_fourth] [one_fourth]One Fourth[/one_fourth] [one_fourth]One Fourth[/one_fourth] [one_fourth_last]One Fourth[/one_fourth_last]');
                        }
						else if(value == 'fivecols'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[one_fifth]One Fifth[/one_fifth] [one_fifth]One Fifth[/one_fifth] [one_fifth]One Fifth[/one_fifth] [one_fifth]One Fifth[/one_fifth] [one_fifth_last]One Fifth[/one_fifth_last]');
                        }
						else if(value == 'sixcols'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[one_sixth]One Sixth[/one_sixth] [one_sixth]One Sixth[/one_sixth] [one_sixth]One Sixth[/one_sixth] [one_sixth]One Sixth[/one_sixth] [one_sixth]One Sixth[/one_sixth] [one_sixth_last]One Sixth[/one_sixth_last]');
                        }
						else if(value == 'one_fourth_three_fourth'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[one_fourth]One Fourth[/one_fourth] [three_fourth_last]Three Fourth[/three_fourth_last]');
                        }
						else if(value == 'three_fourth_one_fourth'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[three_fourth]Three Fourth[/three_fourth] [one_fourth_last]One Fourth[/one_fourth_last]');
                        }
						else if(value == 'one_third_two_third'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[one_third]One Third[/one_third] [two_third_last]Two Third[/two_third_last]');
                        }
						else if(value == 'two_third_one_third'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[two_third]Two Third[/two_third] [one_third_last]One Third[/one_third_last]');
                        }
						else if(value == 'one_fifth_four_fifth'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[one_fifth]One Fifth[/one_fifth] [four_fifth_last]Four Fifth[/four_fifth_last]');
                        }
						else if(value == 'four_fifth_one_fifth'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[four_fifth]Four Fifth[/four_fifth] [one_fifth_last]One Fifth[/one_fifth_last]');
                        }
						else if(value == 'two_fifth_three_fifth'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[two_fifth]Two Fifth[/two_fifth] [three_fifth_last]Three Fifth[/three_fifth_last]');
                        }
						else if(value == 'three_fifth_two_fifth'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[three_fifth]Three Fifth[/three_fifth] [two_fifth_last]Two Fifth[/two_fifth_last]');
                        }
						else if(value == 'one_sixth_five_sixth'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[one_sixth]One Sixth[/one_sixth] [five_sixth_last]Five Sixth[/five_sixth_last]');
                        }
						else if(value == 'five_sixth_one_sixth'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[five_sixth]Five Sixth[/five_sixth] [one_sixth_last]One Sixth[/one_sixth_last]');
                        }
						else if(value == 'two_sixth_four_sixth'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[two_sixth]Two Sixth[/two_sixth] [four_sixth_last]Four Sixth[/four_sixth_last]');
                        }
						else if(value == 'four_sixth_two_sixth'){
                        	tinyMCE.activeEditor.execCommand('mceInsertContent', 0, '[four_sixth]Four Sixth[/four_sixth] [two_sixth_last]Two Sixth[/two_sixth_last]');
                        }
                     }
                });

                cols.add('2 Columns', 'twocols');
				cols.add('3 Columns', 'threecols');
				cols.add('4 Columns', 'fourcols');
				cols.add('5 Columns', 'fivecols');
				cols.add('6 Columns', 'sixcols');
				cols.add('1/4 col + 3/4 col', 'one_fourth_three_fourth');
				cols.add('3/4 col + 1/4 col', 'three_fourth_one_fourth');
				
				cols.add('1/3 col + 2/3 col', 'one_third_two_third');
				cols.add('2/3 col + 1/3 col', 'two_third_one_third');
				
				cols.add('1/5 col + 4/5 col', 'one_fifth_four_fifth');
				cols.add('4/5 col + 1/5 col', 'four_fifth_one_fifth');
				cols.add('2/5 col + 3/5 col', 'two_fifth_three_fifth');
				cols.add('3/5 col + 2/5 col', 'three_fifth_two_fifth');
				
				cols.add('1/6 col + 5/6 col', 'one_sixth_five_sixth');
				cols.add('5/6 col + 1/6 col', 'five_sixth_one_sixth');
				cols.add('2/6 col + 4/6 col', 'two_sixth_four_sixth');
				cols.add('4/6 col + 2/6 col', 'four_sixth_two_sixth');

                return cols;
             }
             
             return null;
		},

	});

	// Register plugin
	tinymce.PluginManager.add('<?php echo $dmColumns->colsButton; ?>', tinymce.plugins.<?php echo $dmColumns->colsButton; ?>);
	
})();