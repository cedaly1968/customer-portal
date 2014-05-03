<?php
$shortname = 'emgtinymce';

$optn = array (
array( "name" => "Order media by",
	"id" => $shortname."_select_method",
	"type" => "select",
	"options" => array( "Select", "Category", "Media" ),
	"std" => "Choose a category" ),	

array( "name" => "Choose a category",
	"id" => $shortname."_select_cat",
	"type" => "selectcat",
	"options" => "",
	"std" => "" ),
	
array( "name" => "Choose media",
	"id" => $shortname."_select_sing_media",
	"type" => "selectmedia",
	"options" => "",
	"std" => "" ),	
);


if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {
	
// ADD STYLE & SCRIPT
	add_action( 'admin_head', 'emg_editor_add_init' );
		function emg_editor_add_init() {
			
			if ( get_post_type( get_the_ID() ) != 'easymediagallery' ) {
				
				wp_enqueue_style( 'easymedia-tinymce' );
				wp_enqueue_style( 'jquery-multiselect-css' );
				wp_enqueue_style( 'jquery-ui-themes-redmond' );
				//wp_enqueue_script( 'jquery-ui-custom' );
				wp_enqueue_script( 'jquery-ui' );
				wp_enqueue_script( 'jquery-multi-sel' );
				wp_enqueue_script( 'easymedia-cpscript', plugins_url( 'functions/tinymce-dlg.js' , __FILE__ ) );
				wp_enqueue_script( 'jquery-i-button', plugins_url( 'js/jquery/jquery.ibutton.js' , __FILE__ ) );
				wp_enqueue_style( 'metabox-ibuttoneditor', plugins_url( 'css/ibutton.css' , __FILE__ ), false, EASYMEDIA_VERSION );
		?>
        <?php
			}
			
		}
	
// ADD MEDIA BUTOON	
	add_action( 'media_buttons_context', 'add_emg_shortcode_button', 1 );
		function add_emg_shortcode_button($context) {
			$img = plugins_url( 'images/easymedia-32x32.png' , __FILE__ );
			$container_id = 'modal';
			$title = 'Easy Media Shortcode';
			$context .= '
			<a class="thickbox" id="add_emg_shortcode_button" title="'.$title.'" style="outline: medium none !important; cursor: pointer;" >
			<img src="'.$img.'" alt="Easy Media Gallery" width="20" height="20" style="position:relative; top:-1px"/></a>';
			return $context;
		}	
}


// GENERATE POPUP CONTENT
add_action('admin_footer', 'emg_popup_content');	
function emg_popup_content() {

if ( strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {

if ( get_post_type( get_the_ID() ) != 'easymediagallery' ) {
// START GENERATE POPUP CONTENT

?>
<div id="modal" style="display:none;">

<ul id="emgtabs">
    <li><a href="#" name="emgtab1">Basic</a></li>
    <li><a href="#" name="emgtab2">Grid Gallery</a></li> 
    <li><a href="#" name="emgtab3">Filterable Media</a></li>    
</ul>

<div id="emgcontent"> 

<div id="emgtab1">
<form method="post">

<?php 

global $optn;
foreach ( $optn as $value ) {
switch ( $value['type'] ) {
	
case "text":
?>

<div class="sc_input sc_text">
	<label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>	<br />
 	<input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text" value="<?php $value['std']; ?>" />
<div class="clearfix"></div>
 </div>
<?php break;	
	
case 'select':
?>

<div class="sc_input sc_select" id="<?php echo $value['id']; ?>_div">
<label class="label_optionttl" for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
<select class="tinymce_select" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
    <?php foreach ( $value['options'] as $state ){ ?>
        <option id="<?php echo $state; ?>" value="<?php echo $state; ?>"><?php echo $state; ?></option>
    <?php }
	?>
</select>

<div class="clearfix"></div>
</div>
<?php
break;	
	
	
case 'selectcat':
?>

<div class="sc_input sc_select" id="<?php echo $value['id']; ?>_div">
<label class="label_optionttl" for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
<?php $states = get_terms( 'emediagallery', array( 'hide_empty' => true ) ); ?>
<select class="tinymce_select" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
    <?php foreach ( $states as $state ){ ?>
        <option id="<?php echo $state->term_id; ?>" value="<?php echo $state->term_id; ?>"><?php echo $state->name; ?></option>
    <?php }
	?>
</select>
<div class="clearfix"></div>
</div>
<?php
break;		


case 'selectmedia':
?>

<div class="sc_input sc_select" id="<?php echo $value['id']; ?>_div">
<label class="label_optionttl" for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
	<select class="tinymce_select" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>">
<?php 

global $post;
$args = array(
  'post_type' => 'easymediagallery',
  'order' => 'ASC',
  'post_status' => 'publish',
  'posts_per_page' => -1
);

$myposts = get_posts( $args );
foreach( $myposts as $post ) :	setup_postdata($post); ?>
<option id="<?php echo $post->ID; ?>" type="text" value="<?php echo $post->ID; ?>" /><?php echo esc_html( esc_js( the_title(NULL, NULL, FALSE) ) ); ?></option>
<?php endforeach; 

?>
</select>
                <div id="markasgallery_div" style="margin-top: 10px;">
                <input type="hidden" name="emgtinymce_mark_asgallery" value="off" />
                <input class="switch" type="checkbox" id="emgtinymce_mark_asgallery" value="off" />
                <label class="label_optionttl"></label><label class="label_mark_as" for="emgtinymce_mark_asgallery">Mark selected media as gallery?</label></div>
<div class="clearfix"></div>
</div>
<?php
break;
}} ?>

<div class="sc_input sc_select" id="custom_col_div">
<label class="label_optionttl" for="emgtinymce_custom_columns">Custom columns</label>
                <div>
                <input type="hidden" name="emgtinymce_custom_columns" value="off" />
                <input class="switch" type="checkbox" id="emgtinymce_custom_columns" value="off" /></div>
			<div id="customcolumns" style="margin-top: 10px;">
		<label class="label_suboption">Columns :</label><div>
					
<select class="tinymce_select" name="select_custom_cola" id="select_custom_col">
        <option value="0">Select</option>
		 <option value="1">1</option>
		  <option value="2">2</option>
		   <option value="3">3</option>
		    <option value="4">4</option>
			 <option value="5">5</option>
			  <option value="6">6</option>
			   <option value="7">7</option>
			    <option value="8">8</option>
	</select>					
					</div></div>
<div class="clearfix"></div>
</div>

<div class="sc_input sc_select" id="custom_align_div">
<label class="label_optionttl" for="emgtinymce_custom_align">Custom alignment</label>
                <div>
                <input type="hidden" name="emgtinymce_custom_align" value="off" />
                <input class="switch" type="checkbox" id="emgtinymce_custom_align" value="off" /></div>
			<div id="customalign" style="margin-top: 10px;">
		<label class="label_suboption">Align :</label><div>					
<select class="tinymce_select" name="select_cus_align" id="select_cus_align">
        <option value="0">Select</option>
		 <option value="Left">Left</option>
		  <option value="Right">Right</option>
		   <option value="Center">Center</option>
           <option value="None">None</option>
	</select>					
					</div></div>
<div class="clearfix"></div>
</div>

<div class="sc_input sc_select" id="custom_style_div">
<label class="label_optionttl" for="emgtinymce_custom_align">Custom Style</label>
                <div>
                <input type="hidden" name="emgtinymce_custom_style" value="off" />
                <input class="switch" type="checkbox" id="emgtinymce_custom_style" value="off" /></div>
			<div id="mediacustomstyle" style="margin-top: 10px;">
		<label class="label_suboption">Style :</label><div>					
<select class="tinymce_select" name="select_cus_style" id="select_cus_style">
        <option value="0">Select</option>
		 <option value="light">Light</option>
		  <option value="dark">Dark</option>
		   <option value="transparent">Transparent</option>
	</select>					
					</div></div>
<div class="clearfix"></div>
</div>

<div class="sc_input sc_select" id="custom_size_div">
<label class="label_optionttl" for="emgtinymce_custom_sz">Custom thumbnail sizes</label>
<div><input type="hidden" name="emgtinymce_custom_sz" value="off" />
                <input class="switch" type="checkbox" id="emgtinymce_custom_sz" value="off" /></div>
			<div id="mediacustomsize" style="margin-top: 10px;">
		<label class="label_suboption">Custom size :</label>                    
                    
                    <div style="margin-top:10px; margin-bottom:5px;"><strong>Width</strong> <input style="margin-right:5px !important; margin-left:3px; width:43px !important; float:none !important;" name="emgtinymce_cus_width" id="emgtinymce_cus_width" type="text" value="" /> px
<span style="border-right:solid 1px #CCC;margin-left:9px; margin-right:10px !important; "></span>

 	<strong>Height</strong> <input style="margin-left:3px; margin-right:5px !important; width:43px !important; float:none !important;" name="emgtinymce_cus_height" id="emgtinymce_cus_height" type="text" value="" /> px </div></div>
<div class="clearfix"></div>
</div>

<div class="sc_button1">
<input type="button" value="Insert Shortcode" name="emg_insert_scrt" id="emg_insert_scrt" class="button-secondary" />	
<div class="clearfix"></div>
</div>
</form>
</div>

<div id="emgtab2">
<form method="post">
<div class="sc_input sc_select" id="listgallerydiv">
<label class="label_optionttl" for="listgallery">Select Gallery</label>
	<select class="tinymce_select" name="listgallery" id="listcustomgallery">
<?php 

global $post;
$args = array(
	'post_type' => 'easymediagallery',
	'order' => 'ASC',
  	'post_status' => 'publish',
  	'posts_per_page' => -1,
	'meta_query' => array(
		array(
			'key' => 'easmedia_metabox_media_type',
			'value' => 'Multiple Images (Slider)',
			'compare' => '='
		),

	)
 );
 
$myposts = get_posts( $args );
foreach( $myposts as $post ) :	setup_postdata($post); ?>
<option id="<?php echo $post->ID; ?>" type="text" value="<?php echo $post->ID; ?>" /><?php echo esc_html( esc_js( the_title(NULL, NULL, FALSE) ) ); ?></option>
<?php endforeach; 

?>
</select>
<div class="clearfix"></div>
</div>

<div class="sc_input sc_select" id="custom_sprd_size_div">
<label class="label_optionttl" for="emgtinymce_custom_sprd_sz">Custom thumbnail sizes</label>
<div><input type="hidden" name="emgtinymce_custom_sprd_sz" value="off" />
                <input class="switch" type="checkbox" id="emgtinymce_custom_sprd_sz" value="off" /></div>
			<div id="mediacustomsprdsize" style="margin-top: 10px;">
		<label class="label_suboption">Custom size :</label>                    
                    
                    <div style="margin-top:10px; margin-bottom:5px;"><strong>Width</strong> <input style="margin-right:5px !important; margin-left:3px; width:43px !important; float:none !important;" name="emgtinymce_cus_sprd_width" id="emgtinymce_cus_sprd_width" type="text" value="" /> px
<span style="border-right:solid 1px #CCC;margin-left:9px; margin-right:10px !important; "></span>

 	<strong>Height</strong> <input style="margin-left:3px; margin-right:5px !important; width:43px !important; float:none !important;" name="emgtinymce_cus_sprd_height" id="emgtinymce_cus_sprd_height" type="text" value="" /> px </div></div>
<div class="clearfix"></div>
</div>

<div class="sc_input sc_select" id="custom_style_sprd_div">
<label class="label_optionttl" for="emgtinymce_custom_stl">Custom Style</label>
                <div>
                <input type="hidden" name="emgtinymce_custom_stl" value="off" />
                <input class="switch" type="checkbox" id="emgtinymce_sprd_custom_style" value="off" /></div>
			<div id="mediacustomstylesprd" style="margin-top: 10px;">
		<label class="label_suboption">Style :</label><div>					
<select class="tinymce_select" name="select_cus_style_sprd" id="select_cus_style_sprd">
        <option value="0">Select</option>
		 <option value="light">Light</option>
		  <option value="dark">Dark</option>
		   <option value="transparent">Transparent</option>
	</select>					
					</div></div>
<div class="clearfix"></div>
</div>

<div class="sc_input sc_select" id="custom_filter_sprd_div">
<label class="label_optionttl" for="emgtinymce_custom_fltr">Show Gallery Filter</label>
                <div>
                <input type="hidden" name="emgtinymce_custom_fltr" value="off" />
                <input class="switch" type="checkbox" id="emgtinymce_custom_fltr" value="off" /></div>
<div class="clearfix"></div>
</div>

<div class="sc_button1">
<input type="button" value="Insert Shortcode" name="emg_insert_scrt1" id="emg_insert_scrt1" class="button-secondary" />	
<div class="clearfix"></div>
</div>
</form>
</div>

<div id="emgtab3">
<form method="post">
<div class="sc_input sc_select" id="listmediacatdiv">
<label class="label_optionttl" for="listmediacat">Select Category</label>
	<?php $states = get_terms( 'emediagallery', array( 'hide_empty' => true ) ); ?>
	<select class="tinymce_select" name="listmediacat" id="listmediacat">
<?php  foreach ( $states as $state ){ ?>
        <option id="<?php echo $state->term_id; ?>" value="<?php echo $state->term_id; ?>"><?php echo $state->name; ?></option>
    <?php }
	?>

</select>
<div class="clearfix"></div>
</div>

<div class="sc_input sc_select" id="custom_singal_size_div">
<label class="label_optionttl" for="emgtinymce_singal_sprd_sz">Custom thumbnail sizes</label>
<div><input type="hidden" name="emgtinymce_custom_sprd_sz" value="off" />
                <input class="switch" type="checkbox" id="emgtinymce_singal_sprd_sz" value="off" /></div>
			<div id="mediasingalsprdsize" style="margin-top: 10px;">
		<label class="label_suboption">Custom size :</label>                    
                    
                    <div style="margin-top:10px; margin-bottom:5px;"><strong>Width</strong> <input style="margin-right:5px !important; margin-left:3px; width:43px !important; float:none !important;" name="emgtinymce_cus_singal_width" id="emgtinymce_cus_singal_width" type="text" value="" /> px
<span style="border-right:solid 1px #CCC;margin-left:9px; margin-right:10px !important; "></span>

 	<strong>Height</strong> <input style="margin-left:3px; margin-right:5px !important; width:43px !important; float:none !important;" name="emgtinymce_cus_singal_height" id="emgtinymce_cus_singal_height" type="text" value="" /> px </div></div>
<div class="clearfix"></div>
</div>

<div class="sc_input sc_select" id="custom_style_singal_div">
<label class="label_optionttl" for="emgtinymce_singal_stl">Custom Style</label>
                <div>
                <input type="hidden" name="emgtinymce_singal_stl" value="off" />
                <input class="switch" type="checkbox" id="emgtinymce_singal_custom_style" value="off" /></div>
			<div id="mediasingalstylesprd" style="margin-top: 10px;">
		<label class="label_suboption">Style :</label><div>					
<select class="tinymce_select" name="select_cus_singal_sprd" id="select_cus_singal_sprd">
        <option value="0">Select</option>
		 <option value="light">Light</option>
		  <option value="dark">Dark</option>
		   <option value="transparent">Transparent</option>
	</select>					
					</div></div>
<div class="clearfix"></div>
</div>

<div class="sc_input sc_select" id="custom_singal_sprd_div">
<label class="label_optionttl" for="emgtinymce_cat_fltr">Show Gallery Filter</label>
                <div>
                <input type="hidden" name="emgtinymce_cat_fltr" value="off" />
                <input class="switch" type="checkbox" id="emgtinymce_cat_fltr" value="off" /></div>
<div class="clearfix"></div>
</div>

<div class="sc_button1">
<input type="button" value="Insert Shortcode" name="emg_insert_scrt1" id="emg_insert_scrt2" class="button-secondary" />	
<div class="clearfix"></div>
</div>
</form>
</div>

<div style="display:none;" id="thisresult"></div>
<div style="display:none;" id="thisgallresult"></div>
<div style="display:none;" id="thiscatresult"></div>
</div>
</div>
<?php 
	}
  } //END
}

?>