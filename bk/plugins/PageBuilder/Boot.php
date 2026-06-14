<?php


namespace Plugin\PageBuilder;

use InnoShop\Plugin\Core\BaseBoot;

class Boot extends BaseBoot
{
    /**
     * @return void
     */
    public function init(): void
    {
        $this->addPanelMenus();
    }

    /**
     * @return void
     */
    private function addPanelMenus(): void
    {
        listen_hook_filter('panel.component.sidebar.design.routes', function ($data) {
            $data[] = [
                'route' => 'pbuilder.index',
                'title' => trans('PageBuilder::route.title'),
                'blank' => true,
            ];

            return $data;
        });
    }
}
