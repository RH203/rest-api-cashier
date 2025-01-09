<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\base\BaseController;
use App\Models\Categories;
use App\Models\Products;

class CashierController extends BaseController
{
  public function getCategory()
  {
    try {
      return $this->success(Categories::select('id', 'name')->get());
    } catch (\Exception $e) {
      return $this->error($e->getMessage());
    }
  }

  public function getMenu()
  {
    try {
      $data = Products::with(['category' => function ($query) {
        $query->select('id', 'name');
      }])
        ->select('id', 'name', 'category_id', 'price', 'stock')
        ->get();

      return $this->success($data);
    } catch (\Exception $e) {
      return $this->error($e->getMessage());
    }
  }
}
