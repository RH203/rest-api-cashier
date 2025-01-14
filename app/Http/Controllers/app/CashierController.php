<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\base\BaseController;
use App\Models\Categories;
use App\Models\Orders;
use App\Models\OrdersDetail;
use App\Models\Payments;
use App\Models\Products;
use App\Models\Reservations;
use App\Models\Tables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
      if (Cache::has('menu')) {
        $menu = Cache::get('menu');
        return $this->success($menu);
      }

      $data = Products::with(['category' => function ($query) {
        $query->select('id', 'name');
      }])
        ->select('id', 'name', 'category_id', 'price')
        ->get();


      Cache::put('menu', $data, now()->addMinutes(10));

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

      $data = $request->validate([
        'user_id' => 'required|integer',
        'amount_paid' => 'required|integer',
        'payment_method' => 'required|string|in:cash,card',
        'items' => 'required|array',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.product_id' => 'required|integer|exists:products,id',
      ]);

      DB::transaction(function () use ($orderNumber, $data) {
        $order = Orders::create([
          'user_id' => $data['user_id'],
          'order_number' => $orderNumber,
        ]);


        $totalPrice = 0;

        foreach ($data['items'] as $item) {
          $orderDetail = OrdersDetail::create([
            'order_id' => $order->id,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
          ]);

          $product = Products::find($item['product_id']);
          $totalPrice += $product->price * $item['quantity'];
        }


        $order->update(['total_price' => $totalPrice]);

        $payment = Payments::create([
          'order_id' => $order->id,
          'amount_paid' => $data['amount_paid'],
          'payment_method' => $data['payment_method'],
        ]);

        $changeDue = $payment->amount_paid - $totalPrice;

        $payment->update(['change_due' => $changeDue]);
      });


      return $this->success(
        Orders::select('id', 'order_number', 'total_price', 'created_at')->where('order_number', $orderNumber)->first(),
        'success',
        201
      );

    } catch (\Exception $e) {
      return $this->error(
        'Gagal membuat order.',
        'error',
        500
      );

    }
  }

  public function createReservation(Request $request)
  {
    try {

      $validated = $request->validate([
        'contact_person' => 'required|string',
        'number_of_people' => 'required|integer',
        'reservation_time' => 'required|date|date_format:Y-m-d H:i:s',
        'user_id' => 'required|integer',
        'table_number' => 'required|integer',
      ]);


      $data = Reservations::where('contact_person', $validated['contact_person'])->first();


      $table = Tables::where('table_number', $validated['table_number'])->first();

      if ($data === null && $table && $table->status === 'available') {

        DB::transaction(function () use ($validated, $table) {
          $reservation = Reservations::create([
            'contact_person' => $validated['contact_person'],
            'number_of_people' => $validated['number_of_people'],
            'reservation_time' => $validated['reservation_time'],
            'user_id' => $validated['user_id'],
            'table_id' => $validated['table_number'],
          ]);


          $table->update(['status' => 'reserved']);
        });


        return $this->success('Reservation for ' . $validated['contact_person'] . ' created');
      }


      return $this->error('Reservation for ' . $validated['contact_person'] . ' already exists or table is not available');

    } catch (\Exception $e) {
      return $this->error($e->getMessage());
    }
  }

}
