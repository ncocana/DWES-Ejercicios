<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleCollection extends ResourceCollection
{
    /**
     * Debido a convención, un Resource Collection busca un Resource Object con el mismo nombre
     * y lo envuelve con ese Resource Object.
     * Si tuvieran distintos nombres (ArticleCollection vs ArticlesResource),
     * añadir esta línea para indicar a la Collection qué Resource Object usar.
     */
    // public $collects = ArticleResource::class;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
            'links' => [
                'self' => route('api.v1.articles.index')
            ]
        ];
    }
}
