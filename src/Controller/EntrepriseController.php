<?php

namespace App\Controller;

use App\Entity\Entreprise;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class EntrepriseController extends AbstractController
{

    #[Route('/research/entreprise/database/{titre}', name:"entreprise_database")]
    public function researchDatabase(EntityManagerInterface $entityManager, String $titre): JsonResponse
    {
        $entreprises = array();
        if($titre != "" || $titre != null) {
            $entreprises = $entityManager->getRepository(Entreprise::class)->findAllByResarch($titre);    
        }
        $json = array();
        foreach ($entreprises as $entreprise) {
            $json[$entreprise->getSymbole()] = $entreprise->getNom();
        }
        return $this->json($json, 200);
    }

    #[Route('/research/entreprise/api/{keywords}', name:"entreprise_alphavantage")]
    public function researchAlphavantage($keywords): JsonResponse
    {

        return $this->json(['message' => 'Test alphavantage']);
    }

}
