<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\ExcludeByDDNS;

use Piwik\Option;
use Piwik\Updates;

/**
 */
class Updates_0_2_0 extends Updates
{
    static function update()
    {
        $exclusions = Option::getLike('ExcludeByDDNS.%');
        foreach ($exclusions AS $option => $ip) {
            $user = substr($option, 14);
            $storage = new Storage($user);
            $storage->setIp($ip);
        }

        $exclusions = Option::getLike('ExcludeByHostname.%');
        foreach ($exclusions AS $option => $hostname) {
            $user = substr($option, 18);
            $storage = new Storage($user);
            $storage->setHostname($hostname);
        }
        Option::deleteLike('ExcludeByHostname.%');
    }
}
