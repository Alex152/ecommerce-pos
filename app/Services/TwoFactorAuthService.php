<?php

namespace App\Services;

use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use PragmaRX\Google2FAQRCode\Google2FAQRCode;

class TwoFactorAuthService
{
    public function __construct(
        private TwoFactorAuthenticationProvider $provider
    ) {}

    public function generateSecretKey(): string
    {
        return $this->provider->generateSecretKey();
    }

    public function getQRCodeUrl(string $email, string $secret): string
    {
        return (new Google2FAQRCode)->getQRCodeInline(
            config('app.name'),
            $email,
            $secret
        );
    }

    public function verifyCode(string $secret, string $code): bool
    {
        return $this->provider->verify($secret, $code);
    }
}