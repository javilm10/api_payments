<?php

namespace App\Service;


class PaymentGatewayService
{
    // Simulación de envio al banco
    public function sendToBank(int $amount, string $currency, string $cardNum): bool
    {
        // Simulem una resposta exitosa
        return true;
    }
}
