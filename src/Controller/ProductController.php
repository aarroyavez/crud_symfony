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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProductSearchFormType;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

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
     * @Route("/products", name="getAvaliableProducts", methods={"GET"})
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
            // En caso de excepción, lanzar una excepción BadRequestHttpException
            throw new BadRequestHttpException('Respuesta 400, error en la consulta: ' . $e->getMessage());
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

    /**
     * @Route("/products/search", name="search_products", methods={"GET", "POST"})
     */
    public function searchProducts(Request $request): Response
    {
        $form = $this->createForm(ProductSearchFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $searchTerm = $form->get('searchTerm')->getData();
            $products = $this->productRepository->findProductsBySearchTerm($searchTerm);
        } else {
            // Si el formulario no ha sido enviado o no es válido, mostramos todos los productos
            $products = $this->productRepository->findAll();
        }

        return $this->render('product/index.html.twig', [
            'form' => $form->createView(),
            'products' => $products,
        ]);
    }
}
