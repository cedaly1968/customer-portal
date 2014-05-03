<html>
    <head>
    	<title>Select options</title>
        <link rel="stylesheet" type="text/css" href="<?php echo plugins_url('/css/basic.css', __FILE__); ?>">
        <script type="text/javascript" src="<?php echo includes_url(); ?>js/tinymce/tiny_mce_popup.js"></script>
        <script type="text/javascript" src="<?php echo includes_url(); ?>js/jquery/jquery.js"></script>
        <script type="text/javascript" src="<?php echo plugins_url('/js/dialog_box.js', __FILE__); ?>"></script> 
        <script type="text/javascript" src="<?php echo plugins_url('/js/jquery.validate.js', __FILE__); ?>"></script>
        <?php
        if(floatval(get_bloginfo("version")) > floatval("3.5.2"))
        {
        ?>
            <script type="text/javascript" src="<?php echo plugins_url('/js/jquery-migrate.js', __FILE__); ?>"></script>
        <?php
        }
        ?>
    </head>
    <body>  
        <form id="add_shortcode" name="add_shortcode" onsubmit="SWPTInsertDialog.insert();return false;" method="post" action="#" class="frm_shortcode">
            <textarea name="shortcode"  id="shortcode"  readonly="readonly" class="hide" ></textarea>
            <div class="cls_testi">
                <label for="no_of_testi" class="lbl_testi">No. of testimonials <span class="chkRequired">*</span></label>
                <input type="text" value="" id="no_of_testi" name="no_of_testi" class="input_testi required digits" onkeypress="return isNumber(event)" maxlength="2">
            </div>
            <div class="cls_testi">
                <label for="order" class="lbl_order">Order <span class="chkRequired">*</span></label>
                <input type="radio" name="order" id="asc_order" value="asc" class="radio_order asc_radio_order order" >
                <label for="asc_order">Ascending</label>
                <input type="radio" name="order" id="desc_order" value="desc" class="desc_radio_order order" checked> 
                <label for="desc_order">Descending</label>
            </div>
            <div class="cls_testi">
                <label for="orderby" class="lbl_order">Order by <span class="chkRequired">*</span></label>
                <input type="radio" name="orderby" id="order_by_id" value="id" class="radio_order_by orderby" checked>
                <label for="order_by_id">ID</label>
                <input type="radio" name="orderby" id="order_by_company" value="company" class="orderby"> 
                <label for="order_by_company">Company</label>
                 <input type="radio" name="orderby" id="order_by_description" value="description" class="orderby"> 
                <label for="order_by_description">Description</label>
            </div>
            <div class="cls_testi">
                <label for="effects" class="lbl_effects">Effects <span class="chkRequired">*</span></label>
                <select name="effects" id="effects" class="input_effects required">
                <?php
                    $arrEffect = array("none","blindX","blindY","blindZ","curtainY","fade","fadeZoom","growY","scrollUp","scrollDown","scrollLeft","scrollRight","scrollHorz","scrollVert","toss","turnUp","turnDown","zoom"); 
                    foreach($arrEffect as $strKey => $strValue)
                    {
                ?>
                <option value="<?php echo $strValue; ?>" <?php if($effect==$strValue) { ?> selected=selected <?php } ?>><?php echo ucfirst($strValue); ?></option>
                <?php } ?>
            </select>
            </div>
            <div class="cls_testi">
                <label for="time" class="lbl_time">Duration<span class="chkRequired">*</span></label>
                <input type="text" value="" id="time" maxlength="5" name="time" class="input_time required digits" onkeypress="return isNumber(event)">(milliseconds)
            </div>
            <p class="submit">    
                <label class="lbl_submit">&nbsp;</label>       
                <input type="submit" value="Insert" class="btn_add" id="insert" name="insert">
            </p>
        </form>   
    </body>
</html>