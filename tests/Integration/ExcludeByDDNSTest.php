<?php

/**
 * Matomo - free/libre analytics platform
 *
 * @link    https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

namespace Piwik\Plugins\ExcluceByDDNS\tests\Integration;

use Piwik\Plugins\SitesManager\API;
use Piwik\Plugins\ExcludeByDDNS\Storage;
use Piwik\Plugins\ExcludeByDDNS\Tasks;
use Piwik\Tests\Framework\TestCase\IntegrationTestCase;
use Piwik\Tracker\Request;
use Piwik\Tracker\VisitExcluded;

/**
 * Class ExcludeByDDNSTest
 *
 * @group Plugins
 * @group ExcludeByDDNS
 */
class ExcludeByDDNSTest extends IntegrationTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        \Piwik\Plugin\Manager::getInstance()->loadPlugins(['ExcludeByDDNS']);
    }

    public function testBasicMethodsEmpty()
    {
        $username = 'admin';
        $storage  = $this->getStorage($username);

        $this->assertEmpty($storage->getHostname());
        $this->assertEmpty($storage->getIp());
        $this->assertEmpty($storage->getLastUpdated());
        $this->assertEmpty($storage->getAllExcludedIps());
        $this->assertEmpty($storage->getAllUsersWithConfig());
    }

    public function testBasicMethodsSetIP()
    {
        $username = 'admin';
        $storage  = $this->getStorage($username);
        $now      = time();
        $storage->setIp('192.168.1.1');

        $this->assertEmpty($storage->getHostname());
        $this->assertEquals('192.168.1.1', $storage->getIp());
        $this->assertGreaterThanOrEqual($now, $storage->getLastUpdated());
        $this->assertEquals(['192.168.1.1'], $storage->getAllExcludedIps());
        $this->assertEquals(['admin'], $storage->getAllUsersWithConfig());
    }


    public function testBasicMethodsSetHostname()
    {
        $username = 'admin';
        $storage  = $this->getStorage($username);
        $storage->setHostname('localhost');

        $this->assertEquals('localhost', $storage->getHostname());
        $this->assertEmpty($storage->getIp());
        $this->assertEmpty($storage->getLastUpdated());
        $this->assertEmpty($storage->getAllExcludedIps());
        $this->assertEquals(['admin'], $storage->getAllUsersWithConfig());
    }

    public function testBasicMethodsSetHostnameAndRunTask()
    {
        $username = 'admin';
        $storage  = $this->getStorage($username);
        $now      = time();
        $storage->setHostname('piwik.org');

        $task = new Tasks();
        $task->updateIPs();

        $storage = $this->getStorage($username);
        $this->assertEquals('piwik.org', $storage->getHostname());
        $this->assertEquals('185.31.40.177', $storage->getIp());
        $this->assertGreaterThanOrEqual($now, $storage->getLastUpdated());
        $this->assertEquals(['185.31.40.177'], $storage->getAllExcludedIps());
        $this->assertEquals(['admin'], $storage->getAllUsersWithConfig());
    }

    public function testSetIPExcludedAndTestVisitExclusion()
    {
        $excludedIp             = '128.26.23.22';
        $_SERVER['REMOTE_ADDR'] = $excludedIp;

        $idsite = API::getInstance()->addSite("name", "http://piwik.net/", $ecommerce = 0, $siteSearch = 1);

        $excluded = new VisitExcluded(new Request(['idsite' => $idsite, 'rec' => 1]));
        $this->assertFalse($excluded->isExcluded());

        $username = 'admin';
        $storage  = $this->getStorage($username);
        $storage->setIp($excludedIp);

        $excluded = new VisitExcluded(new Request(['idsite' => $idsite, 'rec' => 1]));
        $this->assertTrue($excluded->isExcluded());
    }

    protected function getStorage($username)
    {
        return new Storage($username);
    }
}
