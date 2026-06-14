<?php


namespace InnoShop\Front\Components;

use Illuminate\View\Component;
use InnoShop\Front\Repositories\HeaderMenuRepo;
use InnoShop\Common\Repositories\CategoryRepo;

/**
 * Header component class
 * Responsible for rendering the website header, including navigation menu, search box, user account, etc.
 */
class Header extends Component
{
    public array $headerMenus;

    public $currentLocale;

    public $customer;

    public int $favTotal;

    public $activeCategories;
    /**
     * Constructor - Initialize data required for Header component
     *
     * @throws \Exception
     */
    public function __construct()
    {
        // Get header menu data
        $this->headerMenus = HeaderMenuRepo::getInstance()->getMenus();

        // Get current locale settings
        $this->currentLocale = current_locale();

        // Get current customer information
        $this->customer = current_customer();

        // Get favorites count
        $this->favTotal = $this->customer ? $this->customer->favorites->count() : 0;

        $this->activeCategories = CategoryRepo::getInstance()->getActiveCategories(20);
    }

    /**
     * Render Header component view
     *
     * @return mixed
     */
    public function render(): mixed
    {
        $data = [
            'header_menus' => $this->headerMenus,
        ];

        return view('components.header', $data);
    }
}
