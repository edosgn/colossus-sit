<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvIpatImpresoMunicipio;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svipatimpresomunicipio controller.
 *
 * @Route("svipatimpresomunicipio")
 */
class SvIpatImpresoMunicipioController extends Controller
{
    /**
     * Lists all svIpatImpresoMunicipio entities.
     *
     * @Route("/", name="svipatimpresomunicipio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $municipios = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoMunicipio')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($municipios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($municipios) . " registros encontrados",
                'data' => $municipios,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svIpatImpresoMunicipio entity.
     *
     * @Route("/new", name="svipatimpresomunicipio_new")
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

            if ($params->idOrganismoTransito) {
                $organismoTransito = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find(
                    $params->idOrganismoTransito
                );
            }

            $cantidadDisponible = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion')->getTotalDisponibleByOrganismoTransito(
                $organismoTransito->getId()
            );
            $cantidadDisponible = (empty($cantidadDisponible['cantidad']) ? 0 : $cantidadDisponible['cantidad']);

            if ($cantidadDisponible > 0) {
                if ($params->cantidad <= $cantidadDisponible) {
                    $municipio = new SvIpatImpresoMunicipio();

                    $consecutivo = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoMunicipio')->getMaximo(date('Y'));
                
                    $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
                    $municipio->setConsecutivo($consecutivo);

                    $fecha = new \Datetime($params->fecha);
                    
                    $municipio->setNumeroActa(
                        $fecha->format('Y').str_pad($consecutivo, 3, '0', STR_PAD_LEFT)
                    );

                    $municipio->setFecha($fecha);
                    
                    $municipio->setCantidadDisponible($params->cantidad);
                    $municipio->setCantidadEntregada($params->cantidad);
                    $municipio->setCorregimiento($params->corregimiento);
                    $municipio->setResponsableNombre($params->responsableNombre);
                    $municipio->setResponsableIdentificacion($params->responsableIdentificacion);
                    $municipio->setResponsableCargo($params->responsableCargo);
                    $municipio->setActivo(true);

                    if ($organismoTransito) {
                        $municipio->setOrganismoTransito($organismoTransito);
                    }

                    if ($params->idMunicipio) {
                        $municipioDistribucion = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                            $params->idMunicipio
                        );
                        $municipio->setMunicipio($municipioDistribucion);
                    }

                    $em->persist($municipio);
                    $em->flush();

                    $asignaciones = $em->getRepository('JHWEBSeguridadVialBundle:SvIpatImpresoAsignacion')->findBy(
                        array(
                            'organismoTransito' => $organismoTransito->getId(),
                            'activo' => true
                        )
                    );
    
                    foreach ($asignaciones as $key => $asignacion){
                        if ($asignacion->getCantidadDisponible() <= $params->cantidad) {
                            $cantidad =  $params->cantidad - $asignacion->getCantidadDisponible();
                            $params->cantidad = $cantidad;
                            $asignacion->setCantidadDisponible(0);
                            $asignacion->setActivo(false);
    
                            $em->flush(); 
                        }else {
                            if ($params->cantidad > 0) {
                                $cantidad =  $asignacion->getCantidadDisponible() - $params->cantidad;
                                $asignacion->setCantidadDisponible($cantidad);
                                $params->cantidad = 0;
    
                                $em->flush(); 
                            }
                        }
                    }
                
                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Registro creado con exito.',
                        'data' => $municipio
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => 'La cantidad solicitada supera los '.$cantidadDisponible.' disponibles en el organismo de tránsito.', 
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No tiene impresos disponibles en el organismo de tránsito.', 
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => 'Autorizacion no valida.', 
            );
        } 

        return $helpers->json($response);
    }

    /**
     * Finds and displays a svIpatImpresoMunicipio entity.
     *
     * @Route("/{id}", name="svipatimpresomunicipio_show")
     * @Method("GET")
     */
    public function showAction(SvIpatImpresoMunicipio $svIpatImpresoMunicipio)
    {
        $deleteForm = $this->createDeleteForm($svIpatImpresoMunicipio);

        return $this->render('svipatimpresomunicipio/show.html.twig', array(
            'svIpatImpresoMunicipio' => $svIpatImpresoMunicipio,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing svIpatImpresoMunicipio entity.
     *
     * @Route("/{id}/edit", name="svipatimpresomunicipio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SvIpatImpresoMunicipio $svIpatImpresoMunicipio)
    {
        $deleteForm = $this->createDeleteForm($svIpatImpresoMunicipio);
        $editForm = $this->createForm('JHWEB\SeguridadVialBundle\Form\SvIpatImpresoMunicipioType', $svIpatImpresoMunicipio);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('svipatimpresomunicipio_edit', array('id' => $svIpatImpresoMunicipio->getId()));
        }

        return $this->render('svipatimpresomunicipio/edit.html.twig', array(
            'svIpatImpresoMunicipio' => $svIpatImpresoMunicipio,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a svIpatImpresoMunicipio entity.
     *
     * @Route("/{id}", name="svipatimpresomunicipio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvIpatImpresoMunicipio $svIpatImpresoMunicipio)
    {
        $form = $this->createDeleteForm($svIpatImpresoMunicipio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svIpatImpresoMunicipio);
            $em->flush();
        }

        return $this->redirectToRoute('svipatimpresomunicipio_index');
    }

    /**
     * Creates a form to delete a svIpatImpresoMunicipio entity.
     *
     * @param SvIpatImpresoMunicipio $svIpatImpresoMunicipio The svIpatImpresoMunicipio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvIpatImpresoMunicipio $svIpatImpresoMunicipio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svipatimpresomunicipio_delete', array('id' => $svIpatImpresoMunicipio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
