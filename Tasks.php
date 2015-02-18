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
use Piwik\Settings\Storage;

class Tasks extends \Piwik\Plugin\Tasks
{
    public static function getExcludeByHostname()
    {
        return Option::getLike('ExcludeByHostname.%');
    }

    public function schedule()
    {
        if (self::getExcludeByHostname()) {
            $this->hourly('updateIPs');  // method will be executed once every hour
        }
    }

    public function updateIPs()
    {
        $excludes = self::getExcludeByHostname();

        foreach($excludes AS $option => $hostname) {

            $user = substr($option, 18);
            $ip = gethostbyname($hostname);

            Option::set('ExcludeByDDNS.'.$user, $ip);
        }
    }
}