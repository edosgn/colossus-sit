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
     * @Route("/soap/ath/recaudos/transito/departamental")
     */
    public function responseAction()
    {
        $soap = $this->get('app_soap');

        $soapServer = new \SoapServer('http://localhost/software/Gobernacion/Transito/colossus-sit/web/soap/WSATH.wsdl');
        $soapServer->setObject($soap);

        $response = new Response();
        $response->headers->set('Content-Type', 'text/xml; charset=ISO-8859-1');

        ob_start();
        $soapServer->handle();
        $response->setContent(ob_get_clean());

        return $response;
    }
}
