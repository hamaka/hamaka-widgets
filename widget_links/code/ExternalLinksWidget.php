<?php
	class ExternalLinksWidget extends WidgetBaseRight {
		private static $db = array(
			"LinkTxt01"	=> "VarcharExtended(256)",
			"LinkUrl01"	=> "VarcharExtended(256)",
			"LinkTxt02"	=> "VarcharExtended(256)",
			"LinkUrl02"	=> "VarcharExtended(256)",
			"LinkTxt03"	=> "VarcharExtended(256)",
			"LinkUrl03"	=> "VarcharExtended(256)",
			"LinkTxt04"	=> "VarcharExtended(256)",
			"LinkUrl04"	=> "VarcharExtended(256)",
			"LinkTxt05"	=> "VarcharExtended(256)",
			"LinkUrl05"	=> "VarcharExtended(256)",
		);

		private static $title 			= "External links widget";
		private static $cmsTitle 		= "External links widget";
		private static $description	= "";

		public function getCMSFields() {
			return new FieldList(
				new TextField('LinkTxt01', 					_t('Widgets.LBL_LINK_TXT', 'Text for link').' 1'),
				new TextField('LinkUrl01',					_t('Widgets.LBL_LINK', 'Link (start with http://)')),
				new TextField('LinkTxt02', 					_t('Widgets.LBL_LINK_TXT', 'Text for link').' 2'),
				new TextField('LinkUrl02',					_t('Widgets.LBL_LINK', 'Link (start with http://)')),
				new TextField('LinkTxt03', 					_t('Widgets.LBL_LINK_TXT', 'Text for link').' 3'),
				new TextField('LinkUrl03',					_t('Widgets.LBL_LINK', 'Link (start with http://)')),
				new TextField('LinkTxt04', 					_t('Widgets.LBL_LINK_TXT', 'Text for link').' 4'),
				new TextField('LinkUrl04',					_t('Widgets.LBL_LINK', 'Link (start with http://)')),
				new TextField('LinkTxt05', 					_t('Widgets.LBL_LINK_TXT', 'Text for link').' 5'),
				new TextField('LinkUrl05',					_t('Widgets.LBL_LINK', 'Link (start with http://)'))
			);
		}
	}


	class ExternalLinksWidget_Controller extends WidgetBaseRight_Controller {
		public function getLinks() {
			$iNumLinks = 5;
			$iSetLinks = 0;
			$alLinks = new ArrayList();

			for ($iLink = 1; $iLink < ($iNumLinks + 1); $iLink++) {
				// Make sure the iterator is always two characters long, padded with a zero if necessary
				$iFieldNum = str_pad($iLink, 2, '0', STR_PAD_LEFT);

				// If the link is related to a page, add it to the ArrayList
				if ($this->{'LinkUrl'.$iFieldNum}) {
					$alLinks->push(new ArrayData(array(
						'Label' => $this->{'LinkTxt'.$iFieldNum},
						'URL' => $this->{'LinkUrl'.$iFieldNum}
					)));

					$iSetLinks++;
				}
			}

			if ($iSetLinks < 1) { return false; }

			return $alLinks;
		}
	}