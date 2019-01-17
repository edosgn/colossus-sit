<?php

namespace JHWEB\SeguridadVialBundle\Controller;

use JHWEB\SeguridadVialBundle\Entity\SvCfgSenial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Svcfgsenial controller.
 *
 * @Route("svcfgsenial")
 */
class SvCfgSenialController extends Controller
{
    /**
     * Lists all svCfgSenial entities.
     *
     * @Route("/", name="svcfgsenial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $seniales = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenial')->findBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($seniales) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => count($seniales)." registros encontrados", 
                'data'=> $seniales,
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new svCfgSenial entity.
     *
     * @Route("/new", name="svcfgsenial_new")
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
           
            $senial = new SvCfgSenial();

            $senial->setCodigo($params->codigo);
            $senial->setNombre(strtoupper($params->nombre));
            $senial->setCantidad(0);

            $file = $request->files->get('file');
                   
            if ($file) {
                $extension = $file->guessExtension();
                $filename = md5(rand().time()).".".$extension;
                $dir=__DIR__.'/../../../../web/uploads/seniales/logos';

                $file->move($dir,$filename);
                $senial->setLogo($filename);
            }

            if ($params->idSenialTipo) {
                $tipo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialTipo')->find(
                    $params->idSenialTipo
                );
                $senial->setTipoSenial($tipo);
            }

            if ($params->idColor) {
                $color = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialColor')->find(
                    $params->idColor
                );
                $senial->setColor($color);
            }

            $senial->setActivo(true);

            $em->persist($senial);
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
     * Finds and displays a svCfgSenial entity.
     *
     * @Route("/show", name="svcfgsenial_show")
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $senial = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenial')->find(
                $params->id
            );

            if ($senial) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado", 
                    'data'=> $senial,
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
                    'message' => "Autorizacion no valida", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Displays a form to edit an existing svCfgSenial entity.
     *
     * @Route("/edit", name="svcfgsenial_edit")
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

            $senial = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenial')->find(
                $params->id
            );

            if ($senial) {
                $senial->setCodigo($params->codigo);
                $senial->setNombre(strtoupper($params->nombre));
                $senial->setCantidad(0);

                $file = $request->files->get('file');
                       
                if ($file) {
                    $extension = $file->guessExtension();
                    $filename = md5(rand().time()).".".$extension;
                    $dir=__DIR__.'/../../../../web/uploads/seniales/logos';

                    $file->move($dir,$filename);
                    $senial->setLogo($filename);
                }

                if ($params->idSenialTipo) {
                    $tipo = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialTipo')->find(
                        $params->idSenialTipo
                    );
                    $senial->setTipoSenial($tipo);
                }

                if ($params->idColor) {
                    $color = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenialColor')->find(
                        $params->idColor
                    );
                    $senial->setColor($color);
                }

                $em->flush();
                
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro actualizado con éxito",
                    'data' => $senial,
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
     * Deletes a svCfgSenial entity.
     *
     * @Route("/{id}/delete", name="svcfgsenial_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, SvCfgSenial $svCfgSenial)
    {
        $form = $this->createDeleteForm($svCfgSenial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($svCfgSenial);
            $em->flush();
        }

        return $this->redirectToRoute('svcfgsenial_index');
    }

    /**
     * Creates a form to delete a svCfgSenial entity.
     *
     * @param SvCfgSenial $svCfgSenial The svCfgSenial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SvCfgSenial $svCfgSenial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('svcfgsenial_delete', array('id' => $svCfgSenial->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =================================================== */

    /**
     * datos para select 2
     *
     * @Route("/select", name="svcfgsenial_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $seniales = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenial')->findBy(
            array('activo' => 1)
        );

        $response = null;

        foreach ($seniales as $key => $senial) {
            $response[$key] = array(
                'value' => $senial->getId(),
                'label' => $senial->getNombre(),
            );
        }

        return $helpers->json($response);
    }

    /**
     * datos para select 2
     *
     * @Route("/select/tipo", name="svsenial_select_tipo")
     * @Method({"GET", "POST"})
     */
    public function selectTipoAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
           
            $seniales = $em->getRepository('JHWEBSeguridadVialBundle:SvCfgSenial')->findByTipoSenial(
                $params->idTipoSenial
            );
            
            $response = null;

            foreach ($seniales as $key => $senial) {
                $response[$key] = array(
                    'value' => $senial->getId(),
                    'label' => $senial->getCodigo().' - '.$senial->getNombre()
                );
            }
        }else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response);
    }
}
