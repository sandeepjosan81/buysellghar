<?php


namespace InnoShop\Plugin\Hooks;

class MarketplaceSettingsHook
{
    /**
     * Initialize marketplace settings hooks
     *
     * @return void
     */
    public function init(): void
    {
        $this->registerSettingTab();
        $this->registerSettingFields();
    }

    /**
     * Register setting tab navigation
     *
     * @return void
     */
    private function registerSettingTab(): void
    {
        listen_blade_insert('panel.settings.tab.nav.bottom', function ($data) {
            return view('plugin::panel.settings.marketplace_nav')->render();
        });
    }

    /**
     * Register setting tab content
     *
     * @return void
     */
    private function registerSettingFields(): void
    {
        listen_blade_insert('panel.settings.tab.pane.bottom', function ($data) {
            return view('plugin::panel.settings.marketplace_pane')->render();
        });
    }
}
