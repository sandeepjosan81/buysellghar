<?php


namespace InnoShop\Front\Components;

use Illuminate\View\Component;
use InnoShop\Front\Repositories\HeaderMenuRepo;
use InnoShop\Common\Repositories\CategoryRepo;
use InnoShop\Common\Models\Product\PropertyProps;

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

    public $cities;

    public $possession;

    public $forSailRent;

    public $budget=[];
    public $budgetRent=[];
    public $label;

    public $bhk =[];

    public $furnishedStatus;

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

        $this->cities = PropertyProps::select('city')
             ->distinct()
             ->where('city', '!=', '')
             ->get();
        
        $this->possession = [
            'ready_to_move'=>"Ready To Move",
            "under_construction"=>"Under Construction"
        ];    
        
        $this->forSailRent = [
            'sale'=>"Sale",
            "rent"=>"Rent",
            "pg_hostal"=>"PG/Hostal"
        ];

        for ($i = 5; $i <= 500; $i += 5) {
            if ($i < 100) {
                $this->label = $i . ' Lac';
            } else {
                $crore = $i / 100;
                $this->label = rtrim(rtrim(number_format($crore, 2, '.', ''), '0'), '.') . ' Cr';
            }

            $this->budget[(string)$i] = $this->label;
        }

        // BHK Will be   

        for ($i = 1; $i <= 9; $i++) {
            $this->bhk[(string)$i] = $i . ' BHK';
        }
        $this->bhk['10+'] = '10+ BHK';


        $this->furnishedStatus = [
            'unfurnished'    => 'Unfurnished',
            'furnished'      => 'Furnished',
            'semi_furnished' => 'Semi Furnished',
        ];


        // Budget Rent
        for ($i = 5; $i <= 250; $i += 5) {
            if ($i < 100) {
                $this->label = $i . ' k';
            } else {
                $crore = $i / 100;
                $this->label = rtrim(rtrim(number_format($crore, 2, '.', ''), '0'), '.') . ' lac';
            }

            $this->budgetRent[(string)$i] = $this->label;
        }
       
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
