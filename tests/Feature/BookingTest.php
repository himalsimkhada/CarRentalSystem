<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookingTest extends TestCase
{
   /**
    * A basic feature test example.
    *
    * @return void
    */

   public function test_user_can_book_index()
   {
      $this->withoutExceptionHandling();

      $user = User::where('id', '=', 5)->first();

      $this->actingAs($user, 'api');

      $values = [
         'booking_date' => date('Y-m-d H:i:s'),
         'date' => date('Y-m-d'),
         'return_date' => date('Y-m-d'),
         'status' => 'ongoing',
         'final_cost' => '2000',
         'payment' => 0,
         'booking_type_id' => 3,
         'car_id' => 1,
         'user_id' => auth()->user()->id,
         'location_id' => 1
      ];

      $this->json('GET', route('user.car.book.index', ['car-id' => 1, 'bookingtype' => 'Normal']), $values)->assertStatus(302);
   }

   public function test_user_can_book_list()
   {
      $this->withoutExceptionHandling();

      $user = User::where('id', '=', 5)->first();

      $this->actingAs($user, 'api');

      $values = [
         'booking_date' => date('Y-m-d H:i:s'),
         'date' => date('Y-m-d'),
         'return_date' => date('Y-m-d'),
         'status' => 'ongoing',
         'final_cost' => '2000',
         'payment' => 0,
         'booking_type_id' => 3,
         'car_id' => 1,
         'user_id' => auth()->user()->id,
         'location_id' => 1,
      ];

      $this->json('POST', route('user.car.book.list', ['bookingtype' => 'Normal', 'car-id' => '1'], $values))->assertStatus(302);
   }

   public function test_user_can_pay()
   {
      $this->withoutExceptionHandling();

      $user = User::where('id', '=', 5)->first();

      $this->actingAs($user, 'api');

      $values = [
         'paypal_payer_id' => 'test',
         'transaction_id' => 'test',
         'paypal_email_address' => 'test',
         'create_time' => 'test',
         'update_time' => 'test',
         'paypal_payer_name' => 'test',
         'amount' => 'test',
         'address' => 'test',
         'booking_id' => 1,
      ];

      $this->json('GET', route('payment.paid', ['car_id' => 1, 'booking_id_id' => 1]), $values)->assertStatus(302);
   }
}
