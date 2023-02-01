<?php

namespace FondOfSpryker\Zed\ProductApi;

use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge;
use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreBridge;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductApi\ProductApiDependencyProvider as SprykerProductApiDependencyProvider;

/**
 * @codeCoverageIgnore
 */
class ProductApiDependencyProvider extends SprykerProductApiDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);

        return $this->addStoreFacade($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductFacade(Container $container): Container
    {
        $container[static::FACADE_PRODUCT] = static function (Container $container) {
            return new ProductApiToProductBridge($container->getLocator()->product()->facade());
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = static function (Container $container) {
            return new ProductApiToStoreBridge($container->getLocator()->store()->facade());
        };

        return $container;
    }
}
