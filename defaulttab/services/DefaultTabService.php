<?php

namespace Craft;

class DefaultTabService extends BaseApplicationComponent
{

	public $settings;

	public function __construct() {
		$this->settings = craft()->plugins->getPlugin( 'defaulttab' )->getSettings();

	}

	public function addTab($section) {
		if($this->settings['tabTitle']) {
			$tabTitle = $this->settings['tabTitle'];
		} else {
			$tabTitle = Craft::t('Content');
		}
        $entryTypes = craft()->sections->getEntryTypesBySectionId($section->id);
        foreach ($entryTypes as $entryType) {

	        $postedFieldLayout = array($tabTitle => array());

	        $fieldLayout = craft()->fields->assembleLayout($postedFieldLayout);
	        $fieldLayout->type = ElementType::Entry;
	        $entryType->setFieldLayout($fieldLayout);

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