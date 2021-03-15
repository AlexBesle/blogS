<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
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
 * @Route("/blog/{id}/edit", name="blog_edit")
 */

public function create(Article $articleCreate = null, Request $request, EntityManagerInterface $manager ): Response
{
dump($request);

//if($request->request->count() > 0)
//{

if(!$articleCreate)
{

    $articleCreate = new Article;

}

 //   $articleCreate ->setTitle($request->request->get('title'))
  //                  ->setContent($request->request->get('content')) 
  //                  ->setImage($request->request->get('image'))
  //                  ->setCreatedAt(new \DateTime);


   //  dump($articleCreate);
     
 //    $manager->persist($articleCreate);
  //   $manager->flush();

//    return $this->redirectToRoute('blog_show',[

 //      'id' => $articleCreate->getId()
  //  ]);



//}
// $articleCreate = new Article;


//$articleCreate->setTitle("titre a la noix")
            //  ->setContent("Contenu à la niox");


//$form = $this->createFormBuilder($articleCreate)

       //         ->add('title')

       //         ->add('content')

       //         ->add('image')

       //         ->getForm();

    $form = $this->createForm(ArticleFormType::class,$articleCreate);

      $form->handleRequest($request);   
      
      
      if($form->isSubmitted() && $form->isValid())

        {
            $articleCreate->setCreatedAt(new \DateTime);

            $manager->persist($articleCreate);
            $manager->flush();

            return $this->redirectToRoute('blog_show', [
                'id' => $articleCreate->getId()
            ]);

        }

    return $this->render('blog/create.html.twig',[

        'formArticle' => $form->createView(),
        'editMode' => $articleCreate->getId()

    ]);
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
