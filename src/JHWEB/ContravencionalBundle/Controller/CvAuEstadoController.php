<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvAuEstado;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvauestado controller.
 *
 * @Route("cvauestado")
 */
class CvAuEstadoController extends Controller
{
    /**
     * Lists all cvAuEstado entities.
     *
     * @Route("/", name="cvauestado_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cvAuEstados = $em->getRepository('JHWEBContravencionalBundle:CvAuEstado')->findAll();

        return $this->render('cvauestado/index.html.twig', array(
            'cvAuEstados' => $cvAuEstados,
        ));
    }

    /**
     * Creates a new cvAuEstado entity.
     *
     * @Route("/new", name="cvauestado_new")
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

            $estado = new CvAuEstado();

            if ($params->idTipo) {
                $tipo = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgTipo')->find(
                    $params->idTipo
                );
                $estado->setTipo($tipo);
            }

            if ($params->idAudiencia) {
                $audiencia = $em->getRepository('JHWEBContravencionalBundle:CvAudiencia')->find(
                    $params->idAudiencia
                );
                $estado->setAudiencia($audiencia);
            }
            
            $estado->setNombre(mb_strtoupper($tipo->getNombre(), 'utf-8'));
            $estado->setCuerpo($params->cuerpo);
            $estado->setActivo(true);

            $em->persist($estado);
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
     * Finds and displays a cvAuEstado entity.
     *
     * @Route("/{id}", name="cvauestado_show")
     * @Method("GET")
     */
    public function showAction(CvAuEstado $cvAuEstado)
    {
        $deleteForm = $this->createDeleteForm($cvAuEstado);

        return $this->render('cvauestado/show.html.twig', array(
            'cvAuEstado' => $cvAuEstado,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvAuEstado entity.
     *
     * @Route("/{id}/edit", name="cvauestado_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvAuEstado $cvAuEstado)
    {
        $deleteForm = $this->createDeleteForm($cvAuEstado);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvAuEstadoType', $cvAuEstado);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvauestado_edit', array('id' => $cvAuEstado->getId()));
        }

        return $this->render('cvauestado/edit.html.twig', array(
            'cvAuEstado' => $cvAuEstado,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvAuEstado entity.
     *
     * @Route("/{id}", name="cvauestado_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvAuEstado $cvAuEstado)
    {
        $form = $this->createDeleteForm($cvAuEstado);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvAuEstado);
            $em->flush();
        }

        return $this->redirectToRoute('cvauestado_index');
    }

    /**
     * Creates a form to delete a cvAuEstado entity.
     *
     * @param CvAuEstado $cvAuEstado The cvAuEstado entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvAuEstado $cvAuEstado)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvauestado_delete', array('id' => $cvAuEstado->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
