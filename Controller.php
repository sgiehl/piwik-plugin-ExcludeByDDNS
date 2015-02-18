<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\ExcludeByDDNS;

use Piwik\Common;
use Piwik\IP;
use Piwik\Nonce;
use Piwik\Option;
use Piwik\Piwik;
use Piwik\Tracker\Cache;
use Piwik\Url;
use Piwik\View;

/**
 *
 */
class Controller extends \Piwik\Plugin\ControllerAdmin
{
    public function index()
    {
        Piwik::checkUserHasSomeViewAccess();

        $nonce    = Common::getRequestVar('nonce', false);
        $hostname = Common::getRequestVar('excludedHostname', false);

        if ($nonce !== false && Nonce::verifyNonce('Piwik_ExcludeHostname'.Piwik::getCurrentUserLogin(), $nonce)) {
            if($hostname) {
                Option::set('ExcludeByHostname.'.Piwik::getCurrentUserLogin(), $hostname);
            } else {
                Option::delete('ExcludeByHostname.'.Piwik::getCurrentUserLogin());
            }
        }

        $view = new View('@ExcludeByDDNS/index');
        $this->setBasicVariablesView($view);

        $view->updateUrl = Url::getCurrentUrlWithoutQueryString(false) .'?'. Url::getQueryStringFromParameters(array(
                'module' => 'ExcludeByDDNS',
                'action' => 'update',
                'token_auth' => Piwik::getCurrentUserTokenAuth()
            ));

        $view->excludedIp = Option::get('ExcludeByDDNS.'.Piwik::getCurrentUserLogin());
        $view->excludedHostname = Option::get('ExcludeByHostname.'.Piwik::getCurrentUserLogin());
        $view->nonce = Nonce::getNonce('Piwik_ExcludeHostname'.Piwik::getCurrentUserLogin(), 3600);

        return $view->render();
    }


    public function update()
    {
        Piwik::checkUserHasSomeViewAccess();

        $ip = IP::getIpFromHeader();
        $user = Piwik::getCurrentUserLogin();

        Option::set('ExcludeByDDNS.'.$user, $ip);
        Cache::clearCacheGeneral();
    }
}
