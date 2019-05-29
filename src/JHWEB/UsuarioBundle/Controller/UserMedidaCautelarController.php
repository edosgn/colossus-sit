<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserMedidaCautelar;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Usermedidacautelar controller.
 *
 * @Route("usermedidacautelar")
 */
class UserMedidaCautelarController extends Controller
{
    /**
     * Lists all userMedidaCautelar entities.
     *
     * @Route("/", name="usermedidacautelar_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userMedidaCautelars = $em->getRepository('JHWEBUsuarioBundle:UserMedidaCautelar')->findAll();

        return $this->render('usermedidacautelar/index.html.twig', array(
            'userMedidaCautelars' => $userMedidaCautelars,
        ));
    }

    /**
     * Creates a new userMedidaCautelar entity.
     *
     * @Route("/new", name="usermedidacautelar_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $fechaRegistro = new \Datetime($params->fechaRegistro);

            $medidasCautelaresOld = $em->getRepository('JHWEBUsuarioBundle:UserMedidaCautelar')->findBy(
                array(
                    'numeroOficio' => $params->numeroOficio,
                    'fechaRegistro' => $fechaRegistro
                )
            );

            if (!$medidasCautelaresOld) {
                $municipio = $em->getRepository('JHWEBConfigBundle:CfgMunicipio')->find(
                    $params->idMunicipio
                );

                $tipoProceso = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionTipoProceso')->find(
                    $params->idTipoProcesoLimitacion
                );

                $causal = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLimitacionCausal')->find(
                    $params->idCausalLimitacion
                );

                $entidadJudicial = $em->getRepository('JHWEBConfigBundle:CfgEntidadJudicial')->find(
                    $params->idEntidadJudicial
                );
                
                foreach ($params->demandados as $key => $demandadoArray) {
                    $medidaCautelar = new UserMedidaCautelar();
                    
                    $medidaCautelar->setNumeroOficio($params->numeroOficio);
                    $medidaCautelar->setNumeroRadicado($params->numeroRadicado);
                    $medidaCautelar->setObservaciones($params->observaciones);
                    $medidaCautelar->setFechaRegistro($fechaRegistro);
                    $medidaCautelar->setFechaInicio(new \Datetime($params->fechaInicio));
                    $medidaCautelar->setFechaExpiracion(new \Datetime($params->fechaExpiracion));
                    $medidaCautelar->setMunicipio($municipio);                        
                    $medidaCautelar->setTipoProceso($tipoProceso);
                    $medidaCautelar->setCausal($causal);
                    $medidaCautelar->setEntidadJudicial($entidadJudicial);
                    $medidaCautelar->setActivo(true);
                    
                    $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->find(
                        $demandadoArray->ciudadano->id
                    );
                    $medidaCautelar->setCiudadano($ciudadano);

                    $em->persist($medidaCautelar);
                    $em->flush();
                }
    
                $medidasCautelares = $em->getRepository('JHWEBUsuarioBundle:UserMedidaCautelar')->findBy(
                    array(
                        'numeroOficio' => $params->numeroOficio,
                        'fechaRegistro' => $fechaRegistro,
                        'activo' => true
                    )
                );
    
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro creado con exito",
                    'data' => $medidasCautelares
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Las medidas cautelares asociadas al número de oficio ".$params->numeroOficio." con fecha de registro ".$fechaRegistro->format('d/m/Y')." ya se encuentras registradas en el sistema.",
                    'data' => $medidasCautelaresOld
                );
            }
            
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        
        return $helpers->json($response);
    }

    /**
     * Finds and displays a userMedidaCautelar entity.
     *
     * @Route("/{id}/show", name="usermedidacautelar_show")
     * @Method("GET")
     */
    public function showAction(UserMedidaCautelar $userMedidaCautelar)
    {
        $deleteForm = $this->createDeleteForm($userMedidaCautelar);

        return $this->render('usermedidacautelar/show.html.twig', array(
            'userMedidaCautelar' => $userMedidaCautelar,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing userMedidaCautelar entity.
     *
     * @Route("/{id}/edit", name="usermedidacautelar_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, UserMedidaCautelar $userMedidaCautelar)
    {
        $deleteForm = $this->createDeleteForm($userMedidaCautelar);
        $editForm = $this->createForm('JHWEB\UsuarioBundle\Form\UserMedidaCautelarType', $userMedidaCautelar);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('usermedidacautelar_edit', array('id' => $userMedidaCautelar->getId()));
        }

        return $this->render('usermedidacautelar/edit.html.twig', array(
            'userMedidaCautelar' => $userMedidaCautelar,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a userMedidaCautelar entity.
     *
     * @Route("/delete", name="usermedidacautelar_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $medidaCautelar = $em->getRepository('JHWEBUsuarioBundle:UserMedidaCautelar')->find(
                $params->id
            );

            if ($medidaCautelar) {
                $medidaCautelar->setActivo(false);
    
                $em->flush();
    
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro eliminado con exito.",
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos.",
                );
            }
        } else {
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
     * Creates a form to delete a userMedidaCautelar entity.
     *
     * @param UserMedidaCautelar $userMedidaCautelar The userMedidaCautelar entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(UserMedidaCautelar $userMedidaCautelar)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usermedidacautelar_delete', array('id' => $userMedidaCautelar->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ============================================== */

    /**
     * Busca las medidas cautelares activas por numero de identificacion.
     *
     * @Route("/search/identificacion", name="vhlolimitacion_search_identificacion")
     * @Method({"GET", "POST"})
     */
    public function searchByIdentificacionAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $ciudadano = $em->getRepository('JHWEBUsuarioBundle:UserCiudadano')->findOneBy(
                array(
                    'identificacion' => $params->numero
                )
            );

            if ($ciudadano) {
                $medidasCautelares = $em->getRepository('JHWEBUsuarioBundle:UserMedidaCautelar')->findBy(
                    array(
                        'ciudadano' => $ciudadano->getId(),
                        'activo' => true,
                    )
                );

                if ($medidasCautelares) {
                    $response = array(
                        'title' => 'Perfecto!',
                        'status' => 'success',
                        'code' => 200,
                        'message' => count($medidasCautelares).' medidas cautelares encontradas.',
                        'data' => $medidasCautelares,
                    );
                }else{
                    $response = array(
                        'title' => 'Atención!',
                        'status' => 'warning',
                        'code' => 400,
                        'message' => 'Ningún registro encontrado.',
                    );
                }
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => 'No existe ningún registro con el número de placa digitado.',
                );
            }
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }
        
        return $helpers->json($response);
    }
}
