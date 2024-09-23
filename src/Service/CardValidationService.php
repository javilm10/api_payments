<?php

namespace App\Service;


class CardValidationService
{
    public function isValidCard(string $cardNum): bool
    {
        $sum = 0;
        $alt = false;

        for ($i = strlen($cardNum) - 1; $i >= 0; $i--) {
            $n = intval($cardNum[$i]);

            if ($alt) {
                $n *= 2;
                if ($n > 9) {
                    $n -= 9;
                }
            }
            $sum += $n;
            $alt = !$alt;
        }

        return ($sum % 10 == 0);
    }
}
