<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\PersonalAccessToken;
use Tests\TestCase;

class AccessTokenTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Creating and authenticating a user
        $this->user = User::factory()->create([
            'email' => 'example@example.com'
        ]);
    }

    /** @test */
    public function can_issue_access_token(): void
    {
        $this->withoutJsonApiDocumentFormatting();

        $data = [
            'email' => $this->user->email,
            'password' => 'password',
            'device_name' => 'My device',
        ];

        $response = $this->postJson(route('api.v1.login'), $data);

        $token = $response->json('plain-text-token');

        $dbToken = PersonalAccessToken::findToken($token);

        $this->assertTrue($dbToken->tokenable->is($this->user));
    }

    /** @test */
    public function password_must_be_valid(): void
    {
        $this->withoutJsonApiDocumentFormatting();

        $data = [
            'email' => $this->user->email,
            'password' => 'incorrect',
            'device_name' => 'My device',
        ];

        $response = $this->postJson(route('api.v1.login'), $data);

        // dd($response);
        $response->assertStatus(422);
        // $response->assertJson([
        //     'errors' => [
        //         [
        //             'detail' => 'These credentials do not match our records.',
        //             'source' => [
        //                 'pointer' => '/password'
        //             ]
        //         ]
        //     ]
        // ]);
        $response->assertJsonApiValidationErrors('password');
    }
}