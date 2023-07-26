<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/users", name="users_list")
     */
    public function getUsers(): Response
    {
        $userRepository = $this->entityManager->getRepository(Users::class);
        $listUsers = $userRepository->findBy([], ["name" => "ASC"]);

        return $this->render("user/users.html.twig", [
            "listUsers" => $listUsers
        ]);
    }

    /**
     * @Route("/user/create", name="user_create")
     */
    public function createUser(Request $request): Response
    {
        $users = new Users();

        $form_users = $this->createForm(\App\Form\UsersType::class, $users);
        $form_users->handleRequest($request);

        if ($form_users->isSubmitted() && $form_users->isValid()) {
            $this->entityManager->persist($users);
            $this->entityManager->flush();

            // Redirigir a la página de éxito o hacer otra acción después de guardar el usuario
            // Por ejemplo:
            // return $this->redirectToRoute('user_list');
        }

        return $this->render("user/user_create.html.twig", [
            "form_users" => $form_users->createView(),
        ]);
    }
}
