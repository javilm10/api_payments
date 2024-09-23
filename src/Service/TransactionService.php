<?php

namespace App\Service;

use App\Entity\Transaction;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
// Servicio para crear los registros a la bbdd 
class TransactionService
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // Creamos un objeto del la clase Transaction y lo guardamos en bbdd mediante el Entity Manager de Doctrine
    public function createTransaction(int $amount, string $currency, int $cardNum): bool
    {
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setCurrency($currency);
        $transaction->setCardNumber($cardNum);
        $transaction->setCreatedAdd(new DateTime());
        $this->entityManager->persist($transaction); // Marcar el objeto para su posterior guardado
        $this->entityManager->flush(); // Guardamos todos los objetos marcados 

        return true;
    }
}
