<?php


namespace InnoShop\Front\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
// use InnoShop\Common\Models\LeadContact;
use InnoShop\Common\Repositories\LeadContactRepo;
// use InnoShop\Common\Repositories\ProductRepo;
// use InnoShop\Front\Traits\FilterSidebarTrait;
use Illuminate\Support\Facades\Validator;

class LeadContactController extends Controller
{
    // use FilterSidebarTrait;

    /**
     * @return mixed
     */
    public function index(): mixed
    {
        echo "testing"; 
        exit;

        $data = [
            'brands' => BrandRepo::getInstance()->withActive()->all()->groupBy('first'),
        ];

        return inno_view('leadcontact.contact_lead_form', $data);
    }

    public function store(Request $request)
    {
        $data     = $request->all();
        $validator = Validator::make($data, [
            'name'       => 'required|string|max:255',
            'email'      => 'required|email',
            'contact_no' => 'required|min:10|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Save data here        
        $leadContact = LeadContactRepo::getInstance()->create($data);

        return response()->json([
            'status' => true,
            'message' => 'Thank you! Your request has been submitted successfully.'
        ]);
    }

    //  public function store(Request $request) 
    // {
    //     try {
    //         $data     = $request->all();
    //         $leadContact = LeadContactRepo::getInstance()->create($data);
    //         echo "<pre>";
    //         print_r($data);
    //         exit;
    //         // return redirect(panel_route('categories.index'))
    //         //     ->with('instance', $category)
    //         //     ->with('success', panel_trans('common.updated_success'));
    //     } catch (Exception $e) {
    //         return back()->withInput()->withErrors(['error' => $e->getMessage()]);
    //     }
    // }

    /**
     * @param  Brand  $brand
     * @return mixed
     * @throws Exception
     */
    // public function show(Brand $brand): mixed
    // {
    //     return $this->renderShow($brand);
    // }

}
