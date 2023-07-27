<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends AbstractController
{
    private $productRepository;
    private $entityManager;

    public function __construct(ProductRepository $productRepository, EntityManagerInterface $entityManager)
    {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/products", name="get_available_products", methods={"GET"})
     */
    public function getAvailableProducts(Request $request): JsonResponse
    {
        // Validar el límite máximo de productos
        $limit = intval($request->query->get('limit', 10));
        $limit = max(1, min(100, $limit)); // Limitar el límite entre 1 y 100

        // Validar el texto de búsqueda
        $searchTerm = trim($request->query->get('search'));

        // Obtener la lista de productos que cumplan con los parámetros
        try {
            $products = $this->productRepository->findAvailableProducts($limit, $searchTerm);

            $responseData = [];
            foreach ($products as $product) {
                $responseData[] = [
                    'id' => $product->getId(),
                    'name' => $product->getName(),
                    'available_quantity' => $product->getQuantity(),
                    'unit_price' => $product->getPrice(),
                ];
            }

            return new JsonResponse($responseData, 200);
        } catch (\Exception $e) {
            // En caso de excepción, enviar respuesta de error 400 con el mensaje de error
            return new JsonResponse(['error' => 'Respuesta 400, error en la consulta: ' . $e->getMessage()], 400);
        }
    }

    /**
     * @Route("/products/new", name="new_product", methods={"GET", "POST"})
     */
    public function newProduct(Request $request): Response
    {
        $product = new Product();

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            return $this->redirectToRoute('getAvailableProducts');
        }

        return $this->render('product/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
