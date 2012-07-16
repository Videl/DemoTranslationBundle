<?php

namespace A2lix\DemoTranslationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use A2lix\DemoTranslationBundle\Entity\Category;
use A2lix\DemoTranslationBundle\Form\CategoryType;

/**
 * Category controller.
 *
 * @Route("/category")
 */
class CategoryController extends Controller
{
    /**
     * Show all/one entity
     *
     * @Route("/", defaults={"id"=""}, name="category")
     * @Route("/{id}/show", name="category_show")
     * @Template()
     */
    public function indexAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id) {
            $entity = $em->getRepository('A2lixDemoTranslationBundle:Category')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            return $this->render("A2lixDemoTranslationBundle:Category:show.html.twig", array(
                'entity'     => $entity,
                'deleteForm' => $this->createDeleteForm($id)->createView()
            ));
        }
        
        $entities = $em->getRepository('A2lixDemoTranslationBundle:Category')->findAll();
        return array('entities' => $entities);
    }
    
    /**
     * New/Edit entity
     *
     * @Route("/new", defaults={"id"=""}, name="category_new")
     * @Route("/{id}/edit",  name="category_edit")
     * @Template()
     */
    public function editAction($id = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        if ($id) {
            $entity = $em->getRepository('A2lixDemoTranslationBundle:Category')->find($id);
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }
            
            $deleteForm = $this->createDeleteForm($id);
        } else {
            $entity = new Category();
        }

        $editForm = $this->createForm(new CategoryType(), $entity, array('locales' => array('en','de','es','fr')));
        $request = $this->getRequest();
        if ('POST' === $request->getMethod()) {
            $editForm->bindRequest($request);

            if ($editForm->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($entity);
                $em->flush();
                $this->get('session')->setFlash('notice', ($id ? 'Edited!' : 'Created!'));

                return $this->redirect($this->generateUrl('category_show', array('id' => $entity->getId())));
            }
        }
        
//		return $this->render("A2lixDemoTranslationBundle:Category:editplus.html.twig", array(
//            'entity'   => $entity,
//            'editForm' => $editForm->createView()
//        ) + ($id ? array('deleteForm' => $deleteForm->createView()) : array()));
		
        return array(
            'entity'   => $entity,
            'editForm' => $editForm->createView()
        ) + ($id ? array('deleteForm' => $deleteForm->createView()) : array());
    }

    /**
     * Delete entity.
     *
     * @Route("/{id}/delete", name="category_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('A2lixDemoTranslationBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->setFlash('notice', 'Deleted!');
        }

        return $this->redirect($this->generateUrl('category'));
    }
    
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}