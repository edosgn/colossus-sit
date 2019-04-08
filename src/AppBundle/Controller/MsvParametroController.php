<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvParametro;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Msvparametro controller.
 *
 * @Route("msvparametro")
 */
class MsvParametroController extends Controller
{
    /**
     * Lists all msvParametro entities.
     *
     * @Route("/", name="msvparametro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $parametros = $em->getRepository('AppBundle:MsvParametro')->findBy(
            array('estado' => true)
        );

        $response['data'] = array();

        if ($parametros) {
            $response = array(
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
     * @Route("/getByCategoriaId", name="msvparametrovycategoria")
     * @Method({"GET", "POST"})
     */
    public function allCategoriaId(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $hash = $request->get("authorization", null);
        $categoriaId = $request->get("json", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
    
            $msvParametros = $em->getRepository('AppBundle:MsvParametro')->findBy(
                array(
                    'categoria' => $categoriaId,
                    'estado' => 1,
                )
            );

            $msvParametrosArray = null;
            foreach ($msvParametros as $keyParametro => $msvParametro) {
                $msvParametrosArray[$keyParametro] = array(
                    'id'=>$msvParametro->getId(),
                    'name'=>$msvParametro->getNombre(),
                    'valor'=>$msvParametro->getValor(),
                    'numeroCriterios' => $msvParametro->getNumeroCriterios(),
                    'variables' => null,
                );

                 $variables = $em->getRepository('AppBundle:MsvVariable')->findBy(
                    array(
                        'parametro' => $msvParametro->getId(),
                        'estado' => 1,
                    )
                );

                /* $numeroVariables = count($variables);
                $msvParametrosArray[$keyParametro]['numeroVariables'] = $numeroVariables; */


                if($variables){
                    foreach ($variables as $keyVariable => $variable) {
                        $msvParametrosArray[$keyParametro]['variables'][$keyVariable] = array(
                            'id'=> $variable->getId(),
                            'name' => $variable->getNombre(),
                            'criterios' => null,
                        );

                        /** para el numero de criterios por parametro */
                        /* $criterios = $em->getRepository('AppBundle:MsvCriterio')->getCriteriosByParametro($variable);
                        $numeroCriterios = count($criterios);   */                    
                        /* $msvParametrosArray[$keyParametro]['variables'][$keyVariable]; */

                        $criterios = $em->getRepository('AppBundle:MsvCriterio')->findBy(
                            array(
                                'variable' => $variable->getId(),
                                'estado' => 1,
                            )
                        );

                        if($criterios){
                            foreach ($criterios as $keyCriterio => $criterio) {
                                $msvParametrosArray[$keyParametro]['variables'][$keyVariable]['criterios'][] = array(
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
            
            if($msvParametrosArray) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Parámetros encontrados",
                    'data' => $msvParametrosArray,
                );
            } else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "No se encontraron parámetros para la categoria ". $categoriaId,
                );
            }
        } else {
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorización no válida", 
                );
        }
        return $helpers ->json($response);
    }

    /**
     * Creates a new msvParametro entity.
     *
     * @Route("/new", name="msvparametro_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            
            $parametro = new MsvParametro();
            $parametro->setNombre(strtoupper($params->nombre));

            $categoria = $em->getRepository('AppBundle:MsvCategoria')->find($params->idCategoria);
            $parametro->setCategoria($categoria);
            $parametro->setValor($params->valor);
            $parametro->setNumeroCriterios($params->numeroCriterios);
            $parametro->setEstado(true);

            $em->persist($parametro);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Los datos han sido registrados exitosamente.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorización no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Finds and displays a msvParametro entity.
     *
     * @Route("/{id}/show", name="msvparametro_show")
     * @Method("GET")
     */
    public function showAction(MsvParametro $msvParametro)
    {
        $deleteForm = $this->createDeleteForm($msvParametro);

        return $this->render('msvparametro/show.html.twig', array(
            'msvParametro' => $msvParametro,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvParametro entity.
     *
     * @Route("/edit", name="msvparametro_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("json", null);
            $params = json_decode($json);
            
            $em = $this->getDoctrine()->getManager();
            $parametro = $em->getRepository('AppBundle:MsvParametro')->find($params->id);

            $categoria = $em->getRepository('AppBundle:MsvCategoria')->find($params->idCategoria);
            if ($parametro != null) {

                $parametro->setNombre(strtoupper($params->nombre));
                $parametro->setCategoria($categoria);
                $parametro->setValor($params->valor);
                $parametro->setNumeroCriterios($params->numeroCriterios);

                $em->persist($parametro);
                $em->flush();
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $parametro,
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
     * Deletes a msvParametro entity.
     *
     * @Route("/delete", name="msvparametro_delete")
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", true);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json", null);
            $params = json_decode($json);

            $parametro = $em->getRepository('AppBundle:MsvParametro')->find($params->id);

            $parametro->setEstado(false);

            $em->persist($parametro);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con éxito.",
            );
        } else {
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no válida",
            );
        }
        return $helpers->json($response);
    }

    /**
     * Creates a form to delete a msvParametro entity.
     *
     * @param MsvParametro $msvParametro The msvParametro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvParametro $msvParametro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvparametro_delete', array('id' => $msvParametro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select/", name="msvParametro_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $parametros = $em->getRepository('AppBundle:MsvParametro')->findBy(
            array('estado' => true)
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
