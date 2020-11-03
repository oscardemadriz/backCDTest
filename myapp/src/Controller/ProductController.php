<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\Taxonomy;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="create_product",  methods={"POST"})
     */
    public function createProduct(Request $request): Response
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to the action: createProduct(EntityManagerInterface $entityManager)
        $entityManager = $this->getDoctrine()->getManager();


        $tax =  $entityManager->find(Taxonomy::class, $request->request->get("tax"));
        $product = new Product();
        $product->setName($request->request->get("name"));
        $product->setDescription($request->request->get("description"));

        $product->setBasePrice($request->request->get("price"));
        $product->setPrice($product->getBasePrice() + ($product->getBasePrice() * ($tax->getTax() / 100)));
        $product->setImageBlob(

            file_get_contents($request->files->get("imageBlob"))
        );
        $product->setTaxRate($tax);

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT request)
        $entityManager->flush();

        return new Response('Saved new product with id ' . $product->getId());
    }

    /**
     * @Route("/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $product->setPrice($product->getBasePrice() + ($product->getBasePrice() * ($product->getTaxRate()->getTax() / 100)));
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }
}
