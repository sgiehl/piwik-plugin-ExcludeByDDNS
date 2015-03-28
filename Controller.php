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
use Piwik\Date;
use Piwik\IP;
use Piwik\Nonce;
use Piwik\Option;
use Piwik\Piwik;
use Piwik\Site;
use Piwik\Tracker\Cache;
use Piwik\Url;
use Piwik\View;

/**
 *
 */
class Controller extends \Piwik\Plugin\ControllerAdmin
{
    public function admin()
    {
        Piwik::checkUserHasSomeAdminAccess();

        $view = new View('@ExcludeByDDNS/admin');
        $this->setGeneralVariablesView($view);

        $view->exclusions = array();

        $users = Storage::getAllUsersWithConfig();
        foreach ($users AS $user) {
            $storage = new Storage($user);
            $lastUpdated = $storage->getLastUpdated();
            $view->exclusions[] = array(
                'username' => $user,
                'ip' => $storage->getIp(),
                'hostname' => $storage->getHostname(),
                'lastUpdated' => $lastUpdated ? Date::factory($lastUpdated)->getLocalized(Piwik::translate('CoreHome_DateFormat') . ' %time%') : ''
            );
        }

        return $view->render();
    }

    public function index()
    {
        Piwik::checkUserHasSomeViewAccess();

        $idSite   = Common::getRequestVar('idSite', false);
        $nonce    = Common::getRequestVar('nonce', false);
        $hostname = Common::getRequestVar('excludedHostname', false);

        $storage = new Storage(Piwik::getCurrentUserLogin());

        $view = new View('@ExcludeByDDNS/index');
        $this->setBasicVariablesView($view);
        $view->excludedHostname = $storage->getHostname();

        if ($nonce !== false && Nonce::verifyNonce('Piwik_ExcludeHostname'.Piwik::getCurrentUserLogin(), $nonce)) {
            if($hostname) {
                $ip = gethostbyname($hostname);

                if ($ip != $hostname) {
                    $storage->setHostname($hostname);
                    $storage->setIp($ip);
                } else {
                    $view->excludedHostname = $hostname;
                    $view->hostnameError = true;
                }
            } else {
                $storage->setHostname('');
            }
        }

        $view->updateUrl = Url::getCurrentUrlWithoutQueryString(false) .'?'. Url::getQueryStringFromParameters(array(
                'module' => 'ExcludeByDDNS',
                'action' => 'update',
                'token_auth' => Piwik::getCurrentUserTokenAuth()
            ));

        $website        = new Site($idSite);
        $timezone       = $website->getTimezone();

        $view->excludedIp = $storage->getIp();
        $lastUpdated = $storage->getLastUpdated();
        $view->lastUpdated = $lastUpdated ? Date::factory($lastUpdated, $timezone)->getLocalized(Piwik::translate('CoreHome_DateFormat') . ' %time%') : '';
        $view->nonce = Nonce::getNonce('Piwik_ExcludeHostname'.Piwik::getCurrentUserLogin(), 3600);

        return $view->render();
    }


    public function update()
    {
        Piwik::checkUserHasSomeViewAccess();

        $ip = IP::getIpFromHeader();
        $user = Piwik::getCurrentUserLogin();

        $storage = new Storage($user);
        $storage->setIp($ip);
        Cache::clearCacheGeneral();
    }
}
