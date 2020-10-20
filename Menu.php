<?php
/**
 * Matomo - free/libre analytics platform
 *
 * @link https://matomo.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\ExcludeByDDNS;

use Piwik\Menu\MenuAdmin;

class Menu extends \Piwik\Plugin\Menu
{
    public function configureAdminMenu(MenuAdmin $menu)
    {
        $menu->addDiagnosticItem(
            'ExcludeByDDNS_DDNSStatus',
            $this->urlForAction('admin'),
            15
        );
        $menu->addPersonalItem(
            'ExcludeByDDNS_DDNSSettings',
            $this->urlForAction('index'),
            15,
            'ExcludeByDDNS_DDNSSettingsDescription'
        );
    }
}
