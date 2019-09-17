<?php

namespace JHWEB\ContravencionalBundle\Controller;

use JHWEB\ContravencionalBundle\Entity\CvCdoCurso;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cvcdocurso controller.
 *
 * @Route("cvcdocurso")
 */
class CvCdoCursoController extends Controller
{
    /**
     * Lists all cvCdoCurso entities.
     *
     * @Route("/", name="cvcdocurso_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cvCdoCursos = $em->getRepository('JHWEBContravencionalBundle:CvCdoCurso')->findAll();

        return $this->render('cvcdocurso/index.html.twig', array(
            'cvCdoCursos' => $cvCdoCursos,
        ));
    }

    /**
     * Creates a new cvCdoCurso entity.
     *
     * @Route("/new", name="cvcdocurso_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $cvCdoCurso = new Cvcdocurso();
        $form = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCdoCursoType', $cvCdoCurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cvCdoCurso);
            $em->flush();

            return $this->redirectToRoute('cvcdocurso_show', array('id' => $cvCdoCurso->getId()));
        }

        return $this->render('cvcdocurso/new.html.twig', array(
            'cvCdoCurso' => $cvCdoCurso,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a cvCdoCurso entity.
     *
     * @Route("/{id}", name="cvcdocurso_show")
     * @Method("GET")
     */
    public function showAction(CvCdoCurso $cvCdoCurso)
    {
        $deleteForm = $this->createDeleteForm($cvCdoCurso);

        return $this->render('cvcdocurso/show.html.twig', array(
            'cvCdoCurso' => $cvCdoCurso,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cvCdoCurso entity.
     *
     * @Route("/{id}/edit", name="cvcdocurso_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, CvCdoCurso $cvCdoCurso)
    {
        $deleteForm = $this->createDeleteForm($cvCdoCurso);
        $editForm = $this->createForm('JHWEB\ContravencionalBundle\Form\CvCdoCursoType', $cvCdoCurso);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cvcdocurso_edit', array('id' => $cvCdoCurso->getId()));
        }

        return $this->render('cvcdocurso/edit.html.twig', array(
            'cvCdoCurso' => $cvCdoCurso,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a cvCdoCurso entity.
     *
     * @Route("/{id}", name="cvcdocurso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, CvCdoCurso $cvCdoCurso)
    {
        $form = $this->createDeleteForm($cvCdoCurso);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cvCdoCurso);
            $em->flush();
        }

        return $this->redirectToRoute('cvcdocurso_index');
    }

    /**
     * Creates a form to delete a cvCdoCurso entity.
     *
     * @param CvCdoCurso $cvCdoCurso The cvCdoCurso entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(CvCdoCurso $cvCdoCurso)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cvcdocurso_delete', array('id' => $cvCdoCurso->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /* =========================================== */

    /**
     * Creates a new vhloCfgValor entity.
     *
     * @Route("/upload", name="cvcdocurso_upload")
     * @Method({"GET", "POST"})
     */
    public function uploadAction(Request $request)
    { 
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck== true) {
            $json = $request->get("data",null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find(
                $params->idEmpresa
            );

            $file = $request->files->get('file');

            $documentoName = md5(uniqid()).$file->guessExtension();
            $file->move(
                $this->getParameter('data_upload'),
                $documentoName
            );

            $valores = fopen($this->getParameter('data_upload').$documentoName , "r" );//leo el archivo que contiene los datos de los valores

            $batchSize = 100;
            $valoresArray = null;
            $rows = 0;

            $datos = fgetcsv($valores,0,";");
            $cols = count($datos);

            if ($valores) {
                $count = 0;
                //Leo cada linea del archivo hasta un maximo de caracteres (0 sin limite)
                while (($datos = fgetcsv($valores,0,";")) !== FALSE )
                {
                    $j = 6;
                    $datos = array_map("utf8_encode", $datos);

                    $valoresArray[$count]=array(
                        'identificacion'=>$datos[13],
                        'comparendo'=>$datos[14],
                        'fecha'=>$datos[24]
                    );

                    if ((count($valoresArray) % $batchSize) == 0 && $valoresArray != null) {
                        $rowsBatch =  $this->insertBatch($empresa, $valoresArray);
                        $rows += $rowsBatch;
                        $valoresArray = null;
                    }

                    $count++;
                }

                //return $helpers->json($valoresArray);

                if ($valoresArray) {
                    $rowsBatch = $this->insertBatch($empresa, $valoresArray);
                    $rows += $rowsBatch;
                }

                $response = array(
                    'title' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => 'Se han procesado '.$count.' líneas.', 
                );
            }else{
                $response = array(
                    'title' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "No se pudo leer el archivo.", 
                );
            }
        }else{
            $response = array(
                'title' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        } 

        return $helpers->json($response);
    }

    public function insertBatch($empresa, $valoresArray){
        $em = $this->getDoctrine()->getManager();

        $rows = 0;

        foreach ($valoresArray as $key => $row) {       
            $curso = new CvCdoCurso();
            
            $curso->setEmpresa($empresa);
            $curso->setFecha(new \Datetime($params->fecha));
            $curso->setIdentificacion($params->identificacion);
            $curso->setComparendo($params->comparendo);
            $curso->setActivo(true);
            
            $em->persist($curso);
            

            $em->flush();

            $rows++;
        }

        $em->flush();
        $em->clear();

        return $rows;
    }
}
