<?php

namespace FondOfSpryker\Zed\ProductApi\Business;

use FondOfSpryker\Zed\ProductApi\Business\Model\ProductApi;
use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreInterface;
use FondOfSpryker\Zed\ProductApi\ProductApiDependencyProvider;
use Spryker\Zed\ProductApi\Business\ProductApiBusinessFactory as SprykerProductApiBusinessFactory;

/**
 * @method \Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainerInterface getQueryContainer()
 * @method \Spryker\Zed\ProductApi\ProductApiConfig getConfig()
 */
class ProductApiBusinessFactory extends SprykerProductApiBusinessFactory
{
    /**
     * @return \Spryker\Zed\ProductApi\Business\Model\ProductApiInterface
     */
    public function createProductApi()
    {
        return new ProductApi(
            $this->getApiFacade(),
            $this->getApiQueryBuilderQueryContainer(),
            $this->getQueryContainer(),
            $this->createEntityMapper(),
            $this->createTransferMapper(),
            $this->getProductFacade(),
            $this->getStoreFacade(),
        );
    }

    /**
     * @return \FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreInterface
     */
    public function getStoreFacade(): ProductApiToStoreInterface
    {
        return $this->getProvidedDependency(ProductApiDependencyProvider::FACADE_STORE);
    }
}
