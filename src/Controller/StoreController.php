<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StoreController extends AbstractController
{
    public CategoryRepository $categoryRepository;
    public ProductRepository $productRepository;
    public function __construct(CategoryRepository $categoryRepository, ProductRepository $productRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    #[Route('/Store/home', name: 'home')]
    public function index(): Response
    {
        $products = $this->productRepository->GetAllProducts();

        return $this->render('/files/index.html.twig',['products'=>$products],);
    }
    #[Route('/Store/profile', name: 'profile')]
    public function profile(): Response
    {
        return $this->render('/files/profile.html.twig');
    }
    #[Route('/Store/cart', name: 'cart')]
    public function cart(): Response
    {
        return $this->render('/files/cart.html.twig');
    }
    #[Route('/Store/browse_categories', name: 'browse_categories')]
    public function checkout(): Response
    {
        $categories = $this->categoryRepository->getProductCountPerCategory();
        return $this->render('/files/browse_categories.html.twig', [
            'categories' => $categories,
        ]);
    }
    #[Route('/Store/product_details/{id}', name: 'product_details')]
    public function product_details(int $id): Response
    {
        $product = $this->productRepository->GetProductById($id);
        return $this->render('/files/product_details.html.twig',['product'=>$product]);
    }
    #[Route('/Store/productsBrowse', name: 'browse_products')]
    public function browse_products(): Response
    {
        return $this->render('/files/browse_products.html.twig');
    }
    #[Route('/Store/CategoriesSection/{id}', name: 'CategorySection')]
    public function CategoriesSection(int $id): Response
    {
        $category = $this->categoryRepository->GetCategoryById($id);

        $products = $this->productRepository->GetAllProductsByCategoryid($id);
        return $this->render('/files/products_by_category.html.twig',[
            'category' => $category,
            'products' => $products,
            'productCount' => $this->productRepository->getProductCount($id),
        ]);

    }


}
