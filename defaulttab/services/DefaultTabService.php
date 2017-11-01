<?php

namespace Craft;

class DefaultTabService extends BaseApplicationComponent
{

	public $settings;

	public function __construct() {
		$this->settings = craft()->plugins->getPlugin( 'defaulttab' )->getSettings();

	}

	public function addTab($section) {
		$tabTitle = $this->settings['tabTitle'] ? $this->settings['tabTitle'] : Craft::t('Content');
        $entryTypes = craft()->sections->getEntryTypesBySectionId($section->id);
        foreach ($entryTypes as $entryType) {

	        $postedFieldLayout = array($tabTitle => array());

	        $fieldLayout = craft()->fields->assembleLayout($postedFieldLayout);
	        $fieldLayout->type = ElementType::Entry;
	        $entryType->setFieldLayout($fieldLayout);
	        if($this->settings['hasTitleField']) {
	        	$entryType->hasTitleField = true;
	        }

	        // Save it
	        if (craft()->sections->saveEntryType($entryType))
	        {
		        Craft::log('Successfully appended fields.');
	        }
	        else
	        {
		        Craft::log('Could not append the fields.', LogLevel::Warning);
	        }

        }
    }
}