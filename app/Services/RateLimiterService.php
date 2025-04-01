<?php

namespace App\Services;

use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Str;

class RateLimiterService
{
    public function __construct(
        private RateLimiter $limiter
    ) {}

    public function hit(string $key, int $maxAttempts = 5): bool
    {
        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            return false;
        }

        $this->limiter->hit($key);
        return true;
    }

    public function clear(string $key): void
    {
        $this->limiter->clear($key);
    }
}