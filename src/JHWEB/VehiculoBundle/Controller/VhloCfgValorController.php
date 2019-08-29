<?php

namespace JHWEB\VehiculoBundle\Controller;

use JHWEB\VehiculoBundle\Entity\VhloCfgValor;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Vhlocfgvalor controller.
 *
 * @Route("vhlocfgvalor")
 */
class VhloCfgValorController extends Controller
{
    /**
     * Lists all vhloCfgValor entities.
     *
     * @Route("/", name="vhlocfgvalor_index")
     * @Method("GET")
     */
    public function indexAction() 
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();

        $valorVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgValor')->findBy(
            array('activo' => 1)
        );

        $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "listado tipos de proceso", 
                    'data'=> $valorVehiculo,
            );
         
        return $helpers->json($response);
    }

    /**
     * Creates a new vhloCfgValor entity.
     *
     * @Route("/new", name="vhlocfgvalor_new")
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
            
            $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->claseId);
            $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->find($params->lineaId);

            $vhloCfgValor = new VhloCfgValor();

            $vhloCfgValor->setClase($clase);
            $vhloCfgValor->setLinea($linea);
            $vhloCfgValor->setCilindraje($params->cilindraje);
            $vhloCfgValor->setValor($params->valor);
            $vhloCfgValor->setAnio($params->anio);
            $vhloCfgValor->setActivo(true);

            $em->persist($vhloCfgValor);
            $em->flush();
            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "Tipo Producto creado con exito", 
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
     * Finds and displays a vhloCfgValor entity.
     *
     * @Route("/show/{id}", name="vhlocfgvalor_show")
     * @Method("GET")
     */
    public function showAction(VhloCfgValor $vhloCfgValor)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $em = $this->getDoctrine()->getManager();
            $cfgValorVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgValor')->find($id);
            $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "cfgValorVehiculo encontrado", 
                    'data'=> $cfgValorVehiculo,
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
     * Displays a form to edit an existing vhloCfgValor entity.
     *
     * @Route("/edit", name="vhlocfgvalor_edit")
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
            $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->find($params->claseId);
            $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->find($params->lineaId);
            $cfgValorVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgValor')->find($params->id);
            
            if ($cfgValorVehiculo!=null) {
                $cfgValorVehiculo->setClase($clase);
                $cfgValorVehiculo->setLinea($linea);
                $cfgValorVehiculo->setCilindraje($params->cilindraje);
                $cfgValorVehiculo->setValor($params->valor);
                $cfgValorVehiculo->setAnio($params->anio);
               
                $em->persist($cfgValorVehiculo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Limitación editada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "La limitación no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'message' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a vhloCfgValor entity. 
     *
     * @Route("/{id}/delete", name="vhlocfgvalor_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, VhloCfgValor $vhloCfgValor)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck==true) {
            $em = $this->getDoctrine()->getManager();            
            $valorVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgValor')->find($id);

            $valorVehiculo->setEstado(0);
            $em = $this->getDoctrine()->getManager();
                $em->persist($valorVehiculo);
                $em->flush();
            $response = array(
                    'status' => 'success',
                        'code' => 200,
                        'message' => "Tipo proceso eliminada con exito", 
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
     * Creates a form to delete a vhloCfgValor entity.
     *
     * @param VhloCfgValor $vhloCfgValor The vhloCfgValor entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(VhloCfgValor $vhloCfgValor)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('vhlocfgvalor_delete', array('id' => $vhloCfgValor->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    } 


    /**
     * Creates a new vhloCfgValor entity.
     *
     * @Route("/upload", name="vhlocfgvalor_upload")
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
            $cols = $cols - 6;
            $j = 6;

            for ($i=0; $i < $cols; $i++) {
                $anios[] = $datos[$j];

                $j++;
            }

            if ($valores) {
                $count = 0;
                //Leo cada linea del archivo hasta un maximo de caracteres (0 sin limite)
                while (($datos = fgetcsv($valores,0,";")) !== FALSE )
                {
                    $j = 6;
                    $datos = array_map("utf8_encode", $datos);

                    $valoresArray[$count]=array(
                        'nameClase'=>$datos[0],
                        'nameMarca'=>$datos[1],
                        'nameLinea'=>$datos[2],
                        'cilindraje'=>$datos[3],
                        'tonelaje'=>$datos[4],
                        'pesaje'=>$datos[5],
                        'valores' => []
                    );

                    for ($i=0; $i < $cols; $i++) {
                        array_push($valoresArray[$count]['valores'], array($anios[$i] => $datos[$j]));
        
                        $j++;
                    }

                    if ((count($valoresArray) % $batchSize) == 0 && $valoresArray != null) {
                        $rowsBatch =  $this->insertBatch($anios, $valoresArray);
                        $rows += $rowsBatch;
                        $valoresArray = null;
                    }

                    $count++;
                }

                //return $helpers->json($valoresArray);

                if ($valoresArray) {
                    $rowsBatch = $this->insertBatch($anios, $valoresArray);
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

    public function insertBatch($anios, $valoresArray){
        $em = $this->getDoctrine()->getManager();

        $rows = 0;

        foreach ($valoresArray as $key => $row) {
            $clase = $em->getRepository('JHWEBVehiculoBundle:VhloCfgClase')->findOneByNombre($row["nameClase"]);
            $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->findOneByNombre($row["nameLinea"]);
        
            if ($linea) {
                foreach ($anios as $key => $anio) {
                    $valor = new VhloCfgValor();
                    
                    $valor->setClase($clase);
                    $valor->setMarca($linea->getMarca());
                    $valor->setLinea($linea);
                    $valor->setCilindraje($row["cilindraje"]);
                    $valor->setTonelaje($row["tonelaje"]);
                    $valor->setPesaje($row["pesaje"]);
                    $valor->setValor($row['valores'][$key][$anio]);
                    $valor->setAnio($anio);
                    $valor->setActivo(true);
                    
                    $em->persist($valor);
                }

                $em->flush();

                $rows++;
            }
        }

        $em->flush();
        $em->clear();

        return $rows;
    }

    /**
     * datos para select1 
     *
     * @Route("/show/vehiculo", name="vhlocfgvalor_vehiculo")
     * @Method({"GET", "POST"})
     */
    public function showVehiculoAction(Request $request)
    {
    $helpers = $this->get("app.helpers");
    $hash = $request->get("authorization", null);
    $authCheck = $helpers->authCheck($hash);
    if ($authCheck== true) {
        $json = $request->get("data",null);
        $params = json_decode($json);
        
        $em = $this->getDoctrine()->getManager();

        $linea = $em->getRepository('JHWEBVehiculoBundle:VhloCfgLinea')->find($params->linea);

        if ($linea) {
            $valorVehiculo = $em->getRepository('JHWEBVehiculoBundle:VhloCfgValor')->findOneBy(
                array(
                    'linea' => $params->linea,
                    'cilindraje' => $params->cilindraje,
                    'marca' => $linea->getMarca()->getId(),
                    'clase' => $params->clase,
                    'anio' => $params->modelo,
                )
            );
    
            if ($valorVehiculo) {
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Valor encontrado.", 
                    'data' => $valorVehiculo, 
                );
            }else {
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'messager' => "Valor no encontrado para el vehiculo.", 
                );
            } 
        }

    }else{
        $response = array(
            'status' => 'error',
            'code' => 400,
            'messager' => "Autorizacion no valida", 
        );
    }
    return $helpers->json($response);
    }
}
