<?php

namespace ContainerRYFjxI0;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getSousCategoryProductControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\Client\SousCategoryProductController' shared autowired service.
     *
     * @return \App\Controller\Client\SousCategoryProductController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'vendor'.\DIRECTORY_SEPARATOR.'symfony'.\DIRECTORY_SEPARATOR.'framework-bundle'.\DIRECTORY_SEPARATOR.'Controller'.\DIRECTORY_SEPARATOR.'AbstractController.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Controller'.\DIRECTORY_SEPARATOR.'Client'.\DIRECTORY_SEPARATOR.'SousCategoryProductController.php';
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Service'.\DIRECTORY_SEPARATOR.'SlugService.php';

        $container->services['App\\Controller\\Client\\SousCategoryProductController'] = $instance = new \App\Controller\Client\SousCategoryProductController(($container->privates['App\\Service\\GalerieService'] ?? $container->load('getGalerieServiceService')), ($container->privates['App\\Service\\SlugService'] ??= new \App\Service\SlugService()));

        $instance->setContainer(($container->privates['.service_locator.O2p6Lk7'] ?? $container->load('get_ServiceLocator_O2p6Lk7Service'))->withContext('App\\Controller\\Client\\SousCategoryProductController', $container));

        return $instance;
    }
}
