jQuery(document).ready(function() {
	jQuery("#add_sidebar").closest("form").submit(function(event) {
		if (!event.isDefaultPrevented() && jQuery("#add_sidebar").val()) {
			if(jQuery("#sidebars").val()){
				jQuery("#sidebars").val(jQuery("#sidebars").val()+","+jQuery("#add_sidebar").val());
			}else{
				jQuery("#sidebars").val(jQuery("#add_sidebar").val());
			}
		}
	});
	jQuery(".sidebar-item input:button").click(function(){
		jQuery(this).closest(".sidebar-item").fadeOut("normal",function(){
			jQuery(this).remove();
			jQuery("#sidebars").val("");
			jQuery(".sidebar-item-value").each(function(){
				if(jQuery("#sidebars").val()){
					jQuery("#sidebars").val(jQuery("#sidebars").val()+","+jQuery(this).val());
				}else{
					jQuery("#sidebars").val(jQuery(this).val());
				}
			});
		});
		
	});
});