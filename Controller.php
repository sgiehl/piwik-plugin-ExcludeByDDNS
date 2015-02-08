<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\ExcludeByDDNS;

use Piwik\IP;
use Piwik\Option;
use Piwik\Piwik;
use Piwik\Tracker\Cache;
use Piwik\View;

/**
 *
 */
class Controller extends \Piwik\Plugin\ControllerAdmin
{
    public function update()
    {
        Piwik::checkUserHasSomeViewAccess();

        $ip = IP::getIpFromHeader();
        $user = Piwik::getCurrentUserLogin();

        Option::set('ExcludeByDDNS.'.$user, $ip);
        Cache::clearCacheGeneral();
    }
}
