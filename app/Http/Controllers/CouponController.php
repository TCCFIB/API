<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\RestControllerTrait;
use App\Coupon;

class CouponController extends Controller
{
    use RestControllerTrait;

    const MODEL = 'App\Coupon';

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
        $totalData = Coupon::all()->count();

        if ($request->has('limit') && $request->has('offset')) {
            $data = Coupon::limit($request->input('limit'))
                    ->offset($request->input('offset'))
                    ->get();
        } else {
            $data = Coupon::all();
        }
        
        return $this->listResponse($data, $totalData);
    }
}
