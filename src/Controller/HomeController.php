<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    // la route home LISTE tous les articles
    #[Route('/', name: 'app_home')]
    public function listeArticle(EntityManagerInterface $entityManager): Response
    {
        // $repository devient un objet articleRepository
        $repository = $entityManager->getRepository(Article::class);
        $articles = $repository->findAll();

        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }
}
