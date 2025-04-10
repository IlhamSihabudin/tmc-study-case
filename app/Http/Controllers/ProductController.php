<?php

namespace App\Http\Controllers;

use App\Facades\Service\ProductService;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\ListProductRequest;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(ListProductRequest $request) {
        try {
            $lists = ProductService::search($request->validated());

            return ResponseFormatter::success($lists['datas'], $lists['pagging']);
        }catch (\Exception $e){
            return ResponseFormatter::error($e->getMessage());
        }
    }

    public function store(CreateProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = ProductService::store($request->validated());

            DB::commit();
            return ResponseFormatter::success($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
