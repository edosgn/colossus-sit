<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MsvSenial;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * MsvSenial controller.
 *
 * @Route("msvsenial")
 */
class MsvSenialController extends Controller
{
    /**
     * Lists all msvSenial entities.
     *
     * @Route("/", name="msvSenial_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $msvSenials = $em->getRepository('AppBundle:MsvSenial')->findAll();

        return $this->render('msvSenial/index.html.twig', array(
            'msvSenials' => $msvSenials,
        ));
    }

    /**
     * Creates a new msvSenial entity.
     *
     * Route("/new", name="msvSenial_new")
     * Method({"GET", "POST"})
     */
    /*public function newAction(Request $request)
    {
        $msvSenial = new MsvSenial();
        $form = $this->createForm('AppBundle\Form\MsvSenialType', $msvSenial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($msvSenial);
            $em->flush();

            return $this->redirectToRoute('msvSenial_show', array('id' => $msvSenial->getId()));
        }

        return $this->render('msvSenial/new.html.twig', array(
            'msvSenial' => $msvSenial,
            'form' => $form->createView(),
        ));
    }*/

    /**
     * Creates a new msvSenial entity.
     *
     * @Route("/new", name="msvSenial_new")
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
            $msvSenial = new MsvSenial();

            $em = $this->getDoctrine()->getManager();

            if ($params->inventarioSenialId) {
                $build = explode(",", $params->inventarioSenialId);

                $file = $request->files->get('file');

                if ($file) {
                    $extension = $file->guessExtension();
                    $fileName = md5(rand().time()).".".$extension;
                    $dir=__DIR__.'/../../../web/docs';

                    $file->move($dir,$fileName);
                }

                for ($i = 0; $i < count($build); $i++) {

                    if ($params->tipoDestinoId) {
                        $tipoDestino = $em->getRepository('AppBundle:CfgTipoDestino')->find(
                            $params->tipoDestinoId
                        );
                        $msvSenial->setTipoDestino($tipoDestino);
                    }

                    if ($params->tipoSenalId) {
                        $tipoSenal = $em->getRepository('AppBundle:CfgTipoSenial')->find(
                            $params->tipoSenalId
                        );
                        $msvSenial->setTipoSenal($tipoSenal);
                    }

                    if ($params->destinoId) {
                        $msvSenial->setXDestino($params->destinoId);
                    }

                    if ($build[$i]) {
                    $inventarioSenialId = $em->getRepository('AppBundle:MsvInventarioSenial')->find(
                        $build[$i]
                    );
                    $msvSenial->setInventarioSenialId($inventarioSenialId);
                    }

                    $msvSenial->setArchivo($fileName);

                    $em->persist($msvSenial);
                    $em->flush();
                    $em->clear();

                }
            }

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Registro creado con exito",
                'data' => $msvSenial
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
     * Finds and displays a msvSenial entity.
     *
     * Route("/{id}", name="msvSenial_show")
     * Method("GET")
     */
    public function showAction(MsvSenial $msvSenial)
    {
        $deleteForm = $this->createDeleteForm($msvSenial);

        return $this->render('msvSenial/show.html.twig', array(
            'msvSenial' => $msvSenial,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing msvSenial entity.
     *
     * @Route("/{id}/edit", name="msvSenial_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, MsvSenial $msvSenial)
    {
        $deleteForm = $this->createDeleteForm($msvSenial);
        $editForm = $this->createForm('AppBundle\Form\MsvSenialType', $msvSenial);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('msvSenial_edit', array('id' => $msvSenial->getId()));
        }

        return $this->render('msvSenial/edit.html.twig', array(
            'msvSenial' => $msvSenial,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a msvSenial entity.
     *
     * @Route("/{id}", name="msvSenial_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, MsvSenial $msvSenial)
    {
        $form = $this->createDeleteForm($msvSenial);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($msvSenial);
            $em->flush();
        }

        return $this->redirectToRoute('msvSenial_index');
    }

    /**
     * Creates a form to delete a msvSenial entity.
     *
     * @param MsvSenial $msvSenial The msvSenial entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MsvSenial $msvSenial)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('msvSenial_delete', array('id' => $msvSenial->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all mpersonalFuncionario entities.
     *
     * @Route("/search/parametros", name="msvSenial_search_parametros")
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

        $senales = $em->getRepository('AppBundle:MsvSenial')->getSearch($params);

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
     * Lists all msvSenial entities.
     *
     * @Route("/full", name="msvSenial_search_full")
     * @Method("GET")
     */
    public function searchByFullAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $msvSenial = $em->getRepository('AppBundle:MsvSenial')->getFull();

        $response['data'] = array();

        if ($msvSenial) {
            $response = array(
                'status' => 'success',
                'code' => 200,
                'msj' => 'listado senales',
                'data' => $msvSenial,
            );
        }

        return $helpers->json($response);

    }

    /**
     * Lists all msvSenial entities.
     *
     * @Route("/export", name="msvSenial_export")
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

        $msvSenial = $em->getRepository('AppBundle:MsvSenial')->getFull();

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
