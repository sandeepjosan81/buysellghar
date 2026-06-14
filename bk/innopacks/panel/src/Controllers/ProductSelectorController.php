<?php


namespace InnoShop\Panel\Controllers;

class ProductSelectorController extends BaseController
{
    /**
     * Selector page
     *
     * @return mixed
     */
    public function selectorPage(): mixed
    {
        return view('panel::product_selector.index');
    }
}
