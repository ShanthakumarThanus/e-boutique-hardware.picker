<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use App\Entity\Categorie;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ArticleRepository $articleRepository, CategorieRepository $categorieRepository): Response
    {
        $articles = $articleRepository->findAll();
        $categories = $categorieRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }

    #[Route('/categorie/{id}', name: 'categorie_show')]
    public function show(Categorie $categorie): Response
    {
        $articles = $categorie->getArticles();

        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
            'articles' => $articles,
        ]);
    }
}
