<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MparqEntradaSalida;
use AppBundle\Entity\MparqGrua;
use AppBundle\Entity\Vehiculo;
use AppBundle\Entity\Comparendo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Mparqentradasalida controller.
 *
 * @Route("mparqentradasalida")
 */
class MparqEntradaSalidaController extends Controller
{
    /**
     * Lists all mparqEntradaSalida entities.
     *
     * @Route("/", name="mparqentradasalida_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $entradasSalidas = $em->getRepository('AppBundle:MparqEntradaSalida')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($entradasSalidas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => count($entradasSalidas)." Registros encontrados", 
                'data'=> $entradasSalidas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new mparqEntradaSalida entity.
     *
     * @Route("/new", name="mparqentradasalida_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            /*if (count($params)==0) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "los campos no pueden estar vacios", 
                );
            }else{*/
                $em = $this->getDoctrine()->getManager();

                $grua = $em->getRepository('AppBundle:MparqGrua')->findOneByNumeroInterno(
                    $params->numeroGrua
                );

                if (!$grua) {
                    $grua = new MparqGrua();

                    $grua->setNumeroInterno($params->numeroGrua);
                    $em->persist($grua);
                    $em->flush();
                }

                $vehiculo = $em->getRepository('AppBundle:Vehiculo')->findOneByPlaca(
                    $params->numeroPlaca
                );

                if (!$vehiculo) {
                    $vehiculo = new Vehiculo();

                    $vehiculo->setPlaca($params->numeroPlaca);
                    $em->persist($vehiculo);
                    $em->flush();
                }

                $comparendo = $em->getRepository('AppBundle:Comparendo')->findOneByNumeroOrden(
                    $params->numeroComparendo
                );

                if (!$comparendo) {
                    $comparendo = new Comparendo();

                    $funcionario = $em->getRepository('AppBundle:MpersonalFuncionario')->find(
                        $params->funcionarioId
                    );

                    $comparendo->setNumeroOrden($params->numeroComparendo);
                    $comparendo->setVehiculo($vehiculo);
                    $comparendo->setLugarInfraccion($params->lugarInmovilizacion);
                    //$comparendo->setFuncionario($params->funcionarioId);
                    $em->persist($comparendo);
                    $em->flush();
                }

                $entradaSalida = new MparqEntradaSalida();

                $entradaSalida->setFechaIngreso(new \Datetime(date('Y-m-d h:m:s')));
                $entradaSalida->setNumeroInventario($params->numeroInventario);
                $entradaSalida->setGrua($grua);
                $entradaSalida->setComparendo($comparendo);

                
                $em->persist($entradaSalida);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro creado con exito",  
                );
            //}
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida", 
            );
        } 
        return $helpers->json($response);
    }

    /**
     * Finds and displays a mparqEntradaSalida entity.
     *
     * @Route("/{id}", name="mparqentradasalida_show")
     * @Method("GET")
     */
    public function showAction(MparqEntradaSalida $mparqEntradaSalida)
    {
        $deleteForm = $this->createDeleteForm($mparqEntradaSalida);

        return $this->render('mparqentradasalida/show.html.twig', array(
            'mparqEntradaSalida' => $mparqEntradaSalida,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mparqEntradaSalida entity.
     *
     * @Route("/{id}/edit", name="mparqentradasalida_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MparqEntradaSalida $mparqEntradaSalida)
    {
        $deleteForm = $this->createDeleteForm($mparqEntradaSalida);
        $editForm = $this->createForm('AppBundle\Form\MparqEntradaSalidaType', $mparqEntradaSalida);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mparqentradasalida_edit', array('id' => $mparqEntradaSalida->getId()));
        }

        return $this->render('mparqentradasalida/edit.html.twig', array(
            'mparqEntradaSalida' => $mparqEntradaSalida,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mparqEntradaSalida entity.
     *
     * @Route("/{id}", name="mparqentradasalida_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MparqEntradaSalida $mparqEntradaSalida)
    {
        $form = $this->createDeleteForm($mparqEntradaSalida);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mparqEntradaSalida);
            $em->flush();
        }

        return $this->redirectToRoute('mparqentradasalida_index');
    }

    /**
     * Creates a form to delete a mparqEntradaSalida entity.
     *
     * @param MparqEntradaSalida $mparqEntradaSalida The mparqEntradaSalida entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MparqEntradaSalida $mparqEntradaSalida)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mparqentradasalida_delete', array('id' => $mparqEntradaSalida->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
