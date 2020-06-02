<?php

namespace FondOfSpryker\Zed\ProductApi;

use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductApi\ProductApiDependencyProvider as SprykerProductApiDependencyProvider;

class ProductApiDependencyProvider extends SprykerProductApiDependencyProvider
{
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
}
