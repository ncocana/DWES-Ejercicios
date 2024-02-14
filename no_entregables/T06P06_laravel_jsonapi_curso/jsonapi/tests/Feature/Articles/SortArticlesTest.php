<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SortArticlesTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_sort_articles_by_title(): void
    {
        Article::factory()->create(['title' => 'C title']);
        Article::factory()->create(['title' => 'A title']);
        Article::factory()->create(['title' => 'B title']);

        // Query Sort = "/articles?sort=title"
        $url = route('api.v1.articles.index', ['sort' => 'title']);
        // dd($url);
        
        $this->getJson($url)->assertSeeInOrder([
            'A title',
            'B title',
            'C title',
        ]);
    }
    
    /** @test */
    public function can_sort_articles_by_title_descending(): void
    {
        Article::factory()->create(['title' => 'C title']);
        Article::factory()->create(['title' => 'A title']);
        Article::factory()->create(['title' => 'B title']);

        // Query Sort = "/articles?sort=-title"
        $url = route('api.v1.articles.index', ['sort' => '-title']);
        // dd($url);
        
        $this->getJson($url)->assertSeeInOrder([
            'C title',
            'B title',
            'A title',
        ]);
    }
    
    /** @test */
    public function can_sort_articles_by_content(): void
    {
        Article::factory()->create(['content' => 'C content']);
        Article::factory()->create(['content' => 'A content']);
        Article::factory()->create(['content' => 'B content']);

        // Query Sort = "/articles?sort=content"
        $url = route('api.v1.articles.index', ['sort' => 'content']);
        // dd($url);
        
        $this->getJson($url)->assertSeeInOrder([
            'A content',
            'B content',
            'C content',
        ]);
    }
    
    /** @test */
    public function can_sort_articles_by_content_descending(): void
    {
        Article::factory()->create(['content' => 'C content']);
        Article::factory()->create(['content' => 'A content']);
        Article::factory()->create(['content' => 'B content']);

        // Query Sort = "/articles?sort=-content"
        $url = route('api.v1.articles.index', ['sort' => '-content']);
        // dd($url);
        
        $this->getJson($url)->assertSeeInOrder([
            'C content',
            'B content',
            'A content',
        ]);
    }
}
