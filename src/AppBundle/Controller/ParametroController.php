<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Parametro;
use AppBundle\Entity\ConceptoParametro;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Parametro controller.
 *
 * @Route("parametro")
 */
class ParametroController extends Controller
{
    /**
     * Lists all parametro entities.
     *
     * @Route("/", name="parametro_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $parametros = $em->getRepository('AppBundle:Parametro')->findBy(
            array('estado' => true)
        );
        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Listado de parametros", 
            'data'=> $parametros,
        );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new parametro entity.
     *
     * @Route("/new", name="parametro_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) {
            $em = $this->getDoctrine()->getManager();
            $json = $request->get("json",null);
            $params = json_decode($json);

            $parametro = new Parametro();
           

            $parametro->setAnio($params->parametro->anio);
            $parametro->setValor($params->parametro->valor);
            $parametro->setTipo($params->parametro->tipo);
            $parametro->setPorcentaje($params->parametro->porcentaje); 
            $parametro->setEstado(true);

            $em->persist($parametro);
            $em->flush();

            foreach ($params->listaPrecios as $key => $listaPrecio) {
                $valor = $listaPrecio[4];
                $listraPrecioId = $listaPrecio[6];
                $listaPrecioBd = $em->getRepository('AppBundle:TramitePrecio')->find($listraPrecioId);
                $listaPrecioBd->setValor($valor);
                $em->persist($listaPrecioBd);
                $em->flush();
            }

            foreach ($params->conceptos as $key => $concepto) {
                $conceptoParametro = new ConceptoParametro();
                $conceptoParametro->setNombre($concepto->nombre);
                $conceptoParametro->setValor($concepto->valor);
                $conceptoParametro->setParametro($parametro);
                $em->persist($conceptoParametro);
                $em->flush();
                var_dump($concepto->nombre);
               
            }
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => "Registro creado con exito", 
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
     * Finds and displays a pai entity.
     *
     * @Route("/{id}/show", name="parametro_show")
     * @Method("POST")
     */
    public function showAction($id)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $parametro = $em->getRepository('AppBundle:Parametro')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $parametro,
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
     * Displays a form to edit an existing parametro entity.
     *
     * @Route("/{id}/edit", name="parametro_edit")
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
            $parametro = $em->getRepository("AppBundle:Parametro")->find($params->id);

            $nombre = $params->nombre;
            $codigo = $params->codigo;

            if ($parametro!=null) {
                $parametro->setAnio($params->anio);
                $parametro->setValor($params->valor);
                $parametro->setTipo($params->tipo);
                $parametro->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($parametro);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $parametro,
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
     * Deletes a parametro entity.
     *
     * @Route("/{id}", name="parametro_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Parametro $parametro)
    {
        $form = $this->createDeleteForm($parametro);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($parametro);
            $em->flush();
        }

        return $this->redirectToRoute('parametro_index');
    }

    /**
     * Creates a form to delete a parametro entity.
     *
     * @param Parametro $parametro The parametro entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Parametro $parametro)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('parametro_delete', array('id' => $parametro->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
