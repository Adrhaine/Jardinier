<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



class MesureController extends AbstractController
{
    #[Route('/mesure', name: 'mesure', methods: ['POST', 'GET'])]
    public function index(Request $request, SessionInterface $session): Response
    {
        $choix = $request->request->get('user_type', null);
        dump($choix);

        if ($choix) {
            $session->set('user_type', $choix);
            dump($session->get('user_type'));
        }

        return $this->render('mesure/index.html.twig', [
            'controller_name' => 'MesureController',
        ]);
    }
}
