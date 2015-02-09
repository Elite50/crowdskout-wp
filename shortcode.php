<?php

interface CSKT_Shortcode_Interface
{
	public function build();
	public function execute($atts);
}

abstract class CSKT_Shortcodery implements CSKT_Shortcode_Interface
{
	public function build()
	{
		add_shortcode($this->codeName, array($this, 'execute'));
	}
	public function execute($atts)
	{
		ob_start();
		$this->view($atts);
		return ob_get_clean();
	}
	abstract protected function view($atts);
}

class CSKT_Shortcode_Newsletter extends CSKT_Shortcodery {
	var $codeName = 'cskt_newsletter';
	protected function view($atts) {
		/**
         * Attributes
         */
        $attr = shortcode_atts( array('name' => 'false'), $atts );

        if ($attr['name'] == 'true') { $name_checkbox = true; }
        else { $name_checkbox = false; }

		/**
		 * View file
		 */
		require CSKT_PLUGIN_SERVER_ROOT . '/views/email-tpl.php';
	}
}

class CSKT_Shortcode_FB_Like extends CSKT_Shortcodery {
	var $codeName = 'cskt_fb_like';
	protected function view($atts) {
		/** Attributes */
		$attr = shortcode_atts( array('pagename' => '', 'width' => '', 'layout' => 'button', 'action' => 'like', 'show_faces' => 'false', 'share' => 'false', 'comments' => 'true'), $atts );

		if ($attr['pagename'] == '') { $pagename = get_option('cskt_facebook_page_url'); }
		else { $pagename = $attr['pagename']; }
		$width = $attr['width'];
		$layout = $attr['layout'];
		$action = $attr['action'];
		if ($attr['show_faces'] == 'true') { $show_faces = 'true'; }
		else { $show_faces = 'false'; }
		if ($attr['share'] == 'true') { $share = 'true'; }
		else { $share = 'false'; }
		if ($attr['comments'] == 'false') { $comments = 'false'; }
		else { $comments = 'true'; }

		/** View file */
		require CSKT_PLUGIN_SERVER_ROOT . '/views/fb-like-tpl.php';
	}
}

class CSKT_Shortcode_FB_Share extends CSKT_Shortcodery {
	var $codeName = 'cskt_fb_share';
	protected function view($atts) {
		/** Attributes */
		$attr = shortcode_atts( array('pagename' => '', 'layout' => 'button'), $atts  );

		if ($attr['pagename'] == '') { $pagename = get_permalink(); }
		else { $pagename = $attr['pagename']; }
		$layout = $attr['layout'];


		/** View file */
		require CSKT_PLUGIN_SERVER_ROOT . '/views/fb-share-tpl.php';
	}
}
class CSKT_Shortcode_TW_Follow extends CSKT_Shortcodery {
	var $codeName = 'cskt_tw_follow';
	protected function view($atts) {
		/** Attributes */
		$attr = shortcode_atts( array('user' => '', 'show_username' => 'false', 'size' => '', 'show_count' => 'false' ), $atts );

		if ($attr['user'] == '') { $user = get_option('cskt_twitter_handle'); }
		else { $user = $attr['user']; }
		$show_username = $attr['show_username'];
		$size = $attr['size'];
		$show_count = $attr['show_count'];

		/** View file */
		require CSKT_PLUGIN_SERVER_ROOT . '/views/tw-follow-tpl.php';
	}
}

class CSKT_Shortcode_TW_Share extends CSKT_Shortcodery {
	var $codeName = 'cskt_tw_share';
	protected function view($atts) {
		/** Attributes */
		$attr = shortcode_atts( array('url' => '', 'text' => '', 'via' => '', 'size' => '', 'show_count' => '', 'related' => '', 'hashtags' => ''), $atts );

		if ($attr['url'] == '') { $url = wp_get_shortlink(); }
		else { $url = $attr['url']; }
		$text = $attr['text'];
		if ($attr['via'] == '') { $via = get_option('cskt_twitter_handle'); }
		else { $via = $attr['via']; }
		$size = $attr['size'];
		$show_count = $attr['show_count'];
		$recommend = $attr['related'];
		$hashtags = $attr['hashtags'];

		/** View file */
		require CSKT_PLUGIN_SERVER_ROOT . '/views/tw-share-tpl.php';
	}
}

class CSKT_Shortcode_Factory {
	public static function create($codeName) {
		switch ($codeName) {
			case 'cskt_newsletter':
				$cskt_newsletter = new CSKT_Shortcode_Newsletter();
				$cskt_newsletter->build();
				break;
			case 'cskt_fb_like':
				$cskt_fb_like = new CSKT_Shortcode_FB_Like();
				$cskt_fb_like->build();
				break;
			case 'cskt_fb_share':
				$cskt_fb_share = new CSKT_Shortcode_FB_Share();
				$cskt_fb_share->build();
				break;
			case 'cskt_tw_follow':
				$cskt_tw_follow = new CSKT_Shortcode_TW_Follow();
				$cskt_tw_follow->build();
				break;
			case 'cskt_tw_share':
				$cskt_tw_share = new CSKT_Shortcode_TW_Share();
				$cskt_tw_share->build();
				break;
		}
	}
}