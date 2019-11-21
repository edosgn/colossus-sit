<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCfgPorcentajeInicial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcfgporcentajeinicial controller.
 *
 * @Route("cvcfgporcentajeinicial")
 */
class CvCfgPorcentajeInicialController extends Controller
{
    /**
     * Lists all cvCfgPorcentajeInicial entities.
     *
     * @Route("/", name="cvcfgporcentajeinicial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $porcentajes = $em->getRepository('JHWEBContravencionalBundle:CvCfgPorcentajeInicial')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($porcentajes) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($porcentajes)." registros encontrados", 
                'data'=> $porcentajes,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvCfgPorcentajeInicial entity.
     *
     * @Route("/new", name="cvcfgporcentajeinicial_new")
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
           
            $porcentaje = new CvCfgPorcentajeInicial();

            $porcentaje->setAnio($params->anio);
            $porcentaje->setValor($params->valor);
            $porcentaje->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            $em->persist($porcentaje);
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
     * Finds and displays a cvCfgPorcentajeInicial entity.
     *
     * @Route("/{id}", name="cvcfgporcentajeinicial_show")
     * @Method("GET")
     */
    public function showAction(CvCfgPorcentajeInicial $cvCfgPorcentajeInicial)
    {
        $deleteForm = $this->createDeleteForm($cvCfgPorcentajeInicial);

        return $this->render('cvcfgporcentajeinicial/show.html.twig', array(
            'cvCfgPorcentajeInicial' => $cvCfgPorcentajeInicial,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvCfgPorcentajeInicial entity.
     *
     * @Route("/edit", name="cvcfgporcentajeinicial_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $porcentaje = $em->getRepository('JHWEBContravencionalBundle:CvCfgPorcentajeInicial')->find($params->id);
            if ($porcentaje!=null) {

                $porcentaje->setAnio($params->anio);
                $porcentaje->setValor($params->valor);
               
                $em->persist($porcentaje);
                $em->flush();

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro editado con éxito", 
                );
            }else{
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida.", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cvCfgPorcentajeInicial entity.
     *
     * @Route("/delete", name="cvcfgporcentajeinicial_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();          
            
            $porcentajeInicial = $em->getRepository('JHWEBContravencionalBundle:CvCfgPorcentajeInicial')->find($params->id);
            
            $porcentajeInicial->setActivo(false);
            
            $em->persist($porcentajeInicial);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito", 
            );
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
        }
        return $helpers->json($response);
    }

    /**
     * Selecciona el porcentaje inicial activo a la fecha
     *
     * @Route("/search/active", name="cvcfgporcentajeinicial_search_active")
     * @Method({"GET", "POST"})
     */
    public function searchActiveAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        
        $porcentaje = $em->getRepository('JHWEBContravencionalBundle:CvCfgPorcentajeInicial')->findOneBy(
            array('activo' => true)
        );

        if ($porcentaje) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => 'Porcentaje inicial parametrizado '.$porcentaje->getValor().'%',
                'data' => $porcentaje
            );
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Interes no parametrizado", 
            );
        } 

        
        return $helpers->json($response);
    }
}
