<?php
/**
 * optionBuilder class
 */
class optionBuilder {
	var $name;
	var $options;
	var $settings;
	
	function optionBuilder($name, $options) {
		$this->name = $name;
		$this->options = $options;
		$this->save();
		$this->render();
	}
	
	/**
	 * Save options
	 */
	function save() {
		$options = get_option(THEME_NAME .'_'. $this->name);
		if (isset($_POST['save_options'])) {
			foreach($this->options as $value) {
				if (isset($_POST[$value['id']])) {
					$options[$value['id']] = $_POST[$value['id']];
				} else {
					$options[$value['id']] = false;
				}
			}
			update_option(THEME_NAME .'_'. $this->name, $options);
			echo '<div id="message" class="updated"><p><strong>Updated Successfully</strong></p></div>';
		}
		$this->settings = $options;
	}
	
	/**
	 * Start options render
	 */
	function render() {
		echo '<div class="wrap theme-options-page">';
		echo '<form method="post">';
		foreach($this->options as $option) {
			if (method_exists($this, $option['type'])) {
				$this->$option['type']($option);
			}
		}
		echo '</form>';
		echo '</div>';
	}
	
	/**
	 * Display options page title
	 */
	function title($value) {
		echo '<h2>'. $value['name'] .'</h2>';
		if (isset($value['desc'])) {
			echo '<p>'. $value['desc'] .'</p>';
		}
	}
	
	/**
	 * Start group section
	 */
	function start($value) {
		echo '<div class="theme-options-group">';
		echo '<table cellspacing="0" class="widefat theme-options-table">';
		echo '<thead><tr>';
		echo '<th colspan="2">'. $value['name'] .'</th>';
		echo '</tr></thead><tbody>';
	}
	
	function desc($value) {
		echo '<tr><td colspan="2">'. $value['desc'] .'</td></tr>';
	}
	
	/**
	 * End group section
	 */
	function end($value) {
		echo '</tbody></table></div><p class="submit"><input type="submit" name="save_options" class="button-primary autowidth" value="Save Changes" /></p>';
	}
	
	/**
	 * Display text input
	 */
	function text($value) {
		echo '<tr><th><h4><label for="'. $value['id'] .'">'. $value['name'] .'</label></h4></th><td>';
		if(isset($value['desc'])){
			echo '<p class="description">'. $value['desc'] .'</p>';
		}
		echo '<input name="'. $value['id'] .'" id="'. $value['id'] .'" type="text" value="';
		if (isset($this->settings[$value['id']])) {
			echo stripslashes($this->settings[$value['id']]);
		} else {
			echo $value['default'];
		}
		echo '" />';
		echo '</td></tr>';
	}
	
	/**
	 * Display textarea
	 */
	function textarea($value) {
		echo '<tr><th><h4><label for="'. $value['id'] .'">'. $value['name'] .'</label></h4></th><td>';
		if(isset($value['desc'])){
			echo '<p class="description">'. $value['desc'] .'</p>';
		}
		echo '<textarea id="'. $value['id']. '" name="'. $value['id'] .'" type="'. $value['type'] .'" class="code">';
		if (isset($this->settings[$value['id']])) {
			echo stripslashes($this->settings[$value['id']]);
		} else {
			echo $value['default'];
		}
		echo '</textarea>';
		echo '</td></tr>';
	}
	
	/**
	 * Display select
	 */
	function select($value) {
		echo '<tr><th><h4><label for="'. $value['id'] .'">'. $value['name'] .'</label></h4></th><td>';
		if(isset($value['desc'])){
			echo '<p class="description">'. $value['desc'] .'</p>';
		}
		echo '<select name="'. $value['id'] .'" id="'. $value['id'] .'">';
		foreach($value['options'] as $key => $option) {
			echo "<option value='". $key ."'";
			if (isset($this->settings[$value['id']])) {
				if (stripslashes($this->settings[$value['id']]) == $key) {
					echo 'selected="selected"';
				}
			} else if ($key == $value['default']) {
				echo 'selected="selected"';
			}
			echo '>'. $option .'</option>';
		}
		echo '</select>';
		echo '</td></tr>';
	}
		
	/**
	 * Display toggle checkbox
	 */
	function toggle($value) {
		$checked = '';
		if (isset($this->settings[$value['id']])) {
			if ($this->settings[$value['id']] == true) {
				$checked = 'checked="checked"';
			}
		} elseif ($value['default'] == true) {
			$checked = 'checked="checked"';
		}
		echo '<tr><th><h4>'. $value['name'] .'</h4></th><td>';
		if(isset($value['desc'])){
			echo '<p class="description">'. $value['desc'] .'</p>';
		}
		echo '<input type="checkbox" class="toggle-button" name="'. $value['id'] .'" id="'. $value['id'] .'" '. $checked .' />';
		echo '</td></tr>';
	}
		
	/**
	 * Display sidebar fields
	 */
	function sidebar($value) {
		$custom_sidebars = $this->settings[$value['id']];
		if(!empty($custom_sidebars)){
			$sidebars = explode(',', $custom_sidebars);
		}else{
			$sidebars = array();
		}
		echo '<tr><th><h4><label for="'. $value['id'] .'">'. $value['name'] .'</label></h4></th><td>';
		if(isset($value['desc'])){
			echo '<p class="description">'. $value['desc'] .'</p>';
		}
		echo '<input type="text" id="add_sidebar" name="add_sidebar" />';
		if(!empty($sidebars)){
			echo '<div class="sidebar-title">'. __('Below are the sidebars you have created','mandrake_theme') .'</div>';
			foreach($sidebars as $sidebar){
				echo '<div class="sidebar-item"><input type="hidden" class="sidebar-item-value" value="'. $sidebar .'"/><input type="button" class="button" value="'. __('Delete','mandrake_theme') .'"/><span>'. $sidebar .'</span></div>';
			}
		}
		echo '<input type="hidden" id="sidebars" value="'. $custom_sidebars .'" name="'. $value['id'] .'" />';
		echo '</td></tr>';
	}
	
	/**
	 * Display portfolio categories
	*/
	function portfolio_category($value) {
		echo '<tr><th><h4><label for="'. $value['id'] .'">'. $value['name'] .'</label></h4></th><td>';
		if(isset($value['desc'])){
			echo '<p class="description">'. $value['desc'] .'</p>';
		}
		echo '<select name="'. $value['id'] .'" id="'. $value['id'] .'">';
		echo '<option value="">Choose one...</option>';
		foreach($this->get_porftolio_category() as $key => $option) {
			echo "<option value='". $key ."'";
			if (isset($this->settings[$value['id']])) {
				if (stripslashes($this->settings[$value['id']]) == $key) {
					echo 'selected="selected"';
				}
			} else if ($key == $value['default']) {
				echo 'selected="selected"';
			}
			echo '>'. $option .'</option>';
		}
		echo '</select>';
		echo '</td></tr>';
	}
	
	function get_porftolio_category(){
		$options = array();
		$entries = get_terms('portfolio_category');
		if(!empty($entries)){
			foreach($entries as $key) {
				$options[$key->slug] = $key->name;
			}
		}
		return $options;
	}
}
?>