<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Haie;

class HaieController extends AbstractController
{
    #[Route('/haie/creer', name: 'app_haie_creer')]
    public function haie_creer(EntityManagerInterface $entityManager): Response
    {
        $haie = new Haie();
        $haie->setCode('BU');
        $haie->setNom('Buisson');
        $haie->setPrix('15');

        $entityManager->persist($haie);
        $entityManager->flush();
        return new Response('Type de haie créer avec le code ' .$haie->getCode());
    }
    #[Route('/haie/{code}', name: 'app_haie_voir')]
    public function haie_voir(EntityManagerInterface $entityManager, string $code): Response
    {
        $haie = $entityManager->getRepository(Haie::class)->find($code);
        if (!$haie) {
            return new Response('Ce type de haie n\'existe pas : ' .$code);
        }
        else {
            return new Response('Type de haie : ' .$haie->getNom(). ' à : ' .$haie->getPrix(). '€');
        }
    }
    #[Route('/haie/modifier/{code}', name: 'app_haie_modifier')]
    public function modifier_haie(EntityManagerInterface $entityManager, string $code): Response
    {
        $haie = $entityManager->getRepository(Haie::class)->find($code);
        if (!$haie) {
            return new Response('Ce type de haie n\'existe pas : ' .$code);
        }
        else {
            $haie->setPrix('40');
            $entityManager->flush();
            return new Response('Le prix du : ' .$haie->getNom(). ' à été modifié à : ' .$haie->getPrix());
            return $this->redirectToRoute('app_haie_voir', ['code' => $haie->getCode()]);
        }
    } 
    #[Route('/haie/supprimer/{code}', name: 'app_haie_supprimer')]
    public function supprimer_haie(EntityManagerInterface $entityManager, string $code): Response
    {
        $haie = $entityManager->getRepository(Haie::class)->find($code);
        if (!$haie) {
            return new Response('Ce type de haie n\'existe pas :' .$code);
        }
        else {
            $entityManager->remove($haie);
            $entityManager->flush();
            return new Response('Le type de haie : ' .$haie->getNom(). ' à été supprimé');
        }
    }

    #[Route('/mesure', name: 'app_mesure_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $mesHaies = $entityManager->getRepository(Haie::class)->findAll();

        return $this->render('mesure/index.html.twig',
        array(
            'mesHaies' => $mesHaies,
        ));
    }

}
