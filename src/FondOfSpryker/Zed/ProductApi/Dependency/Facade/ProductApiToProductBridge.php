<?php

namespace FondOfSpryker\Zed\ProductApi\Dependency\Facade;

use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge as BaseProductApiToProductBridge;

class ProductApiToProductBridge extends BaseProductApiToProductBridge
{
    /**
     * @var \Spryker\Zed\Product\Business\ProductFacadeInterface
     */
    protected $productFacade;

    /**
     * @param \FondOfSpryker\Zed\ProductApi\Business\ProductApiFacade $productFacade
     */
    public function __construct($productFacade)
    {
        $this->productFacade = $productFacade;
    }

    /**
     * @param string $skuProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractBySku($skuProductAbstract)
    {
        $idProductAbstract = $this->productFacade->findProductAbstractIdBySku($skuProductAbstract);

        if (!$idProductAbstract) {
            return null;
        }

        return $this->productFacade->findProductAbstractById($idProductAbstract);
    }
}
