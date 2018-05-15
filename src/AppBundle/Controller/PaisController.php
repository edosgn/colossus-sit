<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Pais;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Pai controller.
 *
 * @Route("pais")
 */
class PaisController extends Controller
{
    /**
     * Lists all pai entities.
     *
     * @Route("/", name="pais_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $paises = $em->getRepository('AppBundle:Pais')->findBy(
            array('estado' => true)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Listado de paises", 
            'data'=> $paises,
        );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new pai entity.
     *
     * @Route("/new", name="pais_new")
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
                    'msj' => "Los campos no pueden estar vacios", 
                );
            }else{*/
                $pais = new Pais();

                $pais->setNombre($params->nombre);
                $pais->setCodigo($params->codigo);
                $pais->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($pais);
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
     * Finds and displays a pai entity.
     *
     * @Route("/{id}/show", name="pais_show")
     * @Method("POST")
     */
    public function showAction($id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $pais = $em->getRepository('AppBundle:Pais')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado: ".$pais->getNombre(), 
                    'data'=> $pais,
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
     * Displays a form to edit an existing pai entity.
     *
     * @Route("/{id}/edit", name="pais_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $pais = $em->getRepository("AppBundle:Pais")->find($params->id);

            $nombre = $params->nombre;
            $codigo = $params->codigo;

            if ($pais!=null) {
                $pais->setNombre($nombre);
                $pais->setCodigo($codigo);

                $em = $this->getDoctrine()->getManager();
                $em->persist($pais);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $pais,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a pai entity.
     *
     * @Route("/{id}/delete", name="pais_delete")
     * @Method("POST")
     */
    public function deleteAction($id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $pais = $em->getRepository("AppBundle:Pais")->find($params->id);

            $pais->setEstado(false);

            $em->persist($pais);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro eliminado con exito", 
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
     * Creates a form to delete a pai entity.
     *
     * @param Pais $pai The pai entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Pais $pai)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pais_delete', array('id' => $pai->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="pais_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $response = null;
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $paises = $em->getRepository('AppBundle:Pais')->findBy(
            array('estado' => 1)
        );
        foreach ($paises as $key => $pais) {
            $response[$key] = array(
                'value' => $pais->getId(),
                'label' => $pais->getCodigo()."_".$pais->getNombre(),
            );
        }
        return $helpers->json($response);
    }
}
