<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\TwitterFeedWidgetByAmperage\Widgets;

use Piwik\Widget\Widget;
use Piwik\Widget\WidgetConfig;
use Piwik\View;
use Piwik\Common;
use Piwik\Site;
use Piwik\Url;
use Piwik\UrlHelper;
use Piwik\Plugin\SettingsProvider;
use Piwik\Settings\Measurable;
use Piwik\Settings\Measurable\MeasurableSettings;
use Piwik\Plugins\CorePluginsAdmin\SettingsMetadata;

/**
 * This class allows you to add your own widget to the Piwik platform. In case you want to remove widgets from another
 * plugin please have a look at the "configureWidgetsList()" method.
 * To configure a widget simply call the corresponding methods as described in the API-Reference:
 * http://developer.piwik.org/api-reference/Piwik/Plugin\Widget
 */
class getTwitterFeed extends Widget
{

    /**
     * @var SettingsProvider
     */
	private $settingsProvider;

    public function __construct(SettingsProvider $settingsProvider)
    {
        $this->settingsProvider = $settingsProvider;
    }

    public static function configure(WidgetConfig $config)
    {
        /**
         * Set the category the widget belongs to. You can reuse any existing widget category or define
         * your own category.
         */
        $config->setCategoryId('TwitterFeedWidgetByAmperage_Social');

        /**
         * Set the subcategory the widget belongs to. If a subcategory is set, the widget will be shown in the UI.
         */
        // $config->setSubcategoryId('General_Overview');

        /**
         * Set the name of the widget belongs to.
         */
        $config->setName('TwitterFeedWidgetByAmperage_TwitterFeed');

        /**
         * Set the order of the widget. The lower the number, the earlier the widget will be listed within a category.
         */
        $config->setOrder(50);

        /**
         * Optionally set URL parameters that will be used when this widget is requested.
         * $config->setParameters(array('myparam' => 'myvalue'));
         */

        /**
         * Define whether a widget is enabled or not. For instance some widgets might not be available to every user or
         * might depend on a setting (such as Ecommerce) of a site. In such a case you can perform any checks and then
         * set `true` or `false`. If your widget is only available to users having super user access you can do the
         * following:
         *
         * $config->setIsEnabled(\Piwik\Piwik::hasUserSuperUserAccess());
         * or
         * if (!\Piwik\Piwik::hasUserSuperUserAccess())
         *     $config->disable();
         */
    }

    /**
     * This method renders the widget. It's on you how to generate the content of the widget.
     * As long as you return a string everything is fine. You can use for instance a "Piwik\View" to render a
     * twig template. In such a case don't forget to create a twig template (eg. myViewTemplate.twig) in the
     * "templates" directory of your plugin.
     *
     * @return string
     */
    public function render(){
        try {

			$output = '<div class="widget-body">';

			$twitter_username = '';
			$idSite = Common::getRequestVar('idSite');

			// Get the Twitter Feed Username setting from Piwik based on the Measurable (Site/App) (allowing different sites/apps to have different Twitter Feeds)
			$settings = $this->settingsProvider->getMeasurableSettings('TwitterFeedWidgetByAmperage', $idSite);
			$twitter_username = $settings->twitterFeedUsernameSetting->getValue();

			if($twitter_username == ''){
				$output.= '<p>You first need to configure the Twitter Feed Username in your <a href="index.php?module=SitesManager&action=index#TwitterFeedWidgetByAmperage">measurable (website/app) settings</a>.</p>';
			}else{ // Twitter Feed Username has been provided

				$output.= '<a class="twitter-timeline" data-height="400" data-theme="light" href="https://twitter.com/'.$twitter_username.'?ref_src=twsrc%5Etfw">Tweets by '.$twitter_username.'</a>';

				$output.= '<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>';

				$output.= '<p><a href="https://analytics.twitter.com/user/'.$twitter_username.'/home" target="_blank" class="more">View More Twitter Insights &amp; Stats</a></p>';

			}

			$output.= '</div>';
			return $output;

        } catch (\Exception $e) {
            return $this->error($e);
        }
    }

    /**
     * @param \Exception $e
     * @return string
     */
    private function error($e)
    {
        return '<div class="pk-emptyDataTable">'
             . Piwik::translate('General_ErrorRequest', array('', ''))
             . ' - ' . $e->getMessage() . '</div>';
    }

}
