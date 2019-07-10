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
      $subject = "Confirmación PQRSF";
      $data = array('entity'=>$trazabilidad);
      $plantilla = 'JHWEBPqrsfBundle:default:email.notify.html.twig';
      //$from = 'pqrsfhospitalsanpedro.org@gmail.com';
      $from = 'no-responder@apps.hospitalsanpedro.org';
      //Envio de E-Mail
      $message = $this->sendEmail($subject,$to,$data,$plantilla,$from);
      if($message == true){
        $this->session->getFlashBag()->set('info', "Notificación de PQRSF enviada mediante correo a peticionario!");
        $trazabilidad->setNotificadoAcudiente(true);
        $this->em->flush();
      }else{
        $this->session->getFlashBag()->set('error', "No se pudo enviar correo de confirmación! - Error: ".$message);
      }
    }

    public function templateResponse($trazabilidad){
      $subject = "Confirmación de Respuesta PQRSF";
      $data = array('entity'=>$trazabilidad);
      $plantilla = 'JHWEBPqrsfBundle:default:email.response.html.twig';
      //$from = 'pqrsfhospitalsanpedro.org@gmail.com';
      $from = 'no-responder@apps.hospitalsanpedro.org';
      //Envio de E-Mail
      $message = $this->sendEmail($subject,'pqrsfhospitalsanpedro.org@gmail.com',$data,$plantilla,$from);
      if($message == true){
        $this->session->getFlashBag()->set('info', "Copia de Respuesta de PQRSF enviada mediante correo a administrador!");
        $trazabilidad->setNotificadoAcudiente(true);
        $this->em->flush();
      }else{
        $this->session->getFlashBag()->set('error', "No se pudo enviar copia de mensaje a administrador! - Error: ".$message);
      }
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

    public function templateSalvavidas($donante, $campania){
      //E-Mail parameters
      $subject = "Notificación Banco de Sangre";
      $to = $donante->getCorreo();
      $data = array('donante' => $donante, 'campania' => $campania);
      $plantilla = 'JHWEBSalvavidasBundle:default:email.campania.html.twig';
      $from = 'bancodesangre@hospitalsanpedro.org';
      //Envio de E-Mail
      $this->sendEmail($subject,$to,$data,$plantilla,$from);

      /*if($message == true){
        $this->session->getFlashBag()->set('info', "Notificación de PQRSF enviada mediante correo a peticionario!");
        $trazabilidad->setNotificadoAcudiente(true);
        $this->em->flush();
      }else{
        $this->session->getFlashBag()->set('error', "No se pudo enviar correo de confirmación! - Error: ".$message);
      }*/
    }

    public function templateSalvavidasWelcome($donante, $campania){
      //E-Mail parameters
      $subject = "Notificación Banco de Sangre";
      $to = $donante->getCorreo();
      $data = array('donante' => $donante, 'campania' => $campania);
      $plantilla = 'JHWEBSalvavidasBundle:default:email.welcome.html.twig';
      $from = 'bancodesangre@hospitalsanpedro.org';
      //Envio de E-Mail
      $this->sendEmail($subject,$to,$data,$plantilla,$from);

      /*if($message == true){
        $this->session->getFlashBag()->set('info', "Notificación de PQRSF enviada mediante correo a peticionario!");
        $trazabilidad->setNotificadoAcudiente(true);
        $this->em->flush();
      }else{
        $this->session->getFlashBag()->set('error', "No se pudo enviar correo de confirmación! - Error: ".$message);
      }*/
    }

    public function templateSalvavidasNext($donante, $campania){
      //E-Mail parameters
      $subject = "Notificación Banco de Sangre";
      $to = $donante->getCorreo();
      $data = array('donante' => $donante, 'campania' => $campania);
      $plantilla = 'JHWEBSalvavidasBundle:default:email.next.html.twig';
      $from = 'bancodesangre@hospitalsanpedro.org';
      //Envio de E-Mail
      $this->sendEmail($subject,$to,$data,$plantilla,$from);

      /*if($message == true){
        $this->session->getFlashBag()->set('info', "Notificación de PQRSF enviada mediante correo a peticionario!");
        $trazabilidad->setNotificadoAcudiente(true);
        $this->em->flush();
      }else{
        $this->session->getFlashBag()->set('error', "No se pudo enviar correo de confirmación! - Error: ".$message);
      }*/
    }

    public function templateTrazabilidad($trazabilidad){
      $correosInvalidos = null;

      if ($trazabilidad->getSolicitud()->getAcudiente()->getCorreos() && $trazabilidad->getEstado()->getRespuesta() != null){
        $to = array();
        foreach ($trazabilidad->getSolicitud()->getAcudiente()->getCorreos() as $key => $correo) {
          $correoValido = $this->is_valid_email($correo);

          if ($correoValido) {
            array_push($to,$correo);
          }else{
            $correosInvalidos[] = $correo;
          }
        };

        $this->templateNotify($trazabilidad, $to);
        $this->templateResponse($trazabilidad);
      }


      if ($trazabilidad->getFuncionario()->getUsuario()->getCorreos() && $trazabilidad->getFuncionario()->getUsuario()->getRole() != 'ROLE_ADMIN') {
        //E-Mail parameters
        $to = array();
        foreach ($trazabilidad->getFuncionario()->getUsuario()->getCorreos() as $key => $correo) {
          $correoValido = $this->is_valid_email($correo);

          if ($correoValido) {
            array_push($to,$correo);
            $this->templateAssignment($trazabilidad, $to);
          }else{
            $correosInvalidos[] = $correo;
          }
        };
      }

      if ($correosInvalidos) {
        $correosInvalidos = implode(",", $correosInvalidos);

        $this->session->getFlashBag()->set('error', "No se pudo enviar correo de confirmación a estos correos: ".$correosInvalidos);
      }
    }

    public function templateReferenciacion($solicitante){
      $subject = "Registro de proceso de referenciación";
      $data = array('entity'=>$solicitante);
      $plantilla = 'JHWEBReferenciacionBundle:default:email.register.html.twig';
      $to = $solicitante->getContactoCorreo();
      $from = 'no-responder@apps.hospitalsanpedro.org';
      //Envio de E-Mail
      $message = $this->sendEmail($subject,$to,$data,$plantilla,$from);
      if($message == true){
        $this->session->getFlashBag()->set('info', "Proceso de referenciación registrado!");
        //Envía notificación de confirmación al administrador
        $plantilla = 'JHWEBReferenciacionBundle:default:email.confirm.html.twig';
        $to = 'plancalidad@hospitalsanpedro.org';
        $message = $this->sendEmail($subject,$to,$data,$plantilla,$from);
      }else{
        $this->session->getFlashBag()->set('error', "No se pudo enviar correo de confirmación! - Error: ".$message);
      }
    }    
}
