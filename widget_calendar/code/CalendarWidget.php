<?php
	class CalendarWidget extends WidgetBaseRight {
		private static $db = array(
			"Header" 				=> "Varchar(100)",
			"NumberOfItems"	=> "Int",
			"LinkTxt"	=> "VarcharExtended(256)",
			"LinkExternalUrl"	=> "VarcharExtended(256)"
		);

		private static $title 			= "Calendar widget";
		private static $cmsTitle 		= "Calendar widget";
		private static $description	= "This widget displays the first upcoming events";

		private static $defaults = array(
			'Header' 				=> 'Agenda',
			'NumberOfItems'	=> 4,
			'LinkTxt' 			=> 'laat alles zien'
		);

		public function getCMSFields() {
			return new FieldList(
				new TextField('Header', _t('Widgets.LBL_TITLE', 'Title')),
				new NumericField('NumberOfItems', _t('Widgets.LBL_NR_OF_LINES', 'Number of lines')),
				new TextField('LinkTxt', 	_t('Widgets.LBL_LINK_TXT', 'Text for link'))
			);
		}
	}

	class EventWidget_Controller extends WidgetBaseRight_Controller {
		// Return a list of calendar events, sorted from new to old
		
		protected $aCachedCalendarEvents;

		public function getCalendarTopList($iLimit = 4)
		{
			if(isset($this->aCachedCalendarEvents['limit'.$iLimit]) && $this->aCachedCalendarEvents['limit'.$iLimit] != null) return $this->aCachedCalendarEvents['limit'.$iLimit];

			$nSubsiteID = $this->EditingSubsite;

			$oCalendarEvents = CalendarEvent::get()->where('SubsiteID = ' . $nSubsiteID . ' AND StartDate >= CURDATE()')->limit($iLimit)->sort('StartDate ASC'); // alle nieuwsitems worden meteen gepublished dus daar hoeven we niet op te filteren

			if (!$oCalendarEvents) { return false; }

			$this->aCachedCalendarEvents['limit'.$iLimit] = $oCalendarEvents;

			return $this->aCachedCalendarEvents['limit'.$iLimit];
		}

		public function getFirstCalendarHolder()
		{
			$nSubsiteID = $this->EditingSubsite;

			$oSingleInstance = CalendarHolder::get()->filter(array('SubsiteID' => $nSubsiteID))->first();

			if (!$oSingleInstance) { return false; }

			return $oSingleInstance;
		}

	}