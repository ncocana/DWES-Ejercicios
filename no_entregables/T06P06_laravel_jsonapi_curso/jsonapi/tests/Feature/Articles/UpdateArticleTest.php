<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateArticleTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_update_articles(): void
    {
        $article = Article::factory()->create();

        $response = $this->patchJson(route('api.v1.articles.update', $article), [
            'title' => 'Updated Article',
            'slug' => $article->slug,
            'content' => 'Updated content'
        ])->assertOk();

        $response->assertHeader(
            'Location',
            route('api.v1.articles.show', $article)
        );

        $response->assertExactJson([
            'data' => [
                'type' => 'articles',
                'id' => (string) $article->getRouteKey(),
                'attributes' => [
                    'title' => 'Updated Article',
                    'slug' => $article->slug,
                    'content' => 'Updated content',
                ],
                'links' => [
                    'self' => route('api.v1.articles.show', $article)
                ]
            ],
        ]);
    }
    
    public function title_is_required(): void
    {
        $article = Article::factory()->create();

        $this->patchJson(route('api.v1.articles.update', $article), [
            'slug' => 'updated-article',
            'content' => 'Updated content'
        ])->assertJsonApiValidationErrors('title');
    }

    /** @test */
    public function title_must_be_at_least_4_characters(): void
    {
        $article = Article::factory()->create();

        $this->patchJson(route('api.v1.articles.update', $article), [
            'title' => 'Upd',
            'slug' => 'updated-article',
            'content' => 'Updated content'
        ])->assertJsonApiValidationErrors('title');
    }

    /** @test */
    public function slug_is_required(): void
    {
        $article = Article::factory()->create();

        $this->patchJson(route('api.v1.articles.update', $article), [
            'title' => 'Updated Article',
            'content' => 'Updated content'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_must_be_unique()
    {
        $article1 = Article::factory()->create();
        $article2 = Article::factory()->create();

        $this->patchJson(route('api.v1.articles.update', $article1), [
            'title' => 'Nuevo artículo',
            'slug' => $article2->slug,  // Probamos guardar un artículo con un 'slug' existente.
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_only_must_contain_numbers_letters_and_dashes()
    {
        $article = Article::factory()->create();

        $this->patchJson(route('api.v1.articles.update', $article), [
            'title' => 'Nuevo artículo',
            'slug' => '$%^&',  // Caracteres no permitidos.
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_must_not_contain_underscores()
    {
        $article = Article::factory()->create();

        $this->patchJson(route('api.v1.articles.update', $article), [
            'title' => 'Nuevo artículo',
            'slug' => 'with_underscore',  // Guion bajo no está permitido.
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_must_not_start_with_dashes()
    {
        $article = Article::factory()->create();

        $this->patchJson(route('api.v1.articles.update', $article), [
            'title' => 'Nuevo artículo',
            'slug' => '-start-with-dashes',  // Guion bajo no está permitido.
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function slug_must_not_end_with_dashes()
    {
        $article = Article::factory()->create();

        $this->patchJson(route('api.v1.articles.update', $article), [
            'title' => 'Nuevo artículo',
            'slug' => 'start-with-dashes-',  // Guion bajo no está permitido.
            'content' => 'Contenido del artículo'
        ])->assertJsonApiValidationErrors('slug');
    }

    /** @test */
    public function content_is_required(): void
    {
        $article = Article::factory()->create();

        $this->patchJson(route('api.v1.articles.update', $article), [
            'title' => 'Updated Article',
            'slug' => 'updated-article',
        ])->assertJsonApiValidationErrors('content');
    }
}
