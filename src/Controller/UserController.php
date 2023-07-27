<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Product;
use App\Repository\ProductRepository;

class UserController extends AbstractController
{
    private $entityManager;
    private $productRepository;
    
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
            try {
                $this->entityManager->persist($users);
                $this->entityManager->flush();

                // Agregar mensaje de éxito en el registro
                $this->addFlash('success', 'Respuesta 204, se registró correctamente');
            } catch (\Exception $e) {
                // Agregar mensaje de error en caso de excepción
                $this->addFlash('error', 'Respuesta 400, error al registrar el usuario: ' . $e->getMessage());
            }
        }

        return $this->render("user/user_create.html.twig", [
            "form_users" => $form_users->createView(),
        ]);
    }

    public function deleteUser($id, UrlGeneratorInterface $urlGenerator): Response
    {
        $userRepository = $this->entityManager->getRepository(Users::class);
        $user = $userRepository->find($id);

        if (!$user) {
            // Manejar el caso en el que el usuario no existe
            // Puedes lanzar una excepción, redirigir a una página de error, etc.
            // Por ejemplo:
            // throw $this->createNotFoundException('El usuario no existe');
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        // Redirigir a la ruta "getUsers" después de eliminar
        return $this->reDirectToRoute('getUsers');
    }

    public function uptateUser($id){
        
    }

    /**
     * @Route("/products", name="products_list")
     */
    public function getProducts(Request $request): JsonResponse
    {
        // Obtener los parámetros del límite y el fragmento de nombre de la petición
        $limit = $request->query->get('limit', 10);
        $searchText = $request->query->get('searchText', '');

        // Obtener la lista de productos que cumplan con los parámetros
        $products = $this->productRepository->findProductsBySearchText($searchText, $limit);

        // Preparar la respuesta en formato JSON
        $response = [
            'status' => 200,
            'message' => 'OK',
            'data' => $products,
        ];

        return new JsonResponse($response);
    }
}

