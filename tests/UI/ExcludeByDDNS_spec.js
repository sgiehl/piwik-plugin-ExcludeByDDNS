/*!
 * Matomo - free/libre analytics platform
 *
 * Screenshot tests for ExcludeByDDNS plugin
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 */

describe("ExcludeByDDNS", function () {
    this.timeout(0);

    this.fixture = "Piwik\\Plugins\\ExcludeByDDNS\\tests\\Fixtures\\DDNSFixture";

    before(function () {
        testEnvironment.pluginsToLoad = ['ExcludeByDDNS'];
        testEnvironment.save();
    });

    it('show settings', async function () {
        await page.goto('?module=ExcludeByDDNS&action=index');
        expect(await page.screenshotSelector('#content')).to.matchImage('settings');
    });

    it('show status', async function () {
        await page.goto('?module=ExcludeByDDNS&action=admin&idSite=1&period=day&date=yesterday');
        expect(await page.screenshotSelector('#content')).to.matchImage('admin');
    });
});
