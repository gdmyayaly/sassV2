<?php

namespace ContainerRYFjxI0;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_9yqXO_MService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.9yqXO.M' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.9yqXO.M'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService ??= $container->getService(...), [
            'clientRepository' => ['privates', 'App\\Repository\\ClientRepository', 'getClientRepositoryService', true],
            'entityManagerInterface' => ['services', 'doctrine.orm.default_entity_manager', 'getDoctrine_Orm_DefaultEntityManagerService', false],
            'userRepository' => ['privates', 'App\\Repository\\UserRepository', 'getUserRepositoryService', true],
        ], [
            'clientRepository' => 'App\\Repository\\ClientRepository',
            'entityManagerInterface' => '?',
            'userRepository' => 'App\\Repository\\UserRepository',
        ]);
    }
}
