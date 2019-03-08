<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\RestControllerTrait;
use App\Promotion;
use App\PromotionLike;

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
            $promotions = Promotion::with('products', 'users')->get();
            $data = $this->runningPromotion($promotions);
        }
        
        return $this->listResponse($data, $totalData);
    }

    public function runningPromotion($promotions)
    {
        foreach ($promotions as $key => $promotion) {
            $promotion['likes'] = $this->getAllLikesByPromotion($promotion['id']);
        }

        return $promotions;
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
            $promotionLike = PromotionLike::where('promotion_id', $id)->where('user_id', $request->input('user_id'))->get();
            if (count($promotionLike) < 1) {
                $promotion = Promotion::find($id);
                $promotion->like++;
                $promotion->save();
                $promotionLike = PromotionLike::create($request->all());
            }
            $likes = $this->getAllLikesByPromotion($id);
            $data = Promotion::where('id', $id)->get();
            $dataReturn = $data[0];
            $dataReturn['likes'] = $likes;
            return $this->showResponse($dataReturn);
        } catch (\Exception $ex) {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
    }

    public function getAllLikesByPromotion($promotionId)
    {
        $likesByPromotion = PromotionLike::select('user_id')->where('promotion_id', $promotionId)->get();
        if ($likesByPromotion) {
            return $likesByPromotion;
        }
        
        return [];
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
            $bodyReport = new PromotionReport();
            $bodyReport->comment = $request->input('comment');
            $bodyReport->user_id = $request->input('user_id');
            $bodyReport->promotion_id = $promotion->id;
            $bodyReport->save();

            return $this->showResponse($promotion);
        } catch (\Exception $ex) {
            $data = ['form_validations' => $v->errors(), 'exception' => $ex->getMessage()];
            return $this->clientErrorResponse($data);
        }
    }
}
