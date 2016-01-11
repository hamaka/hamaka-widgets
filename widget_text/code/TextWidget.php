<?php

class TextWidget extends WidgetBaseLeft {

	private static $title 			= "Tekstwidget";
	private static $cmsTitle 		= "Tekstwidget";
	private static $description	= "Generieke widget met een tekstveld en link mogelijkheid";

	private static $db = array(
		'Header' 	=> 'Varchar(100)',
		//'Body'		=> 'VarcharExtended(2000)',
		'Body'		=> 'HTMLText',
		'LinkTxt'	=> 'VarcharExtended(256)',
		'LinkExternalUrl'	=> 'VarcharExtended(256)',
		'LinkType' 	=> 'Enum("none, internal, external","none")'
	);

	private static $has_one = array(
		'InternalUrl' => 'Page'
	);

	private static $defaults = array(
		'LinkTxt' 	=> 'Lees meer',
		'LinkType'	=> 'none'
	);

	public function getCMSFields() {
		$oFieldExternalLink = new TextField('LinkExternalUrl', 'Externe link (opent in nieuw venster, begin met http://)', $this->LinkExternalUrl);
		$name = $oFieldExternalLink->getName();
		$name = preg_replace("/([A-Za-z0-9\-_]+)/", "Widget[" . $this->ID . "][\\1]", $name);
		$oFieldExternalLink->setName($name);

		$oFieldInternalLink = new SimpleTreeDropdownField('InternalUrlID', 'Interne link', 'SiteTree', $this->InternalUrlID, null, 'Kies een pagina');
		$name = $oFieldInternalLink->getName();
		$name = preg_replace("/([A-Za-z0-9\-_]+)/", "Widget[" . $this->ID . "][\\1]", $name);
		$oFieldInternalLink->setName($name);

		$aSelectionGroupItems = array(
			new SelectionGroup_Item( 'none', new LiteralField('nolink',''), 'Geen link' ),
			new SelectionGroup_Item( 'internal', $oFieldInternalLink, 'Interne link' ),
			new SelectionGroup_Item( 'external', $oFieldExternalLink, 'Externe link' )
		);

		$fldSelectionGroup = new SelectionGroup('LinkType', $aSelectionGroupItems);

		// config htmleditor
		// make a new TinyMCE config called "footer" by copying the default ("cms") config
		/*
		$footerConfig = CustomHtmlEditorConfig::copy('simpletoolbar', 'cms');
		$footerConfig->setButtonsForLine(3, array());
		$footerConfig->setButtonsForLine(2, array());
*/
		$oFields = new FieldList(
			new TextField('Header', 'Titel'),
			$fldBody = new HtmlEditorField('Body', 'Inhoud'),
			new HeaderField('hdrLink', 'Link', 3),
			new TextField('LinkTxt', 'Tekst link'),
			$fldSelectionGroup
		);

		$fldBody->setRows(6);

		// assign the "footer" TinyMCE config to this field
		$fldBody->setEditorConfig('simpletoolbar');

		// set the editor's body class.  This will make it class="typography footer-content"
		$fldBody->setBodyClass('widget_text typograhy');

		return $oFields;
	}

	public function onBeforeWrite()
	{
		parent::onBeforeWrite();

	}
}

class TextWidget_Controller extends WidgetBaseLeft_Controller {
	// zie WidgetBaseRight voor getWidgLink()
}