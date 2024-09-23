<?php

namespace App\Service;


class ChangeService
{
    public function calculateChange(int $change): array
    {
        $coins = [5000, 2000, 1000, 500, 200, 100, 50, 20, 10, 5, 2, 1];
        $changeDetails = [];

        foreach ($coins as $coin) {
            if ($change >= $coin) {
                $changeDetails[$coin] = intdiv($change, $coin);
                $change %= $coin;
            }
        }

        return $changeDetails;
    }
}
