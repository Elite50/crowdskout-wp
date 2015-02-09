<?php
	if ($comments == 'true') {
		?><div class="fb-like cskt-fb-like"
		    data-href="<?php echo $pagename;?>"
		    data-layout="<?php echo $layout;?>"
		    data-action="<?php echo $action;?>"
		    data-show-faces="<?php echo $show_faces;?>"
		    data-share="<?php echo $share;?>"
			<?php if (!($width == '')) { ?>style="width:<?php echo $width;?>px"<?php }?>
		></div><?php
	} elseif ($comments == 'false') {
		$facebookAppId = get_option('cskt_facebook_app_id');
		if ($show_faces == 'true') { $height = 80; }
		elseif ($show_faces == 'false') { $height = 20; }

		$output = '<iframe src="//www.facebook.com/plugins/like.php?href='.$pagename.'&amp;layout='.$layout.'&amp;action='.$action.'&amp;show_faces='.$show_faces.'&amp;share='.$share.'&amp;height='.$height.'&amp;appId='.$facebookAppId.'" scrolling="no" frameborder="0" class=facebook-like-button style="border:none; overflow:hidden; height:'.$height.'px; width:'.$width.'px; allowTransparency="true"></iframe>';
		echo $output;
	}
?>