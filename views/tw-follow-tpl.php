<a
	href="https://twitter.com/<?php echo $user;?>"
	class="twitter-follow-button"
	data-show-count="<?php echo $show_count;?>"
	<?php if ($size == 'large') { echo 'data-size="large"'; }?>
	data-show-screen-name="<?php echo $show_username;?>">
	Follow @<?php echo $user;?>
</a>