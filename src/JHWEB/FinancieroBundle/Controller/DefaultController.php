<?php

namespace JHWEB\FinancieroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('JHWEBFinancieroBundle:Default:index.html.twig');
    }

    /**
     * @Route("/soap/recaudos/transito/departamental")
     */
    public function responseAction()
    {
        ini_set("soap.wsdl_cache_enabled", "0");

        $recaudo = $this->get('app_soap');

        $soapServer = new \SoapServer('https://subdetra.xn--nario-rta.gov.co/colossus-sit/web/soap/test.wsdl');
        $soapServer->setObject($recaudo);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }

    /**
     * @Route("/soap/recaudos/transito/departamental/confirmar")
     */
    public function confirmAction(Request $request)
    {       
        var_dump($request->request);
        die();

        $client = new \Soapclient('https://subdetra.xn--nario-rta.gov.co/colossus-sit/web/financiero/soap/recaudos/transito/departamental?wsdl', true);


        $result = $client->call('confirmarRecaudo', array('request' => $request));
    }
}
