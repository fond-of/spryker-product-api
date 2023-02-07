<?php

namespace FondOfSpryker\Zed\ProductApi\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface as SprykerProductApiToProductInterface;

interface ProductApiToProductInterface extends SprykerProductApiToProductInterface
{
    /**
     * @param string $sku
     *
     * @return int|null
     */
    public function findProductAbstractIdBySku($sku);

    /**
     * @param string $skuProductConcrete
     *
     * @return int
     */
    public function findProductConcreteIdBySku(string $skuProductConcrete): int;

    /**
     * @api
     *
     * @param string $skuProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractBySku(string $skuProductAbstract): ?ProductAbstractTransfer;

    /**
     * @api
     *
     * @param int $idProductAbstract
     *
     * @return array<\Generated\Shared\Transfer\ProductConcreteTransfer>
     */
    public function getConcreteProductsByAbstractProductId(int $idProductAbstract): array;
}
