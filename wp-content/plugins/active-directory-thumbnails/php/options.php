<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Omar
 * Date: 25/06/12
 * Time: 7:06 PM
 * To change this template use File | Settings | File Templates.
 */

if($_POST['adt_hidden'] == 'Y') {
    $adt_ad_thumbnail = $_POST['adt_adfield'];
    update_option('adt_ad_thumbnail', $adt_ad_thumbnail);
} else {
    $adt_ad_thumbnail = get_option('adt_ad_thumbnail');
}
?>

<script type="text/javascript" src="<?php echo plugins_url() ?>/active-directory-thumbnails/js/jquery-1.7.2.min.js"></script>
<link href="<?php echo plugins_url() ?>/active-directory-thumbnails/css/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo plugins_url() ?>/active-directory-thumbnails/js/jquery-ui.min.js"></script>

<script type="text/javascript">
    var userIDs = '';
    var totalUsers = '';
    var i = 0;

    $(document).ready(function() {
        $("#progressbar").progressbar({ value: 0 });
    });

    function create_picture() {
        alert("Please do not close the browser while this process is ongoing. Please press OK to start.")
        userIDs = <?php echo json_encode(adt_get_all_users()); ?>;
        totalUsers = userIDs.length;
        run_loop_to_create_image(userIDs[i]);
    }

    function run_loop_to_create_image(userid) {
        $.ajax({
            async: true,
            type: "POST",
            url: '<?php echo plugins_url() ?>/active-directory-thumbnails/php/pic-process.php?user_id=' + userid,
            success: function(data)
            {
                if (i < totalUsers) {
                    run_loop_to_create_image(userIDs[i]);
                    $( "#progressbar" ).progressbar( "option", "value", Math.round((i/totalUsers)*100) );
                    i++;
                    $("#current_user_id").html(userid);
                } else {
                    $( "#progressbar" ).progressbar( "option", "value", 100 );
                    alert("Done!");
                    $("#current_user_id").html("Done!");
                }
            }
        });
    }

    function create_single_user_picture() {
        var user_id = $("#adt_user_dropdown option:selected").val();
        var user_name = $("#adt_user_dropdown option:selected").text()
        $.ajax({
            async: true,
            type: "POST",
            url: '<?php echo plugins_url() ?>/active-directory-thumbnails/php/pic-process.php?user_id=' + user_id,
            success: function(data)
            {
                alert("Done! Created image for " + user_name);
            }
        });
    }

</script>

<div class="wrap">
    <?php    echo "<h2>" . __( 'Active Directory Thumbnails Options', 'adt_trdom' ) . "</h2>"; ?>

    <form name="adt_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="adt_hidden" value="Y">
        <?php    echo "<h4>" . __( 'Active Directory Settings', 'adt_trdom' ) . "</h4>"; ?>
        <p><?php _e("AD field name for thumbnail: " ); ?><input type="text" name="adt_adfield" value="<?php echo $adt_ad_thumbnail; ?>" size="30"><?php _e(" ex: adi_thumbnailphoto" ); ?></p>
        <p class="submit">
            <input type="submit" name="Submit" value="<?php _e('Update Options', 'adt_trdom' ) ?>" />
        </p>
    </form>

    <hr />

    <?php    echo "<h4>" . __( 'Active Directory Create Pictures', 'adt_trdom' ) . "</h4>"; ?>
    <div id="progressbar"></div>
    <br />
    <input type="button" class="button" onclick="create_picture()" id="create_photos" name="create_photos" value="<?php _e('Create Photos', 'adt_trdom' ) ?>" />
    <br />
    <h5 style="display: inline;">Currently creating photo for user id: </h5><span id="current_user_id"></span>

    <hr />

    <?php    echo "<h4>" . __( 'Active Directory Generate Single User Picture', 'adt_trdom' ) . "</h4>"; ?>
    <?php wp_dropdown_users(array('name' => 'author', 'id'=> 'adt_user_dropdown')); ?>
    <input type="button" class="button" onclick="create_single_user_picture()" id="create_single_photo" name="create_single_photo" value="<?php _e('Create Photo', 'adt_trdom' ) ?>" />

    <div id="current_photo"></div>
    <br />

    <hr />
    <?php    echo "<h4>" . __( 'Bulk Script URL for Scheduled Tasks', 'adt_trdom' ) . "</h4>"; ?>
    Please run the URL once manually to see if you get a fatal error regarding memory.<br />
    This is caused by the max memory limit in PHP.<br />
    Increase the max memory to ensure this script runs to completion.<br />
    <?php
        $adt_bulk_url = plugins_url() . '/active-directory-thumbnails/php/bulk-scheduled-process.php';
        echo '<a href="' . $adt_bulk_url . ' ">' . $adt_bulk_url . '</a>';
    ?>

    <hr />
    <h4>Meta Field</h4>
    <h5>The meta field for the user photo: </h5>adt_user_photo_url
</div>
