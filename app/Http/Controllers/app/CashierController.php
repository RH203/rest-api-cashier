<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\base\BaseController;
use App\Models\Categories;
use App\Models\Products;
use App\Models\Reservations;
use App\Models\Tables;
use Illuminate\Http\Request;

class CashierController extends BaseController
{

  /**
   * Fitur cashier
   *
   * Crud pesanan
   * Crud reservations
   */

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

  public function showTable()
  {
    try {
      return $this->success(Tables::select('id', 'table_number')->get());
    } catch (\Exception $e) {
      return $this->error($e->getMessage());
    }
  }

  public function createOrder(Request $request)
  {
    try {
      $orderNumber = 'ORD-' . now()->format('YmdHis');


    } catch (\Exception $e) {
      // Handle exception
    }

  }

  public function createReservation(Request $request)
  {
    try {
      $validated = $request->validate([
        'contact_person' => 'required|string',
        'number_of_people' => 'required|integer',
        'reservation_date' => 'required|date|date_format:Y-m-d H:i:s',
        'user_id' => 'required|integer',
        'table_id' => 'required|integer',
      ]);

      $data = Reservations::find($validated['contact_person']);
      if ($data == null) {
        Reservations::create($validated);
        return $this->success('Reservation for ' . $validated['contact_person'] . ' created');
      }

      return $this->error('Reservation for ' . $validated['contact_person'] . ' already exists');

    } catch (\Exception $e) {
      return $this->error($e->getMessage());
    }
  }
}
