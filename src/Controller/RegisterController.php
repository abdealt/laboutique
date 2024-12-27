<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        // On instancie User
        $user = new User();

        // On crée le formulaire et via RegisterUserType (le type lié à l'entité user)
        $form = $this->createForm(RegisterUserType::class, $user);

        // On ecoute le formulaire pour savoir s'il est remplis.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Debug commenté
            //dd($form->getData());
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('register/index.html.twig', [
            'registerForm' => $form->createView()
    ]);
    }
}
