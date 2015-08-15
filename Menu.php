<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\ExcludeByDDNS;

use Piwik\Menu\MenuAdmin;
use Piwik\Menu\MenuUser;

class Menu extends \Piwik\Plugin\Menu
{
    public function configureUserMenu(MenuUser $menu)
    {
        if (!method_exists($menu, 'addPersonalItem')) {
            // menu fallback for piwik < 1.11
            $menu->add(
                'CoreAdminHome_MenuManage',
                'ExcludeByDDNS_DDNSSettings',
                array('module' => 'ExcludeByDDNS', 'action' => 'index'),
                15,
                'ExcludeByDDNS_DDNSSettingsDescription'
            );
            return;
        }
        $menu->addPersonalItem(
            'ExcludeByDDNS_DDNSSettings',
            $this->urlForAction('index'),
            15,
            'ExcludeByDDNS_DDNSSettingsDescription'
        );
    }

    public function configureAdminMenu(MenuAdmin $menu)
    {
        if (!method_exists($menu, 'addDiagnosticItem')) {
            // menu fallback for piwik < 1.11
            $menu->add(
                'CoreAdminHome_MenuDiagnostic',
                'ExcludeByDDNS_DDNSStatus',
                array('module' => 'ExcludeByDDNS', 'action' => 'admin'),
                15
            );
            return;
        }
        $menu->addDiagnosticItem(
            'ExcludeByDDNS_DDNSStatus',
            $this->urlForAction('admin'),
            15
        );
    }
}
