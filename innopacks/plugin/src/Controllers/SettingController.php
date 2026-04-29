<?php


namespace InnoShop\Plugin\Controllers;

use InnoShop\Common\Repositories\SettingRepo;
use InnoShop\Panel\Controllers\BaseController;

class SettingController extends BaseController
{
    public function index()
    {
        return view('plugin::panel.settings.index');
    }

    public function update()
    {
        try {
            SettingRepo::getInstance()->updateValues(request()->all());

            return back()->with('success', __('common.updated_successfully'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
