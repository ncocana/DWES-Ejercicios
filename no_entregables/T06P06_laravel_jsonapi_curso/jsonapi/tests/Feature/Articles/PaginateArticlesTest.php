<?php

namespace Tests\Feature\Articles;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaginateArticlesTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function can_paginate_articles(): void
    {
        $articles = Article::factory(6)->create();

        // Route: "/api/v1/articles?page[size]=2&page[number]=2"
        $url = route('api.v1.articles.index', [
            'page' => [
                'size' => 2,
                'number' => 2
            ]
        ]);
        // dd(urldecode($url));

        $response = $this->getJson($url);

        // Con "size" 2 y "number" 2, se obtienen los artículos 2 y 3.
        $response->assertSee([
            $articles[2]->title,
            $articles[3]->title,
        ]);

        // No se deben ver el resto de artículos.
        $response->assertDontSee([
            $articles[0]->title,
            $articles[1]->title,
            $articles[4]->title,
            $articles[5]->title,
        ]);

        // Las cabeceras las añade el trait "MakesJsonApiRequests" en "/tests".
        // dd($response);
        $response->assertJsonStructure([
            'links' => ['first', 'last', 'prev', 'next']
        ]);

        $firstLink = urldecode($response->json('links.first'));
        $lastLink = urldecode($response->json('links.last'));
        $prevLink = urldecode($response->json('links.prev'));
        $nextLink = urldecode($response->json('links.next'));

        // dd($lastLink);
        $this->assertStringContainsString('page[size]=2', $firstLink);
        $this->assertStringContainsString('page[number]=1', $firstLink);

        $this->assertStringContainsString('page[size]=2', $lastLink);
        $this->assertStringContainsString('page[number]=3', $lastLink);

        $this->assertStringContainsString('page[size]=2', $prevLink);
        $this->assertStringContainsString('page[number]=1', $prevLink);

        $this->assertStringContainsString('page[size]=2', $nextLink);
        $this->assertStringContainsString('page[number]=3', $nextLink);
    }

    /** @test */
    public function can_paginate_and_sort_articles(): void
    {
        Article::factory()->create(['title' => 'C title']);
        Article::factory()->create(['title' => 'A title']);
        Article::factory()->create(['title' => 'B title']);

        // Route: "/api/v1/articles?sort=title&page[size]=1&page[number]=2"
        $url = route('api.v1.articles.index', [
            'sort' => 'title',
            'page' => [
                'size' => 1,
                'number' => 2
            ]
        ]);
        // dd(urldecode($url));

        $response = $this->getJson($url);

        // Ordena la respuesta por el "title" y devuelve la página 2 con tamaño 1.
        // Resultado de la respuesta páginada: 'B title'.
        $response->assertSee([
            'B title',
        ]);

        // No devolverá el resto de artículos.
        $response->assertDontSee([
            'A title',
            'C title',
        ]);

        $firstLink = urldecode($response->json('links.first'));
        $lastLink = urldecode($response->json('links.last'));
        $prevLink = urldecode($response->json('links.prev'));
        $nextLink = urldecode($response->json('links.next'));

        $this->assertStringContainsString('sort=title', $firstLink);
        $this->assertStringContainsString('sort=title', $lastLink);
        $this->assertStringContainsString('sort=title', $prevLink);
        $this->assertStringContainsString('sort=title', $nextLink);
    }
}
