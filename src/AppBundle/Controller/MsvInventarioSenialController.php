<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvInventarioSenial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route; use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

/**
 * MsvInventarioSenial controller.
 *
 * @Route("msvinventariosenial")
 */
class MsvInventarioSenialController extends Controller
{
    /**
     * Lists all msvInventarioSenial entities.
     *
     * @Route("/", name="msvInventarioSenial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $msvInventarioSenial = $em->getRepository('AppBundle:MsvInventarioSenial')->findAll();

        $response['data'] = array();

        if ($msvInventarioSenial) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => 'listado senales',
                'data' => $msvInventarioSenial,
            );
        }
        return $helpers->json($response);

        /*$em = $this->getDoctrine()->getManager();

        $msvInventarioSenial = $em->getRepository('AppBundle:MsvInventarioSenial')->findAll();

        return $this->render('msvInventarioSenial/index.html.twig', array(
            'msvInventarioSenials' => $msvInventarioSenials,
        ));*/

    }

    /**
     * Creates a new msvInventarioSenial entity.
     *
     * @Route("/new", name="msvInventarioSenial_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {

        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        //if ($authCheck== true) {
        $json = $request->get("data",null);
        $params = json_decode($json);

        //if (count($params)==0) {
        //$response = array(
        //'status' => 'error',
        //'code' => 400,
        //'message' => "los campos no pueden estar vacios",
        //);
        //}else{
        /*$msvInventarioSenial = new MsvInventarioSenial();

        $em = $this->getDoctrine()->getManager();

        //if ($params->inventarioSenialId) {
            ///$build = explode(",", $params->inventarioSenialId);

            $file = $request->files->get('file');

            if ($file) {
                $extension = $file->guessExtension();
                $fileName = md5(rand().time()).".".$extension;
                $dir=__DIR__.'/../../../web/logos';

                $file->move($dir,$fileName);
            }

            //for ($i = 0; $i < count($build); $i++) {

                if ($params->fecha) {
                    $msvInventarioSenial->setFecha($params->fecha);
                }
                if ($params->unidad) {
                    $msvInventarioSenial->setUnidad($params->unidad);
                }
                if ($params->color) {
                    $msvInventarioSenial->setColor($params->color);
                }
                if ($params->latitud) {
                    $msvInventarioSenial->setLatitud($params->latitud);
                }
                if ($params->longitud) {
                    $msvInventarioSenial->setLongitud($params->longitud);
                }
                if ($params->direccion) {
                    $msvInventarioSenial->setDireccion($params->direccion);
                }
                if ($params->codigo) {
                    $msvInventarioSenial->setCodigo($params->codigo);
                }
                if ($params->nombre) {
                    $msvInventarioSenial->setNombre($params->nombre);
                }
                if ($params->valor) {
                    $msvInventarioSenial->setValor($params->valor);
                }
                if ($params->estado) {
                    $msvInventarioSenial->setEstado($params->estado);
                }
                if ($params->cantidad) {
                    $msvInventarioSenial->setCantidad($params->cantidad);
                }

                //if ($build[$i]) {
                  //  $inventarioSenialId = $em->getRepository('AppBundle:MsvInventarioSenial')->find(
                    //    $build[$i]
                    //);
                    //$msvInventarioSenial->setInventarioSenialId($inventarioSenialId);
                //}

                $msvInventarioSenial->setArchivo($fileName);

                $em->persist($msvInventarioSenial);
                $em->flush();
                $em->clear();

            //}
        //}

        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => "Registro creado con exito",
            'data' => $msvInventarioSenial
        );*/
        //}
        /*}else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }*/

        //return $helpers->json($response);
        print_r($params);
return new Response("");
    }

    /**
     * Finds and displays a msvInventarioSenial entity.
     *
     */
    public function showAction(MsvInventarioSenial $msvInventarioSenial)
    {
        $deleteForm = $this->createDeleteForm($msvInventarioSenial);

        return $this->render('msvInventarioSenial/show.html.twig', array(
            'msvInventarioSenial' => $msvInventarioSenial,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvInventarioSenial entity.
     *
     */
    public function editAction(Request $request, MsvInventarioSenial $msvInventarioSenial)
    {
        $deleteForm = $this->createDeleteForm($msvInventarioSenial);
        $editForm = $this->createForm('AppBundle\Form\MsvInventarioSenialType', $msvInventarioSenial);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvInventarioSenial_edit', array('id' => $msvInventarioSenial->getId()));
        }

        return $this->render('msvInventarioSenial/edit.html.twig', array(
            'msvInventarioSenial' => $msvInventarioSenial,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvInventarioSenial entity.
     *
     */
    public function deleteAction(Request $request, MsvInventarioSenial $msvInventarioSenial)
    {
        $form = $this->createDeleteForm($msvInventarioSenial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvInventarioSenial);
            $em->flush();
        }

        return $this->redirectToRoute('msvInventarioSenial_index');
    }

    /**
     * Creates a form to delete a msvInventarioSenial entity.
     *
     * @param MsvInventarioSenial $msvInventarioSenial The msvInventarioSenial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvInventarioSenial $msvInventarioSenial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvInventarioSenial_delete', array('id' => $msvInventarioSenial->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/parametros", name="msvInventarioSenial_search_parametros")
     * @Method({"GET", "POST"})
     */
    public function searchByParametrosAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        $senales['data'] = array();

        //if ($authCheck == true) {
            $json = $request->get("json",null);
            $params = json_decode($json);

            $senales = $em->getRepository('AppBundle:MsvInventarioSenial')->getSearch($params);

            if ($senales == null) {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Registro no encontrado",
                );
            }else{
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Registro encontrado",
                    'data'=> $senales,
                );
            }
        /*}else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida",
            );
        }*/
        return $helpers->json($response);
    }

    /**
     * Lists all msvInventarioenial entities.
     *
     * @Route("/full", name="msvInventarioSenial_search_full")
     * @Method("GET")
     */
    public function searchByFullAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $msvInventarioSenial = $em->getRepository('AppBundle:MsvInventarioSenial')->getFull();

        $response['data'] = array();

        if ($msvInventarioSenial) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => 'listado senales',
                'data' => $msvInventarioSenial,
            );
        }

        return $helpers->json($response);

    }

    /**
     * Lists all msvSenial entities.
     *
     * @Route("/export", name="msvInventarioSenial_export")
     * @Method("GET")
     */
    public function exportAction()
    {

        // ask the service for a Excel5
        $phpExcelObject = $this->get('phpexcel')->createPHPExcelObject();

        $phpExcelObject->getProperties()->setCreator("liuggio")
            ->setLastModifiedBy("Giulio De Donato")
            ->setTitle("Office 2005 XLSX Test Document")
            ->setSubject("Office 2005 XLSX Test Document")
            ->setDescription("Test document for Office 2005 XLSX, generated using PHP classes.")
            ->setKeywords("office 2005 openxml php")
            ->setCategory("Test result file");

        $em = $this->getDoctrine()->getManager();

        $msvSenial = $em->getRepository('AppBundle:MsvInventarioSenial')->getFull();

        $row = 1;
        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('A'.$row, "ID")
            ->setCellValue('B'.$row, "FECHA")
            ->setCellValue('C'.$row, "UNIDAD")
            ->setCellValue('D'.$row, "COLOR")
            ->setCellValue('E'.$row, "LATITUD")
            ->setCellValue('F'.$row, "LONGITUD")
            ->setCellValue('G'.$row, "CODIGO")
            ->setCellValue('H'.$row, "LOGO")
            ->setCellValue('I'.$row, "NOMBRE")
            ->setCellValue('J'.$row, "VALOR")
            ->setCellValue('K'.$row, "ESTADO")
            ->setCellValue('L'.$row, "CANTIDAD");

        $row = 2;
        foreach ($msvSenial as $item) {

            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A'.$row, $item->getId())
                ->setCellValue('B'.$row, $item->getFecha())
                ->setCellValue('C'.$row, $item->getUnidad())
                ->setCellValue('D'.$row, $item->getColor())
                ->setCellValue('E'.$row, $item->getLatitud())
                ->setCellValue('F'.$row, $item->getLongitud())
                ->setCellValue('G'.$row, $item->getCodigo())
                ->setCellValue('H'.$row, $item->getLogo())
                ->setCellValue('I'.$row, $item->getNombre())
                ->setCellValue('J'.$row, $item->getValor())
                ->setCellValue('K'.$row, $item->getEstado())
                ->setCellValue('L'.$row, $item->getCantidad());

            $row ++;
        }

        $phpExcelObject->getActiveSheet()->setTitle('Simple');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $phpExcelObject->setActiveSheetIndex(0);

        // create the writer
        $writer = $this->get('phpexcel')->createWriter($phpExcelObject, 'Excel5');
        // create the response
        $response = $this->get('phpexcel')->createStreamedResponse($writer);
        // adding headers
        $dispositionHeader = $response->headers->makeDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            'mrfsvhu08-file.xls'
        );
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        $response->headers->set('Content-Disposition', $dispositionHeader);

        return $response;

    }
}
