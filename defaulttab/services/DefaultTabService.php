<?php

namespace Craft;

class DefaultTabService extends BaseApplicationComponent {

	public $settings;

	public function __construct() {
		$this->settings = craft()->plugins->getPlugin( 'defaulttab' )->getSettings();

	}

	public function addTab( $section ) {
		$tabTitle   = $this->settings['tabTitle'] ? $this->settings['tabTitle'] : Craft::t( 'Content' );
		$entryTypes = craft()->sections->getEntryTypesBySectionId( $section->id );
		foreach ( $entryTypes as $entryType ) {
			$tabs = array( $tabTitle => array() );
			if ( is_array($this->settings->defaultGroups) ) {
				foreach ( $this->settings->defaultGroups as $groupId ) {
					$fieldGroup       = craft()->fields->getGroupById( $groupId );
					$fieldGroupFields = craft()->fields->getFieldsByGroupId( $groupId );
					$fieldGroupFields = array_map(function($field) { return $field->id; }, $fieldGroupFields);
					$tabs             = array_merge( $tabs, array(
						$fieldGroup->name => $fieldGroupFields
					) );
				}
			}
			$postedFieldLayout = $tabs;

			$fieldLayout       = craft()->fields->assembleLayout( $postedFieldLayout );
			$fieldLayout->type = ElementType::Entry;
			$entryType->setFieldLayout( $fieldLayout );
			if ( $this->settings['hasTitleField'] ) {
				$entryType->hasTitleField = true;
			}

			// Save it
			if ( craft()->sections->saveEntryType( $entryType ) ) {
				Craft::log( 'Successfully appended fields.' );
			} else {
				Craft::log( 'Could not append the fields.', LogLevel::Warning );
			}

		}
	}
}