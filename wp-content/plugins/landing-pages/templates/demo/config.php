<?php
/**
* WordPress Landing Page Config File
* Template Name:  Demo Template
* @package  WordPress Landing Pages
* @author 	David Wells
*
* This is a demo template for developers and designers to use as a reference for building landing page templates
* For a boilerplate without all the markup visit: XYZ
* 
*/

do_action('lp_global_config'); // The lp_global_config function is for global code added by 3rd party extensions

//gets template directory name to use as identifier - do not edit - include in all template files
$key = lp_get_parent_directory(dirname(__FILE__)); 

/**
 * $lp_data[$key]['info'] 
 * Configures Template Information
 */

/* $lp_data[$key]['settings'] Parameters

    'version' => (string) (required)
    - Version Number. default = "1.0"

    'label' => (string) (required)
    - Custom Nice Name for templates. default = template file folder name

    'description' => (string) (required)
    - Landing page description.

    'category' => (string) (required)
    - Category for template. default = "all"

    'demo' => (string) (required)
    - Link to demo url.
*/

$lp_data[$key]['info'] = 
array(
	'version' => "2.0.0", // Version Number
	'label' => "Demo", // Nice Name
	'category' => 'Miscellaneous', // Template Category
	'demo' => 'http://demo.inboundnow.com/go/demo-template-preview/', // Demo Link
	'description'  => 'The Demo theme is here to help developers and designs implment thier own designs into the landing page plugin. Study this template to learn about Landing Page Plugin\'s templating system and to assist in building new templates.' // template description
);


/**
 * $lp_data[$key]['settings'] 
 * Adds metabox options to landing page template
 * http://plugins.inboundnow.com/docs/dev/creating-templates/template-config/
 */

/* Parameters
    'label' => (string) (required)
    - Label for Meta Fields.

    'description' => (string) (required)
    - Description for meta Field 

    'id' => (string) (required)
    - unprefixed-meta-key. The $key (template file path name) is appended in the loop this array is used in.

    'type' => (string) (required)
    - Meta box type. default = 'text'

    'default' => (string) (optional)
    - Default Field Value.  default = ''

    'options' => (array) (required for metaboxes with multiple options)
    - example: 'options' => array('value' => 'label','value_2'=>'label 2')
    - For dropdowns, checkboxes, etc.

    'context' => (string) (optional)
    - where this box will go, will be used for advanced placement/styling.  default = normal
 
*/
 
// Define Meta Options for template
// These values are returned in the template's index.php file with lp_get_value($post, $key, 'text-box-id') function
$lp_data[$key]['settings'] = 
array(
	/* Text field Example */
    array(  
        'label' => 'Text Field Label', // Label of field
        'description' => "Text field Description", // field description
        'id' => 'text-box-id', // metakey. The $key Prefix is appended making the meta value demo-text-box-id
        'type'  => 'text', // text metafield type
        'default'  => '2013-1-31 13:00', // default content
        'context'  => 'normal' // Context in screen for organizing options
        ),
    /* Textarea Example */
    array(
        'label' => 'Textarea Label',
        'description' => "Textarea description to the user",
        'id'  => 'textarea-id', // called in template's index.php file with lp_get_value($post, $key, 'textarea-id');
        'type'  => 'textarea',
        'default'  => 'Default text in textarea',
        'context'  => 'normal'
        ),
    /* Colorpicker Example */
    array(
        'label' => 'ColorPicker Label',
        'description' => "Colorpicker field description",
        'id'  => 'color-picker-id', // called in template's index.php file with lp_get_value($post, $key, 'color-picker-id');
        'type'  => 'colorpicker',
        'default'  => 'ffffff',
        'context'  => 'normal'
        ),
    /* Radio Button Example */
    array(
        'label' => 'Radio Label',
        'description' => "Radio field description",
        'id'  => 'radio-id-here', // called in template's index.php file with lp_get_value($post, $key, 'radio-id-here');
        'type'  => 'radio',
        'default'  => '1',
        'options' => array('1' => 'on','0'=>'off'),
        'context'  => 'normal'
        ),
    /* Checkbox Example */
    array(
        'label' => 'Checkbox Label',
        'description' => "Example Checkbox Description",
        'id'  => 'checkbox-id-here', // called in template's index.php file with lp_get_value($post, $key, 'checkbox-id-here');
        'type'  => 'checkbox',
        'default'  => 'on',
        'options' => array('option_on' => 'on','option_off'=>'off'),	
        'context'  => 'normal'
        ),
    /* Dropdown Example */
    array(
        'label' => 'Dropdown Label',
        'description' => "Dropdown option description",
        'id'  => 'dropdown-id-here', // called in template's index.php file with lp_get_value($post, $key, 'dropdown-id-here');
        'type'  => 'dropdown',
        'default'  => 'default',		
		'options' => array('right'=>'Float right','left'=>'Float left', 'default'=>'Default option'),
        'context'  => 'normal'
        ),
    /* Date Picker Example */
     array(
        'label' => 'Date Picker Label',
        'description' => "Date Picker Description",
        'id'  => 'date-picker', // called in template's index.php file with lp_get_value($post, $key, 'date-picker');
        'type'  => 'datepicker',
        'default'  => '2013-12-27',
        'context'  => 'normal'
        ),
     /* WYSIWYG Example */
     array(
        'label' => 'Main Content Box 2',
        'description' => "wysiwyg description",
        'id'  => 'wysiwyg-id', // called in template's index.php file with lp_get_value($post, $key, 'wysiwyg-id');
        'type'  => 'wysiwyg',
        'default'  => 'Default WYSIWYG content',				
        'context'  => 'normal'
        ),
     /* Media Uploaded Example */
     array(
        'label' => 'File/Image Upload Label',
        'description' => "File/Image Upload Description",
        'id'  => 'media-id', // called in template's index.php file with lp_get_value($post, $key, 'media-id');
        'type'  => 'media',
        'default'  => '/wp-content/plugins/landing-pages/templates/path-to-image-place-holder.png',
        'context'  => 'normal'
        )
    );