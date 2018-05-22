<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Sucursal;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Sucursal controller.
 *
 * @Route("sucursal")
 */
class SucursalController extends Controller
{
    /**
     * Lists all sucursal entities.
     *
     * @Route("/", name="sucursal_index")
     * @Method("GET") 
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        $sucursales = $em->getRepository('AppBundle:Sucursal')->findBy(
            array('estado' => 1)
        );

        $response = array(
            'status' => 'success',
            'code' => 200,
            'msj' => "Lista de sucursales",
            'data' => $sucursales, 
        );
        return $helpers->json($response);
    }

    /**
     * Creates a new sucursal entity.
     *
     * @Route("/new", name="sucursal_new")
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

                $nombre = $params->nombre;
                $sigla = $params->sigla;
                $direccion = $params->direccion;
                $telefono = $params->telefono;
                $celular = $params->celular;
                $correo = $params->correo;
                $fax = $params->fax;

                $municipioId = $params->municipioId;
                $municipio = $em->getRepository('AppBundle:Sucursal')->find($municipioId);

                $sucursal = new Sucursal();

                $sucursal->setPlaca($nombre);
                $sucursal->setPlaca($sigla);
                $sucursal->setPlaca($direccion);
                $sucursal->setPlaca($telefono);
                $sucursal->setPlaca($celular);
                $sucursal->setPlaca($correo);
                $sucursal->setPlaca($fax);

                $sucursal->setSucursal($municipio);
                $sucursal->setEstado(true);

                $em = $this->getDoctrine()->getManager();
                $em->persist($sucursal);
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


        // $sucursal = new Sucursal();
        // $form = $this->createForm('AppBundle\Form\SucursalType', $sucursal);
        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     $em = $this->getDoctrine()->getManager();
        //     $em->persist($sucursal);
        //     $em->flush();

        //     return $this->redirectToRoute('sucursal_show', array('id' => $sucursal->getId()));
        // }

        // return $this->render('sucursal/new.html.twig', array(
        //     'sucursal' => $sucursal,
        //     'form' => $form->createView(),
        // ));
    }

    /**
     * Finds and displays a sucursal entity.
     *
     * @Route("/{id}/show", name="sucursal_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, Sucursal $sucursal)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro encontrado", 
                    'data'=> $sucursal,
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
     * Displays a form to edit an existing sucursal entity.
     *
     * @Route("/{id}/edit", name="sucursal_edit")
     * @Method({"POST", "POST"})
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

            $id = $params->id;
            $nombre = $params->nombre;
            $sigla = $params->sigla;
            $direccion = $params->direccion;
            $telefono = $params->telefono;
            $celular = $params->celular;
            $correo = $params->correo;
            $fax = $params->fax;

            $municipioId = $params->municipioId;
            $municipio = $em->getRepository('AppBundle:Municipio')->find($municipioId);
            if ($sucursal!=null) {
                $sucursal->setPlaca($placa);
                $sucursal->setMunicipio($municipio);
                $em = $this->getDoctrine()->getManager();
                $em->persist($sucursal);
                $em->flush();

                 $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'msj' => "Registro actualizado con exito", 
                        'data'=> $sucursal,
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
     * Deletes a sucursal entity.
     *
     * @Route("/{id}", name="sucursal_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Sucursal $sucursal)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();

            $sucursal->setEstado(false);
            $em = $this->getDoctrine()->getManager();
                $em->persist($sucursal);
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
     * Creates a form to delete a sucursal entity.
     *
     * @param Sucursal $sucursal The sucursal entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Sucursal $sucursal)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('sucursal_delete', array('id' => $sucursal->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    




}
