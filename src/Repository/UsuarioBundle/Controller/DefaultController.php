<?php

namespace Repository\UsuarioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;


 /**
 * Default controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * Creates a new Usuario entity.
     *
     * @Route("/login", name="default_login")
     * @Method({"GET", "POST"})
     */
    public function loginAction(Request $request)
    {
        $jwt_auth = $this->get("app.jwt_auth");
        $helpers = $this->get("app.helpers");
        //recibir json por post
        $json = $request->get("data" , null);

        if ($json != null) {
            $params = json_decode($json);

            $email = (isset($params->correo)) ? $params->correo : null;
            $password = (isset($params->password)) ? $params->password : null;
            $getHash = (isset($params->gethash)) ? $params->gethash : null;

            $emialConstraint = new Assert\Email();
            $emialConstraint->message = "emial no valido";  
            $validate_email = $this->get("validator")->validate($email, $emialConstraint );

            //Cifrar la password
            $pwd = hash('sha256', $password);

            if(count($validate_email) == 0 && $password != null) {
                if ($getHash == "true") {
                    $singup = $jwt_auth->singUp($email,$pwd);
                }else{
                    $singup = $jwt_auth->singUp($email,$pwd, true);
                }

                return new \Symfony\Component\HttpFoundation\JsonResponse($singup);
                
            }else{
                return $helpers->json(array("status" => "error", "data" => "login no valido"));
            }
        }else{
            return $helpers->json(array("status" => "error", "data" => "enviar json"));
        }
    }

    /**
     * Logout
     *
     * @Route("/logout", name="default_logout")
     * @Method({"GET", "POST"})
     */
    public function logoutAction(Request $request)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $json = $request->get("data",null);
            $params = json_decode($json);
           
            $em = $this->getDoctrine()->getManager();

            $usuario = $em->getRepository('UsuarioBundle:Usuario')->find(
                $params->id
            );

            if ($usuario) {
                $usuario->setLogueado(false);
    
                $em->flush();
    
                $response = array(
                    'tile' => 'Perfecto!',
                    'status' => 'success',
                    'code' => 200,
                    'message' => "Cierre de sesión realizado correctamente.", 
                );
            }else{
                $response = array(
                    'tile' => 'Atención!',
                    'status' => 'warning',
                    'code' => 400,
                    'message' => "Usuario no encontrado.", 
                );
            }
        }else{
            $response = array(
                'tile' => 'Error!',
                'status' => 'error',
                'code' => 400,
                'message' => "Autorizacion no valida", 
            );
        }

        return $helpers->json($response); 
    }
}
