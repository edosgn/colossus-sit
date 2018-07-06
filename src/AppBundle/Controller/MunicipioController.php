<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Municipio;
use AppBundle\Form\MunicipioType;

/**
 * Municipio controller.
 *
 * @Route("/municipio")
 */
class MunicipioController extends Controller
{
    /**
     * Lists all Municipio entities.
     *
     * @Route("/", name="municipio_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $municipios = $em->getRepository('AppBundle:Municipio')->findBy(
            array('estado' => 1)
        );

       $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "lista de municipios",
                    'data' => $municipios, 
        );
        return $helpers->json($response);       
    }

    /**
     * Creates a new Municipio entity.
     *
     * @Route("/new", name="municipio_new")
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

                // var_dump($params);
                // die();
                $nombre = $params->nombre;
                $codigoDane = $params->codigoDane;
                $departamentoId = $params->departamentoId;
                

                $em = $this->getDoctrine()->getManager();
                $municipios = $em->getRepository('AppBundle:Municipio')->findBy(
                    array('codigoDane' => $codigoDane)
                );
                if ($municipios==null) {
                    $em = $this->getDoctrine()->getManager();
                    $departamento = $em->getRepository('AppBundle:Departamento')->find($departamentoId);
                    $municipio = new Municipio();
                    $municipio->setNombre($nombre);
                    $municipio->setCodigoDane($codigoDane);
                    $municipio->setDepartamento($departamento);
                    $municipio->setEstado(true);

                    $em->persist($municipio);
                    $em->flush();

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Municipio creado con exito", 
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'msj' => "El codigo Dane ya esta registrado", 
                    ); 
                }
            // }

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
     * Finds and displays a Municipio entity.
     *
     * @Route("/show/{id}", name="municipio_show")
     * @Method("POST")
     */
    public function showAction(Request $request,$id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $municipio = $em->getRepository('AppBundle:Municipio')->find($id);

            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Municipio con nombre"." ".$municipio->getNombre(), 
                    'data'=> $municipio,
            );
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
     * Displays a form to edit an existing Municipio entity.
     *
     * @Route("/edit", name="municipio_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $nombre = $params->nombre;
            $codigoDane = $params->codigoDane;
            $departamentoId = $params->departamentoId;

            $em = $this->getDoctrine()->getManager();
            $municipio = $em->getRepository('AppBundle:Municipio')->find($params->id);
            $departamento = $em->getRepository('AppBundle:Departamento')->find($departamentoId);


            if ($municipio!=null && $departamento!=null) {


                $municipio->setNombre($nombre);
                $municipio->setCodigoDane($codigoDane);
                $municipio->setDepartamento($departamento);

                $em = $this->getDoctrine()->getManager();
                $em->persist($municipio);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Municipio actualizado con exito", 
                        'data'=> $municipio,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El municipio no se encuentra en la base de datos", 
                );
            }
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
     * Deletes a Municipio entity.
     *
     * @Route("/{id}/delete", name="municipio_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {

            $em = $this->getDoctrine()->getManager();
            $municipio = $em->getRepository('AppBundle:Municipio')->find($id);

            if ($municipio!=null) {

                $municipio->setEstado(0);
                $em->persist($municipio);
                $em->flush();

                $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Municipio eliminado con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El Municipio no se encuentra en la base de datos", 
                );
            }
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
     * busca los municipios de un departamento.
     *
     * @Route("/mun/dep", name="municipio_dep")
     * @Method("POST")
     */
    public function mundDepAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $json = $request->get("json",null);
        $params = json_decode($json);

        $departamentoId = $params->departamentoId;

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $municipios = $em->getRepository('AppBundle:Municipio')->findBy(
                array('departamento' => $departamentoId)
            );

            foreach ($municipios as $key => $municipio) {
            $municipioArray[$key] = array(
                'value' => $municipio->getId(),
                'label' => $municipio->getCodigoDane()."_".$municipio->getNombre(),
                );
            }

            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "municipio encontrado", 
                    'data'=> $municipioArray,
            );
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
     * Creates a form to delete a Municipio entity.
     *
     * @param Municipio $municipio The Municipio entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Municipio $municipio)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('municipio_delete', array('id' => $municipio->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }


     /**
     * datos para select 2
     *
     * @Route("/select", name="municipio_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $municipios = $em->getRepository('AppBundle:Municipio')->findBy(
        array('estado' => 1)
    );
      foreach ($municipios as $key => $municipio) {
        $response[$key] = array(
            'value' => $municipio->getId(),
            'label' => $municipio->getCodigoDane()."_".$municipio->getNombre(),
            );
      }
       return $helpers->json($response);
    }


    /**
     * datos para select 2 por departamento
     *
     * @Route("/{id}/select/municipios/por/departamento", name="departamento_select_por_departamento")
     * @Method({"GET", "POST"})
     */
    public function selectDepartamentoPorPaisAction($id)
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $municipios = $em->getRepository('AppBundle:Municipio')->findBy(
        array(
            'departamento' => $id,
            'estado' => 1
        )
    );
      foreach ($municipios as $key => $municipio) {
        $response[$key] = array(
            'value' => $municipio->getId(),
            'label' => $municipio->getCodigoDane()."_".$municipio->getNombre(),
            );
      }
       return $helpers->json($response);
    }

    
}
