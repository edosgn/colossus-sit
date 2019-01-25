<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoTrazabilidad;
use JHWEB\ConfigBundle\Entity\CfgAdmActoAdministrativo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcdotrazabilidad controller.
 *
 * @Route("cvcdotrazabilidad")
 */
class CvCdoTrazabilidadController extends Controller
{
    /**
     * Lists all cvCdoTrazabilidad entities.
     *
     * @Route("/", name="cvcdotrazabilidad_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cvCdoTrazabilidads = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findAll();

        return $this->render('cvcdotrazabilidad/index.html.twig', array(
            'cvCdoTrazabilidads' => $cvCdoTrazabilidads,
        ));
    }

    /**
     * Creates a new cvCdoTrazabilidad entity.
     *
     * @Route("/new", name="cvcdotrazabilidad_new")
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

            $trazabilidadNew = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findByEstado(
                    $params->idComparendoEstado
                );

            if (!$trazabilidadNew) {
                $trazabilidadesOld = $em->getRepository('JHWEBContravencionalBundle:CvCdoTrazabilidad')->findBy(
                    array(
                        'comparendo' => $params->idComparendo,
                        'activo' => true
                    )
                );

                if ($trazabilidadesOld) {
                    foreach ($trazabilidadesOld as $key => $trazabilidadOld) {
                        $trazabilidadOld->setActivo(false);
                        $em->flush();
                    }
                }

                $trazabilidad = new CvCdoTrazabilidad();

                $trazabilidad->setFecha(new \Datetime($params->fecha));
                if ($params->observaciones) {
                    $trazabilidad->setObservaciones($params->observaciones);
                }
                $trazabilidad->setActivo(true);

                if ($params->idComparendoEstado) {
                    $estado = $em->getRepository('AppBundle:CfgComparendoEstado')->find(
                        $params->idComparendoEstado
                    );
                }
                    $trazabilidad->setEstado($estado);

                if ($params->idComparendo) {
                    $comparendo = $em->getRepository('AppBundle:Comparendo')->find(
                        $params->idComparendo
                    );
                    $trazabilidad->setComparendo($comparendo);
                    $comparendo->setEstado($estado);
                }

                $em->persist($trazabilidad);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se premite registrar mas de una trazabilidad con el mismo estado.",
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Finds and displays a cvCdoTrazabilidad entity.
     *
     * @Route("/{id}/show", name="cvcdotrazabilidad_show")
     * @Method("GET")
     */
    public function showAction(CvCdoTrazabilidad $cvCdoTrazabilidad)
    {
        $deleteForm = $this->createDeleteForm($cvCdoTrazabilidad);

        return $this->render('cvcdotrazabilidad/show.html.twig', array(
            'cvCdoTrazabilidad' => $cvCdoTrazabilidad,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvCdoTrazabilidad entity.
     *
     * @Route("/{id}/edit", name="cvcdotrazabilidad_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvCdoTrazabilidad $cvCdoTrazabilidad)
    {
        $deleteForm = $this->createDeleteForm($cvCdoTrazabilidad);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCdoTrazabilidadType', $cvCdoTrazabilidad);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvcdotrazabilidad_edit', array('id' => $cvCdoTrazabilidad->getId()));
        }

        return $this->render('cvcdotrazabilidad/edit.html.twig', array(
            'cvCdoTrazabilidad' => $cvCdoTrazabilidad,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvCdoTrazabilidad entity.
     *
     * @Route("/{id}/delete", name="cvcdotrazabilidad_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvCdoTrazabilidad $cvCdoTrazabilidad)
    {
        $form = $this->createDeleteForm($cvCdoTrazabilidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvCdoTrazabilidad);
            $em->flush();
        }

        return $this->redirectToRoute('cvcdotrazabilidad_index');
    }

    /**
     * Creates a form to delete a cvCdoTrazabilidad entity.
     *
     * @param CvCdoTrazabilidad $cvCdoTrazabilidad The cvCdoTrazabilidad entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCdoTrazabilidad $cvCdoTrazabilidad)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcdotrazabilidad_delete', array('id' => $cvCdoTrazabilidad->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Displays a form to update/documento an existing cvCdoTrazabilidad entity.
     *
     * @Route("/update/documento", name="cvcdotrazabilidad_update_document")
     * @Method({"GET", "POST"})
     */
    public function updateDocumentoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $trazabilidad = $em->getRepository("JHWEBContravencionalBundle:CvCdoTrazabilidad")->find(
                $params->id
            );

            if ($trazabilidad) {
                $actoAdministrativo = new CfgAdmActoAdministrativo();

                $actoAdministrativo->setNumero($params->numero);
                $actoAdministrativo->setFecha(new \Datetime(date('Y-m-d')));
                $actoAdministrativo->setCuerpo($params->cuerpo);
                $actoAdministrativo->setActivo(true);

                if ($params->idFormato) {
                    $formato = $em->getRepository('JHWEBConfigBundle:CfgAdmFormato')->find(
                        $params->idFormato
                    );
                    $actoAdministrativo->setFormato($formato);
                }
                $em->persist($actoAdministrativo);
                $em->flush();

                $trazabilidad->setActoAdministrativo($actoAdministrativo);
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $trazabilidad,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }
}
