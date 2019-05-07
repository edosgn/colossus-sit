<?php

namespace JHWEB\ParqueaderoBundle\Controller;

use JHWEB\ParqueaderoBundle\Entity\PqoInmovilizacion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pqoinmovilizacion controller.
 *
 * @Route("pqoinmovilizacion")
 */
class PqoInmovilizacionController extends Controller
{
    /**
     * Lists all pqoInmovilizacion entities.
     *
     * @Route("/", name="pqoinmovilizacion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $inmovilizaciones = $em->getRepository('JHWEBParqueaderoBundle:PqoInmovilizacion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($inmovilizaciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($inmovilizaciones)." registros encontrados", 
                'data'=> $inmovilizaciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new pqoInmovilizacion entity.
     *
     * @Route("/new", name="pqoinmovilizacion_new")
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

            $inmovilizacion = new PqoInmovilizacion();

            $inmovilizacion->setNumeroComparendo($params->numeroComparendo);
            $inmovilizacion->setPlaca($params->placa);
            $inmovilizacion->setFechaIngreso(new \Datetime(date('Y-m-d')));
            $inmovilizacion->setHoraIngreso(new \Datetime(date('h:i:s A')));
            $inmovilizacion->setNumeroInventario($params->numeroInventario);
            $inmovilizacion->setCostoGrua($params->costoGrua);
            $inmovilizacion->setEstado('INMOVILIZADO');
            $inmovilizacion->setActivo(true);

            if ($params->observaciones) {
                $inmovilizacion->setObservaciones($params->observaciones);
            }
            
            if ($params->idLinea) {
                $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->find(
                    $params->idLinea
                );
                $inmovilizacion->setLinea($linea);
            }

            if ($params->idClase) {
                $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find(
                    $params->idClase
                );
                $inmovilizacion->setClase($clase);
            }

            if ($params->idColor) {
                $color = $em->getRepository('JHWEBVehiculoBundle:VhloCfgColor')->find(
                    $params->idColor
                );
                $inmovilizacion->setColor($color);
            }

            if ($params->idGrua) {
                $grua = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgGrua')->find(
                    $params->idGrua
                );
                $inmovilizacion->setGrua($grua);
            }

            if ($params->idPatio) {
                $patio = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgPatio')->find(
                    $params->idPatio
                );
                $inmovilizacion->setPatio($patio);
            }

            $em->persist($inmovilizacion);
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
                'message' => "Autorizacion no valida", 
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a pqoInmovilizacion entity.
     *
     * @Route("/{id}", name="pqoinmovilizacion_show")
     * @Method("GET")
     */
    public function showAction(PqoInmovilizacion $pqoInmovilizacion)
    {
        $deleteForm = $this->createDeleteForm($pqoInmovilizacion);

        return $this->render('pqoinmovilizacion/show.html.twig', array(
            'pqoInmovilizacion' => $pqoInmovilizacion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pqoInmovilizacion entity.
     *
     * @Route("/{id}/edit", name="pqoinmovilizacion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PqoInmovilizacion $pqoInmovilizacion)
    {
        $deleteForm = $this->createDeleteForm($pqoInmovilizacion);
        $editForm = $this->createForm('JHWEB\ParqueaderoBundle\Form\PqoInmovilizacionType', $pqoInmovilizacion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('pqoinmovilizacion_edit', array('id' => $pqoInmovilizacion->getId()));
        }

        return $this->render('pqoinmovilizacion/edit.html.twig', array(
            'pqoInmovilizacion' => $pqoInmovilizacion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a pqoInmovilizacion entity.
     *
     * @Route("/{id}", name="pqoinmovilizacion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PqoInmovilizacion $pqoInmovilizacion)
    {
        $form = $this->createDeleteForm($pqoInmovilizacion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pqoInmovilizacion);
            $em->flush();
        }

        return $this->redirectToRoute('pqoinmovilizacion_index');
    }

    /**
     * Creates a form to delete a pqoInmovilizacion entity.
     *
     * @param PqoInmovilizacion $pqoInmovilizacion The pqoInmovilizacion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PqoInmovilizacion $pqoInmovilizacion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pqoinmovilizacion_delete', array('id' => $pqoInmovilizacion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =========================================== */

    /**
     * Displays a form to edit an existing pqoCfgGrua entity.
     *
     * @Route("/exit", name="pqoinmovilizacion_exit")
     * @Method({"GET", "POST"})
     */
    public function exitAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $inmovilizacion = $em->getRepository('JHWEBParqueaderoBundle:PqoInmovilizacion')->find(
                $params->id
            );

            if ($inmovilizacion) {
                $inmovilizacion->setSalida(true);
                $inmovilizacion->setEstado('AUTORIZADO');

                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $inmovilizacion,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing pqoCfgGrua entity.
     *
     * @Route("/find/comparendo", name="pqoinmovilizacion_comparendo")
     * @Method({"GET", "POST"})
     */
    public function findByComparendoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $inmovilizacion = $em->getRepository('JHWEBParqueaderoBundle:PqoInmovilizacion')->findOneBy(
                array(
                    'numeroComparendo' => $params->numero
                )
            );

            if ($inmovilizacion) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado con éxito",
                    'data' => $inmovilizacion,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }

        return $helpers->json($response);
    }
}
