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
	protected function view($atts) {
		/**
         * Attributes
         */
        $attr = shortcode_atts( array('name' => 'false'), $atts );
        if ($attr['name'] == 'true') {
            $name_checkbox = true;
        } else {
            $name_checkbox = false;
        }
		/**
		 * View file
		 */
		require CSKT_PLUGIN_SERVER_ROOT . '/views/email-tpl.php';
	}
	var $codeName = 'cskt_newsletter';
}
$newsletter = new CSKT_Shortcode_Newsletter();
$newsletter->build();
class CSKT_Shortcode_FB_Like extends CSKT_Shortcodery {
	protected function view($atts) {
		/**
		 * Attributes
		 */

		/**
		 * View file
		 */
		require CSKT_PLUGIN_SERVER_ROOT . '/views/fb-like-tpl.php';
	}
	var $codeName = 'cskt_fb_like';
}
$fb_like = new CSKT_Shortcode_FB_Like();
$fb_like->build();
class CSKT_Shortcode_FB_Share extends CSKT_Shortcodery {
	protected function view($atts) {
		/**
		 * Attributes
		 */

		/**
		 * View file
		 */
		require CSKT_PLUGIN_SERVER_ROOT . '/views/fb-share-tpl.php';
	}
	var $codeName = 'cskt_fb_share';
}
$fb_share = new CSKT_Shortcode_FB_Share();
$fb_share->build();
class CSKT_Shortcode_TW_Follow extends CSKT_Shortcodery {
	protected function view($atts) {
		/**
		 * Attributes
		 */

		/**
		 * View file
		 */
		require CSKT_PLUGIN_SERVER_ROOT . '/views/tw-follow-tpl.php';
	}
	var $codeName = 'cskt_tw_follow';
}
$tw_follow = new CSKT_Shortcode_TW_Follow();
$tw_follow->build();
class CSKT_Shortcode_TW_Share extends CSKT_Shortcodery {
	protected function view($atts) {
		/**
		 * Attributes
		 */

		/**
		 * View file
		 */
		require CSKT_PLUGIN_SERVER_ROOT . '/views/tw-share-tpl.php';
	}
	var $codeName = 'cskt_tw_share';
}
$tw_share = new CSKT_Shortcode_TW_Share();
$tw_share->build();