<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * 
     * @Route("/admin/articles", name="admin_articles")
     * 
     */
    public function adminArticles(EntityManagerInterface $manager, ArticleRepository $repoArticles): Response
    {

            $colonnes = $manager->getClassMetadata(Article::class)->getFieldNames();


            dump($colonnes);


            $articles = $repoArticles->findAll();


            dump($articles);

        return $this->render('admin/admin_articles.html.twig',[
            'colonnes' => $colonnes,

            'articlesBdd'=>$articles

        ]);
    }

}
