    var total_count = 0;
    var checkbox_session = '';  

    function array_search( needle, haystack, strict ) {
        var strict = !!strict;
        for(var key in haystack){
            if( (strict && haystack[key] === needle) || (!strict && haystack[key] == needle) && haystack.hasOwnProperty( key ) ){
                return key;
            }
        }
        return false;
    }

    function change_checked_count(e) {
        checkbox_session = e.val(); 
        console.log(checkbox_session);       
    }

    jQuery( document ).ready( function() {
        var search_text = '';
        var order = '';
        var display = '';
        var ok_action = 0;
        jQuery(".pagination_links[rel=first]").hide();
        jQuery(".pagination_links[rel=prev]").hide();

        // assign Clients to NEW file
        jQuery(".fancybox_link").click(function() {
            checkbox_session = '';
            console.log(checkbox_session);
            var href = jQuery(this).attr('href');
            var rel = jQuery(this).attr('rel');
            jQuery(href + " .input_ref").val(rel);
            jQuery(".pagination_links[rel=first]").hide();
            jQuery(".pagination_links[rel=prev]").hide();
            jQuery(".page_num").html('1');
            jQuery(href).find(".inside table tr td input[type=radio]").removeAttr('checked');
            jQuery('.show option').removeAttr('selected');
            jQuery('.order option').removeAttr('selected');                      

            jQuery.ajax({
                type: "POST",
                url: site_url+"/wp-admin/admin-ajax.php",
                data: "action=get_popup_pagination_data&datatype=" + rel + "&page=1&goto=first&search=&current_page=" + wpc_current_page,
                dataType: "json",
                success: function(data) {
                    if(data.html) {
                        jQuery(href).find(".inside table tr td").html(data.html);
                        for(key in data.buttons) {
                            if( data.buttons.hasOwnProperty( key ) ) {
                                if(data.buttons[key]) {
                                    jQuery(href).find(".pagination_links[rel="+key+"]").show();
                                } else {
                                    jQuery(href).find(".pagination_links[rel="+key+"]").hide();
                                }
                            }
                        }
                        if(data.count > 1) {
                            jQuery(href).find(".page_num").html(data.page);
                        } else {
                            jQuery(href).find(".page_num").html('');
                        }
                        
                        var cur_val = jQuery("#"+rel).val();
                        if(cur_val) {
                            jQuery(href).find(".inside table tr td input[type=radio][value=" + cur_val + "]").attr('checked', true);
                            checkbox_session = cur_val;
                            console.log(checkbox_session);
                        }
                    }
                    jQuery('.fancybox-inner').width('auto');
                    jQuery('.fancybox-wrap').width('auto');
                },
                error: function(data) {
                    jQuery(href).find(".inside table tr td").html(data.html);
                }
            });

            jQuery.fancybox({
                'type'           : 'inline',
                'beforeClose'       : (function() {
                    if(ok_action) {
                        ok_action = 0;
                    }
                }),
                'width'          : 'auto',
                'height'         : 'auto',
                'titleShow'      : false,
                'titleFormat'    : '',
                'autoDimensions' : false,
                'transitionIn'   : 'none',
                'transitionOut'  : 'none',
                'href'           : href
            });
        });

        /*jQuery(".change_clients").change(function() {
            var name = jQuery(this).attr('name');
            var value = jQuery(this).val();
            var datatype = 'clients';

            jQuery.ajax({
                type: "POST",
                url: site_url+"/wp-admin/admin-ajax.php",
                data: "action=update_assigned_data&datatype=" + datatype + "&id=" + name + "&data=" + value + "&current_page=" + wpc_current_page,
                dataType: "json",
                success: function(data) {
                    if(data.status) {
                        console.log('Client assign updated.');
                    } else {
                        alert('Error: ' + data.message);
                    }
                },
                error: function(data) {
                    alert('Can not update assign data.');
                }
            });
        });

        jQuery(".change_circles").change(function() {
            var name = jQuery(this).attr('name');
            var value = jQuery(this).val();
            var datatype = 'circles';

            jQuery.ajax({
                type: "POST",
                url: site_url+"/wp-admin/admin-ajax.php",
                data: "action=update_assigned_data&datatype=" + datatype + "&id=" + name + "&data=" + value + "&current_page=" + wpc_current_page,
                dataType: "json",
                success: function(data){
                    if(data.status) {
                        console.log('Client assign updated.');
                    } else {
                        alert('Error: ' + data.message);
                    }
                },
                error: function(data) {
                    alert('Can not update assign data.');
                }
            });
        });*/

        jQuery(".show").change(function() {
            display = jQuery(this).val();
            order = jQuery(this).parent().find('.order').val();

            var input_ref = jQuery(this).parent().find(".input_ref").val();
            var obj_str = jQuery("#"+input_ref).val();
            /*if(obj_str) {
                checkbox_session = obj_str;        
                
            }
            
            jQuery("#"+input_ref).trigger('change'); */
            console.log(checkbox_session);
            var goto = 'first';
            var page = 1;
            datatype = input_ref;
            
            var param = '';
            if( order == 'first_asc' ) {
                if( checkbox_session ) {
                    var param = '&already_assinged=' + checkbox_session;
                }
            }

            var link = jQuery(this);
            jQuery.ajax({
                type: "POST",
                url: site_url+"/wp-admin/admin-ajax.php",
                data: "action=get_popup_pagination_data&datatype=" + datatype + "&page=" + page + "&goto=" + goto + "&display=" + display + "&order=" + order + "&search=" + search_text + "&current_page=" + wpc_current_page + param,
                dataType: "json",
                success: function(data){
                    if(data.html) {
                        link.parent().parent().find(".inside table tr td").html(data.html);
                        for(key in data.buttons) {
                            if( data.buttons.hasOwnProperty( key ) ) {
                                if(data.buttons[key]) {
                                    link.parent().find(".pagination_links[rel="+key+"]").show();
                                } else {
                                    link.parent().find(".pagination_links[rel="+key+"]").hide();
                                }
                            }
                        }
                        if(data.count > 1) {
                            link.parent().find(".page_num").html(data.page);
                        } else {
                            link.parent().find(".page_num").html('');
                        }
                        
                        link.parent().parent().find(".inside table tr td input[type=radio][value="+checkbox_session+"]").attr('checked', true);
                    }
                    jQuery('.fancybox-inner').width('auto');
                    jQuery('.fancybox-wrap').width('auto');

                },
                error: function(data) {
                    link.parent().parent().find(".inside table tr td").html(data.html);
                }
            });

        });

        jQuery(".order").change(function() {
            display = jQuery(this).parent().find('.show').val();
            order = jQuery(this).val();

            var input_ref = jQuery(this).parent().find(".input_ref").val();
            var obj_str = jQuery("#"+input_ref).val();
            /*if(obj_str) {
                checkbox_session = obj_str; 
                
            }
            jQuery("#"+input_ref).trigger('change'); */
            //console.log(checkbox_session);
            var goto = 'first';
            var page = 1;
            datatype = input_ref;

            var param = '';
            if( order == 'first_asc' ) {
                if( checkbox_session ) {
                    var param = '&already_assinged=' + checkbox_session;
                }
            }
            
            var link = jQuery(this);
            jQuery.ajax({
                type: "POST",
                url: site_url+"/wp-admin/admin-ajax.php",
                data: "action=get_popup_pagination_data&datatype=" + datatype + "&page=" + page + "&goto=" + goto + "&display=" + display + "&order=" + order + "&search=" + search_text + "&current_page=" + wpc_current_page + param,
                dataType: "json",
                success: function(data){
                    if(data.html) {
                        link.parent().parent().find(".inside table tr td").html(data.html);
                        for(key in data.buttons) {
                            if( data.buttons.hasOwnProperty( key ) ) {
                                if(data.buttons[key]) {
                                    link.parent().find(".pagination_links[rel="+key+"]").show();
                                } else {
                                    link.parent().find(".pagination_links[rel="+key+"]").hide();
                                }
                            }
                        }
                        if(data.count > 1) {
                            link.parent().find(".page_num").html(data.page);
                        } else {
                            link.parent().find(".page_num").html('');
                        }
                        link.parent().parent().find(".inside table tr td input[type=radio][value="+checkbox_session+"]").attr('checked', true);
                    }
                    jQuery('.fancybox-inner').width('auto');
                    jQuery('.fancybox-wrap').width('auto');

                },
                error: function(data) {
                    link.parent().parent().find(".inside table tr td").html(data.html);
                }
            });
        });

        jQuery(".search_field").keypress(function(e) {
            if(e.which == 13) {
                var input_ref = jQuery(this).parent().find(".input_ref").val();
                var obj_str = jQuery("#"+input_ref).val();
                /*if(obj_str) {
                    checkbox_session = obj_str;
                    
                }
                jQuery("#"+input_ref).trigger('change'); */
                console.log(checkbox_session);
                search_text = jQuery(this).val();
                var goto = 'first';
                var page = 1;
                datatype = input_ref;
                display = jQuery(this).parent().find('.show').val();
                order = jQuery(this).parent().find('.order').val();
                
                var param = '';
                if( order == 'first_asc' ) {
                    if( checkbox_session ) {
                        var param = '&already_assinged=' + checkbox_session;
                    }
                }

                var link = jQuery(this);
                jQuery.ajax({
                    type: "POST",
                    url: site_url+"/wp-admin/admin-ajax.php",
                    data: "action=get_popup_pagination_data&datatype=" + datatype + "&page=" + page + "&goto=" + goto + "&display=" + display + "&order=" + order + "&search=" + search_text + "&current_page=" + wpc_current_page + param,
                    dataType: "json",
                    success: function(data){
                        if(data.html) {
                            link.parent().parent().find(".inside table tr td").html(data.html);
                            for(key in data.buttons) {
                                if( data.buttons.hasOwnProperty( key ) ) {
                                    if(data.buttons[key]) {
                                        link.parent().find(".pagination_links[rel="+key+"]").show();
                                    } else {
                                        link.parent().find(".pagination_links[rel="+key+"]").hide();
                                    }
                                }
                            }
                            if(data.count > 1) {
                                link.parent().find(".page_num").html(data.page);
                            } else {
                                link.parent().find(".page_num").html('');
                            }
                            link.parent().parent().find(".inside table tr td input[type=radio][value="+checkbox_session+"]").attr('checked', true);
                        }
                        jQuery('.fancybox-inner').width('auto');
                        jQuery('.fancybox-wrap').width('auto');

                    },
                    error: function(data) {
                        link.parent().parent().find(".inside table tr td").html(data.html);
                    }
                });
            }
        });

        jQuery(".pagination_links").click(function() {
            var input_ref = jQuery(this).parent().parent().find(".input_ref").val();
            var obj_str = jQuery("#"+input_ref).val();

            /*if(obj_str) {
                checkbox_session = obj_str    
                
            }
            jQuery("#"+input_ref).trigger('change'); */
            console.log(checkbox_session);
            var goto = jQuery(this).attr('rel');
            var page = jQuery(this).parent().children(".page_num").html();
            if( !(typeof(page) == 'number' || !isNaN(page)) )
                page = 1;
            display = jQuery(this).parents('#popup_block2').find('.show').val();
            order = jQuery(this).parents('#popup_block2').find('.order').val();
            if( jQuery(this).parents('#popup_block2').find('.search_field').val() != 'Search' ) {
                search_text = jQuery(this).parents('#popup_block2').find('.search_field').val();
            } else {
                search_text = '';
            }
            datatype = input_ref;
            
            var param = '';
            if( order == 'first_asc' ) {
                if( checkbox_session ) {
                    var param = '&already_assinged=' + checkbox_session;
                }
            }

            var link = jQuery(this);

            jQuery.ajax({
                type: "POST",
                url: site_url+"/wp-admin/admin-ajax.php",
                data: "action=get_popup_pagination_data&datatype=" + datatype + "&page=" + page + "&goto=" + goto + "&display=" + display + "&order=" + order + "&search=" + search_text + "&current_page=" + wpc_current_page + param,
                dataType: "json",
                success: function(data){
                    if(data.html) {
                        link.parent().parent().find(".inside table tr td").html(data.html);
                        for(key in data.buttons) {
                            if( data.buttons.hasOwnProperty( key ) ) {
                                if(data.buttons[key]) {
                                    link.parent().children(".pagination_links[rel="+key+"]").show();
                                } else {
                                    link.parent().children(".pagination_links[rel="+key+"]").hide();
                                }
                            }
                        }
                        link.parent().children(".page_num").html(data.page);
                        link.parent().parent().find(".inside table tr td input[type=radio][value="+checkbox_session+"]").attr('checked', true);
                    }
                    jQuery('.fancybox-inner').width('auto');
                    jQuery('.fancybox-wrap').width('auto');
                },
                error: function(data) {
                    link.parent().parent().find(".inside table tr td").html(data.html);
                }
            });
        });  

        //Cancel Assign block
        jQuery( ".cancel_popup2" ).click( function() {
            jQuery(this).parent().parent().find( 'input[type="checkbox"]' ).removeAttr( 'checked');
            jQuery.fancybox.close();
        });

        //Ok Assign block
        jQuery( ".ok_popup2" ).click( function() {
            var input_ref = jQuery(this).parent().find(".input_ref").val();
            ok_action = 1;
            if( jQuery("#"+input_ref).length && checkbox_session ) {
                jQuery("#"+input_ref).val(checkbox_session);        
                console.log(checkbox_session);
            }         
            
            if( checkbox_session ) {
                jQuery.ajax({
                    type: "POST",
                    url: site_url+"/wp-admin/admin-ajax.php",
                    data: "action=get_name&current_page=" + wpc_current_page + "&id=" + checkbox_session + "&type=" + input_ref,
                    dataType: "json",
                    success: function(data){
                        if(data.status && data.name) {
                            jQuery("#counter_" + input_ref).html("( " + data.name + " )");        
                        }
                    }
                });
            } else {
                jQuery("#counter_" + input_ref).html("(  )");
            }
            
            jQuery("#"+input_ref).trigger('change');
            jQuery(this).parent().find(".input_ref").val('');
            jQuery.fancybox.close();
        });  
    });