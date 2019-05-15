<?php

namespace Repository\UsuarioBundle\services;

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

    public function templateAssignment($trazabilidad, $to){
      $subject = "Asignación PQRSF";
      $data = array('entity'=>$trazabilidad);
      $plantilla = 'JHWEBPqrsfBundle:default:email.assignment.html.twig';
      //$from = 'pqrsfhospitalsanpedro.org@gmail.com';
      $from = 'no-responder@apps.hospitalsanpedro.org';
      //Envio de E-Mail
      $message = $this->sendEmail($subject,$to,$data,$plantilla,$from);
      if($message == true){
          $this->session->getFlashBag()->set('info', "Confirmación de PQRSF enviada mediante correo de Coordinador!");
          $trazabilidad->setNotificadoCoordinador(true);
          $this->em->flush();
      }else{
          $this->session->getFlashBag()->set('error', "No se pudo enviar correo de confirmación! - Error: ".$message);
      }
    } 
}
