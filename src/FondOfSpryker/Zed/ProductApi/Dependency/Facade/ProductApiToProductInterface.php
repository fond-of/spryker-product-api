<?php

namespace FondOfSpryker\Zed\ProductApi\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface as SprykerProductApiToProductInterface;

interface ProductApiToProductInterface extends SprykerProductApiToProductInterface
{
    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param string $skuProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductAbstractTransfer|null
     */
    public function findProductAbstractBySku(string $skuProductAbstract): ProductAbstractTransfer;

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer[]
     */
    public function getConcreteProductsByAbstractProductId(int $idProductAbstract): int;

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param int $idAbstractProduct
     *
     * @return void
     */
    public function touchProductAbstract(int $idAbstractProduct): void;
}
