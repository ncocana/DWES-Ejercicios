<?php

namespace Tests\Feature;

use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\Type\VoidType;
use Tests\TestCase;

class ValidateJsonApiHeadersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::any('test_route', fn() => 'OK')
            ->middleware(ValidateJsonApiHeaders::class);
    }
    
    /** @test */
    public function accept_header_must_be_present_in_all_requests(): void
    {
        $this->get('test_route')->assertStatus(406);

        $this->get('test_route', [
            'accept' => 'application/vnd.api+json'
        ])->assertSuccessful();
    }
    
    /** @test */
    public function content_type_header_must_be_present_in_all_requests(): void
    {
        // Primer parametro: endpoint
        // Segundo parametro: body
        // Tercer parametro: headers
        $this->post('test_route', [], [
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415);

        $this->post('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful();
    }
    
    /** @test */
    public function content_type_header_must_be_present_in_all_posts_requests(): void
    {
        // Primer parametro: endpoint
        // Segundo parametro: body
        // Tercer parametro: headers
        $this->post('test_route', [], [
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415);

        $this->post('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful();
    }
    
    /** @test */
    public function content_type_header_must_be_present_in_all_patch_requests(): void
    {
        // Primer parametro: endpoint
        // Segundo parametro: body
        // Tercer parametro: headers
        $this->patch('test_route', [], [
            'accept' => 'application/vnd.api+json'
        ])->assertStatus(415);

        $this->patch('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertSuccessful();
    }
    
    /** @test */
    public function content_type_header_must_be_present_in_response() {
        $this->get('test_route', [
            'accept' => 'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json');

        $this->post('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json');

        $this->patch('test_route', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json');
    }
    
    /** @test */
    public function content_type_header_must_not_be_present_in_empty_response() {
        Route::any('empty_response', fn() => response()->noContent())
            ->middleware(ValidateJsonApiHeaders::class);

        $this->get('empty_response', [
            'accept' => 'application/vnd.api+json',
        ])->assertHeaderMissing('content-type');

        $this->post('empty_response', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

        $this->patch('empty_response', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

        $this->delete('empty_response', [], [
            'accept' => 'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');
    }
}
