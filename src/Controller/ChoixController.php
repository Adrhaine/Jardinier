<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChoixController extends AbstractController
{
    #[Route('/choix', name: 'choix', methods: ['GET', 'POST'])]
    public function index(Request $request, SessionInterface $session): Response
    {
        return $this->render('choix/index.html.twig', [
            'controller_name' => 'ChoixController',
        ]);
    }
}
