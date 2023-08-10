<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\ExcludeByDDNS;

use Piwik\Common;
use Piwik\Tracker\Cache;

/**
 *
 */
class ExcludeByDDNS extends \Piwik\Plugin
{
    const __CACHE_ID__ = 'ExcludeByDDNS';

    /**
     * @see \Piwik\Plugin::registerEvents
     */
    public function registerEvents()
    {
        return [
            'Tracker.isExcludedVisit' => 'checkIfIpIsExcluded',
            'Tracker.setTrackerCacheGeneral' => 'setTrackerCacheGeneral',
        ];
    }

    public function isTrackerPlugin()
    {
        return true;
    }

    public function checkIfIpIsExcluded(&$exclude, $request)
    {
        if ($exclude) {
            Common::printDebug("Visit is already excluded, no need to check exclusion by DDNS.");
            return;
        }

        $cache = Cache::getCacheGeneral();
        $excludedIPs = $cache[self::__CACHE_ID__];

        if (empty($excludedIPs)) {
            return; // Nothing to exclude
        }

        $ip = \Matomo\Network\IP::fromStringIP($request->getIpString());
        if ($ip->isInRanges($excludedIPs)) {
            Common::printDebug('Visitor IP ' . $ip->toString() . ' is excluded from being tracked');
            $exclude = true;
        }
    }

    public function setTrackerCacheGeneral(&$cacheContent)
    {
        $cacheContent[self::__CACHE_ID__] = $this->getExcludedIPs();
    }

    protected function getExcludedIPs()
    {
        return Storage::getAllExcludedIps();
    }
}
