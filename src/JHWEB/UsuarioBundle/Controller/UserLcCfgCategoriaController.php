<?php

namespace JHWEB\UsuarioBundle\Controller;

use JHWEB\UsuarioBundle\Entity\UserLcCfgCategoria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Userlccfgcategorium controller.
 *
 * @Route("userlccfgcategoria")
 */
class UserLcCfgCategoriaController extends Controller
{
    /**
     * Lists all userLcCfgCategorium entities.
     *
     * @Route("/", name="userlccfgcategoria_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userLcCfgCategorias = $em->getRepository('JHWEBUsuarioBundle:UserLcCfgCategoria')->findAll();

        return $this->render('userlccfgcategoria/index.html.twig', array(
            'userLcCfgCategorias' => $userLcCfgCategorias,
        ));
    }

    /**
     * Finds and displays a userLcCfgCategorium entity.
     *
     * @Route("/{id}", name="userlccfgcategoria_show")
     * @Method("GET")
     */
    public function showAction(UserLcCfgCategoria $userLcCfgCategorium)
    {

        return $this->render('userlccfgcategoria/show.html.twig', array(
            'userLcCfgCategorium' => $userLcCfgCategorium,
        ));
    }
}
