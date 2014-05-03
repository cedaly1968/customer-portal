<?php
/**
 * metaboxBuilder class
 */
class metaboxBuilder {
	var $config;
	var $options;
	
	function metaboxBuilder($config, $options) {
		$this->config = $config;
		$this->options = $options;
		
		add_action('admin_menu', array(&$this, 'create'));
		add_action('save_post', array(&$this, 'save'));
	}
	
	function create() {
		if (function_exists('add_meta_box')) {
			$callback = array(&$this, 'render');
			foreach($this->config['pages'] as $page) {
				add_meta_box($this->config['id'], $this->config['title'], $callback, $page, $this->config['context'], $this->config['priority']);
			}
		}
	}
	
	function save($post_id) {
		if (! wp_verify_nonce($_POST[$this->config['id'] . '_noncename'], plugin_basename(__FILE__))) {
			return $post_id;
		}
		if ($_POST['post_type'] == 'page') {
			if (! current_user_can('edit_page', $post_id)) {
				return $post_id;
			}
		} else {
			if (! current_user_can('edit_post', $post_id)) {
				return $post_id;
			}
		}
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post_id;
		}
		
		foreach($this->options as $option) {
			if (isset($option['id']) && ! empty($option['id'])) {
				if (isset($_POST[$option['id']])) {
					$value = $_POST[$option['id']];
				} else {
					$value = false;
				}
				if (get_post_meta($post_id, $option['id']) == "") {
					add_post_meta($post_id, $option['id'], $value, true);
				} elseif ($value != get_post_meta($post_id, $option['id'], true)) {
					update_post_meta($post_id, $option['id'], $value);
				} elseif ($value == "") {
					delete_post_meta($post_id, $option['id'], get_post_meta($post_id, $option['id'], true));
				}
			}
		}
	}
	
	function render() {
		global $post;
		foreach($this->options as $option) {
			if (method_exists($this, $option['type'])) {
				if (isset($option['id'])) {
					$default = get_post_meta($post->ID, $option['id'], true);
					if ($default != "") {
						$option['default'] = $default;
					}
				}
				echo '<div class="meta-box-item">';
				$this->$option['type']($option);
				echo '</div>';
			}
		}
		echo '<input type="hidden" name="' . $this->config['id'] . '_noncename" id="' . $this->config['id'] . '_noncename" value="' . wp_create_nonce(plugin_basename(__FILE__)) . '" />';
	}
	
	/**
	 * display metabox title
	 */
	function title($value) {
		if (isset($value['name'])) {
			echo '<div class="meta-box-item-title"><h4>' . $value['name'] . '</h4></div>';
		}
		if (isset($value['desc'])) {
			echo '<p>' . $value['desc'] . '</p>';
		}
	}
	
	/**
	 * display text input
	 */
	function text($value) {
		echo '<div class="meta-box-item-title"><h4>'. $value['name'] .'</h4></div>';
		if (isset($value['desc'])) {
			echo '<p class="description">'. $value['desc'] .'</p>';
		}
		echo '<div class="meta-box-item-content">';
		echo '<input name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="'. $value['default'] .'" />';
		echo '</div>';
	}
	
	/**
	 * display textarea
	 */
	function textarea($value) {
		echo '<div class="meta-box-item-title"><h4>'. $value['name'] .'</h4></div>';
		if (isset($value['desc'])) {
			echo '<p class="description">'. $value['desc'] .'</p>';
		}
		echo '<div class="meta-box-item-content">';
		echo '<textarea name="'. $value['id'] .'" type="'. $value['type'] .'" class="code">'. $value['default'] .'</textarea>';
		echo '</div>';
	}
	
	/**
	 * display select
	 */
	function select($value) {
		echo '<div class="meta-box-item-title"><h4>'. $value['name'] .'</h4></div>';
		if (isset($value['desc'])) {
			echo '<p class="description">'. $value['desc'] .'</p>';
		}
		echo '<div class="meta-box-item-content"><select name="'. $value['id'] .'" id="'. $value['id'] .'">';
		echo '<option value="">Choose one...</option>';
		foreach($value['options'] as $key => $option) {
			echo '<option value="'. $key .'"';
			if ($key == $value['default']) {
				echo ' selected="selected"';
			}
			echo '>'. $option .'</option>';
		}	
		echo '</select></div>';
	}

	/**
	 * display radio
	 */
	function radio($value) {
		echo '<div class="meta-box-item-title"><h4>'. $value['name'] .'</h4></div>';
		if (isset($value['desc'])) {
			echo '<p class="description">'. $value['desc'] .'</p>';
		}
		echo '<div class="meta-box-item-content">';
		$i = 0;
		foreach($value['options'] as $key => $option) {
			$i++;
			$checked = '';
			if ($key == $value['default']) {
				$checked = ' checked="checked"';
			}
			echo '<input type="radio" id="'. $value['id'] .'_'. $i .'" name="'. $value['id'] .'" value="'. $key .'" '. $checked .' />';
			echo '<label for="'. $value['id'] .'_'. $i .'">'. $option .'</label>';
		}
		echo '</div>';
	}
	
	/**
	 * display portfolio category
	 */
	function portfolio_category($value) {
		echo '<div class="meta-box-item-title"><h4>'. $value['name'] .'</h4></div>';
		if (isset($value['desc'])) {
			echo '<p class="description">'. $value['desc'] .'</p>';
		}
		echo '<div class="meta-box-item-content"><select name="'. $value['id'] .'" id="'. $value['id'] .'">';
		echo '<option value="">Choose one...</option>';
		foreach($this->get_portfolio_category() as $key => $option) {
			echo '<option value="'. $key .'"';
			if ($key == $value['default']) {
				echo ' selected="selected"';
			}
			echo '>'. $option .'</option>';
		}	
		echo '</select></div>';
	}
	
	function get_portfolio_category(){
		$options = array();
		$entries = get_terms('portfolio_category');
		if(!empty($entries)){
			foreach($entries as $key) {
				$options[$key->slug] = $key->name;
			}
		}
		return $options;
	}
	
	/**
	 * display blog category
	 */
	function blog_category($value) {
		echo '<div class="meta-box-item-title"><h4>'. $value['name'] .'</h4></div>';
		if (isset($value['desc'])) {
			echo '<p class="description">'. $value['desc'] .'</p>';
		}
		echo '<div class="meta-box-item-content"><select name="'. $value['id'] .'" id="'. $value['id'] .'">';
		echo '<option value="">Choose one...</option>';
		foreach($this->get_blog_category() as $key => $option) {
			echo '<option value="'. $key .'"';
			if ($key == $value['default']) {
				echo ' selected="selected"';
			}
			echo '>'. $option .'</option>';
		}	
		echo '</select></div>';
	}
	
	function get_blog_category(){
		$options = array();
		$entries = get_categories('title_li=&orderby=name&hide_empty=0');
		if(!empty($entries)){
			foreach($entries as $key) {
				$options[$key->slug] = $key->name;
			}
		}
		return $options;
	}
}

?>