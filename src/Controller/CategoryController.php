<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Form\ProductType;

class CategoryController extends AbstractController
{

    /**
     * @Route("/category/create", name="category_create")
     */
    public function createcatAction(ManagerRegistry$doctrine, Request $request, SluggerInterface $slugger)
    {

        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form ->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {


            $em = $doctrine->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash(
                'notice',
                'Product Added'

            );
            return $this->redirectToRoute('product_list');
        }
        return $this->renderForm('category/createcat.html.twig', ['form' => $form,]);


    }

    public function createChanges(ManagerRegistry $doctrine,$form, $request, $category)
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category->setCatname($request->request->get('category')['catname']);
            $em = $doctrine->getManager();
            $em->persist($category);
            $em->flush();

            return true;

        }

        return false;
    }



    /**
     * @Route("/category/delete/{id}", name="product_deletecat")
     */
    public function deletecatAction(ManagerRegistry $doctrine,$id)
    {
        $em = $doctrine->getManager();
        $product = $em->getRepository('App:Category')->find($id);
        $em->remove($product);
        $em->flush();

        $this->addFlash(
            'error',
            'Category deleted'
        );

        return $this->redirectToRoute('product_list');
    }

    /**
     * @Route("/category/editcat/{id}", name="product_editcat" )
     */
    public function editcatAction(ManagerRegistry $doctrine, $id, Request $request)
    {
        $todo= new Category();
        $em= $doctrine ->getManager();
        $todo = $em ->getRepository('App:Category')->find($id);
        $form = $this->createForm(CategoryType::class, $todo);

        $form ->handleRequest($request);


        if ($form->isSubmitted() ) {

            $entityManager = $doctrine->getManager();

            $entityManager->persist($todo);

            $entityManager->flush();
            return $this->redirectToRoute('product_list');

        }
        return $this->render('category/editcat.html.twig', [
            'form' => $form->createView()
        ]);

    }
}
