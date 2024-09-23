<?php

namespace App\Controller;

use App\Service\CardValidationService;
use App\Service\ChangeService;
use App\Service\PaymentGatewayService;
use App\Service\TransactionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{


    /*Recibe una petición de JSON con los datos que necesitamos */
    #[Route('/api/payment/card', name: 'app_payment_card', methods: ["POST"])]
    public function cardPayment(Request $request, CardValidationService $cardValidationService, PaymentGatewayService $paymentGatewayService, TransactionService $transactionService): JsonResponse
    {
        /*Extraemos los datos */
        $data = json_decode($request->getContent(), true);
        $amount = $data['amount'];
        $currency = $data['currency'];
        $cardNum = $data['card_num'];

        // Valida la tarjeta con el algoritmo de Luhn  y valida que sean números
        if (!is_numeric($cardNum) || !$cardValidationService->isValidCard($cardNum)) {
            return $this->json(['success' => false, 'error' => 702]);
        }

        // Simula el envio al banco
        $paymentSucess = $paymentGatewayService->sendToBank($amount, $currency, $cardNum);
        if ($paymentSucess) {
            $transactionService->createTransaction($amount, $currency, $cardNum);
            return $this->json(['success' => true]);
        }
        return $this->json(['success' => false, 'error' => 702]);
    }


    // Recibe una petición con el importe y las monedas introducidas en JSON
    #[Route('/api/payment/cash', name: 'app_payment_cash', methods: ["POST"])]
    public function cashPayment(Request $request, ChangeService $changeService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $amount = $data['amount'];
        $currency = $data['currency'];
        $coins = $data['coin_types'];

        // Calcula el canvio
        $paidAmount = 0;
        foreach ($coins as $coinValue => $coinCount) {
            $paidAmount += $coinValue * $coinCount;
        }

        $change = $paidAmount - $amount;
        if ($change < 0) {
            return $this->json(['success' => false, 'error' => 'Insufficient funds']);
        }

        // Generar el canvio con las minimas monedas
        $changeDetails = $changeService->calculateChange($change);

        return $this->json([
            'success' => true,
            'amount' => $change,
            'coin_types' => $changeDetails
        ]);
    }
}
