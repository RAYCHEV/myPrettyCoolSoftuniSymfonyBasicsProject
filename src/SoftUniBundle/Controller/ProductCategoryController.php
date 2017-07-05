<?php

namespace SoftUniBundle\Controller;

use SoftUniBundle\Entity\ProductCategory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Productcategory controller.
 *
 *
 */
class ProductCategoryController extends Controller
{
    /**
     * Lists all productCategory entities.
     *
     * @Route("admin/product-category/", name="admin_product-category_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $productCategories = $this->get('app.product_category_manager')->getAll();

        return $this->render('SoftUniBundle:productcategory:index.html.twig', array(
            'productCategories' => $productCategories,
        ));
    }


    /**
     * Lists all productCategory entities.
     *
     * @Route("category/list", name="product-category_list_ord_by_rank")
     * @Method("GET")
     */
    public function listAction()
    {
        $productCategories = $this->get('app.product_category_manager')->getAllOrderedByRang();

        return $this->render('SoftUniBundle:productcategory:category-list.html.twig', array(
            'productCategories' => $productCategories,
        ));
    }

    /**
     * Creates a new productCategory entity.
     *
     * @Route("admin/product-category/new", name="admin_product-category_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $productCategory = new Productcategory();
        $form = $this->createForm('SoftUniBundle\Form\ProductCategoryType', $productCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('app.product_category_manager')->createProductCategory($productCategory);

            return $this->redirectToRoute('product-category_list_ord_by_rank');
        }

        return $this->render('SoftUniBundle:productcategory:new.html.twig', array(
            'productCategory' => $productCategory,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a productCategory entity.
     *
     * @Route("admin/product-category/{id}", name="admin_product-category_show")
     * @Method("GET")
     */
    public function showAction(ProductCategory $productCategory)
    {
        $deleteForm = $this->createDeleteForm($productCategory);

        return $this->render('SoftUniBundle:productcategory:show.html.twig', array(
            'productCategory' => $productCategory,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing productCategory entity.
     *
     * @Route("admin/product-category/{id}/edit", name="admin_product-category_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ProductCategory $productCategory)
    {
        $deleteForm = $this->createDeleteForm($productCategory);
        $editForm = $this->createForm('SoftUniBundle\Form\ProductCategoryType', $productCategory);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $productCategory->setUpdatedAt(new \DateTime());

            $file = $productCategory->getPicture();
            $fileName = $this->get('app.product-category_pic_uploader') ->upload($file);

            $productCategory->setPicture($fileName);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_product-category_edit', array('id' => $productCategory->getId()));
        }

        return $this->render('SoftUniBundle:productcategory:edit.html.twig', array(
            'productCategory' => $productCategory,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a productCategory entity.
     *
     * @Route("admin/product-category/{id}", name="admin_product-category_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ProductCategory $productCategory)
    {
        $form = $this->createDeleteForm($productCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->get('app.product_category_manager')->removeProductCategory($productCategory);
        }

        return $this->redirectToRoute('admin_product-category_index');
    }

    /**
     * Creates a form to delete a productCategory entity.
     *
     * @param ProductCategory $productCategory The productCategory entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ProductCategory $productCategory)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_product-category_delete', array('id' => $productCategory->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
