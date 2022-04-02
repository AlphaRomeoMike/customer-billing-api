<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Models\Bill;
use App\Mail\BillGenerated;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/mailable', function () {
  $user = User::find(2);
  $id = $user->id;
  $bill = Bill::where('user_id', $id)->first();

  return new BillGenerated($user, $bill);
});
