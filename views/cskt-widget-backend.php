<p>
	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Widget Title:' ); ?></label>
    <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">

	<div id='accordionmenu'>
		<ul id="sortable">
			<li class='active has-sub'>
				<a href='#'>
					<input class="checkbox" type="checkbox" <?php checked($nl_checkbox, true);?> id="<?php echo $this->get_field_id('nl_checkbox');?>" name="<?php echo $this->get_field_name('nl_checkbox');?>"/>
					<label for="<?php echo $this->get_field_id('nl_checkbox'); ?>">Add Newsletter Form</label>
					<span class="holder"></span>
				</a>
				<ul>
					<label for="<?php echo $this->get_field_id( 'nl_title' ); ?>"><?php _e( 'Newsletter Title:' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'nl_title' ); ?>" name="<?php echo $this->get_field_name( 'nl_title' ); ?>" type="text" value="<?php echo esc_attr( $nl_title ); ?>">
					<p></p>
					<input class="checkbox" type="checkbox" <?php checked($name_checkbox, true); ?> id="<?php echo $this->get_field_id('name_checkbox'); ?>" name="<?php echo $this->get_field_name('name_checkbox'); ?>" />
					<label for="<?php echo $this->get_field_id('name_checkbox'); ?>">Ask signup for name</label>
				</ul>
			</li>
			<li class='active has-sub'>
				<a href='#'>
					<input class="checkbox" type="checkbox" <?php checked($fb_like_checkbox, true); ?> id="<?php echo $this->get_field_id('fb_like_checkbox'); ?>" name="<?php echo $this->get_field_name('fb_like_checkbox'); ?>" />
					<label for="<?php echo $this->get_field_id('fb_like_checkbox'); ?>">Add Facebook Like Button</label>
					<span class="holder"></span>
				</a>
				<ul>
					<label for="<?php echo $this->get_field_id( 'fb_like_title' ); ?>"><?php _e( 'Facebook Like Button Title:' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'fb_like_title' ); ?>" name="<?php echo $this->get_field_name( 'fb_like_title' ); ?>" type="text" value="<?php echo esc_attr( $nl_title ); ?>">
					<p></p>
					<input class="checkbox" type="checkbox" <?php checked($name_checkbox, true); ?> id="<?php echo $this->get_field_id('name_checkbox'); ?>" name="<?php echo $this->get_field_name('name_checkbox'); ?>" />
					<label for="<?php echo $this->get_field_id('name_checkbox'); ?>">Ask signup for name</label>
				</ul>
			</li>
			<li class='active has-sub'>
				<a href='#'>
					<input class="checkbox" type="checkbox" <?php checked($fb_share_checkbox, true); ?> id="<?php echo $this->get_field_id('fb_share_checkbox'); ?>" name="<?php echo $this->get_field_name('fb_share_checkbox'); ?>" />
					<label for="<?php echo $this->get_field_id('fb_share_checkbox'); ?>">Add Facebook Share Button</label>
					<span class="holder"></span>
				</a>
				<ul>
					<label for="<?php echo $this->get_field_id( 'fb_share_title' ); ?>"><?php _e( 'Facebook Share Button Title:' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'fb_share_title' ); ?>" name="<?php echo $this->get_field_name( 'fb_share_title' ); ?>" type="text" value="<?php echo esc_attr( $nl_title ); ?>">
					<p></p>
				</ul>
			</li>
			<li class='active has-sub'>
				<a href='#'>
					<input class="checkbox" type="checkbox" <?php checked($tw_follow_checkbox, true); ?> id="<?php echo $this->get_field_id('tw_follow_checkbox'); ?>" name="<?php echo $this->get_field_name('tw_follow_checkbox'); ?>" />
					<label for="<?php echo $this->get_field_id('tw_follow_checkbox'); ?>">Add Twitter Follow Button</label>
					<span class="holder"></span>
				</a>
				<ul>
					<label for="<?php echo $this->get_field_id( 'tw_follow_title' ); ?>"><?php _e( 'Twitter Follow Button Title:' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'tw_follow_title' ); ?>" name="<?php echo $this->get_field_name( 'tw_follow_title' ); ?>" type="text" value="<?php echo esc_attr( $nl_title ); ?>">
					<p></p>
				</ul>
			</li>
			<li class='active has-sub'>
				<a href='#'>
					<input class="checkbox" type="checkbox" <?php checked($tw_share_checkbox, true); ?> id="<?php echo $this->get_field_id('tw_share_checkbox'); ?>" name="<?php echo $this->get_field_name('tw_share_checkbox'); ?>" />
					<label for="<?php echo $this->get_field_id('tw_share_checkbox'); ?>">Add Twitter Share Button</label>
					<span class="holder"></span>
				</a>
				<ul>
					<label for="<?php echo $this->get_field_id( 'tw_share_title' ); ?>"><?php _e( 'Twitter Share Button Title:' ); ?></label>
					<input class="widefat" id="<?php echo $this->get_field_id( 'tw_share_title' ); ?>" name="<?php echo $this->get_field_name( 'tw_share_title' ); ?>" type="text" value="<?php echo esc_attr( $nl_title ); ?>">
					<p></p>
				</ul>
			</li>
		</ul>
	</div>
</p>