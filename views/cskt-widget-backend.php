<p>
    <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
    <br/><br/>
    <input class="checkbox" type="checkbox" <?php checked($name_checkbox, true); ?> id="<?php echo $this->get_field_id('name_checkbox'); ?>" name="<?php echo $this->get_field_name('name_checkbox'); ?>" />
    <label for="<?php echo $this->get_field_id('name_checkbox'); ?>">Ask signup for name</label>
</p>