<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Haie; 

class DevisController extends AbstractController
{
    #[Route('/devis', name: 'devis', methods: ['POST'])]
    public function index(Request $request, SessionInterface $session, EntityManagerInterface $entityManager): Response
    {
        $typeUtilisateur = $session->get('user_type', 'particulier');
        dump($typeUtilisateur);


        // Récupération des données POST
        $typeHaie = $request->request->get('type', 'Inconnu');
        $longueur = $request->request->get('longueur', 0);
        $hauteur = $request->request->get('hauteur', 0);


        $haie = $entityManager->getRepository(Haie::class)->findOneBy(['code' => $typeHaie]);


        if (!$haie) {
            return $this->render('devis/index.html.twig', [
                'controller_name' => 'DevisController',
                'typeUtilisateur' => ucfirst($typeUtilisateur),
                'typeHaie' => 'Inconnu',
                'longueur' => $longueur,
                'hauteur' => $hauteur,
                'prix' => 0,
                'error' => 'Type de haie non trouvé en base de données.',
            ]);
        }

        $prixUnitaire = $haie->getPrix();
        $nomHaie = $haie->getNom();

        // Calcul du prix
        $prix = $prixUnitaire * $longueur;

        if ($hauteur > 1.5) {
            $prix *= 1.5;
        }

        if ($typeUtilisateur === 'entreprise') {
            $prix *= 0.9; // Réduction de 10 % pour les entreprises
        }

        return $this->render('devis/index.html.twig', [
            'controller_name' => 'DevisController',
            'typeUtilisateur' => ucfirst($typeUtilisateur),
            'typeHaie' => $nomHaie,
            'longueur' => $longueur,
            'hauteur' => $hauteur,
            'prix' => $prix,
        ]);
    }
}
