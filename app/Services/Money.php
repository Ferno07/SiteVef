<?php

namespace App\Services;

class Money
{
    // Parité officielle BCEAO, franc CFA de l'UEMOA (XOF).
    public const XOF_PER_EUR = 655.957;

    public static function fcfa(float $euros): string
    {
        return number_format(round($euros * self::XOF_PER_EUR), 0, ',', ' ').' FCFA';
    }

    public static function cents(float $amount, string $currency = 'eur'): int
    {
        return (int) round(($currency === 'xof' ? $amount / self::XOF_PER_EUR : $amount) * 100);
    }
}
