<?php

namespace FondOfSpryker\Zed\ProductApi;

use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge;
use Spryker\Zed\ProductApi\ProductApiDependencyProvider as BaseProductApiDependencyProvider;

class ProductApiDependencyProvider extends BaseProductApiDependencyProvider
{
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function provideProductFacade(Container $container)
    {
        $container[static::FACADE_PRODUCT] = function (Container $container) {
            return new ProductApiToProductBridge($container->getLocator()->product()->facade());
        };

        return $container;
    }
}
