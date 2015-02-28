<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\ExcludeByDDNS;

use Piwik\Menu\MenuUser;
use Piwik\Piwik;
use Piwik\Plugins\MobileMessaging\MobileMessaging;
use Piwik\Plugins\MobileMessaging\API as APIMobileMessaging;

class Menu extends \Piwik\Plugin\Menu
{
    public function configureUserMenu(MenuUser $menu)
    {
        if (!method_exists($menu, 'addPersonalItem')) {
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
}
