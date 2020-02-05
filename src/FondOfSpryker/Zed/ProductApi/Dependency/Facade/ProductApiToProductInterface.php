<?php

namespace FondOfSpryker\Zed\ProductApi\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface as SprykerProductApiToProductInterface;

interface ProductApiToProductInterface extends SprykerProductApiToProductInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $skuProductAbstract
     *
     * @return int $idProductAbstract
     */
    public function findProductAbstractIdBySku(string $skuProductAbstract);

    /**
     * @param string $skuProductConcrete
     *
     * @return int
     */
    public function findProductConcreteIdBySku(string $skuProductConcrete): int;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $skuProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    public function findProductAbstractBySku(string $skuProductAbstract): ProductAbstractTransfer;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer[]
     */
    public function getConcreteProductsByAbstractProductId(int $idProductAbstract): array;

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idAbstractProduct
     *
     * @return void
     */
    public function touchProductAbstract(int $idAbstractProduct): void;
}
