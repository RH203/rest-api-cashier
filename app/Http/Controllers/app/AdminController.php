<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\base\BaseController;
use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminController extends BaseController
{
  /**
   * Fitur admin
   *
   * CRUD User
   * CRUD Product
   * CRUD Categories
   * Laporan Penjualan perbulan
   */

  public function showCashier(Request $request)
  {
    try {
      return response()->json(User::all());
    } catch (\Exception $exception) {
      return $this->error('Failed to fetch users: ' . $exception->getMessage());
    }
  }

  public function updateCashier(Request $request)
  {
    try {
      $validated = $request->validate([
        'id' => 'required|integer',
        'name' => 'required|string',
        'password' => 'required|string',
        'role' => 'required|string|in:cashier,admin'
      ]);

      $data = User::findOrFail($validated['id']);

      $data->name = $validated['name'];
      $data->password = Hash::make($validated['password']);
      $data->role = $validated['role'];
      $data->save();

      return $this->success('User ' . $data->name . ' has been updated');
    } catch (ModelNotFoundException $exception) {
      return $this->error('User not found');
    } catch (ValidationException $exception) {
      return $this->error('Validation failed: ' . implode(', ', $exception->errors()));
    } catch (\Exception $exception) {
      return $this->error('Failed to update user: ' . $exception->getMessage());
    }
  }

  public function deleteCashier(Request $request)
  {
    try {
      $validated = $request->validate([
        'id' => 'required|integer',
      ]);

      $data = User::findOrFail($validated['id']);

      $data->deleted_at = now();
      $data->save();

      return $this->success('User ' . $data->name . ' has been deleted');
    } catch (ModelNotFoundException $exception) {
      return $this->error('User not found');
    } catch (ValidationException $exception) {
      return $this->error('Validation failed: ' . implode(', ', $exception->errors()));
    } catch (\Exception $exception) {
      return $this->error('Failed to delete user: ' . $exception->getMessage());
    }
  }

  public function createProduct(Request $request)
  {
    try {
      $validated = $request->validate([
        'products.*.name' => 'required|string',
        'products.*.price' => 'required|integer',
        'products.*.stock' => 'required|integer',
        'products.*.image' => 'required|string',
        'products.*.category_id' => 'required|integer',
      ]);

      $products = $validated['products'];

      foreach ($products as &$product) {
        $product['created_at'] = now();
        $product['updated_at'] = now();
      }

      Products::insert($products);

      return $this->success(count($products) . ' product(s) have been created');
    } catch (ValidationException $exception) {
      return $this->error('Validation failed: ' . implode(', ', $exception->errors()));
    } catch (\Exception $e) {
      return $this->error('Failed to create products: ' . $e->getMessage());
    }
  }

  public function updateProduct(Request $request)
  {
    try {
      $validated = $request->validate([
        'id' => 'required|integer',
        'name' => 'required|string',
        'price' => 'required|integer',
        'stock' => 'required|integer',
        'image' => 'required|string',
        'category_id' => 'required|integer',
      ]);

      $data = Products::findOrFail($validated['id']);

      $data->name = $validated['name'];
      $data->price = $validated['price'];
      $data->stock = $validated['stock'];
      $data->image = $validated['image'];
      $data->category_id = $validated['category_id'];

      $data->save();

      return $this->success('Product ' . $data->name . ' has been updated');
    } catch (ModelNotFoundException $exception) {
      return $this->error('Product not found');
    } catch (ValidationException $exception) {
      return $this->error('Validation failed: ' . implode(', ', $exception->errors()));
    } catch (\Exception $exception) {
      return $this->error('Failed to update product: ' . $exception->getMessage());
    }
  }

  public function deleteProduct(Request $request)
  {
    try {
      $validated = $request->validate([
        'id' => 'required|integer',
      ]);

      $data = Products::findOrFail($validated['id']);

      $data->deleted_at = now();
      $data->save();

      return $this->success('Product ' . $data->name . ' has been deleted');
    } catch (ModelNotFoundException $exception) {
      return $this->error('Product not found');
    } catch (ValidationException $exception) {
      return $this->error('Validation failed: ' . implode(', ', $exception->errors()));
    } catch (\Exception $e) {
      return $this->error('Failed to delete product: ' . $e->getMessage());
    }
  }
}
