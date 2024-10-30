<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
<form name="form1" method="post" action="">
<?php wp_nonce_field( self::return_plugin_namespace()."-backend_nonce", self::return_plugin_namespace()."-backend_nonce", false ); ?>
<table class="form-table">
<tr valign="top">
<th scope="row"><label for="<?php echo self::return_favicon_field_name(); ?>"><?php _e("Favicon url:", self::return_plugin_namespace()); ?></label></th>
<td>
<input type="hidden" name="<?php echo self::return_favicon_field_name(); ?>"  id="<?php echo self::return_favicon_field_name(); ?>" value="<?php if (isset($options[self::return_favicon_field_name()])){ 
echo $options[self::return_favicon_field_name()]; 

}
?>" size="10" />
<input type="url" name="<?php echo self::return_favicon_field_name(); ?>-url" id="<?php echo self::return_favicon_field_name(); ?>-url" value="<?php
if (isset($options[self::return_favicon_field_name()])){ 

echo wp_get_attachment_url($options[self::return_favicon_field_name()]); 

}
?>" size="50" />
<input type="button" class="button" name="<?php echo self::return_favicon_field_name(); ?>-upload_button" id="<?php echo self::return_favicon_field_name(); ?>-upload_button" value="Upload/Select Image" />
</td>
</tr>


<tr valign="top">
<th scope="row">
<label for="<?php echo self::return_admin_footer_text_field_name(); ?>">
<?php _e("Admin Footer text (left side);", self::return_plugin_namespace()); ?>
</label>
</th>
<td>
<input type="text" name="<?php echo self::return_admin_footer_text_field_name(); ?>" id="<?php echo self::return_admin_footer_text_field_name(); ?>" value="<?php if (!empty($options[self::return_admin_footer_text_field_name()])){ echo $options[self::return_admin_footer_text_field_name()]; } ?>" size="50" />
</td>
</tr>

<tr valign="top">
<th scope="row">
<label for="<?php echo self::return_update_footer_text_field_name(); ?>">
<?php _e("Update Footer text (right side);", self::return_plugin_namespace() ); ?>
</label>
</th>
<td>
<input type="text" name="<?php echo self::return_update_footer_text_field_name(); ?>" id="<?php echo self::return_update_footer_text_field_name(); ?>" value="<?php if (!empty($options[self::return_update_footer_text_field_name()])){ echo $options[self::return_update_footer_text_field_name()]; } ?>" size="50" />
</td>
</tr>
</table>
<?php submit_button( 'Save Changes' ); ?>
</form>