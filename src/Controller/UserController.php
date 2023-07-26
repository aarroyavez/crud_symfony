<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

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
}
