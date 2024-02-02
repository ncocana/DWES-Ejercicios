<?php

namespace Tests\Feature;

use App\Http\Middleware\ValidateJsonApiHeaders;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class ValidateJsonApiHeadersTest extends TestCase
{
    use RefreshDatabase;

    // Create route for testing for this test
    protected function setup():void {
        parent::setup();
        Route::any('test_route', fn() => 'Ok')->middleware(ValidateJsonApiHeaders::class);
        Route::any('empty_response', fn() => response()->noContent())->middleware(ValidateJsonApiHeaders::class);
    }

    /** @test */
    public function accept_header_must_be_present_in_all_request(): void
    {
        // Sin cabecera 'accept', devolverá un estado 406
        $this->get('test_route')->assertStatus(406);

        // Inspeccionar una respuesta con dump()
        // Para que salga con mas claridad,
        // en ".env" cambiar "APP_DEBUG" a  "APP_DEBUG=false"
        // $this->get('test_route')->dump()->assertStatus(406);

        // "APP_DEBUG=true"
        // Con "APP_DEBUG=false", devuelve un JSON vacío con un mensaje vacío
        // Para mostrar un mensaje no-vacío,
        // "throw new HttpException(406, __('Not Acceptable'))" en el Middleware
        // $this->getJson('test_route')->dump()->assertStatus(406);

        // En la función 'get', el segundo parámetro puede contener las cabeceras
        $this->get('test_route', [
            'accept'=>'application/vnd.api+json'
        ])->assertSuccessful();
    }

    /** @test */
    public function content_type_header_must_be_present_in_all_post_request(): void
    {
        // Sin cabecera 'accept', devolverá un estado 406
        $this->post('test_route')->assertStatus(406);

        // Con la cabecera 'accept' pero sin la cabecera 'content-type',
        // devolverá un estado 425
        // El tercer parámetro contiene las cabeceras.
        $this->post('test_route', [], [
            'accept'=> 'application/vnd.api+json'
        ])->assertStatus(415);

        // Con ambas cabeceras, devolverá un estado entre 200 y 300
        $this->post('test_route', [], [
            'accept'=>'application/vnd.api+json',
            'content-type'=>'application/vnd.api+json'
        ])->assertSuccessful();
    }

    /** @test */
    public function content_type_header_must_be_present_in_all_patch_request(): void
    {
        // Sin cabecera 'accept', devolverá un estado 406
        $this->patch('test_route')->assertStatus(406);

        // Con la cabecera 'accept' pero sin la cabecera 'content-type',
        // devolverá un estado 425
        // El tercer parámetro contiene las cabeceras.
        $this->patch('test_route', [], [
            'accept'=> 'application/vnd.api+json'
        ])->assertStatus(415);

        // Con ambas cabeceras, devolverá un estado entre 200 y 300
        $this->patch('test_route', [], [
            'accept'=>'application/vnd.api+json',
            'content-type'=>'application/vnd.api+json'
        ])->assertSuccessful();
    }

    /** @test */
    public function content_type_header_must_be_present_in_all_request(): void
    {
        $this->get('test_route', [
            'accept'=>'application/vnd.api+json'
        ])->assertHeader('content-type', 'application/vnd.api+json');
    }

    /** @test */
    public function content_type_header_must_not_be_present_in_empty_responses(): void
    {
        $this->delete('empty_response', [], [])->assertStatus(406);

        $this->get('empty_response', [
            'accept'=>'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

        $this->post('empty_response', [], [
            'accept'=>'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

        $this->patch('empty_response', [], [
            'accept'=>'application/vnd.api+json',
            'content-type' => 'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');

        $this->delete('empty_response', [], [
            'accept'=>'application/vnd.api+json'
        ])->assertHeaderMissing('content-type');
    }
}
