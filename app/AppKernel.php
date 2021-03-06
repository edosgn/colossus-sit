<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Repository\UsuarioBundle\UsuarioBundle(),
            new WhiteOctober\TCPDFBundle\WhiteOctoberTCPDFBundle(),
            new Liuggio\ExcelBundle\LiuggioExcelBundle(),
            new AppBundle\AppBundle(),
            new JHWEB\VehiculoBundle\JHWEBVehiculoBundle(),
            new JHWEB\SeguridadVialBundle\JHWEBSeguridadVialBundle(),
            new JHWEB\ConfigBundle\JHWEBConfigBundle(),
            new JHWEB\ContravencionalBundle\JHWEBContravencionalBundle(),
            new JHWEB\GestionDocumentalBundle\JHWEBGestionDocumentalBundle(),
            new JHWEB\InsumoBundle\JHWEBInsumoBundle(),
            new JHWEB\PersonalBundle\JHWEBPersonalBundle(),
            new JHWEB\FinancieroBundle\JHWEBFinancieroBundle(),
            new JHWEB\UsuarioBundle\JHWEBUsuarioBundle(),
            new JHWEB\BancoProyectoBundle\JHWEBBancoProyectoBundle(),
            new JHWEB\ParqueaderoBundle\JHWEBParqueaderoBundle(),
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
