<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\RestControllerTrait;
use App\Promotion;
use DB;

class PromotionController extends Controller
{
    use RestControllerTrait;

    const MODEL = 'App\Promotion';

    /**
     * Validation Rules for the Usuario Database.
     *
     * @var array
     */
    protected $validationRules = [];

    /**
     * Validation Rules for User Database on a patch request.
     *
     * @var array
     */
    protected $validationPatchRules = [];

    /**
     * Manage index request
     * @param Request $request
     * @return type
     */
    public function index(Request $request)
    {
        $totalData = Promotion::all()->count();

        if ($request->has('limit') && $request->has('offset')) {
            $data = Promotion::limit($request->input('limit'))
                    ->offset($request->input('offset'))
                    ->get();
        } else {
            $data = Promotion::all();
        }
        
        return $this->listResponse($data, $totalData);
    }

    /**
     * Manage buscar request
     * @param Request $request
     * @return type
     */
    public function search(Request $request)
    {
        $dataSearch = Promotion::search($request);
        $totalData = $dataSearch->count();
        
        return $this->listResponse($dataSearch, $totalData);
    }
}
