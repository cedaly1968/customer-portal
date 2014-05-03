<?php 
//Make it a JavaScript file
header("Content-type: text/javascript");
if(file_exists('../../../../wp-load.php')) {
	include '../../../../wp-load.php';
}
else {
	include '../../../../../wp-load.php';
}
?>

/*-------------------------------------------------*/
/*	TinyMCE Shortcodes Button
/*-------------------------------------------------*/
jQuery(document).ready(function() {
  tinymce.create('tinymce.plugins.ml_add_shortcode_button', {
      init : function(ed, url) {
          ed.addButton('ml_add_shortcode_button', {
              title : 'Add Shortcode',
              image : '<?php echo get_template_directory_uri(); ?>/images/ml_magic_wand.png',
              onclick : function() {
			var shortcode = '[ml_column width=\'one_half OR one_third OR one_fourth OR one_fifth OR two_third OR two_fifth OR three_fourth OR three_fifth OR five_sixth\' last=\'true OR false\'] ';
			shortcode += 'Content Here... ';
			shortcode += '[/ml_column]';

			tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
			tb_remove();
              }
          });
      },
      createControl : function(n, cm) {
          return null;
      },
  });
  tinymce.PluginManager.add('ml_add_shortcode_button', tinymce.plugins.ml_add_shortcode_button);
	
})();