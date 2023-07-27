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
    public function getAvailableProducts(Request $request): JsonResponse
    {
        $limit = $request->query->getInt('limit', 10); // Obtener el límite máximo de productos de la consulta
        $searchTerm = $request->query->get('search'); // Obtener el texto de búsqueda

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
    }
}



