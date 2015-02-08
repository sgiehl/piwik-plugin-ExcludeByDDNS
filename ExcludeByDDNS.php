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
use Piwik\Option;
use Piwik\Tracker\Cache;

/**
 *
 */
class ExcludeByDDNS extends \Piwik\Plugin
{
    const __CACHE_ID__ = 'ExcludeByDDNS';

    /**
     * @see Piwik\Plugin::getListHooksRegistered
     */
    public function getListHooksRegistered()
    {
        return array(
            'Tracker.isExcludedVisit'           => 'checkIfIpIsExcluded',
            'Tracker.setTrackerCacheGeneral'    => 'setTrackerCacheGeneral',
        );
    }

    public function checkIfIpIsExcluded(&$exclude)
    {
        if ($exclude) {
            Common::printDebug("Visit is already excluded, no need to check DoNotTrack support.");
            return;
        }

        $cache = Cache::getCacheGeneral();
        $excludedIPs = $cache[self::__CACHE_ID__];

        if (empty($excludedIPs)) {
            return; // Nothing to exclude
        }

        $ip = \Piwik\Network\IP::fromStringIP(IP::getIpFromHeader());
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
        return Option::getLike('ExcludeByDDNS.%');
    }
}
