<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvAuCfgHorario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvaucfghorario controller.
 *
 * @Route("cvaucfghorario")
 */
class CvAuCfgHorarioController extends Controller
{
    /**
     * Lists all cvAuCfgHorario entities.
     *
     * @Route("/", name="cvaucfghorario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $horarios = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgHorario')->findBy(
            array(
                'activo' => true
            )
        );

        $response['data'] = array();

        if ($horarios) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($horarios)." registros encontrados", 
                'data'=> $horarios,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cvAuCfgHorario entity.
     *
     * @Route("/new", name="cvaucfghorario_new")
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
           
            $horario = new CvAuCfgHorario();

            $horario->setHoraManianaInicial(new \Datetime($params->horaManianaInicial));
            $horario->setHoraManianaFinal(new \Datetime($params->horaManianaFinal));
            $horario->setHoraTardeInicial(new \Datetime($params->horaTardeInicial));
            $horario->setHoraTardeFinal(new \Datetime($params->horaTardeFinal));
            $horario->setActivo(true);

            $em = $this->getDoctrine()->getManager();
            
            $em->persist($horario);
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
     * Finds and displays a cvAuCfgHorario entity.
     *
     * @Route("/{id}", name="cvaucfghorario_show")
     * @Method("GET")
     */
    public function showAction(CvAuCfgHorario $cvAuCfgHorario)
    {
        $deleteForm = $this->createDeleteForm($cvAuCfgHorario);

        return $this->render('cvaucfghorario/show.html.twig', array(
            'cvAuCfgHorario' => $cvAuCfgHorario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvAuCfgHorario entity.
     *
     * @Route("/edit", name="cvaucfghorario_edit")
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

            $horario = $em->getRepository("JHWEBContravencionalBundle:CvAuCfgHorario")->find(
                $params->id
            );

            if ($horario) {
                $horario->setHoraManianaInicial(
                    new \Datetime($params->horaManianaInicial)
                );
                $horario->setHoraManianaFinal(
                    new \Datetime($params->horaManianaFinal)
                );
                $horario->setHoraTardeInicial(
                    new \Datetime($params->horaTardeInicial)
                );
                $horario->setHoraTardeFinal(
                    new \Datetime($params->horaTardeFinal)
                );
                
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con exito", 
                    'data'=> $horario,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "El registro no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a cvAuCfgHorario entity.
     *
     * @Route("/delete", name="cvaucfghorario_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, CvAuCfgHorario $cvAuCfgHorario)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $horario = $em->getRepository('JHWEBContravencionalBundle:CvAuCfgHorario')->find(
                $params->id
            );

            $horario->setActivo(false);

            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro eliminado con exito"
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
     * Creates a form to delete a cvAuCfgHorario entity.
     *
     * @param CvAuCfgHorario $cvAuCfgHorario The cvAuCfgHorario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvAuCfgHorario $cvAuCfgHorario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvaucfghorario_delete', array('id' => $cvAuCfgHorario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
