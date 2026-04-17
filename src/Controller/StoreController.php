<?php

namespace App\Controller;

use App\Cart\ApiCart;
use App\Cart\CartHandler;
use App\Cart\CartInterface;
use App\Cart\CartItem;
use App\Cart\SessionCart;
use App\Entity\Product;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

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
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('/files/profile.html.twig');
    }
    #[Route('/Store/cart', name: 'cart')]
    public function cart(#[Autowire(service: SessionCart::class)]CartInterface $sessionCart): Response
    {
        $cart = $sessionCart->GetCart('cart');
        return $this->render('/files/cart.html.twig', [
            'cart' => $cart,
        ]);
    }
    #[Route('/Store/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function AddToCart(int $id,Request $request,CartHandler $cartHandler,#[Autowire(service: SessionCart::class)] CartInterface $sessionCart): Response
    {
        $product = $this->productRepository->GetProductById($id);
        $quantity = $request->request->getInt('quantity', 1);
        $cartItem = new CartItem($product, $quantity);
        $cart = $sessionCart->GetCart('cart');
        $cartHandler->handle($cart, $cartItem, $sessionCart);
        return $this->redirectToRoute('cart');
    }
    #[Route('/Store/cart/remove/{id}', name: 'cart_remove')]
    public function removeFromCart(int $id,#[Autowire(service: SessionCart::class)] CartInterface $sessionCart): Response
    {
        $cart = $sessionCart->GetCart('cart');
        if (isset($cart->Cartitems[$id])) {
            $sessionCart->remove($cart->Cartitems[$id], $cart);
        }
        return $this->redirectToRoute('cart');
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
