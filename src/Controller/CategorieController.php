<?php

namespace App\Controller;

use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie/new', name: 'app_categorie')]
    public function new(EntityManagerInterface $entityManagerInterface): Response
    {
        $categorie = new Categorie;
        $categorie->setNom('penflet');
        $categorie->setDescription('pour rigoler de quelquun');

        // Indique à Doctrine que tu souhaites SAUVER l'Article VIA persist()
        $entityManagerInterface->persist($categorie);

        // Execute l'objet (INSERT query)
        $entityManagerInterface->flush();

        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    // la route categorie LISTE toutes les categories
    #[Route('/categories', name: 'app_categories')]
    public function listeCategorie(EntityManagerInterface $entityManager): Response
    {
        // $repository devient un objet categorieRepository
        $repository = $entityManager->getRepository(Categorie::class);
        $categories = $repository->findAll();

        return $this->render('categorie/categories.html.twig', [
            'categories' => $categories,
        ]);
    }
}
