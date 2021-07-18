<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CredentialsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_company_credentials_display_view()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->get(route('company.credential'))->assertStatus(200);
    }

    public function test_company_adds_credentails()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $data = [
            'credential_name' => 'test',
            'credetial_file' => UploadedFile::fake()->create('document.pdf'),
            'image' => UploadedFile::fake()->image('fake.jpg'),
            'credential_id' => rand(0,10000),
            'company_id' => 1,
        ];

        $this->json('POST', route('company.store.credential'), $data)->assertStatus(302);
    }

    public function test_company_edits_credentails()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $data = [
            'credential_name' => 'test',
            'credetial_file' => UploadedFile::fake()->create('document.pdf'),
            'image' => UploadedFile::fake()->image('fake.jpg'),
            'credential_id' => rand(0,10000),
            'company_id' => 1,
        ];

        $this->json('POST', route('company.update.credential', ['id' => 1]), $data)->assertStatus(302);
    }

    public function test_company_deletes_credential()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 3)->first();

        $this->actingAs($user, 'api');

        $this->json('GET', route('company.delete.credential', ['id' => 1]))->assertStatus(302);
    }

    public function test_user_credentials_display_view()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 5)->first();

        $this->actingAs($user, 'api');

        $this->get(route('user.credential'))->assertStatus(200);
    }

    public function test_user_adds_credentails()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 5)->first();

        $this->actingAs($user, 'api');

        $data = [
            'credential_name' => 'test',
            'credetial_file' => UploadedFile::fake()->create('document.pdf'),
            'image' => UploadedFile::fake()->image('fake.jpg'),
            'credential_id' => 125555,
            'user_id' => 5,
        ];

        $this->json('POST', route('user.store.credential'), $data)->assertStatus(302);
    }

    public function test_user_edits_credentails()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 5)->first();

        $this->actingAs($user, 'api');

        $data = [
            'credential_name' => 'test',
            'credetial_file' => UploadedFile::fake()->create('document.pdf'),
            'image' => UploadedFile::fake()->image('fake.jpg'),
            'credential_id' =>  10000,
            'user_id' => 5,
        ];

        $this->json('POST', route('user.update.credential', ['id' => 2]), $data)->assertStatus(302);
    }

    public function test_user_deletes_credential()
    {
        $this->withoutExceptionHandling();

        $user = User::where('id', '=', 5)->first();

        $this->actingAs($user, 'api');

        $this->json('GET', route('user.delete.credential', ['id' => 2]))->assertStatus(302);
    }
}
