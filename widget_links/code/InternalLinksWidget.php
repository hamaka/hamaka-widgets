<?php

class InternalLinksWidget extends WidgetBaseRight {
	private static $db = array(
		"LinkTxt01"	=> "VarcharExtended(256)",
		"LinkTxt02"	=> "VarcharExtended(256)",
		"LinkTxt03"	=> "VarcharExtended(256)",
		"LinkTxt04"	=> "VarcharExtended(256)",
		"LinkTxt05"	=> "VarcharExtended(256)"
	);

	private static $has_one = array(
		'LinkUrl01' => 'Page',
		'LinkUrl02' => 'Page',
		'LinkUrl03' => 'Page',
		'LinkUrl04' => 'Page',
		'LinkUrl05' => 'Page'
	);

	private static $title 			= "Internal links widget";
	private static $cmsTitle 		= "Internal links widget";
	private static $description	= "";

	public function getCMSFields() {
		return new FieldList(
			//new HeaderField('LinkTxt01Hdr', 		'Link 1'),
			new TextField('LinkTxt01', 					_t('Widgets.LBL_LINK_TXT', 'Text for link').' 1'),
		  new SimpleTreeDropdownField('LinkUrl01ID', '', 'SiteTree', '', null, _t('Widgets.LBL_INTERNAL_LINK_SELECT', 'Select a page')),
			//new HeaderField('LinkTxt01Hdr', 		'Link 2'),
			new TextField('LinkTxt02', 					_t('Widgets.LBL_LINK_TXT', 'Text for link').' 2'),
			new SimpleTreeDropdownField('LinkUrl02ID', '', 'SiteTree', '', null, _t('Widgets.LBL_INTERNAL_LINK_SELECT', 'Select a page')),
			//new HeaderField('LinkTxt01Hdr', 		'Link 3'),
			new TextField('LinkTxt03', 					_t('Widgets.LBL_LINK_TXT', 'Text for link').' 3'),
			new SimpleTreeDropdownField('LinkUrl03ID', '', 'SiteTree', '', null, _t('Widgets.LBL_INTERNAL_LINK_SELECT', 'Select a page')),
			//new HeaderField('LinkTxt01Hdr', 		'Link 4'),
			new TextField('LinkTxt04', 					_t('Widgets.LBL_LINK_TXT', 'Text for link').' 4'),
			new SimpleTreeDropdownField('LinkUrl04ID', '', 'SiteTree', '', null, _t('Widgets.LBL_INTERNAL_LINK_SELECT', 'Select a page')),
			//new HeaderField('LinkTxt01Hdr', 		'Link 5'),
			new TextField('LinkTxt05', 					_t('Widgets.LBL_LINK_TXT', 'Text for link').' 5'),
			new SimpleTreeDropdownField('LinkUrl05ID', '', 'SiteTree', '', null, _t('Widgets.LBL_INTERNAL_LINK_SELECT', 'Select a page'))
		);
	}
}

class InternalLinksWidget_Controller extends WidgetBaseRight_Controller {
	public function getLinks() {
		$iNumLinks = 5;
		$iSetLinks = 0;
		$alLinks = new ArrayList();

		for ($iLink = 1; $iLink < ($iNumLinks + 1); $iLink++) {
			// Make sure the iterator is always two characters long, padded with a zero if necessary
			$iFieldNum = str_pad($iLink, 2, '0', STR_PAD_LEFT);

			// If the link is related to a page, add it to the ArrayList
			if ($this->{'LinkUrl'.$iFieldNum.'ID'}) {
				$alLinks->push(new ArrayData(array(
					'Label' => $this->{'LinkTxt'.$iFieldNum},
					'URL' => $this->getComponent('LinkUrl'.$iFieldNum)->Link()
				)));

				$iSetLinks++;
			}
		}

		if ($iSetLinks < 1) { return false; }

		return $alLinks;
	}
}