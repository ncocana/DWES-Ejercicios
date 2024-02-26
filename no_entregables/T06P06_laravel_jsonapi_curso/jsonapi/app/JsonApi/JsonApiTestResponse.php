<?php

namespace App\JsonApi;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Assert as PHPUnit;
use PHPUnit\Framework\ExpectationFailedException;

class JsonApiTestResponse
{
    public function assertJsonApiValidationErrors(): Closure
    {
        return function($attribute) {
            /** @var TestResponse $this */
            $pointer = Str::of($attribute)->startsWith('data')
                ? "/".str_replace('.', '/', $attribute)
                : "/data/attributes/{$attribute}";

            try {
                $this->assertJsonFragment([
                    'source' => ['pointer' => $pointer]
                ]);
            } catch (ExpectationFailedException $e) {
                PHPUnit::fail("Failed to find a JSON:API validation error for key: '{$attribute}'"
                    . PHP_EOL . PHP_EOL .
                    $e->getMessage());
            }

            try {
                $this->assertJsonStructure([
                    'errors' => [
                        ['title', 'detail', 'source' => ['pointer']]
                    ]
                ]);
            } catch (ExpectationFailedException $e) {
                PHPUnit::fail("Failed to find a valid JSON:API error response"
                    . PHP_EOL.PHP_EOL .
                    $e->getMessage());
            }

            $this->assertHeader(
                'content-type', 'application/vnd.api+json'
            )->assertStatus(422);
        };
    }

    protected function tryAlternativePointer(): Closure
    {
        return function($attribute) {
            /** @var TestResponse $this */
            $pointers = [
                "/{$attribute}",
                "/data/attributes/{$attribute}"
            ];

            $found = false;

            foreach ($pointers as $pointer) {
                try {
                    $this->assertJsonFragment([
                        'source' => ['pointer' => $pointer]
                    ]);
                    $found = true;
                    // If found, break the loop
                    break;
                } catch (ExpectationFailedException $e) {
                    // If not found, continue to the next pointer
                    continue;
                }
            }

            // If not found, return fail message
            if (!$found) {
                PHPUnit::fail("Failed to find a JSON:API validation error for key: '{$attribute}'"
                    . PHP_EOL . PHP_EOL .
                    $e->getMessage());
            }
        };
    }
}