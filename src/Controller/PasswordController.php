<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Form\PasswordChangeType;

final class PasswordController extends AbstractController
{
    #[Route('/profil/mot-de-passe', name: 'app_password_change')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $em): Response
    {
        /** @var \App\Entity\Utilisateur $user */
        $user = $this->getUser();

        $form = $this->createForm(PasswordChangeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newPassword = $form->get('newPassword')->getData();
            $hashedPassword = $passwordHasher->hashPassword($user, $newPassword);
            $user->setPassword($hashedPassword);

            $em->flush();
            $this->addFlash('success', 'Mot de passe modifié avec succès.');
            return $this->redirectToRoute('app_profil');
        }

        return $this->render('password/modifier_motDePasse.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
