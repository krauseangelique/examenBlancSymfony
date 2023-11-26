<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/new', name: 'app_article_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categorie;
        $categorie->setNom('conte de fée');
        $categorie->setDescription('C\'est le plus vieux conte');

        // pdf p14/24$
        $article = new Article;
        $article->setNom("la Belle au bois dormant");
        $article->setContenu("Elle s'endormi et le prince l'éveilla");
        $article->setVotes(5);
        $article->setDateDeCreation(new DateTime('2022-10-30'));
        $article->setCategorie($categorie);

        // Indique à Doctrine que tu souhaites SAUVER l'Article VIA persist()
        $entityManager->persist($article);

        // Execute l'objet (INSERT query)
        $entityManager->flush();

        // return new Response('Saved new product with id '.$product->getId());
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }
}
