<?php

class ImageWidget extends WidgetBaseLeft {

	private static $db = array(
		"LinkTxt"	=> "VarcharExtended(256)",
		"LinkExternalUrl"	=> "VarcharExtended(256)",
		'LinkType' 	=> 'Enum("none, internal, external","none")'
	);

	private static $defaults = array(
		'LinkTxt' => 'Lees meer'
	);

	private static $title 			= "Afbeelding";
	private static $cmsTitle 		= "Afbeelding";
	private static $description	= "Toon een afbeelding die linkt naar een pagina op de eigen of een externe website.";

	private static $has_one = array(
		'Img' 				=> 'Image',
		'InternalUrl' => 'Page'
	);

	public function getCMSFields() {
		$oFieldLinkTxt = new TextField('LinkTxt', 'Externe link (opent in nieuw venster, begin met http://)', $this->LinkTxt);
		$fldExternalLink = new TextField('LinkExternalUrl', 'Externe link (opent in nieuw venster, begin met http://)', $this->LinkExternalUrl);
		$fldInternalLink = new SimpleTreeDropdownField('InternalUrlID', 'Interne link', 'SiteTree', $this->InternalUrlID, null, 'Kies een pagina');

		$aSelectionGroupItems = array(
			new SelectionGroup_Item( 'none', new LiteralField('nolink',''), 'Geen link' ),
			new SelectionGroup_Item( 'internal', $fldInternalLink, 'Interne link' ),
			new SelectionGroup_Item( 'external', $fldExternalLink, 'Externe link' )
		);

		$fldSelectionGroup = new SelectionGroup('LinkType', $aSelectionGroupItems);

		if ($this->Created) {
			$oImgSelectField = new SimpleTreeDropdownField('ImgID', '', 'File', '', null, 'Kies een afbeelding');
			$oImgSelectField->setType(SimpleTreeDropdownField::TYPE_FOLDERS_AS_HEADINGS);
		} else {
			$oImgSelectField = new LiteralField("NoImg", '<div class="message notice" style="background-color: #f0f8fc; border-color: #93cde8;"><p>Er kan een afbeelding worden geselecteerd nadat de widget is opgeslagen</p></div>' );
		}

		$oFields = new FieldList(
			$oImgSelectField,
			new TextField('LinkTxt', 'Bijschrift'),
			new HeaderField('hdrLink', 'Link', 3),
			$fldSelectionGroup
		);

		return $oFields;
	}

	public function onBeforeWrite()
	{
		parent::onBeforeWrite();

		if(isset($_POST['LinkExternalUrl']))	$this->LinkExternalUrl = $_POST['LinkExternalUrl'];
		if(isset($_POST['InternalUrlID']))		$this->InternalUrlID = $_POST['InternalUrlID'];
	}

}

class ImageWidget_Controller extends WidgetBaseLeft_Controller {
	// zie WidgetBaseRight voor getWidgLink()
}