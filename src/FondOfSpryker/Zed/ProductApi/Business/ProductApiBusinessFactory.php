<?php

namespace FondOfSpryker\Zed\ProductApi\Business;

use FondOfSpryker\Zed\ProductApi\Business\Model\ProductApi;
use Spryker\Zed\ProductApi\Business\ProductApiBusinessFactory as SprykerProductApiBusinessFactory;

/**
 * @method \Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainerInterface getQueryContainer()
 */
class ProductApiBusinessFactory extends SprykerProductApiBusinessFactory
{
    /**
     * @return \Spryker\Zed\ProductApi\Business\Model\ProductApiInterface
     */
    public function createProductApi()
    {
        return new ProductApi(
            $this->getApiQueryContainer(),
            $this->getApiQueryBuilderQueryContainer(),
            $this->getQueryContainer(),
            $this->createEntityMapper(),
            $this->createTransferMapper(),
            $this->getProductFacade()
        );
    }
}
