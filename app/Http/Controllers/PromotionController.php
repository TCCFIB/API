<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\RestControllerTrait;
use App\Promotion;
use App\PromotionReport;
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
            $data = Promotion::with('products')->get();
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

    public function upLike(Request $request, $id)
    {
        $v = \Validator::make($request->all(), $this->validationPatchRules);
        try {
            $promotion = Promotion::find($id);
            $promotion->like++;
            $promotion->save();

            return $this->showResponse($promotion);
        } catch (\Exception $ex) {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
    }
    public function downLike(Request $request, $id)
    {
        $v = \Validator::make($request->all(), $this->validationPatchRules);
        try {
            $promotion = Promotion::find($id);
            $promotion->like--;
            $promotion->save();

            return $this->showResponse($promotion);
        } catch (\Exception $ex) {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
    }

    public function report(Request $request, $id)
    {
        $v = \Validator::make($request->all(), $this->validationPatchRules);
        try {
            $promotion = Promotion::find($id);
            $bodyReport = null;
            $bodyReport->comment = $request->input('comment');
            $bodyReport->user_id = $request->input('user_id');
            $bodyReport->promotion_id = $promotion->id;
            $data = PromotionReport::create($bodyReport);

            return $this->showResponse($promotion);
        } catch (\Exception $ex) {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
    }
}
