<?php

namespace JHWEB\ConfigBundle\Controller;

use JHWEB\ConfigBundle\Entity\CfgPropietario;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cfgpropietario controller.
 *
 * @Route("cfgpropietario")
 */
class CfgPropietarioController extends Controller
{
    /**
     * Lists all cfgPropietario entities.
     *
     * @Route("/", name="cfgpropietario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();
        
        $propietario = $em->getRepository('JHWEBConfigBundle:CfgPropietario')->findOneBy(
            array('activo' => true)
        );

        $response['data'] = array();

        if ($propietario) {
            $response = array(
                'title' => 'Perfecto!',
                'status' => 'success',
                'code' => 200,
                'message' => "Datos del propietario del sistema registrados.", 
                'data'=> $propietario,
            );
        }else{
            $response = array(
                'title' => 'Atención!',
                'status' => 'warning',
                'code' => 400,
                'message' => "No existen datos regsitrados, por favor diligencie la información del propietario del sistema..", 
            );
        }

        return $helpers->json($response);
    }

    /**
     * Creates a new cfgPropietario entity.
     *
     * @Route("/new", name="cfgpropietario_new")
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

            $propietario = new Cfgpropietario();

            $propietario->setNombre(strtoupper($params->nombre));
            $propietario->setNit($params->nit);
            $propietario->setCorreo($params->correo);
            $propietario->setTelefono($params->telefono);
            $propietario->setCorreo($params->correo);
            $propietario->setConceptos($params->conceptos);
            $propietario->setActivo(true);

            //Carga de imagen de cabecera de página
            $fileHeader = $request->files->get('fileHeader');
               
            if ($fileHeader) {
                $extension = $fileHeader->guessExtension();
                $filename = "header.".$extension;
                $dir=__DIR__.'/../../../../web/img';

                $fileHeader->move($dir,$filename);
                $propietario->setImagenCabecera($filename);
            }

            //Carga de imagen de pie de página
            $fileFooter = $request->files->get('fileFooter');
               
            if ($fileFooter) {
                $extension = $fileFooter->guessExtension();
                $filename = "footer.".$extension;
                $dir=__DIR__.'/../../../../web/img';

                $fileFooter->move($dir,$filename);
                $propietario->setImagenPie($filename);
            }

            //Carga de imagen de logo de sistema
            $fileLogo = $request->files->get('fileLogo');
               
            if ($fileLogo) {
                $extension = $fileLogo->guessExtension();
                $filename = "logo.".$extension;
                $dir=__DIR__.'/../../../../web/img';

                $fileLogo->move($dir,$filename);
                $propietario->setImagenLogo($filename);
            }

            $em->persist($propietario);
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
     * Finds and displays a cfgPropietario entity.
     *
     * @Route("/{id}/show", name="cfgpropietario_show")
     * @Method("GET")
     */
    public function showAction(CfgPropietario $cfgPropietario)
    {
        $deleteForm = $this->createDeleteForm($cfgPropietario);

        return $this->render('cfgpropietario/show.html.twig', array(
            'cfgPropietario' => $cfgPropietario,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cfgPropietario entity.
     *
     * @Route("/edit", name="cfgpropietario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $em = $this->getDoctrine()->getManager();

            $propietario = $em->getRepository('JHWEBConfigBundle:CfgPropietario')->find(
                $params->id
            );


            $propietario->setNombre(strtoupper($params->nombre));
            $propietario->setNit($params->nit);
            $propietario->setCorreo($params->correo);
            $propietario->setTelefono($params->telefono);
            $propietario->setCorreo($params->correo);
            $propietario->setConceptos($params->conceptos);

            //Carga de imagen de cabecera de página
            if ($request->files->get('fileHeader')) {
                $fileHeader = $request->files->get('fileHeader');
                   
                if ($fileHeader) {
                    $extension = $fileHeader->guessExtension();
                    $filename = "header.".$extension;
                    $dir=__DIR__.'/../../../../web/img';
    
                    $fileHeader->move($dir,$filename);
                    $propietario->setImagenCabecera($filename);
                }
            }

            //Carga de imagen de pie de página
            if ($request->files->get('fileFooter')) {
                $fileFooter = $request->files->get('fileFooter');
                   
                if ($fileFooter) {
                    $extension = $fileFooter->guessExtension();
                    $filename = "footer.".$extension;
                    $dir=__DIR__.'/../../../../web/img';
    
                    $fileFooter->move($dir,$filename);
                    $propietario->setImagenPie($filename);
                }
            }

            //Carga de imagen de logo de sistema
            if ($request->files->get('fileLogo')) {
                $fileLogo = $request->files->get('fileLogo');
                   
                if ($fileLogo) {
                    $extension = $fileLogo->guessExtension();
                    $filename = "logo.".$extension;
                    $dir=__DIR__.'/../../../../web/img';
    
                    $fileLogo->move($dir,$filename);
                    $propietario->setImagenLogo($filename);
                }
            }

            $em->persist($propietario);
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
     * Deletes a cfgPropietario entity.
     *
     * @Route("/{id}", name="cfgpropietario_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CfgPropietario $cfgPropietario)
    {
        $form = $this->createDeleteForm($cfgPropietario);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cfgPropietario);
            $em->flush();
        }

        return $this->redirectToRoute('cfgpropietario_index');
    }

    /**
     * Creates a form to delete a cfgPropietario entity.
     *
     * @param CfgPropietario $cfgPropietario The cfgPropietario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CfgPropietario $cfgPropietario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cfgpropietario_delete', array('id' => $cfgPropietario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* ===================================================== */

    /**
     * Actualiza la imagen de cabecera del pdf.
     *
     * @Route("/upload/header", name="cfgpropietario_upload_header")
     * @Method({"GET", "POST"})
     */
    public function uploadHeaderAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $file = $request->files->get('file');
                   
            if ($file) {
                $extension = $file->guessExtension();
                if ($extension == '.png') {
                    $filename = "header.".$extension;
                    $dir=__DIR__.'/../../../../web/img';

                    $file->move($dir,$filename);

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Cabecera de pagina cargada con exito.'
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Solo se admite formato .png"
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún archivo seleccionado"
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
     * Actualiza la imagen de cabecera del pdf.
     *
     * @Route("/upload/footer", name="cfgpropietario_upload_footer")
     * @Method({"GET", "POST"})
     */
    public function uploadFooterAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $file = $request->files->get('file');
                   
            if ($file) {
                $extension = $file->guessExtension();
                if ($extension == '.png') {
                    $filename = "footer.".$extension;
                    $dir=__DIR__.'/../../../../web/img';

                    $file->move($dir,$filename);

                    $response = array(
                        'status' => 'success',
                        'code' => 200,
                        'message' => 'Pie de pagina cargada con exito.'
                    );
                }else{
                    $response = array(
                        'status' => 'error',
                        'code' => 400,
                        'message' => "Solo se admite formato .png"
                    );
                }
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Ningún archivo seleccionado"
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
