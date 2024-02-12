<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteArticleTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_delete_articles(): void
    {
        $article= Article::factory()->create();

        // Verifica el estado 204, No Content
        $this->deleteJson(route('api.v1.articles.destroy', $article))->assertNoContent();

        // Verifica que en la tabla 'articles' no existe ningún artículo
        $this->assertDatabaseCount('articles', 0);
    }
}
