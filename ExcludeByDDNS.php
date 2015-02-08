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

/**
 *
 */
class ExcludeByDDNS extends \Piwik\Plugin
{
    /**
     * @see Piwik\Plugin::getListHooksRegistered
     */
    public function getListHooksRegistered()
    {
        return array(
            'Tracker.isExcludedVisit' => 'checkIfIpIsExcluded',
        );
    }

    public function checkIfIpIsExcluded(&$exclude)
    {
        if ($exclude) {
            Common::printDebug("Visit is already excluded, no need to check DoNotTrack support.");
            return;
        }

        $excludedIPs = $this->getExcludedIPs();

        if (empty($excludedIPs)) {
            return; // Nothing to exclude
        }

        $ip = \Piwik\Network\IP::fromStringIP(IP::getIpFromHeader());
        if ($ip->isInRanges($excludedIPs)) {
            Common::printDebug('Visitor IP ' . $ip->toString() . ' is excluded from being tracked');
            $exclude = true;
        }
    }

    protected function getExcludedIPs()
    {
        return Option::getLike('ExcludeByDDNS.%');
    }
}
