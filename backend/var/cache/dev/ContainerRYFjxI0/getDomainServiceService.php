<?php

namespace ContainerRYFjxI0;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDomainServiceService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'App\Service\DomainService' shared autowired service.
     *
     * @return \App\Service\DomainService
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).''.\DIRECTORY_SEPARATOR.'src'.\DIRECTORY_SEPARATOR.'Service'.\DIRECTORY_SEPARATOR.'DomainService.php';

        return $container->privates['App\\Service\\DomainService'] = new \App\Service\DomainService(($container->privates['App\\Repository\\ClientRepository'] ?? $container->load('getClientRepositoryService')), ($container->services['doctrine.orm.default_entity_manager'] ?? self::getDoctrine_Orm_DefaultEntityManagerService($container)));
    }
}
