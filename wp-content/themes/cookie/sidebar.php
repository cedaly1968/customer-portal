<!--BEGIN Sidebar-->
<nav id="ml_sidebar">
	<ul class="ul-sidebar">
		<?php
			if(is_category()) {
	
			$cat_array = get_the_category();
			$cat_name = $cat_array[0]->cat_name;
			
			/* a custom sidebar in EACH category - must be enables in the theme options */
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('Category - '.$cat_name, 'meydjer')) );
			
			/* a sidebar for all the categories */
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('For All Categories', 'meydjer')) );
		}
		?>

		<?php
			if(is_page()) {
			
			$page_title = get_the_title($post->ID);
	
			/* a custom sidebar in EACH page - must be enables in the theme options */
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('Page - '.$page_title, 'meydjer')) );

			/* a sidebar for all the pages */
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('For All Pages', 'meydjer')) );
		}
		?>

		<?php
		/* this widget will appear in every single post/page/portolio, if has a sidebar */
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(__('General', 'meydjer')) )
		?>
	</ul>
</nav>
<!--END Sidebar-->