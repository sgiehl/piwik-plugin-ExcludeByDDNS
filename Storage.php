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
use Piwik\Option;
use Piwik\Tracker\Cache;

class Storage
{
    private $username;
    private $hostname = null;
    private $ip = null;
    private $lastUpdated = null;

    public function __construct($username)
    {
        $this->username = $username;
        $this->load();
    }

    public function setHostname($hostname)
    {
        $this->hostname = $hostname;
        $this->save();
    }

    public function getHostname()
    {
        return $this->hostname;
    }

    public function getIp()
    {
        return $this->ip;
    }

    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
        $this->lastUpdated = time();
        $this->save();
    }

    protected function load()
    {
        $data = Option::get('ExcludeByDDNS.' . $this->username);
        if (!$data) {
            return;
        }

        $data = (array) @Common::safe_unserialize($data);

        if (isset($data['hostname'])) {
            $this->hostname = $data['hostname'];
        }
        if (isset($data['ip'])) {
            $this->ip = $data['ip'];
        }
        if (isset($data['lastUpdated'])) {
            $this->lastUpdated = $data['lastUpdated'];
        }
    }

    protected function save()
    {
        $data = array(
            'hostname' => $this->hostname,
            'ip' => $this->ip,
            'lastUpdated' => $this->lastUpdated,
        );

        Option::set('ExcludeByDDNS.' . $this->username, serialize($data));
        Cache::clearCacheGeneral();
    }

    public static function getAllUsersWithConfig()
    {
        $options = (array) Option::getLike('ExcludeByDDNS.%');
        return array_filter(array_map(function($elem){
            return substr($elem, 14);
        }, array_keys($options)));
    }

    public static function getAllExcludedIps()
    {
        $options = (array) Option::getLike('ExcludeByDDNS.%');
        return array_filter(array_map(function($elem){
            $elem = Common::safe_unserialize($elem);
            return $elem['ip'];
        }, array_values($options)));
    }
}
