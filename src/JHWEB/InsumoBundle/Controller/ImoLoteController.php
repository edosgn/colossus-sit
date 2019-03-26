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
            array('tipo'=>'insumo')
        );
        $loteSustratos = $em->getRepository('JHWEBInsumoBundle:ImoLote')->findBy(
            array('tipo'=>'sustrato')
        );

        $data = array(
            'loteInsumos' =>  $loteInsumos, 
            'loteSustratos' =>  $loteSustratos, 
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
            $sedeOperativaId = (isset($params->sedeOperativaId)) ? $params->sedeOperativaId : null;
            $loteInsumo = new ImoLote();
            if ($sedeOperativaId) {
                $sedeOperativa = $em->getRepository('JHWEBConfigBundle:CfgOrganismoTransito')->find($idOrganismoTransito);
                $loteInsumo->setSedeOperativa($sedeOperativa);
                $loteInsumo->setTipo('sustrato');
                $ultimoRango = $em->getRepository('AppBundle:LoteInsumo')->getMax(); 
                if ($params->rangoInicio < $ultimoRango['maximo']+1) {
                    $response = array(
                        'status' => 'error',
                        'code' => 200,
                        'msj' => "El rango ya se encuentra registrado", 
                    );
                    return $helpers->json($response);
                }
            }else {
                $loteInsumo->setTipo('insumo');
            }
            $casoInsumo = $em->getRepository('JHWEBInsumoBundle:ImoCfgTipo')->find($params->imoCfgTipo);

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
     * Displays a form to edit an existing imoLote entity.
     *
     * @Route("/{id}/edit", name="imolote_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, ImoLote $imoLote)
    {
        $deleteForm = $this->createDeleteForm($imoLote);
        $editForm = $this->createForm('JHWEB\InsumoBundle\Form\ImoLoteType', $imoLote);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('imolote_edit', array('id' => $imoLote->getId()));
        }

        return $this->render('imolote/edit.html.twig', array(
            'imoLote' => $imoLote,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
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
}
