<script type="text/javascript">
jQuery(function(event) {
    jQuery("#save-settings").bind("click", function() {
        jQuery.post(ajaxurl, jQuery('#um_settings').serialize()+"&action=um_save_settings"
        , function() {
            jQuery("#ajax-response").html('<div class="message updated fade"><p><?php _e("settings saved", "ultimatemenu")?></p></div>');
            jQuery("#ajax-response div").delay(3000).hide("slow");
        });
    });
});
</script>

<div class="um_container">
    <div class="um_wrap">
        <form method="post" action="" id="um_settings" enctype="multipart/form-data">
            <h2>General Settings</h2>
            <table class="form-table">

                <tbody>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <label for="">Add logo</label>
                        </th>
                        <td class="">
                            <input type="checkbox" name="um_enable_logo" value="Yes" <?php checked(get_option('um_enable_logo'), 'Yes')?>>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row" class="titledesc">
                            <label for="">Select Theme</label>
                        </th>
                        <td class="">
                            <label for="blue">
                                <input type="radio" name="um_menu_theme" value="blue" id="blue" <?php checked(get_option('um_menu_theme'), 'blue')?>/>Blue
                            </label>
                            <br>
                            <label for="red">
                                <input type="radio" name="um_menu_theme" value="red" <?php checked(get_option('um_menu_theme'), 'red')?> id="red" />Red
                            </label>
                            <br>
                            <label for="brown">
                                <input type="radio" name="um_menu_theme" value="brown" <?php checked(get_option('um_menu_theme'), 'brown')?> id="brown" />Brown
                            </label>
                            <br>
                            <label for="cyan">
                                <input type="radio" name="um_menu_theme" value="cyan" <?php checked(get_option('um_menu_theme'), 'cyan')?> id="cyan" />Cyan
                            </label>
                            <br>
                            <label for="orange">
                                <input type="radio" name="um_menu_theme" value="orange" <?php checked(get_option('um_menu_theme'), 'orange')?> id="orange" />Orange
                            </label>
                            <br>
                            <label for="violet">
                                <input type="radio" name="um_menu_theme" value="violet" <?php checked(get_option('um_menu_theme'), 'violet')?>id="violet" />Violet
                            </label>
                            <br>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">
                <div id="ajax-response"></div>
<?php if (!isset($GLOBALS['hide_save_button'])):?>
                <input name="save-settings" id="save-settings" class="button-primary" type="button" value="<?php _e('Save changes', 'deal-of-day');?>" />
<?php endif;?>
</p>
        </form>
    </div>
</div>
