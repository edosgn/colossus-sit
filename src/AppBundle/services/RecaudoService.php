<?php 

namespace AppBundle\services;

class RecaudoService
{
    public function confirmarRecaudo($request)
    {
        return true;
    }

    public function consultarRecaudo($array)
    {
        return $array['usuario'];
    }
}