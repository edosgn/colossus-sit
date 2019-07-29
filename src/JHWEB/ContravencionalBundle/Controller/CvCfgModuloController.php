<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCfgModulo;
use JHWEB\ContravencionalBundle\Entity\CvCfgReparto;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcfgmodulo controller.
 *
 * @Route("cvcfgmodulo")
 */
class CvCfgModuloController extends Controller
{
    /**
     * Lists all cvCfgModulo entities.
     *
     * @Route("/", name="cvcfgmodulo_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $modulos = $em->getRepository('JHWEBContravencionalBundle:CvCfgModulo')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($modulos) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($modulos)." registros encontrados", 
                'data'=> $modulos,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvCfgModulo entity.
     *
     * @Route("/new", name="cvcfgmodulo_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
           
            $modulo = new CvCfgModulo();

            $modulo->setNombre(mb_strtoupper($params->nombre, 'utf-8'));
            $modulo->setActivo(true);

            $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                $params->idFuncionario
            );
            $modulo->setFuncionario($funcionario);
            
            $em->persist($modulo);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a cvCfgModulo entity.
     *
     * @Route("/{id}", name="cvcfgmodulo_show")
     * @Method("GET")
     */
    public function showAction(CvCfgModulo $cvCfgModulo)
    {
        $deleteForm = $this->createDeleteForm($cvCfgModulo);

        return $this->render('cvcfgmodulo/show.html.twig', array(
            'cvCfgModulo' => $cvCfgModulo,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvCfgModulo entity.
     *
     * @Route("/{id}/edit", name="cvcfgmodulo_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvCfgModulo $cvCfgModulo)
    {
        $deleteForm = $this->createDeleteForm($cvCfgModulo);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCfgModuloType', $cvCfgModulo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvcfgmodulo_edit', array('id' => $cvCfgModulo->getId()));
        }

        return $this->render('cvcfgmodulo/edit.html.twig', array(
            'cvCfgModulo' => $cvCfgModulo,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvCfgModulo entity.
     *
     * @Route("/{id}", name="cvcfgmodulo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvCfgModulo $cvCfgModulo)
    {
        $form = $this->createDeleteForm($cvCfgModulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvCfgModulo);
            $em->flush();
        }

        return $this->redirectToRoute('cvcfgmodulo_index');
    }

    /**
     * Creates a form to delete a cvCfgModulo entity.
     *
     * @param CvCfgModulo $cvCfgModulo The cvCfgModulo entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCfgModulo $cvCfgModulo)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcfgmodulo_delete', array('id' => $cvCfgModulo->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ====================================================== */

    /**
     * Creates a new cvCfgModulo entity.
     *
     * @Route("/states", name="cvcfgmodulo_states")
     * @Method({"GET", "POST"})
     */
    public function statesAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
           
            $modulo = $em->getRepository('JHWEBContravencionalBundle:CvCfgModulo')->find(
                $params->idModulo
            );
            
            foreach ($params->estados as $key => $idEstado) {
                $reparto = new CvCfgReparto();
                
                $reparto->setActivo(true);
                $reparto->setModulo($modulo);
    
                $estado = $em->getRepository('JHWEBContravencionalBundle:CvCdoCfgEstado')->find(
                    $idEstado
                );
                $reparto->setEstado($estado);
                
                $em->persist($reparto);
                $em->flush();
            }
            

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }
}
