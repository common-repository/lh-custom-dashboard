<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $this->hidden_field_name; ?>" value="Y" />

<p>
<label for="<?php echo $this->favicon_field_name; ?>"><?php _e("Favicon url:", $this->namespace); ?></label>
<input type="hidden" name="<?php echo $this->favicon_field_name; ?>"  id="<?php echo $this->favicon_field_name; ?>" value="<?php echo $this->site_options[$this->favicon_field_name]; ?>" size="10" />
<input type="url" name="<?php echo $this->favicon_field_name; ?>-url" id="<?php echo $this->favicon_field_name; ?>-url" value="<?php echo wp_get_attachment_url($this->site_options[$this->favicon_field_name]); ?>" size="50" />
<input type="button" class="button" name="<?php echo $this->favicon_field_name; ?>-upload_button" id="<?php echo $this->favicon_field_name; ?>-upload_button" value="Upload/Select Image" />
</p>


<p>
<?php _e("Admin Footer text (left side);", $this->namespace ); ?> 
<input type="text" name="<?php echo $this->admin_footer_text_field_name; ?>" value="<?php echo $this->site_options[$this->admin_footer_text_field_name]; ?>" size="50" />
</p>

<p>
<?php _e("Update Footer text (right side);", $this->namespace ); ?> 
<input type="text" name="<?php echo $this->update_footer_text_field_name; ?>" id="<?php echo $this->update_footer_text_field_name; ?>" value="<?php 
echo $this->site_options[$this->update_footer_text_field_name]; ?>" size="50" />
</p>


<p class="submit">
<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
</p>

</form>