<?php


namespace InnoShop\Front\Controllers;

use App\Http\Controllers\Controller;
use InnoShop\Common\Repositories\ArticleRepo;
use InnoShop\Common\Repositories\CategoryRepo;
use InnoShop\Common\Repositories\ProductRepo;
use InnoShop\Common\Models\Product\PropertyProps;
use InnoShop\Front\Repositories\HomeRepo;
use Detection\MobileDetect;

class HomeController extends Controller
{
    /**
     * @return mixed
     * @throws \Exception
     */
    public function index(): mixed
    {
        $detect = new MobileDetect();
        $isMobile = $detect->isMobile();
        $isTablet = $detect->isTablet();
        
        $todayDealProducts  = ProductRepo::getInstance()->getTodayDealProducts(3);
        // $hotDealProducts    = ProductRepo::getInstance()->getHotDealProducts();
        $featuredProducts   = ProductRepo::getInstance()->getFeaturedProducts();

        // $bestSeller  = ProductRepo::getInstance()->getBestSellerProducts();
        // $newArrivals        = ProductRepo::getInstance()->getLatestProducts();
        $propertyForSale        = ProductRepo::getInstance()->getPropertyForSale();
        $propertyForRent        = ProductRepo::getInstance()->getPropertyForRent();
        
        
        $popularProducts    = ProductRepo::getInstance()->getPopularProducts(4);
        $tabProducts = [
            // ['tab_title' => trans('front/home.bestseller'), 'products' => $bestSeller],
            ['tab_title' => trans('front/home.new_arrival'), 'products' => $featuredProducts],
        ];
        
        $activeCategories = CategoryRepo::getInstance()->getActiveCategories(6);
        // echo "<pre>";
        // print_r($propertyForSale);
        // exit;

        $news = ArticleRepo::getInstance()->getLatestArticles();
        $data = [
            'slideshow'       => HomeRepo::getInstance()->getSlideShow(),
            'tab_products'    => $tabProducts,
            'news'            => $news,
            'hot_products'    => $this->getHotProducts(),
            'home_categories' => HomeRepo::getInstance()->getHomeCategories(),
            'today_deal_products' => $todayDealProducts,
            // 'hot_deal_products' => $hotDealProducts,
            'propertyForSale' => $propertyForSale,
            'propertyForRent' => $propertyForRent,
            // 'active_categories' => $activeCategories,
            'popularProducts'=> $popularProducts,
            'isMobile'=> $isMobile,
            'isTablet'=> $isTablet,
            'getAreaTypeOptions'=> PropertyProps::getAreaTypeOptions()
        ];
        
        // echo "<pre>";
        // print_r($data);
        // exit;
        $data = fire_hook_filter('home.index.data', $data);
        return inno_view('home_new', $data);
    }

    /**
     * Get hot products from settings, organized by category
     * Returns array of category groups with their products
     *
     * @return array Array of category groups: [['category_id' => 1, 'category_name' => 'xxx', 'products' => [...]], ...]
     */
    private function getHotProducts(): array
    {
        $hotProductsSetting = system_setting('home_hot_products', '{}');

        // Handle both string and array return types from system_setting
        if (is_array($hotProductsSetting)) {
            $hotProductsData = $hotProductsSetting;
        } else {
            $hotProductsData = json_decode($hotProductsSetting, true) ?: [];
        }

        if (empty($hotProductsData) || ! isset($hotProductsData['categories']) || ! is_array($hotProductsData['categories'])) {
            return [];
        }

        $categoryGroups = [];

        try {
            $allProductIds = [];
            foreach ($hotProductsData['categories'] as $categoryGroup) {
                if (isset($categoryGroup['products']) && is_array($categoryGroup['products'])) {
                    $allProductIds = array_merge($allProductIds, $categoryGroup['products']);
                }
            }

            if (empty($allProductIds)) {
                return [];
            }

            $products = ProductRepo::getInstance()->builder(['active' => true])
                ->whereIn('products.id', array_unique($allProductIds))
                ->with(['masterSku', 'skus', 'translation'])
                ->get();

            // 获取所有分类ID，用于批量获取分类名称
            $categoryIds = [];
            foreach ($hotProductsData['categories'] as $categoryGroup) {
                if (isset($categoryGroup['category_id'])) {
                    $categoryIds[] = $categoryGroup['category_id'];
                }
            }

            // 批量获取分类信息
            $categories = [];
            if (! empty($categoryIds)) {
                $categoryModels = CategoryRepo::getInstance()
                    ->builder(['category_ids' => array_unique($categoryIds)])
                    ->with(['translation'])
                    ->get();
                foreach ($categoryModels as $category) {
                    $categories[$category->id] = $category->fallbackName();
                }
            }

            foreach ($hotProductsData['categories'] as $categoryGroup) {
                if (! isset($categoryGroup['products']) || ! is_array($categoryGroup['products']) || empty($categoryGroup['products'])) {
                    continue;
                }

                $categoryId = $categoryGroup['category_id'] ?? 0;
                // 优先使用从数据库查询的多语言分类名称，如果不存在则使用配置中的名称
                $categoryName = $categories[$categoryId] ?? ($categoryGroup['category_name'] ?? "分类 ID: {$categoryId}");

                $categoryProducts = [];
                foreach ($categoryGroup['products'] as $productId) {
                    $product = $products->firstWhere('id', $productId);
                    if ($product) {
                        $categoryProducts[] = HomeRepo::getInstance()->formatProductData($product);
                    }
                }

                if (! empty($categoryProducts)) {
                    $categoryGroups[] = [
                        'category_id'   => $categoryId,
                        'category_name' => $categoryName,
                        'products'      => $categoryProducts,
                    ];
                }
            }

            return $categoryGroups;
        } catch (\Exception $e) {
            return [];
        }
    }

    
}
