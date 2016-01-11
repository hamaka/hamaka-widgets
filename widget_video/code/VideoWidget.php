<?php

class VideoWidget extends WidgetBaseRight {
	private static $db = array(
		"Header" 		=> "Varchar(100)",
		"VideoUrl"	=> "VarcharExtended(256)"
	);

	private static $title 			= "Video widget";
	private static $cmsTitle 		= "Video widget";
	private static $description	= "";

	public function getCMSFields() {
		return new FieldList(
			new TextField('Header', 	_t('Widgets.LBL_TITLE', 'Title')),
			new TextField('VideoUrl', _t('Widgets.LBL_VIDEO_URL', 'The url of the YouTube page'))
		);
	}
}

class VideoWidget_Controller extends WidgetBaseRight_Controller {
	// This dissects a given YouTube URL (no matter what it looks
	// like, given "v=" is in it) to extract the video's unique code
	function YouTubeURL() {
		// Break the URL apart into sections (host, path, query, etc.)
		$aURL = parse_url($this->VideoUrl);

		if (isset($aURL['query'])) {
			// Break the query part of the URL apart into key-value pairs for each variable
			// and select the corresponding index for the YouTube video ID
			parse_str($aURL['query'], $aQueryString);
			$sVideoID = $aQueryString['v'];

			return $sVideoID;
		} else {
			return false;
		}
	}
}