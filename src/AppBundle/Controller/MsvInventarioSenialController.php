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
        $msvInventarioSenial = new MsvInventarioSenial();

        $em = $this->getDoctrine()->getManager();


            $file = $request->files->get('file');

            $fileName = null;
            if ($file) {
                $extension = $file->guessExtension();
                $fileName = md5(rand().time()).".".$extension;
                $dir=__DIR__.'/../../../web/logos';

                $file->move($dir,$fileName);
            }

                    $inventario = $em->getRepository('AppBundle:CfgInventario')->find(
                        @$params->inventario
                    );
                    $msvInventarioSenial->setInventario($inventario);

                    $msvInventarioSenial->setFecha(new \DateTime(@$params->fecha));
                    $msvInventarioSenial->setUnidad(@$params->unidad);

                    $tipoColor = $em->getRepository('AppBundle:CfgTipoColor')->find(
                        @$params->tipoColorId
                    );
                    $msvInventarioSenial->setTipoColor($tipoColor);

                    $msvInventarioSenial->setLatitud(@$params->latitud);
                    $msvInventarioSenial->setLongitud(@$params->longitud);
                    $msvInventarioSenial->setDireccion(@$params->direccion);
                    $msvInventarioSenial->setCodigo(@$params->codigo);
                    $msvInventarioSenial->setNombre(@$params->nombre);
                    $msvInventarioSenial->setValor(@$params->valor);

                    $tipoEstado = $em->getRepository('AppBundle:CfgTipoEstado')->find(
                        @$params->tipoEstadoId
                    );
                    $msvInventarioSenial->setTipoEstado($tipoEstado);

                    $msvInventarioSenial->setCantidad(@$params->cantidad);

                    if($fileName != '') {
                        $msvInventarioSenial->setLogo($fileName);
                    }

                $em->persist($msvInventarioSenial);
                $em->flush();

        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => "Registro creado con exito",
            'data' => $msvInventarioSenial
        );
        //}
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
    /*public function editAction(Request $request, MsvInventarioSenial $msvInventarioSenial)
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
    }*/


    /**
     * Displays a form to edit an existing sedeOperativa entity.
     *
     * @Route("/edit", name="msvInventarioSenial_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction( Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        //if ($authCheck==true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();

            $msvInventarioSenial = $em->getRepository('AppBundle:MsvInventarioSenial')->find(@$params->id);

            if ($msvInventarioSenial!=null) {

                $file = $request->files->get('file');

                $fileName = '';
                if ($file) {
                    $extension = $file->guessExtension();
                    $fileName = md5(rand().time()).".".$extension;
                    $dir=__DIR__.'/../../../web/logos';

                    $file->move($dir,$fileName);
                }

                $msvInventarioSenial->setId(@$params->id);

                $inventario = $em->getRepository('AppBundle:CfgInventario')->find(
                    @$params->inventario
                );
                $msvInventarioSenial->setInventario($inventario);

                $msvInventarioSenial->setFecha(new \DateTime(@$params->fecha));
                $msvInventarioSenial->setUnidad(@$params->unidad);

                $tipoColor = $em->getRepository('AppBundle:CfgTipoColor')->find(
                    @$params->tipoColorId
                );
                $msvInventarioSenial->setTipoColor($tipoColor);

                $msvInventarioSenial->setLatitud(@$params->latitud);
                $msvInventarioSenial->setLongitud(@$params->longitud);
                $msvInventarioSenial->setDireccion(@$params->direccion);
                $msvInventarioSenial->setCodigo(@$params->codigo);

                if($fileName != '') {
                    $msvInventarioSenial->setLogo($fileName);
                }

                $msvInventarioSenial->setNombre(@$params->nombre);
                $msvInventarioSenial->setValor(@$params->valor);

                $tipoEstado = $em->getRepository('AppBundle:CfgTipoEstado')->find(
                    @$params->tipoEstadoId
                );
                $msvInventarioSenial->setTipoEstado($tipoEstado);

                $msvInventarioSenial->setCantidad(@$params->cantidad);
                $em = $this->getDoctrine()->getManager();
                $em->persist($msvInventarioSenial);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Registro actualizado con exito",
                    'data'=> $msvInventarioSenial,
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "El registro no se encuentra en la base de datos",
                );
            }
        /*}else{
            $response = array(
                'status' => 'error',
                'code' => 400,
                'msj' => "Autorizacion no valida para editar banco",
            );
        }*/

        return $helpers->json($response);
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
     * @Route("/bysenial", name="msvInventarioSenial_search_by_senial")
     * @Method({"GET", "POST"})
     */
    public function searchBySenialAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        $json = $request->get("data",null);
        $params = json_decode($json);

        $em = $this->getDoctrine()->getManager();

        $msvInventarioSenial = $em->getRepository('AppBundle:MsvInventarioSenial')->getBySenial($params);

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
            ->setCellValue('B'.$row, "# INVENTARIO")
            ->setCellValue('C'.$row, "FECHA DE INVENTARIO")
            ->setCellValue('D'.$row, "FECHA DE INGRESO")
            ->setCellValue('E'.$row, "UNIDAD")
            ->setCellValue('F'.$row, "COLOR")
            ->setCellValue('G'.$row, "LATITUD")
            ->setCellValue('H'.$row, "LONGITUD")
            ->setCellValue('I'.$row, "CODIGO")
            ->setCellValue('J'.$row, "LOGO")
            ->setCellValue('K'.$row, "NOMBRE")
            ->setCellValue('L'.$row, "VALOR")
            ->setCellValue('M'.$row, "ESTADO")
            ->setCellValue('N'.$row, "CANTIDAD");

        $row = 2;
        foreach ($msvSenial as $item) {

            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A'.$row, $item->getId())
                ->setCellValue('B'.$row, $item->getInventario()->getNumero())
                ->setCellValue('C'.$row, $item->getInventario()->getFecha())
                ->setCellValue('D'.$row, $item->getFecha())
                ->setCellValue('E'.$row, $item->getUnidad())
                ->setCellValue('F'.$row, $item->getTipoColor()->getNombre())
                ->setCellValue('G'.$row, $item->getLatitud())
                ->setCellValue('H'.$row, $item->getLongitud())
                ->setCellValue('I'.$row, $item->getCodigo())
                ->setCellValue('J'.$row, '')
                ->setCellValue('K'.$row, $item->getNombre())
                ->setCellValue('L'.$row, $item->getValor())
                ->setCellValue('M'.$row, $item->getTipoEstado()->getNombre())
                ->setCellValue('N'.$row, $item->getCantidad());

            $objDrawing = new \PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('PHPExcel image');
            $objDrawing->setDescription('PHPExcel image');
            $objDrawing->setPath(__DIR__.'/../../../web/logos/'.$item->getLogo());
            $objDrawing->setHeight(25);
            $objDrawing->setCoordinates('J'.$row);
            $objDrawing->setOffsetX(100);
            $objDrawing->setWorksheet($phpExcelObject->getActiveSheet());

            $phpExcelObject->getActiveSheet()
                ->getStyle('F'.$row)
                ->getFill()
                ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB(substr($item->getTipoColor()->getHex(), 1));

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


    /**
     * Lists all msvInventarioSenial entities.
     *
     * @Route("/exportinv/{data}", name="msvInventarioSenial_exportInv")
     * @Method("GET")
     */
    public function exportInvAction($data)
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

        $msvSenial = $em->getRepository('AppBundle:MsvInventarioSenial')->getByInv($data);

        $row = 1;
        $phpExcelObject->setActiveSheetIndex(0)
            ->setCellValue('A'.$row, "ID")
            ->setCellValue('B'.$row, "# INVENTARIO")
            ->setCellValue('C'.$row, "FECHA DE INVENTARIO")
            ->setCellValue('D'.$row, "FECHA DE INGRESO")
            ->setCellValue('E'.$row, "UNIDAD")
            ->setCellValue('F'.$row, "COLOR")
            ->setCellValue('G'.$row, "LATITUD")
            ->setCellValue('H'.$row, "LONGITUD")
            ->setCellValue('I'.$row, "CODIGO")
            ->setCellValue('J'.$row, "LOGO")
            ->setCellValue('K'.$row, "NOMBRE")
            ->setCellValue('L'.$row, "VALOR")
            ->setCellValue('M'.$row, "ESTADO")
            ->setCellValue('N'.$row, "CANTIDAD");

        $row = 2;
        foreach ($msvSenial as $item) {

            $phpExcelObject->setActiveSheetIndex(0)
                ->setCellValue('A'.$row, $item->getId())
                ->setCellValue('B'.$row, $item->getInventario()->getNumero())
                ->setCellValue('C'.$row, $item->getInventario()->getFecha())
                ->setCellValue('D'.$row, $item->getFecha())
                ->setCellValue('E'.$row, $item->getUnidad())
                ->setCellValue('F'.$row, $item->getTipoColor()->getNombre())
                ->setCellValue('G'.$row, $item->getLatitud())
                ->setCellValue('H'.$row, $item->getLongitud())
                ->setCellValue('I'.$row, $item->getCodigo())
                ->setCellValue('J'.$row, '')
                ->setCellValue('K'.$row, $item->getNombre())
                ->setCellValue('L'.$row, $item->getValor())
                ->setCellValue('M'.$row, $item->getTipoEstado()->getNombre())
                ->setCellValue('N'.$row, $item->getCantidad());

            $objDrawing = new \PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('PHPExcel image');
            $objDrawing->setDescription('PHPExcel image');
            $objDrawing->setPath(__DIR__.'/../../../web/logos/'.$item->getLogo());
            $objDrawing->setHeight(25);
            $objDrawing->setCoordinates('J'.$row);
            $objDrawing->setOffsetX(100);
            $objDrawing->setWorksheet($phpExcelObject->getActiveSheet());

            $phpExcelObject->getActiveSheet()
                ->getStyle('F'.$row)
                ->getFill()
                ->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)
                ->getStartColor()
                ->setRGB(substr($item->getTipoColor()->getHex(), 1));

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
