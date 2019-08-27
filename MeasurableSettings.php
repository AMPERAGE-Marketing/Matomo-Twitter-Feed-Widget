<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\TwitterFeedWidgetByAmperage;

use Piwik\Settings\Setting;
use Piwik\Settings\FieldConfig;

/**
 * Defines Settings for TwitterFeedWidgetByAmperage.
 *
 * Usage like this:
 * // require Piwik\Plugin\SettingsProvider via Dependency Injection eg in constructor of your class
 * $settings = $settingsProvider->getMeasurableSettings('TwitterFeedWidgetByAmperage', $idSite);
 * $settings->appId->getValue();
 * $settings->contactEmails->getValue();
 */
class MeasurableSettings extends \Piwik\Settings\Measurable\MeasurableSettings
{

    /** @var Setting */
    public $twitterFeedUsernameSetting;

    protected function init()
    {
        $this->twitterFeedUsernameSetting = $this->makeTwitterFeedUsernameSetting();
    }

    private function makeTwitterFeedUsernameSetting()
    {
        return $this->makeSetting('twitterFeedUsername', $default = '', FieldConfig::TYPE_STRING, function (FieldConfig $field) {
            $field->title = 'Twitter Feed Username';
            $field->uiControl = FieldConfig::UI_CONTROL_TEXT;
            $field->uiControlAttributes = array('size' => 3);
            $field->description = 'The Username for your Twitter Feed (ex. "WeMoveTheNeedle" would be for https://twitter.com/WeMoveTheNeedle.)';
        });
    }

}
