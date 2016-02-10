<?php

namespace OverrideAdminThemeBundle\EventListener;

use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
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
            $password = new MenuItemModel('password', 'Password', '', $earg, 'fa fa-key'),
            $categories = new MenuItemModel('categories', 'Categories', '', $earg, 'fa fa-folder-open-o'),
        );

        $password
                ->addChild(new MenuItemModel('add-passwords', 'Add New', 'unique_password_add', $earg, 'fa fa-plus'))
                ->addChild(new MenuItemModel('list-passwords', 'Retrieve', 'unique_password_list', $earg, 'fa fa-unlock'));

        $categories
                ->addChild(new MenuItemModel('list-categories', 'List Categories', 'unique_categories_list', $earg, 'fa fa-folder-open-o'));

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
