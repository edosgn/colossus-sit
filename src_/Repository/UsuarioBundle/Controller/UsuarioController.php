<?php

namespace Repository\UsuarioBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Repository\UsuarioBundle\Entity\Usuario;
use Repository\UsuarioBundle\Entity\Empresa;
use Repository\UsuarioBundle\Form\UsuarioType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Usuario controller.
 *
 * @Route("/usuario")
 */
class UsuarioController extends Controller
{
    /**
     * Lists all Usuario entities.
     *
     * @Route("/", name="usuario_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $helpers = $this->get("app.helpers");

        $em = $this->getDoctrine()->getManager();

        $usuarios = $em->getRepository('UsuarioBundle:Usuario')->findAll();
    
        $response = array(
            'status' => 'success',
            'code' => 200,
            'usuarios'=> $usuarios,
            'msj'=>'',
        );

        return $helpers->json($response);
       
    }

    /**
     * Creates a new Usuario entity.
     *
     * @Route("/new", name="usuario_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
         $data = array(
                        "status" => "error",
                        "code" => 400,
                        "msg" => "Usuario no creado!"
                    );

        $helpers = $this->get('app.helpers');
        $json = $request->get("json",null);
        $params = json_decode($json);

        $usuario = new Usuario();
        $nombres = (isset($params->nombres)) ? $params->nombres : null;
        $apellidos = (isset($params->apellidos)) ? $params->apellidos : null;
        $identificacion = (isset($params->identificacion)) ? $params->identificacion : null;
        $correo = (isset($params->correo)) ? $params->correo : null;
        $foto = (isset($params->foto)) ? $params->foto : null;
        $telefono = (isset($params->telefono)) ? $params->telefono : null;
        $fecha_nacimiento1 = (isset($params->fechaNacimiento)) ? $params->fechaNacimiento : null;
        $estado = (isset($params->estado)) ? $params->estado : "activo";
        $rol = (isset($params->rol)) ? $params->rol : "ROLE_USER";
        $password = (isset($params->password)) ? $params->password : null;

        $emailContraint = new Assert\Email();
        $emailContraint->message = "This email is not valid !!";
        $validate_email = $this->get("validator")->validate($correo, $emailContraint);

        if ($correo != null && count($validate_email)==0 && $password != null && $nombres !=null && $apellidos != null && $identificacion != null) {

            $usuario->setNombres($nombres);
            $usuario->setApellidos($apellidos);
            $usuario->setIdentificacion($identificacion);
            $usuario->setCorreo($correo);
            $usuario->setFoto($foto);
            $usuario->setTelefono($telefono);
            $usuario->setFechaNacimiento($fecha_nacimiento1);
            $usuario->setEstado($estado);
            $usuario->setRole($rol);
            $usuario->setCreatedAt();
            $usuario->setUpdatedAt();

            //Cifrar la password
                $pwd = hash('sha256', $password);
                $usuario->setPassword($pwd);

            $em = $this->getDoctrine()->getManager();
                $isset_user = $em->getRepository("UsuarioBundle:Usuario")->findBy(
                        array(
                            "correo" => $correo
                ));
            if (count($isset_user)==0) {
                $em->persist($usuario);
                $em->flush();

                $data["status"] = 'success';
                $data["code"] = 200;
                $data["msg"] = 'Nuevo usuario creado';
            }else{

                $data = array(
                        "status" => "error",
                        "code" => 400,
                        "msg" => "Usuario no creado email repetido"
                    );

            }
        }
        return $helpers->json($data);
    }

    /**
     * Finds and displays a Usuario entity.
     *
     * @Route("/show/{id}", name="usuario_show")
     * @Method("POST")
     */
    public function showAction(Request $request, $id = null)
    {
        $helpers = $this->get("app.helpers");
        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck==true) {

            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository("UsuarioBundle:Usuario")->findOneBy(array(
                    "id" => $id
            ));

            if (is_object($usuario)) {
               
               return $helpers->json($usuario);
            }else{

                $data["status"] = 'error';
                $data["code"] = 400;
                $data["msg"] = 'no se encuentra en la base de datos';

               return $helpers->json($data);
            }
            
        }else{
            $data = array(
                        "status" => "error",
                        "code" => 400,
                        "msg" => "autenticacion no valida"
                    );
            return $helpers->json($data);
        }

       return $helpers->json($data);

      
        
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     * @Route("/edit", name="usuario_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request) {

        $data = array(
                "status" => "error",
                "code" => 400,
                "msg" => "User not updated"
            );

        $helpers = $this->get("app.helpers");

        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {

            $identity = $helpers->authCheck($hash, true);
            
            
            
            $json = $request->get("json", null);
            $params = json_decode($json);

            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository("UsuarioBundle:Usuario")->findOneBy(array(
                    "id" => $params->id
            ));

            
            if ($json != null) {
                
                $nombres = (isset($params->nombres)) ? $params->nombres : null;
                $apellidos = (isset($params->apellidos)) ? $params->apellidos : null;
                $identificacion = (isset($params->identificacion)) ? $params->identificacion : null;
                $correo = (isset($params->correo)) ? $params->correo : null;
                $foto = (isset($params->foto)) ? $params->foto : null;
                $telefono = (isset($params->telefono)) ? $params->telefono : null;
                $fecha_nacimiento = (isset($params->fecha_nacimiento)) ? $params->fecha_nacimiento : null;
                $estado = (isset($params->estado)) ? $params->estado : "activo";
                $rol = (isset($params->rol)) ? $params->rol : "ROLE_USER";
                $password = (isset($params->password)) ? $params->password : null;


                $emailContraint = new Assert\Email();
                $emailContraint->message = "This email is not valid !!";
                $validate_email = $this->get("validator")->validate($correo, $emailContraint);

                if ($correo != null && count($validate_email) == 0 &&
                     $identificacion != null && $nombres != null
                ) {
                    $usuario->setNombres($nombres);
                    $usuario->setApellidos($apellidos);
                    $usuario->setIdentificacion($identificacion);
                    $usuario->setCorreo($correo);
                    $usuario->setFoto($foto);
                    $usuario->setTelefono($telefono);
                    $usuario->setEstado($estado);
                    $usuario->setRole($rol);
                    $usuario->setCreatedAt();
                    $usuario->setUpdatedAt();

                    if($password != null && !empty($password)){
                        //Cifrar la password
                        $pwd = hash('sha256', $password);
                        $usuario->setPassword($pwd);
                    }
                    
                    $em = $this->getDoctrine()->getManager();
                   

                    
                        $em->persist($usuario);
                        $em->flush();

                        $data["status"] = 'success';
                        $data["code"] = 200;
                        $data["msg"] = 'User updated !!';
                   
                }
            } else {
                $data = array(
                    "status" => "error",
                    "code" => 400,
                    "msg" => "Authorization not valid"
                );
            }
        }

        return $helpers->json($data);
    }

    /**
     * Deletes a Usuario entity.
     *
     * @Route("/delete/{id}", name="usuario_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request, $id = null) {
        $helpers = $this->get("app.helpers");

        $hash = $request->get("authorization", null);
        $authCheck = $helpers->authCheck($hash);

        if ($authCheck == true) {
            $identity = $helpers->authCheck($hash, true);

            $user_id = ($identity->sub != null) ? $identity->sub : null;

            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository("UsuarioBundle:Usuario")->findOneBy(array(
                "id" => $id
            ));

            if (is_object($usuario) && $user_id != null) {
                    $em->remove($usuario);
                    $em->flush();

                    $data = array(
                        "status" => "success",
                        "code" => 200,
                        "msg" => "Usuario eliminado"
                    );
                } else {
                    $data = array(
                        "status" => "error",
                        "code" => 400,
                        "msg" => "Usuario no eliminado"
                    );
                }
                } else {
                    $data = array(
                        "status" => "error",
                        "code" => 400,
                        "msg" => "Autenticacion no valida"
                    );
                }
        return $helpers->json($data);
    }

    /**
     * Creates a form to delete a Usuario entity.
     *
     * @param Usuario $usuario The Usuario entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Usuario $usuario)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('id' => $usuario->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * datos para select 2
     *
     * @Route("/select", name="usuario_select")
     * @Method({"GET", "POST"})
     */
    public function selectAction()
    {
    $helpers = $this->get("app.helpers");
    $em = $this->getDoctrine()->getManager();
    $usuarios = $em->getRepository('UsuarioBundle:Usuario')->findAll();
    
    foreach ($usuarios as $key => $usuario) {
        $response[$key] = array(
            'value' => $usuario->getId(),
            'label' => $usuario->getPrimerNombre()." ".$usuario->getPrimerApellido(),
        );
      }
       return $helpers->json($response);
    }
}
