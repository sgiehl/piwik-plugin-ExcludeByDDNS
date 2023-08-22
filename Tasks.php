<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\ExcludeByDDNS;

use Piwik\Tracker\Cache;

class Tasks extends \Piwik\Plugin\Tasks
{
    public function schedule()
    {
        $this->hourly('updateIPs', null, self::HIGH_PRIORITY);  // method will be executed once every hour
    }

    public function updateIPs()
    {
        foreach (Storage::getAllUsersWithConfig() as $user) {
            $storage = new Storage($user);
            if (($hostname = $storage->getHostname())) {
                $ip = gethostbyname($hostname);
                if ($ip != $hostname) {
                    $storage->setIp($ip);
                }
            }
        }

        Cache::clearCacheGeneral();
    }
}
