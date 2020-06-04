<?php

namespace FondOfSpryker\Zed\ProductApi\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface as SprykerProductApiToProductInterface;

interface ProductApiToProductInterface extends SprykerProductApiToProductInterface
{
    /**
     * {@inheritedDoc}
     *
     * @api
     *
     * @param string $skuProductAbstract
     *
     * @return int
     */
    public function findProductAbstractIdBySku(string $skuProductAbstract);

    /**
     * {@inheritedDoc}
     *
     * @param string $skuProductConcrete
     *
     * @return int
     */
    public function findProductConcreteIdBySku(string $skuProductConcrete): int;

    /**
     * {@inheritedDoc}
     *
     * @api
     *
     * @param string $skuProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractBySku(string $skuProductAbstract): ?ProductAbstractTransfer;

    /**
     * {@inheritedDoc}
     *
     * @api
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer[]
     */
    public function getConcreteProductsByAbstractProductId(int $idProductAbstract): array;

    /**
     * {@inheritedDoc}
     *
     * @api
     *
     * @param int $idAbstractProduct
     *
     * @return void
     */
    public function touchProductAbstract(int $idAbstractProduct): void;
}
