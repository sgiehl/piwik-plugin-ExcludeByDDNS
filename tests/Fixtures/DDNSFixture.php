<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */

namespace Piwik\Plugins\ExcludeByDDNS\tests\Fixtures;

use Piwik\Option;
use Piwik\Tests\Framework\Fixture;
use Piwik\Date;

class DDNSFixture extends Fixture
{
    public $dateTime = '2014-09-04 00:00:00';
    public $idSite = 1;

    public function setUp(): void
    {
        $this->setUpWebsite();

        Option::set('ExcludeByDDNS.superUserLogin', serialize([
            'hostname' => null,
            'ip' => '192.168.12.5',
            'lastUpdated' => Date::factory('2019-05-05 06:33:33')->getTimestamp(),
        ]));

        Option::set('ExcludeByDDNS.viewUserLogin', serialize([
            'hostname' => 'my.ddns.host',
            'ip' => '16.17.18.19',
            'lastUpdated' => Date::factory('2019-07-05 16:30:03')->getTimestamp(),
        ]));
    }

    private function setUpWebsite()
    {
        if (!self::siteCreated($this->idSite)) {
            $idSite = self::createWebsite($this->dateTime);
            $this->assertSame($this->idSite, $idSite);
        }
    }
}