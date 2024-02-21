<?php

namespace Tests\Feature\Articles;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CreateArticleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Creating and authenticating a user
        $user = User::factory()->create();
        Sanctum::actingAs($user);
    }

    /** @test */
    public function can_create_articles(): void
    {
        $this->withoutExceptionHandling();

        $response = $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo artículo',
            'slug' => 'nuevo-articulo',
            'content' => 'Contenido del artículo'
        ])->assertCreated();

        $article = Article::first();

        $response->assertHeader(
            'Location',
            route('api.v1.articles.show', $article)
        );

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => (string) $article->getRouteKey(),
                'attributes' => [
                    'title' => (string) $article->title,
                    'slug' => $article->slug,
                    'content' => $article->content,
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article)
                ]
            ],
        ]);
    }

    /** @test */
    public function title_is_required(): void
    {
        $this->postJson(route('api.v1.articles.store'), [
            'slug' => 'nuevo-articulo',
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('title');
    }

    /** @test */
    public function title_must_be_at_least_4_characters(): void
    {
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nue',
            'slug' => 'nuevo-articulo',
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('title');
    }

    /** @test */
    public function slug_is_required(): void
    {
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo Artículo',
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_must_be_unique()
    {
        $article= Article::factory()->create();

        // Probamos guardar un artículo con un 'slug' existente.
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo artículo',
            'slug' => $article->slug,
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_only_must_contain_numbers_letters_and_dashes()
    {
        // Caracteres no permitidos.
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo artículo',
            'slug' => '$%^&',
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_must_not_contain_underscores()
    {
        // Guion bajo no está permitido.
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo artículo',
            'slug' => 'with_underscore',
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_must_not_start_with_dashes()
    {
        // Guion al principio no está permitido.
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo artículo',
            'slug' => '-start-with-dashes',
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_must_not_end_with_dashes()
    {
        // Guion al final no está permitido.
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo artículo',
            'slug' => 'end-with-dashes-',
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function content_is_required(): void
    {
        $this->postJson(route('api.v1.articles.store'), [
            'title' => 'Nuevo Artículo',
            'slug' => 'nuevo-articulo',
        ])->assertJsonApiValidationErrors('content');
    }
}
