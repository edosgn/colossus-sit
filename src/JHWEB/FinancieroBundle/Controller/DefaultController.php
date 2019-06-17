<?php

namespace JHWEB\FinancieroBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

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
     * @Route("/soap/response")
     */
    public function responseAction()
    {
        $soapServer = new \SoapServer('http://localhost/GitHub/colossus-sit/web/consultar_recaudos.wsdl');

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }

    /**
     * @Route("/soap/call")
     */
    public function callAction()
    {
        $client = new \Soapclient('http://localhost/GitHub/colossus-sit/web/consultar_recaudos?wsdl', true);

        $result = $client->call('hello', array('name' => 'Scott'));

        var_dump($result);
    }
}
