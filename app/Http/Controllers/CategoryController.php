<?php

namespace App\Http\Controllers;

use App\Facades\Service\CategoryService;
use App\Helpers\ResponseFormatter;
use App\Http\Requests\Category\CreateCategoryRequest;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function store(CreateCategoryRequest $request){
        try {
            DB::beginTransaction();
            $data = CategoryService::store($request->validated());

            DB::commit();
            return ResponseFormatter::success($data);
        } catch (\Exception $e) {
            DB::rollBack();
            return ResponseFormatter::error($e->getMessage());
        }
    }
}
