<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ContactUsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_main_view()
    {
        $this->withoutExceptionHandling();

        $this->get(route('contactus.create'))->assertStatus(200);
    }

    public function test_check_contact_admin()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.messages'))->assertStatus(200);
    }

    public function test_check_contact_company()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $this->get(route('company.messages'))->assertStatus(200);
    }

    public function test_can_email_customer()
    {
        $this->withoutExceptionHandling();

        $company = Company::where('id', '=', 1)->first();

        $this->actingAs($company, 'company');

        $this->json('POST', route('company.support.customer', ['id' => 1, 'user_id' => 1]))->assertStatus(302);
    }


    public function test_can_send_support_message()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $data = [
            'fullname' => 'test',
            'email' => 'test',
            'contact_num' => 'test',
            'message' => 'test',
            'type' => 'emr',
            'user_id' => 4
        ];

        $this->json('POST', route('contactus.post'), $data)->assertStatus(200);
    }
}
