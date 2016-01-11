<?php
	class TwitterWidget extends WidgetBaseRight {
		private static $db = array(
			'TwitterHandle' => 'Varchar(100)',
			'WidgetID' => 'Varchar(50)'
		);

		private static $title = 'Twitter';
		private static $cmsTitle = 'Twitter';
		private static $description = 'Widget waarin de laatste tweets getoond worden.';

		private static $defaults = array(
			'Header' 					=> 'MATS op twitter',
			'TwitterHandle' 	=> 'kiesMATS',							//widget maken via @haamaakaa op https://twitter.com/settings/widgets
			'WidgetID' 				=> '321256107903422464'			//widget maken via @haamaakaa op https://twitter.com/settings/widgets
		);

		public function getCMSFields() {
			$oFields = parent::getCMSFields();

			return $oFields;
		}
	}


	class TwitterWidget_Controller extends WidgetBaseRight_Controller {
	}