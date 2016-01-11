<?php

/* keep on the height widget ;) */

class NewsletterWidget extends WidgetBaseRight {
	private static $db = array(
		"Header" 		=> "Varchar(100)",
		"Body"			=> "VarcharExtended(255)",
		"FieldLabelName"=> "Varchar(100)",
		"FieldLabelEmail"=> "Varchar(100)", // eventueel overige velden die een in het CMS in te stellen label moeten krijgen kunnen hier toegevoegd worden en in getCMSFields EN SubscribeNewsletterForm
		"BtnLabel"	=> "Varchar(100)",
		"MailChimpListID"	=> "Varchar(100)"
	);

	private static $title 			= "Newsletter";
	private static $cmsTitle 		= "Newsletter";
	private static $description	= "This widget displays a registration form for the mailinglist";

	private static $defaults = array(
		'Header' 						=> 'Keep me posted',
		'FieldLabelName' 		=> 'Your Name',
		'FieldLabelEmail' 	=> 'emailadres@email.com',
		'BtnLabel' 			=> 'Sign up'
	);

	public function getCMSFields() {

		$fieldBody = new TextareaField('Body', 	'Inhoud');
		$fieldBody->setRows(5);

		$oFields = new FieldList(
			new TextField('Header', 			'Title'),
			$fieldBody,
			new TextField('FieldLabelName', 	'Dummy text in name field'),
			new TextField('FieldLabelEmail', 	'Dummy text in email field'),
			new TextField('BtnLabel', 		'Button label')
		);

		if(Config::inst()->get(NewsLetterWidget_Name, NewsLetterWidget_Storage_Sys) == NewsLetterWidget_Storage_Sys_Mailchimp)
		{
			$fldTextFieldListId = new TextField('MailChimpListID', 'Mailchimp lijst id');

			$sApiKey = Config::inst()->get(NewsLetterWidget_Name, NewsLetterWidget_Storage_Sys_Mailchimp_APIKey);
			if($sApiKey == null || trim($sApiKey) == '')
			{
				$oFields->push($fldTextFieldListId);
			}
			else
			{ // fetch lists
				$api = new MCAPI($sApiKey);
				$retval = $api->lists();

				if ($api->errorCode)
				{
					//echo "Unable to load lists()!";
					//echo "\n\tCode=".$api->errorCode;
					//echo "\n\tMsg=".$api->errorMessage."\n";
				}
				else
				{
					//echo "Lists that matched:".$retval['total']."\n";
					//echo "Lists returned:".sizeof($retval['data'])."\n";
					$aOptions = array();
					foreach ($retval['data'] as $list)
					{
						//echo "Id = ".$list['id']." - ".$list['name']."\n";
						//echo "Web_id = ".$list['web_id']."\n";
						$aOptions[$list['id']] = $list['name'];
					}

					$oFields->push(new DropdownField('MailChimpListID', 'Mailchimp lijst id', $aOptions));
				}
			}
		}

		return $oFields;
	}

	function SubscribeNewsletterForm(){
		$controller = new NewsletterWidget_Controller($this);
		return $controller->SubscribeNewsletterForm();
	}
}

class NewsletterWidget_Controller extends WidgetBaseRight_Controller {

	public function init()
	{
		parent::init();
		$sBaseUrl = Director::absoluteBaseURL();
		Requirements::JavaScript($sBaseUrl . 'widgets/widget_newsletter/javascript/newsletterwidget.js');
	}

	public function SubscribeNewsletterForm() {
		$oFields = new FieldList(
			new HeaderField('header', $this->Header),
			new LiteralField('intro', $this->Body),
			new HiddenField('MailChimpListID', false, $this->MailChimpListID)
		);

		// get field settings from config file
		$aFieldSettings = Config::inst()->get(NewsLetterWidget_Name, NewsLetterWidget_Storage_Fields);
		$sLabelLocation = Config::inst()->get(NewsLetterWidget_Name, NewsLetterWidget_FieldLabel_Location);
		$aRequiredFields = array();
		foreach($aFieldSettings as $key=>$value)
		{ // key is formulier, value is mailchimp of data object
			$sTitle = '';
			$sPlaceholder = '';

			if($key == 'Email')
			{
				if($sLabelLocation == NewsLetterWidget_FieldLabel_Location_Placeholder) $sPlaceholder = $this->FieldLabelEmail;
				else $sTitle = $this->FieldLabelEmail;
				$field = new EmailField("Email", $sTitle);
			}
			else if($key == 'Name')
			{
				if($sLabelLocation == NewsLetterWidget_FieldLabel_Location_Placeholder) $sPlaceholder = $this->FieldLabelName;
				else $sTitle = $this->FieldLabelName;
				$field = new TextField('Name', $sTitle);
			}
			else
			{
				if($sLabelLocation == NewsLetterWidget_FieldLabel_Location_Placeholder) $sPlaceholder = $key;
				else $sTitle = $key;
				$field = new TextField($key, $sTitle);
			}

			if($sLabelLocation == NewsLetterWidget_FieldLabel_Location_Placeholder)	$field->setAttribute('placeholder', $sPlaceholder);

			array_push($aRequiredFields, $key); // voor nu is alles required
			$oFields->push($field);
		}

		foreach ($aRequiredFields as $oReqField) {
			$oFields->fieldByName($oReqField)->addExtraClass('required');
		}

		$oActions = new FieldList(new FormAction("subscribeNewsLetter", $this->BtnLabel ));
		$oForm = new Form($this, "SubscribeNewsletterForm", $oFields, $oActions);
		$oForm->addExtraClass('ajaxForm');
		$oForm->addExtraClass('widgetNewsLetter');
		$oForm->addExtraClass('box');
		$oForm->forAjaxTemplate();

		return $oForm;
	}

	protected $oCachedFormFeedbackFromSession;
	public function getFormFeedbackFromSession()
	{
		if($this->oCachedFormFeedbackFromSession != null) return $this->oCachedFormFeedbackFromSession;

		if(!isset($_SESSION['nwsltrwdgt'])) return false;

		$this->oCachedFormFeedbackFromSession = $_SESSION['nwsltrwdgt']; // only store for the rest of this pageload

		unset($_SESSION['nwsltrwdgt']);

		return $this->oCachedFormFeedbackFromSession;
	}

	// return the non-AJAX results from the session cookie
	function subscribeNewsLetterAJAX()
	{
		if (Director::is_ajax()) {
			$sSec = '';
			if(isset($_GET['SecurityID'])) $sSec = $_GET['SecurityID'];

			if ($sSec == Session::get('SecurityID'))
			{
				$vo = $this->getVoBaseOnInput($_GET);
				$bSuccess = $this->store($vo);

				if($bSuccess == true)
				{
					return 'success';
				}
				else
				{
					return $bSuccess;
				}
			}
			else return false;
		}
		return array();
	}

	public function subscribeNewsLetter($postedData, $form)	{

		$vo = $this->getVoBaseOnInput($postedData);

		$bSuccess = $this->store($vo);

		if($bSuccess == true)
		{
			$_SESSION['nwsltrwdgt'] = 'success';
		}
		else
		{
			$_SESSION['nwsltrwdgt'] = '0';
		}

		Controller::curr()->redirectBack();
	}

	protected function getVoBaseOnInput($oInputData)
	{
		$oVo = new NewsletterWidgetVo();
		$aFieldSettings = $oVo->aFieldSettings; // settings from _config.php

		foreach($aFieldSettings as $key=>$value)
		{
			if(isset($oInputData[$key])) $oVo->setProperty($value, $oInputData[$key]);
		}

//		Session::set('formresults', $oVo->sName);

		return $oVo;
	}

	protected function store(NewsletterWidgetVo $oVo)
	{
		$sStorageMechanisme = Config::inst()->get(NewsLetterWidget_Name, NewsLetterWidget_Storage_Sys);

		if($sStorageMechanisme == null)
		{
			return false;
		}
		else if($sStorageMechanisme == NewsLetterWidget_Storage_Sys_DataObject) {
			return $this->storeInDataObject($oVo);
		}
		else if($sStorageMechanisme == NewsLetterWidget_Storage_Sys_Mailchimp) {
			return $this->storeInMailChimp($oVo);
		}
		else {
			return false;
		}
	}

	protected function storeInDataObject(NewsletterWidgetVo $oVo)
	{
		$aFieldSettings = $oVo->aFieldSettings; // settings from _config.php

		$doClassName = Config::inst()->get(NewsLetterWidget_Name, NewsLetterWidget_Storage_Sys_DataObject_ClassName);
		if(ClassInfo::exists($doClassName)) $oDoInst = Injector::inst()->get($doClassName);
		else {
			echo('NewsletterWidget - Class ' . $doClassName . ' does not exist');
			exit;
		}

		// $key is naam veld in form, $value is naam veld in VO
		foreach($aFieldSettings as $key=>$value)
		{
			$val = $oVo->getProperty($value);
			$oDoInst->$value = $val;
		}

		if(isset($oDoInst->user_ip)) $oDoInst->user_ip 	= $_SERVER['REMOTE_ADDR'];
		if(isset($oDoInst->edit_ts)) $oDoInst->edit_ts 	=  SS_Datetime::now()->Rfc2822();
		$oSubscribed 						= $oDoInst->write();
		return $oSubscribed;
	}

	protected function storeInMailChimp(NewsletterWidgetVo $oVo)
	{
		$oBulkmailer = new BulkMail();

		$sApiKey 								= Config::inst()->get(NewsLetterWidget_Name, NewsLetterWidget_Storage_Sys_Mailchimp_APIKey);

		$sListId = null;
		if(isset($_GET['MailChimpListID']))				$sListId = $_GET['MailChimpListID'];
		else if(isset($_POST['MailChimpListID']))	$sListId = $_POST['MailChimpListID'];

		$oBulkMailPublisher 		= new BulkMailPublisherMailchimp($sApiKey, $sListId);
		$oBulkmailer->setPublisher($oBulkMailPublisher);

		$bSubscribed = $oBulkmailer->addRecipient($oVo->getProperty('Email'), $oVo->getProperty('Name'));

		return $bSubscribed;
	}
}

class NewsletterWidgetVo  {

	protected $aFilledFields;
	public $aFieldSettings;

	public function __construct()
	{
		// get field settings from config file
		$this->aFieldSettings = Config::inst()->get(NewsLetterWidget_Name, NewsLetterWidget_Storage_Fields);

		foreach($this->aFieldSettings as $key=>$value)
		{
			$this->aFilledFields[$value] = ''; // prefill all fields with an empty string, key is the key used in the dataobject or @ Mailchimp to make processing easy
		}
	}

	// voor nu gaan we er vanuit dat alle input strings betreft
	// als er wel meerdere types komen dan kunnen er verschillende set functies komen (setStringProperty) maar het nadeel is dan dat je in
	// de config mee moet kunnen geven wat voor type veld het is

	public function setProperty($sKey, $oInput)
	{
		if(array_key_exists($sKey, $this->aFilledFields))
		{
			$sValue = Convert::raw2sql($oInput);
			$sValue = (string) $sValue;
			$this->aFilledFields[$sKey] = $sValue;
		}
	}

	public function getProperty($sKey)
	{
		if(array_key_exists($sKey, $this->aFilledFields))
		{
			return $this->aFilledFields[$sKey];
		}

		return false;
	}
}
