<?php

class WidgetBaseLeft extends Widget {
	private static $title 			= "Basiswidget";
	private static $cmsTitle 		= "Basiswidget";
	private static $description	= "Deze basiswidget zou nooit zichtbaar moeten zijn.";
}

class WidgetBaseLeft_Controller extends WidgetController {
	/**
	 * Vooral voor TextWidget maar mogelijk ook nuttig voor andere widgets
	 * @return bool|mixed
	 */
	public function getWidgLink()
	{
		$sWidgLink = false;
		if (!$this->LinkType) { return $sWidgLink; }

		if ($this->LinkType == 'internal' && $this->InternalUrlID)
		{
			$sWidgLink = $this->InternalUrl()->Link();
		}
		else if ($this->LinkType == 'external' && $this->LinkExternalUrl != '')
		{
			$sWidgLink = $this->LinkExternalUrl;
		}

		return $sWidgLink;
	}
}