<?php

namespace AppBundle\services;

use Symfony\Component\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManager;

class Mailer
{
    private $mailer;
    private $templating;
    private $session;
    protected $em;

    function __construct( \Swift_Mailer $mailer, EngineInterface $templating, Session $session, EntityManager $em) {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->session = $session;
        $this->em = $em;
    }

    public function sendEmail($subject,$to,$data,$plantilla,$from){
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody(
                $this->templating->render(
                    $plantilla,
                    $data
                ), 'text/html'
            )
            ->setPriority(2);

        if(!$this->mailer->send($message, $failures)){
          return false;
        }else{
          return true;
        }
    }

    /**
     *
     * Valida un email usando filter_var y comprobar las DNS. 
     *  Devuelve true si es correcto o false en caso contrario
     *
     * param    string  $str la dirección a validar
     * return   boolean
     *
     */
    function is_valid_email($str)
    {
      $result = (false !== filter_var($str, FILTER_VALIDATE_EMAIL));
      
      if ($result)
      {
        list($user, $domain) = explode('@', $str);
        $result = checkdnsrr($domain, 'MX');
      }
      
      return $result;
    }

    public function templateNotify($trazabilidad, $to){
      $subject = "Notificación";
      $data = array('entity'=>$trazabilidad);
      $plantilla = 'JHWEBContravencionalBundle:Default:email.notify.html.twig';
      $from = 'no_responder@subdetra.narino.gov.co';
      //Envio de E-Mail
      $message = $this->sendEmail($subject,$to,$data,$plantilla,$from);
      if($message == true){
        $this->session->getFlashBag()->set('info', "Notificación de trazabilidad enviada mediante correo a infractor!");
      }else{
        $this->session->getFlashBag()->set('error', "No se pudo enviar correo de confirmación! - Error: ".$message);
      }
    }

    public function templateAssignment($trazabilidad, $to){
      $subject = "Asignación de proceso";
      $data = array('entity'=>$trazabilidad);
      $plantilla = 'JHWEBContravencionalBundle:Default:email.assignment.html.twig';
      $from = 'no_responder@subdetra.narino.gov.co';
      //Envio de E-Mail
      $message = $this->sendEmail($subject,$to,$data,$plantilla,$from);
      if($message == true){
          $this->session->getFlashBag()->set('info', "Confirmación de trazabilidad enviada mediante correo a funcionario!");
          $this->em->flush();
      }else{
          $this->session->getFlashBag()->set('error', "No se pudo enviar correo de confirmación! - Error: ".$message);
      }
    }   
}
