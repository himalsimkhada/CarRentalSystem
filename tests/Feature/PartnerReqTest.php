<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PartnerReqTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_partner_req_view_page()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 4)->first();

        $this->actingAs($user, 'api');

        $this->get(route('req.partnership'))->assertStatus(302);
    }

    public function test_view_all_reqs()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->get(route('admin.requests'))->assertStatus(200);
    }

    public function test_user_can_request_for_partner()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 7)->first();

        $this->actingAs($user, 'api');

        $data = [
            'company_name' => 'testing',
            'company_description' => 'test',
            'company_address' => 'test',
            'company_contact' => 'test',
            'company_reg' => 'testing',
            'company_email' => 'test',
            'user_id' => auth()->user()->id,
            'approved' => 'waiting'
        ];

        $this->json('POST', route('req.partnership.store'), $data)->assertStatus(200);
    }

    public function test_request_approved()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->json('GET', route('admin.req.approve', ['r_id' => 1]))->assertStatus(302);
    }


    public function test_request_deined()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 1)->first();

        $this->actingAs($user, 'api');

        $this->json('GET', route('admin.req.deny', ['deny_id' => 2]))->assertStatus(302);
    }
}
