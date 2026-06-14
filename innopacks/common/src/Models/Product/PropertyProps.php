<?php


namespace InnoShop\Common\Models\Product;

use Exception;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InnoShop\Common\Models\BaseModel;
use InnoShop\Common\Models\Product;
use InnoShop\Common\Repositories\ProductRepo;

/**
 * @property int $quantity
 */
class PropertyProps extends BaseModel
{
    protected $table = 'property_props';

    protected $fillable = [
        'product_id', 'model','seller_type', 'property_for', 'list_type','bedrooms','balconies','total_floors','floor_no','facing', 'furnished_status','bathrooms','allowed_floors', 'open_side', 'plot_area', 'plot_area_type', 'plot_length',
        'plot_breadth', 'is_corner', 'balcony', 'covered_area', 'covered_area_type',  'carpet_area','carpet_area_type', 'super_builtup_area', 'super_builtup_area_type', 'price', 'price_type', 'property_age', 'maintenance_cost', 'maintenance_cost_period', 'ownership_status', 'possession_status', 'rera_registration_no', 'transaction_type','location','city','address',        
    ];
    
    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public static function getSellerTypeOptions(): array
    {
        return [
            ['id' => 'owner', 'name' => 'Owner'],
            ['id' => 'dealer', 'name' => 'Agent Dealer'],
            ['id' => 'builder', 'name' => 'Builder'],
        ];
    }
    public static function getPropertyForOptions(): array
    {
        return [
            ['id' => 'sale', 'name' => 'Sale'],
            ['id' => 'rent', 'name' => 'Rent'],
            ['id' => 'pg_hostal', 'name' => 'PG/Hostal'],
        ];
    }

    public static function getPropertyListTypeOptions(): array
    {
    //    $categories = ProductRepo::getCategoryOptions();
        //  echo "<pre>";
        //  print_r($categories);
        //  exit;
        //  return $categories;
         
        return [
            // ['id' => 'villas', 'name' => 'Villas/Kothi'],
            // ['id' => 'flat_apartment', 'name' => 'Flat/ Apartment'],
            // ['id' => 'residential_house', 'name' => 'Residential House'],
            // ['id' => 'land_plot', 'name' => 'Residential Land/ Plot'],
            // ['id' => 'penthouse', 'name' => 'Penthouse'],
            // ['id' => 'studio_apartment', 'name' => 'Studio Apartment'],            
            // ['id' => 'residential', 'name' => 'Residential'],
            // ['id' => 'commercial', 'name' => 'Commercial'],
            // ['id' => 'cos', 'name' => 'Commercial Office Space'],
            // ['id' => 'oitp', 'name' => 'Office in IT Park'],
            // ['id' => 'commercial_shop', 'name' => 'Commercial Shop'],
            // ['id' => 'commercial_showroom', 'name' => 'Commercial Showroom'],
            // ['id' => 'commercial_land', 'name' => 'Commercial Land'],
            // ['id' => 'warehouse_godown', 'name' => 'Warehouse/ Godown'],
            // ['id' => 'industrial_land', 'name' => 'Industrial Land'],
            // ['id' => 'industrial_building', 'name' => 'Industrial Building'],
            // ['id' => 'industrial_shed', 'name' => 'Industrial Shed'],
            // ['id' => 'agricultural_land', 'name' => 'Agricultural Land'],
            // ['id' => 'farm_house', 'name' => 'Farm House'],
        ];
    }

    public static function getBedroomsOptions(): array
    {
        return [
            ['id' => '1', 'name' => '1'],
            ['id' => '2', 'name' => '2'],
            ['id' => '3', 'name' => '3'],
            ['id' => '4', 'name' => '4'],
            ['id' => '5', 'name' => '5'],
            ['id' => '6', 'name' => '6'],
            ['id'=>  '7', 'name'=> '7'],
            ['id'=>  '8', 'name'=> '8'],
            ['id'=>  '9', 'name'=> '9'],
            ['id'=>  '10+', 'name'=> '10+'],
        ];
    }

    public static function getBalconyOptions(): array
    {
        return [
            ['id' => '', 'name' => '0'],
            ['id' => '1', 'name' => '1'],
            ['id' => '2', 'name' => '2'],
            ['id' => '3', 'name' => '3'],
            ['id' => '4', 'name' => '4'],
            ['id' => '5', 'name' => '5'],
            ['id' => '6', 'name' => '6'],
            ['id'=>  '7', 'name'=> '7'],
            ['id'=>  '8', 'name'=> '8'],
            ['id'=>  '9', 'name'=> '9'],
            ['id'=>  '10+', 'name'=> '10+'],
        ];
    }

        public static function getBathRoomsOptions(): array
    {
        return [
            ['id' => '1', 'name' => '1'],
            ['id' => '2', 'name' => '2'],
            ['id' => '3', 'name' => '3'],
            ['id' => '4', 'name' => '4'],
            ['id' => '5', 'name' => '5'],
            ['id' => '6', 'name' => '6'],
            ['id'=>  '7', 'name'=> '7'],
            ['id'=>  '8', 'name'=> '8'],
            ['id'=>  '9', 'name'=> '9'],
            ['id'=>  '10+', 'name'=> '10+'],
        ];
    }
    public static function getTotalFloorsOptions(): array
    {
        return [
            ['id' => '', 'name' => '0'],
            ['id' => '1', 'name' => '1st'],
            ['id' => '2', 'name' => '2nd'],
            ['id' => '3', 'name' => '3rd'],
            ['id' => '4', 'name' => '4th'],
            ['id' => '5', 'name' => '5th'],
            ['id' => '6', 'name' => '6th'],
            ['id'=>  '7', 'name'=> '7th'],
            ['id'=>  '8', 'name'=> '8th'],
            ['id'=>  '9', 'name'=> '9th'],
            ['id'=>  '10+', 'name'=> '10th'],
            ['id' => '11', 'name' => '11th'],
            ['id' => '12', 'name' => '12th'],
            ['id' => '13', 'name' => '13'],
            ['id' => '14', 'name' => '14'],
            ['id' => '15', 'name' => '15'],
            ['id' => '16', 'name' => '16'],
            ['id' => '17', 'name' => '17'],
            ['id' => '18', 'name' => '18'],
            ['id' => '19', 'name' => '19'],
            ['id' => '20', 'name' => '20'],
            ['id' => '21', 'name' => '21'],
            ['id' => '22', 'name'=> '22'],
            ['id' => '23', 'name'=> '23'],
            ['id' => '24', 'name'=> '24'],
            ['id' => '25', 'name'=> '25'],
            ['id' => '26', 'name'=> '26'],
            ['id' => '27', 'name'=> '27'],
            ['id' => '28', 'name'=> '28'],
            ['id' => '29', 'name'=> '29'],
            ['id' => '30+', 'name'=> '30+']
        ];
    }

    public static function getFacingOptions(): array
    {
        return [
            ['id' => 'north', 'name' => 'North'],
            ['id' => 'south', 'name' => 'South'],
            ['id' => 'east', 'name' => 'East'],
            ['id' => 'west', 'name' => 'West'],
            ['id' => 'northeast', 'name' => 'Northeast'],
            ['id' => 'northwest', 'name' => 'Northwest'],
            ['id' => 'southeast', 'name' => 'Southeast'],
            ['id' => 'southwest', 'name' => 'Southwest'],
        ];
    }

    public static function getAreaTypeOptions(): array
    {
        return [
            ['id' => 'sq_ft', 'name' => 'Sq.ft'],
            ['id' => 'gaj', 'name' => 'Gaj'],            
             ['id' => 'ft', 'name' => 'FT'],
            ['id' => 'sq_m', 'name' => 'Sq.M'],
            ['id' => 'sq_yd', 'name' => 'Sq.Y'],            
            ['id'=> 'marla', 'name'=> 'Marla'],
            ['id'=> 'bigha', 'name'=> 'Bigha'],
            ['id'=> 'kanal', 'name'=> 'Kanal'],
            ['id' => 'acre', 'name' => 'Acre'],
            ['id'=> 'killa', 'name'=> 'Killa'],            
            ['id' => 'bigha', 'name' => 'Bigha'],
            ['id'=> 'hectare', 'name'=> 'Hectare'],
            ['id'=> 'biswa1', 'name'=> 'Biswa1'],
            ['id'=> 'biswa2', 'name'=> 'Biswa2'],
            ['id'=> 'are', 'name'=> 'Are'],
            ['id' => 'hectare', 'name' => 'Hectare'],
            ['id'=> 'ground', 'name'=> 'Ground'],
            ['id'=> 'aankadam', 'name'=> 'Aankadam'],
            ['id'=> 'rood', 'name'=> 'Rood'],
            ['id'=> 'chatak', 'name'=> 'Chatak'],
            ['id'=> 'kottah', 'name'=> 'Kottah'],
            ['id'=> 'cent', 'name'=> 'Cent'],
            ['id'=> 'perch', 'name'=> 'Perch'],
            ['id'=> 'guntha', 'name'=> 'Guntha'],
            ['id'=> 'kuncham', 'name'=> 'Kuncham'],
            ['id'=> 'katha', 'name'=> 'Katha']

            
        ];
    }

    public static function getFurnishedStatusOptions(): array
    {
        return [
            ['id' => 'unfurnished', 'name' => 'Unfurnished'],
            ['id' => 'furnished', 'name' => 'Furnished'],
            ['id' => 'semi_furnished', 'name' => 'Semi Furnished'],            
        ];
    }

    public static function getPriceTypeOptions(): array
    {
        return [
            ['id' => 'cr', 'name' => 'Cr'],
            ['id' => 'lacs', 'name' => 'Lacs'],
        ];
    }

    public static function getPropertyAgeOptions(): array
    {
        return [
            ['id' => 'new', 'name' => 'New Property'],
            ['id' => '0-1_year', 'name' => ' 0-1 Year'],
            ['id' => '1-3_years', 'name' => '1-3 Years'],
            ['id' => '3-5_years', 'name' => '3-5 Years'],
            ['id' => '5-10_years', 'name' => '5-10 Years'],
            ['id' => '10+_years', 'name' => '10+ Years'],
        ];
    }

     public static function getMaintenanceCostPeriodOptions(): array
    {
        return [
            ['id' => 'monthly', 'name' => 'Monthly'],
            ['id' => 'yearly', 'name' => 'Yearly'],
        ];
    }

    public static function getOpenSideOptions(): array
    {
        return [
            ['id' => '1', 'name' => '1'],
            ['id' => '2', 'name' => '2'],
            ['id' => '3', 'name' => '3'],
            ['id' => '4', 'name' => '4'],
        ];
    }

        public function getProprtyPriceFormat(): mixed
    {
        return currency_format($this->price)." ".$this->price_type;
    }

    public function getPossession(): mixed
    {
        return ($this->possession_status=='ready_to_move'? 'Ready To Move' : 'Under Construction');
    }
    

    public static function getBHKOptions(): array
    {
        return [
            ['id' => '1', 'name' => '1 BHK'],
            ['id' => '2', 'name' => '2 BHK'],
            ['id' => '3', 'name' => '3 BHK'],
            ['id' => '4', 'name' => '4 BHK'],
            ['id' => '5', 'name' => '5 BHK'],
            ['id' => '6', 'name' => '6 BHK'],
            ['id'=>  '7', 'name'=> '7 BHK'],
            ['id'=>  '8', 'name'=> '8 BHK'],
            ['id'=>  '9', 'name'=> '9 BHK'],
            ['id'=>  '10+', 'name'=> '10+ BHK'],
        ];
    }

}
