<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article/new', name: 'app_article_new')]
    public function new(EntityManagerInterface $entityManager): Response
    {

        // object categorie Repository cf. Repository CategorieRepository.php 
        // C'est la partie modèle du MVC
        $repository = $entityManager->getRepository(Categorie::class);
        $categorie = $repository->find(1);
        /**
         * dd($categorie); // localhost:8000/article/new 
         * 
         *  ArticleController.php on line 23:
         *App\Entity\Categorie {#455 ▼
         * -id: 1
         * -nom: "conte de fée"
         * -description: "C'est le plus vieux conte"
         * -articles: Doctrine\ORM\PersistentCollection {#465 ▶}
         *}
         */
        // je vais rechercher la catégorie de mon bouquin
        $categorie = $repository->findByName('roman');


        // pdf p14/24 création d'un nouvel article
        $article = new Article;
        $article->setNom("Cris et chuchotements");
        $article->setContenu("travail en Asie");
        $article->setVotes(2);
        $article->setDateDeCreation(new DateTime('2023-10-02'));

        $article->setCategorie($categorie); // le nvl article sera dans la catégorie 'roman'

        //$article->getCategorie();

        // Indique à Doctrine que tu souhaites SAUVER l'Article VIA persist()
        $entityManager->persist($article);

        // Execute l'objet (INSERT query)
        $entityManager->flush();

        // return new Response('Saved new product with id '.$product->getId());
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
        ]);
    }

    #[Route('/article/{id}', name: 'app_article_detail')]
    public function article_detail($id, EntityManagerInterface $entityManager): Response
    {

        $repository = $entityManager->getRepository(Article::class);
        $objetArticle = $repository->find($id);
        // dd($objetArticle);

        return $this->render('article/article_detail.html.twig', [
            // 'this_article' c'estl'objet ARTICLE que  je récupère de la DB, je vais pouvoir l'utiliser dans ma VUE
            'this_article' =>
            $objetArticle,
        ]);
    }
}
