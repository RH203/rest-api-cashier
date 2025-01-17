<?php

namespace App\Http\Controllers\app;

use App\Http\Controllers\base\BaseController;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends BaseController
{
  public function login(Request $request)
  {
    try {

      $validated = $request->validate([
        'name' => 'required|string',
        'password' => 'required|string'
      ]);

      $data = User::where('name', $validated['name'])->first();

      if (!$data || $data->deleted_at != null || !Hash::check($validated['password'], $data->password)) {

        return $this->error(null, 'Unauthorized', 401);
      }

      $data->tokens()->delete();

      $token = $data->createToken($request->name, [$data->role]);
      $data->remember_token = $token->plainTextToken;
      $data->update();

      return $this->success($token->plainTextToken);

    } catch (AuthenticationException $exception) {

      return $this->error($exception->getMessage(), 'Authentication error', 401);
    }
  }

  public function register(Request $request)
  {
    try {
      $validated = $request->validate([
        'name' => 'required|string',
        'password' => 'required|string',
        'role' => 'required|string|in:cashier,admin',
      ]);

      $data = User::where('name', $validated['name'])->first();

      if (!$data) {
        User::create([
          'name' => $validated['name'],
          'password' => Hash::make($validated['password']),
          'role' => $validated['role'],
        ]);
      }

      return $this->success("Successfully registered");
    } catch (\Exception $exception) {
      return $this->error($exception->getMessage());
    }
  }

  public function logout(Request $request)
  {
    try {
      $validated = request()->validate([
        'id' => 'requred|integer'
      ]);

      $data = User::find($validated['id']);

      $data->tokens()->where('id', $validated['id'])->delete();

      return $this->success("Successfully logged out");

    }catch (AuthenticationException $exception) {
      return $this->error($exception->getMessage());
    }
  }
}
