<a
	href="https://twitter.com/share"
	class="twitter-share-button"
	data-url="<?php echo $url;?>"
	data-text="<?php echo $text;?>"
	data-via="<?php echo $via;?>"
	<?php if ($size == 'large') { echo 'data-size="large"'; }?>
	<?php if (!($recommend == '')) { echo 'data-related="'.$recommend.'"'; }?>
	<?php if ($show_count == '') { echo 'data-show-count="false"'; }?>
	<?php if (!($hashtags == '')) { echo 'data-hashtags="'.$hashtags.'"'; }?>>
	Tweet
</a>