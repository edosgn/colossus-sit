<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpCdp;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Numbers_Words;

/**
 * Bpcdp controller.
 *
 * @Route("bpcdp")
 */
class BpCdpController extends Controller
{
    /**
     * Lists all bpCdp entities.
     *
     * @Route("/", name="bpcdp_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $cdps = $em->getRepository('JHWEBBancoProyectoBundle:BpCdp')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($cdps) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($cdps)." registros encontrados", 
                'data'=> $cdps,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new bpCdp entity.
     *
     * @Route("/new", name="bpcdp_new")
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

            $cdp = new BpCdp();

            $solicitudFecha = new \Datetime(date('Y-m-d'));

            $consecutivo = $em->getRepository('JHWEBBancoProyectoBundle:BpCdp')->getMaximo(
                $solicitudFecha->format('Y')
            );
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);
            $cdp->setConsecutivo($consecutivo);

            $numero = str_pad($consecutivo, 3, '0', STR_PAD_LEFT).'-'.$solicitudFecha->format('Y');

            $cdp->setSolicitudNumero($numero);
            $cdp->setNumero($numero);

            $cdp->setSolicitudFecha($solicitudFecha);
            $cdp->setNumero($params->numero);
            $cdp->setValor($params->valor);
            $cdp->setActivo(true);

            $em->persist($cdp);
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
     * Finds and displays a bpCdp entity.
     *
     * @Route("/{id}/show", name="bpcdp_show")
     * @Method("GET")
     */
    public function showAction(BpCdp $bpCdp)
    {
        $deleteForm = $this->createDeleteForm($bpCdp);

        return $this->render('bpcdp/show.html.twig', array(
            'bpCdp' => $bpCdp,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bpCdp entity.
     *
     * @Route("/{id}/edit", name="bpcdp_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BpCdp $bpCdp)
    {
        $deleteForm = $this->createDeleteForm($bpCdp);
        $editForm = $this->createForm('JHWEB\BancoProyectoBundle\Form\BpCdpType', $bpCdp);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bpcdp_edit', array('id' => $bpCdp->getId()));
        }

        return $this->render('bpcdp/edit.html.twig', array(
            'bpCdp' => $bpCdp,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bpCdp entity.
     *
     * @Route("/{id}/delete", name="bpcdp_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BpCdp $bpCdp)
    {
        $form = $this->createDeleteForm($bpCdp);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bpCdp);
            $em->flush();
        }

        return $this->redirectToRoute('bpcdp_index');
    }

    /**
     * Creates a form to delete a bpCdp entity.
     *
     * @param BpCdp $bpCdp The bpCdp entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpCdp $bpCdp)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpcdp_delete', array('id' => $bpCdp->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ========================= */
    /**
     * Creates a request bpCdp entity.
     *
     * @Route("/request", name="bpcdp_request")
     * @Method({"GET", "POST"})
     */
    public function requestAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $em = $this->getDoctrine()->getManager();

            $cdp = new BpCdp();

            $solicitudFecha = new \Datetime(date('Y-m-d'));

            $consecutivo = $em->getRepository('JHWEBBancoProyectoBundle:BpCdp')->getMaximo(
                $solicitudFecha->format('Y')
            );
            $consecutivo = (empty($consecutivo['maximo']) ? 1 : $consecutivo['maximo']+=1);

            $numero = $solicitudFecha->format('Y').(str_pad($consecutivo, 3, '0', STR_PAD_LEFT));

            $cdp->setSolicitudNumero($numero);
            $cdp->setSolicitudFecha($solicitudFecha);
            $cdp->setSolicitudConsecutivo($consecutivo);

            if ($params->idActividad) {
                $actividad = $em->getRepository('JHWEBBancoProyectoBundle:BpActividad')->find($params->idActividad);
                $cdp->setActividad($actividad);
                $cdp->setValor($actividad->getCostoTotal());

                $valorEnLetras = Numbers_Words::toWords(
                    $actividad->getCostoTotal(), 'es'
                );
                $cdp->setValorLetras($valorEnLetras);
            }


            $cdp->setActivo(true);

            $em->persist($cdp);
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
}
