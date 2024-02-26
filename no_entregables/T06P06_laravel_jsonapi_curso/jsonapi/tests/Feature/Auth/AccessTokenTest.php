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

        $data = $this->validCredentials([
            'email' => $this->user->email,
        ]);

        $response = $this->postJson(route('api.v1.login'), $data);

        $token = $response->json('plain-text-token');

        $dbToken = PersonalAccessToken::findToken($token);

        $this->assertTrue($dbToken->tokenable->is($this->user));
    }

    /** @test */
    public function password_must_be_valid(): void
    {
        $this->withoutJsonApiDocumentFormatting();

        $data = $this->validCredentials([
            'email' => $this->user->email,
            'password' => 'incorrect',
        ]);

        $response = $this->postJson(route('api.v1.login'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('email');
    }

    /** @test */
    public function user_must_be_registered(): void
    {
        $data = $this->validCredentials();

        $response = $this->postJson(route('api.v1.login'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrorFor('email');
    }

    /** @test */
    public function email_is_required(): void
    {
        $data = $this->validCredentials([
            'email' => null,
        ]);

        $response = $this->postJson(route('api.v1.login'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email' => 'required',
        ]);
    }

    /** @test */
    public function email_must_be_valid(): void
    {
        $data = $this->validCredentials([
            'email' => 'invalid-email',
        ]);

        $response = $this->postJson(route('api.v1.login'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'email' => 'email',
        ]);
    }

    /** @test */
    public function password_is_required(): void
    {
        $data = $this->validCredentials([
            'password' => null,
        ]);

        $response = $this->postJson(route('api.v1.login'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'password' => 'required',
        ]);
    }

    /** @test */
    public function device_name_is_required(): void
    {
        $data = $this->validCredentials([
            'device_name' => null,
        ]);

        $response = $this->postJson(route('api.v1.login'), $data);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'device_name' => 'required',
        ]);
    }

    protected function validCredentials(mixed $overrides = []): array
    {
        return array_merge([
            'email' => 'ncocana@cifpfbmoll.eu',
            'password' => 'password',
            'device_name' => 'My device',
        ], $overrides);
    }
}