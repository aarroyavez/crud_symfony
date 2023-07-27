<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/products", name="get_available_products", methods={"GET"})
     */
    public function getAvailableProducts(Request $request, ProductRepository $productRepository): JsonResponse
    {
        // Validar el límite máximo de productos
        $limit = intval($request->query->get('limit', 10));
        $limit = max(1, min(100, $limit)); // Limitar el límite entre 1 y 100

        // Validar el texto de búsqueda
        $searchTerm = trim($request->query->get('search'));

        // Obtener la lista de productos que cumplan con los parámetros
        try {
            $products = $productRepository->findAvailableProducts($limit, $searchTerm);

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
}
