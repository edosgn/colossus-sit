<?php

namespace JHWEB\BancoProyectoBundle\Controller;

use JHWEB\BancoProyectoBundle\Entity\BpReduccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Bpreduccion controller.
 *
 * @Route("bpreduccion")
 */
class BpReduccionController extends Controller
{
    /**
     * Lists all bpReduccion entities.
     *
     * @Route("/", name="bpreduccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $reducciones = $em->getRepository('JHWEBBancoProyectoBundle:BpReduccion')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($reducciones) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($reducciones)." registros encontrados", 
                'data'=> $reducciones,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new bpReduccion entity.
     *
     * @Route("/new", name="bpreduccion_new")
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

            $reduccion = new BpReduccion();

            $reduccion->setNumero($params->numero);
            $reduccion->setJustificacion($params->justificacion);
            $reduccion->setValor($params->valor);
            $reduccion->setActivo(true);
            
            if ($params->tipoReduccion == 1) {
                $reduccion->setTipo('CDP');
            
                if ($params->idCdp) {
                    $cdp = $em->getRepository('JHWEBBancoProyectoBundle:BpCdp')->find($params->idCdp);
                    $reduccion->setCdp($cdp);

                    if ($params->valor <= $cdp->getSaldo()) {
                        $response = array(
                            'title' => 'Atención!',
                            'status' => 'warning',
                            'code' => 400,
                            'message' => "El valor a reducir supera el saldo actual del CDP.", 
                        );
                    
                        return $helpers->json($response);
                    }else{
                        $cdp->setSaldo($cdp->getSaldo() - $params->valor);
                        $proyecto = $cdp->getProyecto();
                        $proyecto->setSaldo($proyecto->getSaldo() +  $params->valor);
                    }
                }
            } elseif ($params->tipoReduccion == 2) {
                $reduccion->setTipo('RC');
                
                if ($params->idRegistroCompromiso) {
                    $registro = $em->getRepository('JHWEBBancoProyectoBundle:BpRegistroCompromiso')->find(
                        $params->idRegistroCompromiso
                    );
                    $reduccion->setRegistroCompromiso($registro);

                    if ($params->valor <= $registro->getSaldo()) {
                        $response = array(
                            'title' => 'Atención!',
                            'status' => 'warning',
                            'code' => 400,
                            'message' => "El valor a reducir supera el saldo actual del Registro de Compromiso.", 
                        );

                        return $helpers->json($response);
                    }else{
                        $registro->setSaldo($registro->getSaldo() - $params->valor);
                        $cdp = $registro->getCdp();
                        $cdp->setSaldo($cdp->getSaldo() + $params->valor);
                        $proyecto = $cdp->getProyecto();
                        $proyecto->setSaldo($proyecto->getSaldo() +  $params->valor);
                    }
                }

            }
            
            if ($params->idFuncionario) {
                $funcionario = $em->getRepository('JHWEBPersonalBundle:PnalFuncionario')->find(
                    $params->idFuncionario
                );
                $reduccion->setSolicita($funcionario);
            }

            $em->persist($reduccion);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
                'data' => $cuenta
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
     * Finds and displays a bpReduccion entity.
     *
     * @Route("/{id}", name="bpreduccion_show")
     * @Method("GET")
     */
    public function showAction(BpReduccion $bpReduccion)
    {
        $deleteForm = $this->createDeleteForm($bpReduccion);

        return $this->render('bpreduccion/show.html.twig', array(
            'bpReduccion' => $bpReduccion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing bpReduccion entity.
     *
     * @Route("/{id}/edit", name="bpreduccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, BpReduccion $bpReduccion)
    {
        $deleteForm = $this->createDeleteForm($bpReduccion);
        $editForm = $this->createForm('JHWEB\BancoProyectoBundle\Form\BpReduccionType', $bpReduccion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bpreduccion_edit', array('id' => $bpReduccion->getId()));
        }

        return $this->render('bpreduccion/edit.html.twig', array(
            'bpReduccion' => $bpReduccion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a bpReduccion entity.
     *
     * @Route("/{id}", name="bpreduccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, BpReduccion $bpReduccion)
    {
        $form = $this->createDeleteForm($bpReduccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($bpReduccion);
            $em->flush();
        }

        return $this->redirectToRoute('bpreduccion_index');
    }

    /**
     * Creates a form to delete a bpReduccion entity.
     *
     * @param BpReduccion $bpReduccion The bpReduccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BpReduccion $bpReduccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('bpreduccion_delete', array('id' => $bpReduccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * Busca la reducciones por filtros establecidos
     *
     * @Route("/search/filter", name="bpcdp_search_filter")
     * @Method({"GET", "POST"})
     */
    public function searchByFilterAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $em = $this->getDoctrine()->getManager();

            if ($params->tipoReduccion == 1) {
                $tipo = "CDP";
            }elseif ($params->tipoReduccion == 2) {
                $tipo = "RC";
            }

            switch ($params->tipoFiltro) {
                case 1:
                    $reducciones = $em->getRepository('JHWEBBancoProyectoBundle:BpReduccion')->findBy(
                        array(
                            'tipo' => $tipo,
                            'numero' => $params->filtro,
                        )
                    );
                    break;

                case 2:
                    $reducciones = $em->getRepository('JHWEBBancoProyectoBundle:BpReduccion')->findBy(
                        array(
                            'tipo' => $tipo,
                            'fecha' => new \Datetime($params->fecha),
                        )
                    );
                    break;
            }

            if ($reducciones) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => count($reducciones)." registros encontrados.",
                    'data' => $reducciones,
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Ningún registro encontrado.", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida.", 
            );
        }
        
        return $helpers->json($response);
    }
}
