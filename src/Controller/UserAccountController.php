<?php

declare(strict_types=1);

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UserAccountController extends AbstractController
{
    #[IsGranted('ROLE_USER')]
    #[Route('/user/show_flights', name: 'show_flights')]
    public function showFlights(): Response
    {
        return $this->render('userAccount/show_flights.html.twig', []);
    }
}