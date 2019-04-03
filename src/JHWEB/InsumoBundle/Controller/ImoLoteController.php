<?php

namespace JHWEB\InsumoBundle\Controller;

use JHWEB\InsumoBundle\Entity\ImoLote;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Imolote controller.
 *
 * @Route("imolote")
 */
class ImoLoteController extends Controller
{
    /**
     * Lists all imoLote entities.
     *
     * @Route("/", name="imolote_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");
        $em = $this->getDoctrine()->getManager();
        

        $loteInsumos = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findBy(
            array('tipo'=>'Insumo')
        );
        $loteSustratos = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findBy(
            array('tipo'=>'Sustrato')
        );

        $totalesTtpo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->getTotalesTipo();
        // var_dump($totalesTtpo);
        // die();

        $data = array(
            'loteInsumos' =>  $loteInsumos, 
            'loteSustratos' =>  $loteSustratos, 
            'totalesTipo' =>  $totalesTtpo, 
        );
        
        $response = array(
            'status' => 'success',
            'code' => 200,
            'message' => count($loteInsumos)+count($loteSustratos)." registros encontrados", 
            'data'=> $data,
        );
        

        return $helpers->json($response);
    }

    /**
     * Creates a new imoLote entity.
     *
     * @Route("/new", name="imolote_new")
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
            
            $fecha = $params->fecha;
            $fecha = new \DateTime($params->fecha);
            $em = $this->getDoctrine()->getManager();
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->idEmpresa);
            $idOrganismoTransito = (isset($params->idOrganismoTransito)) ? $params->idOrganismoTransito : null;
            // var_dump($params->idOrganismoTransito);
            // die();

            $loteInsumo = new ImoLote();
            if ($idOrganismoTransito) {
                $sedeOperativa = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($idOrganismoTransito);
                $loteInsumo->setSedeOperativa($sedeOperativa);
                $loteInsumo->setTipo('Sustrato');
                $ultimoRango = $em->getRepository('JHWEBInsumoBundle:ImoLote')->getMax(); 
                if ($params->rangoInicio < $ultimoRango['maximo']+1) {
                    $response = array(
                        'status' => 'error',
                        'code' => 200,
                        'msj' => "El rango ya se encuentra registrado", 
                    );
                    return $helpers->json($response);
                }
            }else {
                $loteInsumo->setTipo('Insumo');
            }
            $casoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($params->imoCfgTipo);
            // var_dump($params->numeroActa);
            $loteInsumo->setNumeroActa($params->numeroActa);
            $loteInsumo->setEmpresa($empresa);
            $loteInsumo->setTipoInsumo($casoInsumo); 
            $loteInsumo->setEstado('REGISTRADO');
            $loteInsumo->setRangoInicio($params->rangoInicio);
            $loteInsumo->setRangoFin($params->rangoFin);
            $loteInsumo->setCantidad($params->cantidad);
            $loteInsumo->setReferencia($params->referencia);
            $loteInsumo->setFecha($fecha);
            $em->persist($loteInsumo);
            $em->flush();

            $response = array(
                'status' => 'success',
                'code' => 200,
                'message' => "lote Insumo creado con exito", 
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
     * Finds and displays a imoLote entity.
     *
     * @Route("/{id}", name="imolote_show")
     * @Method("GET")
     */
    public function showAction(ImoLote $imoLote)
    {
        $deleteForm = $this->createDeleteForm($imoLote);

        return $this->render('imolote/show.html.twig', array(
            'imoLote' => $imoLote,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Linea entity.
     *
     * @Route("/edit", name="imoLote_edit")
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
            // var_dump($params);
            // die();
            $loteInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->find($params->id);
            
            $empresa = $em->getRepository('JHWEBUsuarioBundle:UserEmpresa')->find($params->empresaId);

            $sedeOperativaId = (isset($params->sedeOperativaId)) ? $params->sedeOperativaId : null;

            if ($sedeOperativaId) {
                $sedeOperativa = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($sedeOperativaId);
                $loteInsumo->setSedeOperativa($sedeOperativa);
                
            }
            
            
            $tipoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($params->casoInsumoId);

            
            if ($loteInsumo!=null) {

                $loteInsumo->setNumeroActa($params->numeroActa);
                $loteInsumo->setEmpresa($empresa);
                $loteInsumo->setTipoInsumo($tipoInsumo); 
                $loteInsumo->setRangoInicio($params->rangoInicio);
                $loteInsumo->setRangoFin($params->rangoFin);
                $loteInsumo->setCantidad($params->cantidad);
                $loteInsumo->setReferencia($params->referencia);
                $em->persist($loteInsumo);
                $em->flush();

                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "linea editada con exito", 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "La linea no se encuentra en la base de datos", 
                );
            }
        }else{
            $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "Autorizacion no valida para editar banco", 
                );
        }

        return $helpers->json($response);
    }

    /**
     * Deletes a imoLote entity.
     *
     * @Route("/{id}", name="imolote_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, ImoLote $imoLote)
    {
        $form = $this->createDeleteForm($imoLote);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($imoLote);
            $em->flush();
        }

        return $this->redirectToRoute('imolote_index');
    }

    /**
     * Creates a form to delete a imoLote entity.
     *
     * @param ImoLote $imoLote The imoLote entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(ImoLote $imoLote)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('imolote_delete', array('id' => $imoLote->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * Lists all loteInsumo entities.
     *
     * @Route("/insumo/lote/sede", name="limolote_Sede_index")
     * @Method({"GET", "POST"})
     */
    public function loteInsumoSedeAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);
        if ($authCheck== true) { 
            $json = $request->get("data",null);
            $params = json_decode($json);
            $em = $this->getDoctrine()->getManager();
            $idOrganismoTransito = (isset($params->idOrganismoTransito)) ? $params->idOrganismoTransito : null;
            
            // var_dump($idOrganismoTransito);
            // die();

            if ($idOrganismoTransito) {
                $loteInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findBy(
                    array('estado' => 'REGISTRADO','sedeOperativa'=> $idOrganismoTransito,'tipoInsumo'=>$params->tipoInsumo)
                );
            }else{
                $loteInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findOneBy(
                    array('estado' => 'REGISTRADO','tipoInsumo'=>$params->tipoInsumo)
                );
            }
            if ($loteInsumo!=null) { 
                $response = array(
                    'status' => 'success',
                    'code' => 200,
                    'msj' => "Lote encontrado con exito", 
                    'data' => $loteInsumo, 
                );
            }else{
                $response = array(
                    'status' => 'error',
                    'code' => 400,
                    'msj' => "no hay sustratos pa la sede", 
                );
            }
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
     * Creates a new Cuenta entity.
     *
     * @Route("/pdf/acta/asignacion/{numeroActa}", name="pdf_loteInsumo")
     * @Method({"GET", "POST"})
     */
    public function pdfAction(Request $request,$numeroActa)
    {
        $em = $this->getDoctrine()->getManager();

        setlocale(LC_ALL,"es_ES");
        $fechaActual = strftime("%d de %B del %Y");

        $lotesInsumo = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findByActaEntrega($numeroActa);

        if ($lotesInsumo) {
            $organismoTransito = $lotesInsumo[0]->getSedeOperativa();
            $insumo = $em->getRepository('JHWEBInsumoBundle:ImoInsumo')->findOneByLote($lotesInsumo[0]->getId());
            $fechaEntrega = $insumo->getFecha()->format('Y-m-d');
        }

        $html = $this->renderView('@JHWEBInsumo/Default/pdf.asignacion.html.twig', array(
            'lotesInsumo' => $lotesInsumo,
            'organismoTransito' => $organismoTransito,
            'fechaEntrega' => $fechaEntrega,
        ));

        $this->get('app.pdf.insumo.membretes')->templateAsignacion($html, $numeroActa);
    }
}
