<?php

namespace FondOfSpryker\Zed\ProductApi\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge as SprykerProductApiToProductBridge;

class ProductApiToProductBridge extends SprykerProductApiToProductBridge implements ProductApiToProductInterface
{
    /**
     * @param string $sku
     *
     * @return int|null
     */
    public function findProductAbstractIdBySku($sku)
    {
        return $this->productFacade->findProductAbstractIdBySku($sku);
    }

    /**
     * @param string $skuProductConcrete
     *
     * @return int
     */
    public function findProductConcreteIdBySku(string $skuProductConcrete): int
    {
        return $this->productFacade->findProductConcreteIdBySku($skuProductConcrete);
    }

    /**
     * @param string $skuProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractBySku(string $skuProductAbstract): ?ProductAbstractTransfer
    {
        $idProductAbstract = $this->productFacade->findProductAbstractIdBySku($skuProductAbstract);

        if (!$idProductAbstract) {
            return null;
        }

        return $this->productFacade->findProductAbstractById($idProductAbstract);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductAbstract
     *
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    public function getConcreteProductsByAbstractProductId(int $idProductAbstract): array
    {
        return $this->productFacade->getConcreteProductsByAbstractProductId($idProductAbstract);
    }
}
