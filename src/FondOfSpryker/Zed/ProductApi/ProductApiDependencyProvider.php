<?php

namespace FondOfSpryker\Zed\ProductApi;

use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge;
use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreBridge;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductApi\ProductApiDependencyProvider as SprykerProductApiDependencyProvider;

class ProductApiDependencyProvider extends SprykerProductApiDependencyProvider
{
    public const FACADE_STORE = 'FACADE_STORE';

    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        $container = $this->addStoreFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function provideProductFacade(Container $container): Container
    {
        $container[static::FACADE_PRODUCT] = function (Container $container) {
            return new ProductApiToProductBridge($container->getLocator()->product()->facade());
        };

        return $container;
    }

    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = static function (Container $container) {
            return new ProductApiToStoreBridge($container->getLocator()->store()->facade());
        };

        return $container;
    }
}
