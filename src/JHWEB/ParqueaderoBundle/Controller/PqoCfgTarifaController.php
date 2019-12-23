<?php

namespace JHWEB\ParqueaderoBundle\Controller;

use JHWEB\ParqueaderoBundle\Entity\PqoCfgTarifa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Pqocfgtarifa controller.
 *
 * @Route("pqocfgtarifa")
 */
class PqoCfgTarifaController extends Controller
{
    /**
     * Lists all pqoCfgTarifa entities.
     *
     * @Route("/", name="pqocfgtarifa_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $tarifas = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgTarifa')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($tarifas) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($tarifas)." registros encontrados", 
                'data'=> $tarifas,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new pqoCfgTarifa entity.
     *
     * @Route("/new", name="pqocfgtarifa_new")
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

            $patio = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgPatio')->find(
                $params->idPatio
            );

            $tipoVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->find(
                $params->idTipoVehiculo
            );

            $tarifaOld = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgTarifa')->findOneBy(
                array(
                    'patio' => $patio->getId(),
                    'tipoVehiculo' => $tipoVehiculo->getId(),
                    'activo' => true
                )
            );

            if ($tarifaOld) {
                $tarifaOld->setActivo(false);

                $em->flush();
            }

            $tarifa = new PqoCfgTarifa();
            
            $tarifa->setFecha(new \Datetime($params->fecha));
            $tarifa->setValorHora($params->valorHora);
            $tarifa->setActivo(true);
            
            if ($params->numeroActoAdministrativo) {
                $tarifa->setNumeroActoAdministrativo($params->numeroActoAdministrativo);
            }
                
            $tarifa->setTipoVehiculo($tipoVehiculo);
            $tarifa->setPatio($patio);
            
            $em->persist($tarifa);
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
     * Finds and displays a pqoCfgTarifa entity.
     *
     * @Route("/{id}", name="pqocfgtarifa_show")
     * @Method("GET")
     */
    public function showAction(PqoCfgTarifa $pqoCfgTarifa)
    {
        $deleteForm = $this->createDeleteForm($pqoCfgTarifa);

        return $this->render('pqocfgtarifa/show.html.twig', array(
            'pqoCfgTarifa' => $pqoCfgTarifa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing pqoCfgTarifa entity.
     *
     * @Route("/edit", name="pqocfgtarifa_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $tarifa = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgTarifa')->find(
                $params->id
            );


            $patio = $em->getRepository('JHWEBParqueaderoBundle:PqoCfgPatio')->find(
                $params->idPatio
            );

            $tipoVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgTipoVehiculo')->find(
                $params->idTipoVehiculo
            );

            $tarifa->setValorHora($params->valorHora);
            
            if ($params->numeroActoAdministrativo) {
                $tarifa->setNumeroActoAdministrativo($params->numeroActoAdministrativo);
            }

            $tarifa->setFecha(new \Datetime($params->fecha));
            $tarifa->setTipoVehiculo($tipoVehiculo);
            $tarifa->setPatio($patio);
            
            $em->persist($tarifa);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro actualizado con éxito",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida para editar",
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a pqoCfgTarifa entity.
     *
     * @Route("/{id}", name="pqocfgtarifa_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PqoCfgTarifa $pqoCfgTarifa)
    {
        $form = $this->createDeleteForm($pqoCfgTarifa);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($pqoCfgTarifa);
            $em->flush();
        }

        return $this->redirectToRoute('pqocfgtarifa_index');
    }

    /**
     * Creates a form to delete a pqoCfgTarifa entity.
     *
     * @param PqoCfgTarifa $pqoCfgTarifa The pqoCfgTarifa entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PqoCfgTarifa $pqoCfgTarifa)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pqocfgtarifa_delete', array('id' => $pqoCfgTarifa->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
