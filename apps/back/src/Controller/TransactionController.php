<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\TransactionRepository;
use App\Entity\Transaction;
use App\Entity\User;

class TransactionController extends AbstractController
{

    public function __construct(
        private readonly TransactionRepository $transactionRepository
    ) {
    }


    #[Route('/transactions', name: 'transactions')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function transactions(): JsonResponse
    {
        $currentUserId = $this->getUser()->getId();
        $transactions = $this->transactionRepository->findBy(array('user' => $currentUserId));
        return new JsonResponse($transactions);
        
    }


    #[Route('/transactions/{id}', name: 'update_transaction', methods: ['PUT'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function updateTransaction(
        EntityManagerInterface $entityManager, 
        Transaction $transaction,
        Request $request
        ): JsonResponse
    {
        if ($transaction->getUser() != $this->getUser()) {
            return new JsonResponse('Not Found',404);
        }

        $address = $request->getPayload()->get('address');
        $latLong = $request->getPayload()->get('latLong');

        $transaction->setLocation($address);
        $transaction->setLatLong($latLong);
        $entityManager->persist($transaction);
        $entityManager->flush();

        return new JsonResponse($transaction);
    }

}
