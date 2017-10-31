<?php

namespace Craft;

class DefaultTabService extends BaseApplicationComponent
{
    public function addTab($section) {
        $entryTypes = craft()->sections->getEntryTypesBySectionId($section->id);
        foreach ($entryTypes as $entryType) {
	        $postedFieldLayout = array('content' => array());

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