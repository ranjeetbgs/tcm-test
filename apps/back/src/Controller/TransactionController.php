<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\TransactionRepository;
use App\Entity\User;

class TransactionController extends AbstractController
{

    public function __construct(
        private readonly TransactionRepository $transactionRepository,
    ) {
    }


    #[Route('/transactions', name: 'transactions')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function transactions(): JsonResponse
    {
        $user = $this->getUser();
        $transactions = $this->transactionRepository->findBy(array('user' => $user->getId()));
        return new JsonResponse($transactions);
        
    }

}
