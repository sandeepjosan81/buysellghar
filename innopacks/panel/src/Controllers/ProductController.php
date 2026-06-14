<?php


namespace InnoShop\Panel\Controllers;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use InnoShop\Common\Models\Product;
use InnoShop\Common\Models\Product\PropertyProps;
use InnoShop\Common\Repositories\AttributeRepo;
use InnoShop\Common\Repositories\BrandRepo;
use InnoShop\Common\Repositories\ProductRepo;
use InnoShop\Common\Repositories\TaxClassRepo;
use InnoShop\Common\Repositories\WeightClassRepo;
use InnoShop\Common\Resources\SkuListItem;
use InnoShop\Panel\Requests\ProductRequest;
use InnoShop\Panel\Resources\ProductNameResource;
use Throwable;
use DNS1D;
use Illuminate\Support\Facades\Auth;

class ProductController extends BaseController
{
    /**
     * @param  Request  $request
     * @return mixed
     * @throws Exception
     */
    public function index(Request $request): mixed
    {
    
       $property = Product::with('propertyProps')->get();//->toArray();
        // echo "<pre>";
        // print_r($property[0]->propertyProps->seller_type ?? []);
        // exit;

        $filters = $request->all();
   
        $data = [
            'criteria'        => ProductRepo::getCriteria(),
            'sortOptions'     => ProductRepo::getSortOptions(),
            'products'        => ProductRepo::getInstance()->list($filters),
            'categoryOptions' => ProductRepo::getCategoryOptions(),
            
            // 'seller'          => $seller,
        ];

        return inno_view('panel::products.index', $data);
    }

     public function generateBarcode(Product $product){
                
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);
        // $id = $request->get('id');
        // $product = Product::find($id);        
        // echo "<pre>";
        // print_r($product);
        // exit;

        // return view('products/barcode', compact('product', 'barCodeHtml'));
        $data = [
            'product'     => $product,
        ];
        return inno_view('panel::products.barcode', $data);
    }

    /**
     * Product creation page.
     *
     * @return mixed
     * @throws Exception
     */
    public function create(): mixed
    {
        return $this->form(new Product);
    }

    /**
     * @param  ProductRequest  $request
     * @return RedirectResponse
     * @throws Throwable
     */
    public function store(ProductRequest $request): RedirectResponse
    {
        try {
            $data    = $request->all();           
            $data['admin_id'] = Auth::id(); // Set the admin_id to the currently authenticated admin's ID
            
            // echo "<pre>";
            // print_r($data);
            // exit;
            
            $product = ProductRepo::getInstance()->create($data);


            return redirect(panel_route('products.index', ['sort' => 'updated_at', 'order' => 'desc']))
                ->with('instance', $product)
                ->with('success', panel_trans('common.saved_success'));
        } catch (Exception $e) {
            return redirect(panel_route('products.index'))
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param  Product  $product
     * @return mixed
     * @throws Exception
     */
    public function edit(Product $product): mixed
    {
        return $this->form($product);
    }

    /**
     * 
     *
     * @param  $product
     * @return array
     */
    private function prepareProductOptionsData(Product $product): array
    {
        $existingProductOptions = [];
        $existingOptionValues   = [];

        if ($product->id) {
            // Prepare existing product option data - use correct relationships
            if ($product->productOptions && $product->productOptions->count() > 0) {
                foreach ($product->productOptions as $productOption) {
                    $existingProductOptions[] = [
                        'option_id'           => $productOption->option_id,
                        'name'                => $productOption->option->getLocalizedName(),
                        'type'                => $productOption->option->type,
                        'option_values_count' => $productOption->option->optionValues->count(),
                        'required'            => $productOption->option->required,
                        'position'            => $productOption->position,
                    ];
                }
            }

            // Prepare existing option value configuration data
            if ($product->productOptionValues && $product->productOptionValues->count() > 0) {
                foreach ($product->productOptionValues as $productOptionValue) {
                    $existingOptionValues[] = [
                        'option_id'        => $productOptionValue->option_id,
                        'option_value_id'  => $productOptionValue->option_value_id,
                        'price_adjustment' => $productOptionValue->price_adjustment,
                        'stock_quantity'   => $productOptionValue->quantity,
                    ];
                }
            }
        }

        return [
            'existingProductOptions' => $existingProductOptions,
            'existingOptionValues'   => $existingOptionValues,
        ];
    }

    /**
     * @param  $product
     * @return mixed
     * @throws Exception
     */
    public function form($product): mixed
    {
        // Preload related product relationships
        if ($product->id) {
            $product->load([
                'relations.relationProduct.translation',
                'productOptions.option.optionValues',
                'productOptionValues.option',
                'productOptionValues.optionValue',
            ]);
        }

        $skus = SkuListItem::collection($product->skus)->jsonSerialize();

        $attributeData = AttributeRepo::getInstance()->getAttributesWithValues();

        $categories = ProductRepo::getCategoryOptions();

        // Process complete data for selected related products
        $selectedRelatedProducts = [];
        if ($product->id && $product->relations) {
            $selectedRelatedProducts = ProductNameResource::collection(
                $product->relations->pluck('relationProduct')
            )->toArray(request());
        }

        // Prepare product option data
        $productOptionsData = $this->prepareProductOptionsData($product);

        $data = [
            'product'                 => $product,
            'skus'                    => $skus,
            'categories'              => $categories,
            'brands'                  => BrandRepo::getInstance()->all()->toArray(),
            'tax_classes'             => TaxClassRepo::getInstance()->all()->toArray(),
            'weightClasses'           => WeightClassRepo::getInstance()->withActive()->all()->toArray(),
            'attribute_count'         => $product->productAttributes->count(),
            'all_attributes'          => $attributeData,
            'selectedRelatedProducts' => $selectedRelatedProducts,
            'existingProductOptions'  => $productOptionsData['existingProductOptions'],
            'existingOptionValues'    => $productOptionsData['existingOptionValues'],
            'sellerTypeOptions'       => PropertyProps::getSellerTypeOptions(),
            'propertyForOptions'      => PropertyProps::getPropertyForOptions(),
            'propertyListTypeOptions' => PropertyProps::getPropertyListTypeOptions(),
            'bedroomsOptions'         => PropertyProps::getBedroomsOptions(),
            'balconyOptions'          => PropertyProps::getBalconyOptions(),
            'totalFloorsOptions'      => PropertyProps::getTotalFloorsOptions(),
            'bathRoomsOptions'        => PropertyProps::getBathRoomsOptions(),
            'areaTypeOptions'         => PropertyProps::getAreaTypeOptions(),
            'facingOptions'           => PropertyProps::getFacingOptions(),
            'furnishedStatusOptions'  => PropertyProps::getFurnishedStatusOptions(),
            'priceTypeOptions'        => PropertyProps::getPriceTypeOptions(),
            'propertyAgeOptions'      => PropertyProps::getPropertyAgeOptions(),
            'maintenanceCostPeriodOptions' => PropertyProps::getMaintenanceCostPeriodOptions(),
            'openSideOptions'         => PropertyProps::getOpenSideOptions(),
        ];

        return inno_view('panel::products.form', $data);
    }

    /**
     * @param  ProductRequest  $request
     * @param  Product  $product
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(ProductRequest $request, Product $product): RedirectResponse
    {
        try {
            $data = $request->all();
            $data    = $request->all();
            // echo "<pre>";
            // print_r($data);
            // exit;
            ProductRepo::getInstance()->update($product, $data);

            return redirect(panel_route('products.index', ['sort' => 'updated_at', 'order' => 'desc']))
                ->with('instance', $product)
                ->with('success', panel_trans('common.updated_success'));
        } catch (Exception $e) {
            return redirect(panel_route('products.edit', $product))
                ->withInput()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param  Product  $product
     * @return RedirectResponse
     */
    public function destroy(Product $product): RedirectResponse
    {
        try {
            ProductRepo::getInstance()->destroy($product);

            return back()->with('success', panel_trans('common.deleted_success'));
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param  Product  $product
     * @return RedirectResponse
     */
    public function copy(Product $product): RedirectResponse
    {
        try {
            ProductRepo::getInstance()->copy($product);

            return back()->with('success', panel_trans('common.saved_success'));
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Bulk update products
     *
     * @param  Request  $request
     * @return mixed
     */
    public function bulkUpdate(Request $request): mixed
    {
        try {
            $action = $request->input('action');
            $ids    = $request->input('ids', []);
            $data   = $request->input('data', []);

            // Validate required parameters
            if (empty($action) || empty($ids)) {
                return json_fail(__('panel/common.invalid_parameters'));
            }

            // Validate action type
            $allowedActions = ['price', 'categories', 'quantity', 'publish', 'unpublish'];
            if (! in_array($action, $allowedActions)) {
                return json_fail(__('panel/common.invalid_action'));
            }

            $result = ProductRepo::getInstance()->bulkUpdate($ids, $action, $data);

            return json_success(__('panel/product.bulk_update_success', ['count' => $result['count']]));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    /**
     * Bulk destroy products
     *
     * @param  Request  $request
     * @return mixed
     */
    public function bulkDestroy(Request $request): mixed
    {
        try {
            $ids = $request->input('ids', []);

            if (empty($ids)) {
                return json_fail(__('panel/common.select_items'));
            }

            $deletedCount = ProductRepo::getInstance()->bulkDestroy($ids);

            return json_success(__('panel/product.bulk_delete_success', ['count' => $deletedCount]));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }

    

    public function isTodayDeal($product){
        try {
            $productObj = Product::findOrFail($product);
            $productObj->is_today_deal = !$productObj->is_today_deal;
            $productObj->save();
            return json_success(__('panel/common.updated_success'));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }
    }



    public function isHotDeal($product) {
        try {
            $productObj = Product::findOrFail($product);
            $productObj->is_hot_deal = !$productObj->is_hot_deal;
            $productObj->save();
            return json_success(__('panel/common.updated_success'));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }       
    }

    public function isFeatured($product) {
        try {
            $productObj = Product::findOrFail($product);
            $productObj->is_featured = !$productObj->is_featured;
            $productObj->save();
            return json_success(__('panel/common.updated_success'));
        } catch (Exception $e) {
            return json_fail($e->getMessage());
        }       
    }

   
}
