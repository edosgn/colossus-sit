<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgParametro;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgparametro controller.
 *
 * @Route("svcfgparametro")
 */
class SvCfgParametroController extends Controller
{
    /**
     * Lists all svCfgParametro entities.
     *
     * @Route("/", name="svcfgparametro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $parametros = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgParametro')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($parametros) {
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => count($parametros) . " registros encontrados",
                'data' => $parametros,
            );
        }
        return $helpers->json($response);
    }

    /**
     * Parametros por categoriaid.
     *
     * @Route("/getByCategoriaId", name="svcfgparametro_categoria")
     * @Method({"GET", "POST"})
     */
    public function allCategoriaId(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            
            $parametros = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgParametro')->findBy(
                array(
                    'categoria' => $params->id,
                    'activo' => 1,
                )
            );

            $parametrosArray = null;
            foreach ($parametros as $keyParametro => $parametro) {
                $parametrosArray[$keyParametro] = array(
                    'id'=>$parametro->getId(),
                    'name'=>$parametro->getNombre(),
                    'valor'=>$parametro->getValor(),
                    'numeroCriterios' => $parametro->getNumeroCriterios(),
                    'variables' => null,
                );

                 $variables = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgVariable')->findBy(
                    array(
                        'parametro' => $parametro->getId(),
                        'activo' => 1,
                    )
                );

                /* $numeroVariables = count($variables);
                $parametrosArray[$keyParametro]['numeroVariables'] = $numeroVariables; */


                if($variables){
                    foreach ($variables as $keyVariable => $variable) {
                        $parametrosArray[$keyParametro]['variables'][$keyVariable] = array(
                            'id'=> $variable->getId(),
                            'name' => $variable->getNombre(),
                            'criterios' => null,
                        );

                        /** para el numero de criterios por parametro */
                        /* $criterios = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCriterio')->getCriteriosByParametro($variable);
                        $numeroCriterios = count($criterios);   */                    
                        /* $msvParametrosArray[$keyParametro]['variables'][$keyVariable]; */

                        $criterios = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCriterio')->findBy(
                            array(
                                'variable' => $variable->getId(),
                                'activo' => 1,
                            )
                        );

                        if($criterios){
                            foreach ($criterios as $keyCriterio => $criterio) {
                                $parametrosArray[$keyParametro]['variables'][$keyVariable]['criterios'][] = array(
                                    'id'=> $criterio->getId(),
                                    'name' => $criterio->getNombre(),
                                    'aplica'=>false,
                                    'evidencia'=> false,
                                    'responde'=>false,
                                    'observacion'=>null,
                                );
                            }  
                        }
                    }                
                }           
            }
            
            if($parametrosArray) {
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Parámetros encontrados",
                    'data' => $parametrosArray,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraron parámetros para la categoria ". $params->id,
                );
            }
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida", 
            );
        }
        return $helpers ->json($response);
    }

    /**
     * Creates a new svCfgParametro entity.
     *
     * @Route("/new", name="svCfgparametro_new")
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
            
            $parametro = new SvCfgParametro();
            $parametro->setNombre(strtoupper($params->nombre));

            $categoria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCategoria')->find($params->idCategoria);
            $parametro->setCategoria($categoria);
            $parametro->setValor($params->valor);
            $parametro->setNumeroCriterios($params->numeroCriterios);
            $parametro->setActivo(true);

            $em->persist($parametro);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
            );
        } else {
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
     * Finds and displays a svcfgParametro entity.
     *
     * @Route("/show", name="svcfgparametro_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $parametro = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgParametro')->find($params->id);

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "parametro con nombre"." ".$parametro->getNombre(), 
                'data'=> $parametro,
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
     * Displays a form to edit an existing svCfgParametro entity.
     *
     * @Route("/edit", name="svcfgparametro_edit")
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
            
            $parametro = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgParametro')->find($params->id);

            $categoria = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgCategoria')->find($params->idCategoria);
            if ($parametro != null) {

                $parametro->setNombre(strtoupper($params->nombre));
                $parametro->setCategoria($categoria);
                $parametro->setValor($params->valor);
                $parametro->setNumeroCriterios($params->numeroCriterios);

                $em->persist($parametro);
                $em->flush();
                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $parametro,
                );
            } else {
                $response = array(
                    'title' => 'Error!',
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos",
                );
            }
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
     * Deletes a svCfgParametro entity.
     *
     * @Route("/delete", name="svcfgparametro_delete")
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();

            $parametro = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgParametro')->find($params->id);

            $parametro->setActivo(false);

            $em->persist($parametro);
            $em->flush();

            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * datos para select 2
     *
     * @Route("/select/", name="svCfgParametro_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $parametros = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgParametro')->findBy(
            array(
                'activo' => true
            )
        );
        $response = null;

        foreach ($parametros as $key => $parametro) {
            $response[$key] = array(
                'value' => $parametro->getId(),
                'label' => $parametro->getNombre(),
            );
        }
        return $helpers->json($response);
    }

}
