<?php

namespace A2lix\DemoTranslationBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use A2lix\DemoTranslationBundle\Entity\Product;
use A2lix\DemoTranslationBundle\Form\ProductType;

/**
 * Product controller.
 *
 * @Route("/product")
 */
class ProductController extends Controller
{
    /**
     * Show all/one entity
     *
     * @Route("/", defaults={"id"=""}, name="backend_product")
     * @Route("/{id}/show", name="backend_product_show")
     * @Template()
     */
    public function indexAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id) {
            $entity = $em->getRepository('A2lixDemoTranslationBundle:Product')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product entity.');
            }

            return $this->render("A2lixDemoTranslationBundle:Backend\\Product:show.html.twig", array(
                'entity'     => $entity,
                'deleteForm' => $this->createDeleteForm($id)->createView()
            ));
        }
        
        $entities = $em->getRepository('A2lixDemoTranslationBundle:Product')->findAll();
        return array('entities' => $entities);
    }
    
    /**
     * New/Edit entity
     *
     * @Route("/new", defaults={"id"=""}, name="backend_product_new")
     * @Route("/{id}/edit", name="backend_product_edit")
     * @Template()
     */
    public function editAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id) {
            $entity = $em->getRepository('A2lixDemoTranslationBundle:Product')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product entity.');
            }
            
            $deleteForm = $this->createDeleteForm($id);
        
        } else {
            $entity = new Product();
        }

        $editForm = $this->createForm(new ProductType(), $entity);
        $request = $this->getRequest();
        if ('POST' === $request->getMethod()) {
            $editForm->bindRequest($request);

            if ($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->setFlash('notice', ($id ? 'Edited!' : 'Created!'));

                return $this->redirect($this->generateUrl('backend_product_show', array('id' => $entity->getId())));
            }
        }
        
        return array(
            'entity'   => $entity,
            'editForm' => $editForm->createView()
        ) + ($id ? array('deleteForm' => $deleteForm->createView()) : array());
    }

    /**
     * Delete entity.
     *
     * @Route("/{id}/delete", name="backend_product_delete", options={"i18n" = false})
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('A2lixDemoTranslationBundle:Product')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Deleted!');
        }

        return $this->redirect($this->generateUrl('product'));
    }
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}