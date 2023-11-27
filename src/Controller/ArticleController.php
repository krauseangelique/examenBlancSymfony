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
        $repository = $entityManager->getRepository(Categorie::class);
        $categorie = $repository->find(1);
        // dd($categorie);
        $categorie = $repository->findByName('roman');


        // pdf p14/24
        $article = new Article;
        $article->setNom("llloiuuyhh");
        $article->setContenu("Un des chefsppoiuy");
        $article->setVotes(3);
        $article->setDateDeCreation(new DateTime('2022-09-25'));

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
}
