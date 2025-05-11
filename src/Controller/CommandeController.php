<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Commande;
use App\Form\CommandeType;
use App\Entity\LigneCommande;

final class CommandeController extends AbstractController
{
    #[Route('/commande', name: 'app_commande')]
    public function index(CommandeRepository $commandeRepository): Response
    {
        $commandes = $commandeRepository->findAll();
        return $this->render('commande/commande.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    #[Route('/commande/nouvelle', name: 'commande_nouvelle')]
    public function passerCommande(Request $request, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\Utilisateur $utilisateur */
        $utilisateur = $this->getUser();

        $commande = new Commande();
        $commande->setUtilisateur($utilisateur);
        $commande->setDateCommande(new \DateTimeImmutable());

        $panier = $utilisateur->getPanier();
        $total = 0;

        foreach ($panier->getLignesPanier() as $lignePanier) 
        {
            $ligneCommande = new LigneCommande();
            $ligneCommande->setCommande($commande);
            $ligneCommande->setArticle($lignePanier->getArticle());
            $ligneCommande->setQuantite($lignePanier->getQuantite());
            $ligneCommande->setPrixFixe($lignePanier->getArticle()->getPrix());
            
            $montant = $lignePanier->getArticle()->getPrix() * $lignePanier->getQuantite();
            $total += $montant;

            $commande->addLigneCommande($ligneCommande);
        }

        $commande->setTotal($total);

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($commande);
            $em->flush();

            $panier = $utilisateur->getPanier();
            foreach ($panier->getLignesPanier() as $lignePanier) {
                $em->remove($lignePanier);
            }

            $em->flush();

            $this->addFlash('success', 'Commande validée avec succès.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('commande/commande.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/mes-commandes', name: 'mes_commandes')]
    public function mesCommandes(CommandeRepository $commandeRepository): Response
    {
        /** @var \App\Entity\Utilisateur $utilisateur */
        $utilisateur = $this->getUser();

        $commandes = $commandeRepository->findBy(['utilisateur' => $utilisateur], ['dateCommande' => 'DESC']);

        return $this->render('commande/historique.html.twig', [
            'commandes' => $commandes,
        ]);
    }

}
