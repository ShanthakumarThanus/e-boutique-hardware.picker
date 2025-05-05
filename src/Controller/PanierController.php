<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\PanierRepository;
use App\Entity\Article;
use App\Entity\LignePanier;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

use function Symfony\Component\Clock\now;

final class PanierController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(PanierRepository $panierRepository): Response
    {
        $paniers = $panierRepository->findAll();
        return $this->render('panier/index.html.twig', [
            'paniers' => $paniers,
        ]);
    }

    #[Route('/panier/add/{id}', name: 'ajouter_au_panier', methods: ['POST'])]
    public function ajouterAuPanier(Article $article, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\Utilisateur $utilisateur */
        $utilisateur = $this->getUser();
        $panier = $utilisateur->getPanier(); // ou autre logique de récupération

        //Créer un panier si l'utilisateur n'en a pas
        if (!$panier) {
            $panier = new \App\Entity\Panier();
            $panier->setUtilisateur($utilisateur);
            $panier->setDateCreation(new \DateTimeImmutable());
            $utilisateur->setPanier($panier);
            $em->persist($panier);
        }

        $ligne = new LignePanier();
        $ligne->setArticle($article);
        $ligne->setQuantite(1);
        $ligne->setPanier($panier);

        $panier->addLignePanier($ligne);

        $em->persist($ligne);
        $em->flush();

        $this->addFlash('success', 'Article ajouté au panier.');

        return $this->redirectToRoute('app_home');
    }

}
