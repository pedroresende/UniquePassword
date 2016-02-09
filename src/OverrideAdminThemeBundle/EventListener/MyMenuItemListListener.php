<?php

namespace OverrideAdminThemeBundle\EventListener;

use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
#use OverrideAdminThemeBundle\Model\MenuItemModel;
use Avanzu\AdminThemeBundle\Model\MenuItemModel;
use Symfony\Component\HttpFoundation\Request;


/**
 * Description of MyMenuItemListListener
 *
 * @author pedroresende
 */
class MyMenuItemListListener
{

    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }

    protected function getMenu(Request $request)
    {
        $earg = array();
        $rootItems = array(
            $dash = new MenuItemModel('dashboard', 'Dashboard', 'unique_password_dashboard', $earg, 'fa fa-dashboard'),
            $pass = new MenuItemModel('password', 'Password', '', $earg, 'fa fa-key'),
        );

        $pass->addChild(new MenuItemModel('add-passwords', 'Add New', 'unique_password_add', $earg, 'fa fa-plus'))
                ->addChild($icons = new MenuItemModel('get-passwords', 'Retrieve', 'unique_password_retrieve', $earg, 'fa fa-unlock'));

        return $this->activateByRoute($request->get('_route'), $rootItems);
    }

    protected function activateByRoute($route, $items)
    {

        foreach ($items as $item) { /** @var $item MenuItemModel */
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else {
                if ($item->getRoute() == $route) {
                    $item->setIsActive(true);
                }
            }
        }

        return $items;
    }

}
