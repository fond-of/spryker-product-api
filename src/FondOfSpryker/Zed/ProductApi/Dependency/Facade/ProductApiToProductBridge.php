<?php

namespace FondOfSpryker\Zed\ProductApi\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractTransfer;

use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge as SprykerProductApiToProductBridge;

class ProductApiToProductBridge extends SprykerProductApiToProductBridge implements ProductApiToProductInterface
{
    /**
     * @param \Generated\Shared\Transfer\ProductAbstractTransfer $productAbstractTransfer
     * @param array $productConcreteCollection
     *
     * @return int
     */
    public function addProduct(ProductAbstractTransfer $productAbstractTransfer, array $productConcreteCollection)
    {
        return $this->productFacade->addProduct($productAbstractTransfer, $productConcreteCollection);
    }

    /**
     * @param string $skuProductAbstract
     *
     * @return int $idProductAbstract
     */
    public function findProductAbstractIdBySku(string $skuProductAbstract)
    {
        return $this->productFacade->findProductAbstractIdBySku($skuProductAbstract);
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
     * {@inheritdoc}
     *
     * @api
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer[]
     */
    public function getConcreteProductsByAbstractProductId(int $idProductAbstract): array
    {
        return $this->productFacade->getConcreteProductsByAbstractProductId($idProductAbstract);
    }

    /**
     * @param int $idAbstractProduct
     *
     * @return void
     */
    public function touchProductAbstract(int $idAbstractProduct): void
    {
        $this->productFacade->touchProductAbstract($idAbstractProduct);
    }
}
