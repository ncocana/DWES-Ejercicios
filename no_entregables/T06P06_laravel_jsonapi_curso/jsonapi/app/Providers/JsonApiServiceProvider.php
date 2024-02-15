<?php

namespace App\Providers;

use App\Models\Article;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;

class JsonApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // TestResponse::macro(
        //     'assertJsonApiValidationErrors',
        //     function($attribute) {
        //         /** @var TestResponse $this */
        //         $this->assertJsonStructure([
        //             'errors' => [
        //                 ['title', 'detail', 'source' => ['pointer']]
        //             ]
        //         ])->assertJsonFragment([
        //             'source' => ['pointer' => "/data/attributes/{$attribute}"]
        //         ])->assertHeader(
        //             'content-type', 'application/vnd.api+json'
        //         )->assertStatus(422);
        //     }
        // );

        Builder::macro('allowedSorts', function($allowedSorts) {
            // Sort by order - Multiple fields
            if (request()->filled('sort')) {
                $sortFields = explode(',', request()->input('sort'));
        
                foreach ($sortFields as $sortField) {
                    $sortDirection = Str::of($sortField)->startsWith('-') ? 'desc' : 'asc';
                    $sortField = ltrim($sortField, '-');
                    
                    abort_unless(in_array($sortField, $allowedSorts), 400);
        
                    $this->orderBy($sortField, $sortDirection);
                }
            }

            return $this;
        });
    }
}
