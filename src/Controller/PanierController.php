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
        /** @var \App\Entity\Utilisateur $utilisateur */
        $utilisateur = $this->getUser();
        $panier = $utilisateur->getPanier();

        if (!$panier) {
            $this->addFlash('warning', 'Votre panier est vide.');
            return $this->redirectToRoute('app_home');
        }

        $lignes = $panier->getLignesPanier();
        $total = 0;
        
        foreach ($lignes as $ligne) {
            $total += $ligne->getQuantite() * $ligne->getArticle()->getPrix();
        }

        return $this->render('panier/index.html.twig', [
            'lignes' => $lignes,
            'total' => $total,
        ]);
    }

    #[Route('/panier/add/{id}', name: 'ajouter_au_panier', methods: ['POST'])]
    public function ajouterAuPanier(Article $article, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\Utilisateur $utilisateur */
        $utilisateur = $this->getUser();
        $panier = $utilisateur->getPanier();

        if (!$panier) {
            $panier = new \App\Entity\Panier();
            $panier->setUtilisateur($utilisateur);
            $panier->setDateCreation(new \DateTimeImmutable());
            $em->persist($panier);
            $utilisateur->setPanier($panier);
        }

        // Vérifie si une ligne existe déjà pour cet article
        $ligneExistante = null;
        foreach ($panier->getLignesPanier() as $ligne) {
            if ($ligne->getArticle() === $article) {
                $ligneExistante = $ligne;
                break;
            }
        }

        if ($ligneExistante) {
            // Incrémente la quantité
            $ligneExistante->setQuantite($ligneExistante->getQuantite() + 1);
        } else {
            // Crée une nouvelle ligne
            $ligne = new LignePanier();
            $ligne->setArticle($article);
            $ligne->setQuantite(1);
            $ligne->setPanier($panier); // n'oublie pas d’associer le panier à la ligne

            $em->persist($ligne);
            $panier->addLignePanier($ligne);
        }

        $em->flush();

        $this->addFlash('success', 'Article ajouté au panier.');

        return $this->redirectToRoute('app_home');
    }

    #[Route('/panier/remove/{id}', name:'retirer_du_panier')]
    public function retirerDuPanier(LignePanier $ligne, EntityManagerInterface $em): Response
    {
        $em->remove($ligne);
        $em->flush();

        $this->addFlash('success', 'Article retiré du panier.');
        return $this->redirectToRoute('app_panier');
    }

    
    //Fonction pour incrémenter la quantité d'un article ajouté dans le panier
    #[Route('/panier/increment/{id}', name: 'increment_quantite')]
    public function incrementQuantite(LignePanier $ligne, EntityManagerInterface $em): Response
    {
        $ligne->setQuantite($ligne->getQuantite() + 1);
        $em->flush();

        return $this->redirectToRoute('app_panier');
    }

    //Fonction pour décrémenter la quantité d'un article ajouté dans le panier
    #[Route('/panier/decrement/{id}', name: 'decrement_quantite')]
    public function decrementQuantite(LignePanier $ligne, EntityManagerInterface $em): Response
    {
        $quantite = $ligne->getQuantite();
        if ($quantite > 1) {
            $ligne->setQuantite($quantite - 1);
            $em->flush();
        } else {
            // Si quantité devient 0, on peut le retirer du panier
            $em->remove($ligne);
            $em->flush();
        }

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/commander', name: 'commander')]
    public function payement(PanierRepository $panierRepository): Response
    {
        return $this->redirectToRoute('commander');
    }
}
