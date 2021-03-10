<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{

    /**
     * @Route ("/", name="home")
     */

     public function home() : Response
     {
        return $this->render('blog/home.html.twig', [
            'title' => "Bienvenue sur le blog Symfony",
            'age' => 25
        ]);
     }


    /**
     * @Route("/blog", name="blog")
     */
    public function index(): Response
    {

        $repo = $this->getDoctrine()->getRepository(Article::class);

        dump($repo);

        $articles = $repo->findAll();

        dump($articles);

        return $this->render('blog/index.html.twig', [
            'title' => 'Liste des articles',
            'articles' => $articles
        ]);
    }

    /**
 * 
 * @Route("/blog/new", name="blog_create")
 */

public function create(Request $request): Response
{
dump($request);

    return $this->render('blog/create.html.twig');
}



/**
 * @Route("/blog/{id}", name="blog_show")
 */

 public function show(Article $article): Response
 {



    dump($article);

     return $this->render('blog/show.html.twig',[

        'articleTwig' => $article
     ]);
 }





}
