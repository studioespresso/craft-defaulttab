<?php
/**
 * Default Tab plugin for Craft CMS
 *
 * Adds a tab to every new section you create
 *
 * --snip--
 * Craft plugins are very much like little applications in and of themselves. We’ve made it as simple as we can,
 * but the training wheels are off. A little prior knowledge is going to be required to write a plugin.
 *
 * For the purposes of the plugin docs, we’re going to assume that you know PHP and SQL, as well as some semi-
 * advanced concepts like object-oriented programming and PHP namespaces.
 *
 * https://craftcms.com/docs/plugins/introduction
 * --snip--
 *
 * @author    Studio Espresso
 * @copyright Copyright (c) 2017 Studio Espresso
 * @link      https://studioespresso.co
 * @package   DefaultTab
 * @since     1.0.0
 */

namespace Craft;

class DefaultTabPlugin extends BasePlugin {
	/**
	 * Called after the plugin class is instantiated; do any one-time initialization here such as hooks and events:
	 *
	 * craft()->on('entries.saveEntry', function(Event $event) {
	 *    // ...
	 * });
	 *
	 * or loading any third party Composer packages via:
	 *
	 * require_once __DIR__ . '/vendor/autoload.php';
	 *
	 * @return mixed
	 */
	public function init() {
		craft()->on( 'sections.onSaveSection', function ( Event $event ) {
			if ( ! $event->params['isNewSection'] ) {
				return false;
			}
			craft()->defaultTab->addTab( $event->params['section'] );
		} );
		parent::init();


	}


	/**
	 * @return mixed
	 */
	public function getName()
	{
		return Craft::t('Default Tab');
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return Craft::t('Adds a tab to every new section you create');
	}

	/**
	 * @return string
	 */
	public function getDocumentationUrl()
	{
		return 'https://github.com/studioespresso/defaulttab/blob/master/README.md';
	}

	/**
	 * @return string
	 */
	public function getReleaseFeedUrl()
	{
		return 'https://raw.githubusercontent.com/studioespresso/defaulttab/master/releases.json';
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return '1.0.0';
	}

	/**
	 * @return string
	 */
	public function getSchemaVersion()
	{
		return '1.0.0';
	}

	/**
	 * @return string
	 */
	public function getDeveloper()
	{
		return 'Studio Espresso';
	}

	/**
	 * @return string
	 */
	public function getDeveloperUrl()
	{
		return 'https://studioespresso.co';
	}

	/**
	 * @return bool
	 */
	public function hasCpSection()
	{
		return false;
	}

	/**
	 */
	public function onBeforeInstall()
	{
	}

	/**
	 */
	public function onAfterInstall()
	{
	}

	/**
	 */
	public function onBeforeUninstall()
	{
	}

	/**
	 */
	public function onAfterUninstall()
	{
	}

	/**
	 * @return array
	 */
	protected function defineSettings()
	{
		return array(
			'tabTitle' => array(AttributeType::String, 'label' => 'Default tab title', 'default' => 'Content'),
			'hasTitleField' => array(AttributeType::Bool, 'label' => 'Should a new section have title field ', 'default' => true),
		);
	}

	/**
	 * @return mixed
	 */
	public function getSettingsHtml()
	{
		return craft()->templates->render('defaulttab/DefaultTab_Settings', array(
			'settings' => $this->getSettings()
		));
	}

	/**
	 * @param mixed $settings  The plugin's settings
	 *
	 * @return mixed
	 */
	public function prepSettings($settings)
	{
		// Modify $settings here...

		return $settings;
	}

}