<?php
	// to prevent typos (no need to edit this)
	define('NewsLetterWidget_Name', 'NewsLetterWidget');
	define('NewsLetterWidget_Storage', 'NewsLetterWidget_Storage');
		define('NewsLetterWidget_Storage_Sys', 'NewsLetterWidget_Storage_Sys');
			define('NewsLetterWidget_Storage_Sys_Mailchimp', 'NewsLetterWidget_Storage_Sys_Mailchimp');
				define('NewsLetterWidget_Storage_Sys_Mailchimp_APIKey', 'NewsLetterWidget_Storage_Sys_Mailchimp_APIKey');
		define('NewsLetterWidget_Storage_Sys_DataObject', 'NewsLetterWidget_Storage_Sys_DataObject');
			define('NewsLetterWidget_Storage_Sys_DataObject_ClassName', 'NewsLetterWidget_Storage_Sys_DataObject_ClassName');
	define('NewsLetterWidget_Storage_Fields', 'NewsLetterWidget_Storage_Fields');
	define('NewsLetterWidget_FieldLabel_Location', 'NewsLetterWidget_FieldLabel_Location');
		define('NewsLetterWidget_FieldLabel_Location_Title', 'NewsLetterWidget_FieldLabel_Location_Title');
		define('NewsLetterWidget_FieldLabel_Location_Placeholder', 'NewsLetterWidget_FieldLabel_Location_Placeholder');

	/*
	 * Hieronder kun je instellen welke velden er in je widget formulier zitten.
	 * Zie het als de $db static in Silverstripe objecten.
	 * De key (links) is de naam die je het veld in je formulier wilt geven.
	 * Name en Email hebben een speciale afhandeling, maar je kan toevoegen wat je wilt.
	 * De waarde (rechts) is de naam van de property in het dataobject of de mergevar in Mailchimp.
	 * 	NB op het moment kent de Mailchimp optie alleen de velden Name en Email
	 */

	// configuration EDIT BELOW (config update heeft als waardes de naam van de class, de naam van de variabele, de waarde)

	// Waar tonen we labels in de widget? Als titel voor het veld of als placeholder in het veld?
	Config::inst()->update(NewsLetterWidget_Name, NewsLetterWidget_FieldLabel_Location, NewsLetterWidget_FieldLabel_Location_Title);

	// Welke velden zitten er in de widget en hoe corresponderen deze met de namen van de velden zoals we ze opslaan (in Mailchimp of in het DataObject)
	$oNwsLtrWdgtFields = array( // key is formulier, value is mailchimp of data object
		'Name'	=> 'Name',
		'Email'	=> 'Email'
	);

	Config::inst()->update(NewsLetterWidget_Name, NewsLetterWidget_Storage_Fields, $oNwsLtrWdgtFields);

	// Quote onderstaande 2 regels uit als je de data op wil slaan in een dataobject
	//Config::inst()->update(NewsLetterWidget_Name, NewsLetterWidget_Storage_Sys, NewsLetterWidget_Storage_Sys_DataObject);
	//Config::inst()->update(NewsLetterWidget_Name, NewsLetterWidget_Storage_Sys_DataObject_ClassName, 'NewsletterSubscriber'); // de laatste string is de naam van de class waarin je je data wilt opslaan, de velden zoals gedefinieerd in $oNwsLtrWdgtFields moeten hier in staan

	// Quote onderstaande 2 regels uit als je iemand aan wilt melden via mailchimp in plaats van opslaan in een dataobject
	Config::inst()->update(NewsLetterWidget_Name, NewsLetterWidget_Storage_Sys, NewsLetterWidget_Storage_Sys_Mailchimp);
	Config::inst()->update(NewsLetterWidget_Name, NewsLetterWidget_Storage_Sys_Mailchimp_APIKey, '1111111-us7'); // laatste string is de API key van Mailchimp

