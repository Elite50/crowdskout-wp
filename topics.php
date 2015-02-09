<?php
	class CSKT_Request {
		public $url;
		public $topics;

		const CS_API_URL = 'https://api.crowdskout.com/pages/topics';

		public function __construct() {
			$this->url = get_permalink();

			$tags = explode(',', strip_tags(get_the_tag_list('', ',')));
			$cats = explode(',', strip_tags(get_the_category_list(',', '', get_the_ID())));
			$this->topics = array_filter( array_merge( $cats, $tags ) );
			/** merge cats and tags filtering out empty entries */
		}

		/**
		* @return array|WP_Error
		*/
		public function updateTopics()
		{
			$this->updatePostMeta(get_the_ID());
			return $this->makeRequest(self::CS_API_URL, 'PUT');
		}

		/**
		* @return array|WP_Error
		*/
		public function newTopics()
		{
			$this->updatePostMeta(get_the_ID());
			return $this->makeRequest(self::CS_API_URL, 'POST');
		}

		/**
		* function to determine if user on the edit post page on the back end
		*
		* @param \WP_Post $pagenow
		*
		* @return bool
		*/
		public static function isEditPage($pagenow)
		{
			// make sure we are on the backend
			if (!is_admin()) {
				return false;
			}

			// make sure user is editing a post as opposed to creating a new one
			return in_array( $pagenow, array('post.php', 'post-new.php') );
		}

		/**
		* @param int $id
		*
		* @return bool|int
		*/
		protected function updatePostMeta($id)
		{
			return add_post_meta($id, 'cskt_db_entry', 'true');
		}

		/**
		* @param string $crowdskoutUrl
		* @param string $type
		*
		* @return array|WP_Error
		*/
		protected function makeRequest($crowdskoutUrl, $type)
		{
			$cskt_request = json_encode(array(
				'url' => $this->url,
				'topics' => $this->topics,
			));

			/** Send Request to the Crowdskout Database */
			$cskt_api_host = $crowdskoutUrl;
			$request = new WP_Http;
			$result = $request->request($cskt_api_host, array('method' => $type, 'headers' => array('Content-Type' => 'application/json'), 'body' => $cskt_request, 'timeout' => apply_filters( 'http_request_timeout', 1 ), 'blocking' => false));

			return $result;
		}
	}

	// Add topics to crowdskout database
	if (!function_exists('cskt_request_function')) {
		function cskt_request_function() {
			global $pagenow;
			$csktRequest = new CSKT_Request;

			// When should I send a request to the cs DB?
			$in_db = get_post_meta(get_the_ID(), 'cskt_db_entry', true);
			if ((is_single() || CSKT_Request::isEditPage($pagenow)) && !($in_db)) { // if user is on a single post page and the post is not in cskt's database
				$csktRequest->newTopics();
			} elseif (CSKT_Request::isEditPage($pagenow) && $in_db) { // if user is on an edit post page and they updated a post that is already in cskt's db, update the cskt db entry with PUT request
				$csktRequest->updateTopics();
			}
		}

	/** hook cskt_request_action into the wordpress site */
		add_action('wp_head', 'cskt_request_function'); /** hook in after page's header */
		add_action('publish_post', 'cskt_request_function'); /** hook in after post has been saved */
	}
