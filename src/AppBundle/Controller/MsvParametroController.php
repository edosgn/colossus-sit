<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvParametro;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvparametro controller.
 *
 * @Route("msvparametro")
 */
class MsvParametroController extends Controller
{
    /**
     * Lists all msvParametro entities.
     *
     * @Route("/", name="msvparametro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $msvParametros = $em->getRepository('AppBundle:MsvParametro')->findAll();

        return $this->render('msvparametro/index.html.twig', array(
            'msvParametros' => $msvParametros,
        ));
    }

    /**
     * Parametros por categoriaid.
     *
     * @Route("/getByCategoriaId", name="msvparametrovycategoria")
     * @Method({"GET", "POST"})
     */
    public function getParametroByCategoriaId(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $hash = $request->get("authorization", null);
        $categoriaId = $request->get("json", null);
        $authCheck = $helpers->authCheck($hash);
        $msvParametros = $em->getRepository('AppBundle:MsvParametro')->findByCategoria($categoriaId);

        foreach ($msvParametros as $keyParametro => $msvParametro) {
            $msvParametrosArray[$keyParametro] = array(
                'id'=>$msvParametro->getId(),
                'name'=>$msvParametro->getNombre(),
                'valor'=>$msvParametro->getValor(),
                'variables' => null,
             );
            $variables = $em->getRepository('AppBundle:MsvVariable')->findByParametro($msvParametro->getId());
            if($variables){
                foreach ($variables as $keyVariable => $variable) {
                    $msvParametrosArray[$keyParametro]['variables'][$keyVariable] = array(
                        'id'=> $variable->getId(),
                        'name' => $variable->getNombre(),
                        'criterios' => null
                    );
                    $criterios = $em->getRepository('AppBundle:MsvCriterio')->findByVariable($variable->getId());
                    if($criterios){
                        foreach ($criterios as $keyCriterio => $criterio) {
                            $msvParametrosArray[$keyParametro]['variables'][$keyVariable]['criterios'][$keyCriterio] = array(
                                'id'=> $criterio->getId(),
                                'name' => $criterio->getNombre(),
                            );
                        }
                    }
                }                
            }           
        }
        $response = array(
            'status' => 'succes',
            'code' => 200,
            'msj' => "Parametros no encontrados",
            'data' => $msvParametrosArray,);
        return $helpers ->json($response);
    }

    /**
     * Creates a new msvParametro entity.
     *
     * @Route("/new", name="msvparametro_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $msvParametro = new Msvparametro();
        $form = $this->createForm('AppBundle\Form\MsvParametroType', $msvParametro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($msvParametro);
            $em->flush();

            return $this->redirectToRoute('msvparametro_show', array('id' => $msvParametro->getId()));
        }

        return $this->render('msvparametro/new.html.twig', array(
            'msvParametro' => $msvParametro,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a msvParametro entity.
     *
     * @Route("/{id}", name="msvparametro_show")
     * @Method("GET")
     */
    public function showAction(MsvParametro $msvParametro)
    {
        $deleteForm = $this->createDeleteForm($msvParametro);

        return $this->render('msvparametro/show.html.twig', array(
            'msvParametro' => $msvParametro,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvParametro entity.
     *
     * @Route("/{id}/edit", name="msvparametro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MsvParametro $msvParametro)
    {
        $deleteForm = $this->createDeleteForm($msvParametro);
        $editForm = $this->createForm('AppBundle\Form\MsvParametroType', $msvParametro);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvparametro_edit', array('id' => $msvParametro->getId()));
        }

        return $this->render('msvparametro/edit.html.twig', array(
            'msvParametro' => $msvParametro,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvParametro entity.
     *
     * @Route("/{id}", name="msvparametro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvParametro $msvParametro)
    {
        $form = $this->createDeleteForm($msvParametro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvParametro);
            $em->flush();
        }

        return $this->redirectToRoute('msvparametro_index');
    }

    /**
     * Creates a form to delete a msvParametro entity.
     *
     * @param MsvParametro $msvParametro The msvParametro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvParametro $msvParametro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvparametro_delete', array('id' => $msvParametro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
