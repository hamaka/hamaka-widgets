<?php

class ContactWidget extends WidgetBaseRight {
	private static $db = array(
		"Header" 		=> "Varchar(100)",
		"Body"			=> "VarcharExtended(256)",
		"BtnLabel"	=> "Varchar(100)"
	);

	private static $title 			= "Meer weten?";
	private static $cmsTitle 		= "Meer weten?";
	private static $description	= "Widget met korte tekst, een afbeelding en knop die verwijst naar de contactpagina";

	private static $defaults = array(
		'Header' 				=> 'Meer weten?',
		'Body' 					=> 'Geïnspireerd? Smaakt dit naar meer? We helpen je graag verder.',
		'BtnLabel' 			=> 'Neem contact met me op'
	);

	public function getCMSFields() {

		$fieldBody = new TextareaField('Body', 	'Inhoud (max ongeveer 90 tekens)');
		$fieldBody->setRows(5);

		return new FieldList(
			new TextField('Header', 'Titel'),
			$fieldBody,
			new TextField('BtnLabel', 'Tekst op knop')
		);
	}
}

class ContactWidget_Controller extends WidgetBaseRight_Controller {


}