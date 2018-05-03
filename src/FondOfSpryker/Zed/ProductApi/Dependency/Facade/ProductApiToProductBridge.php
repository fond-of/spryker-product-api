<?php

namespace FondOfSpryker\Zed\ProductApi\Dependency\Facade;

use Generated\Shared\Transfer\ProductAbstractTransfer;
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

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ProductConcreteTransfer[]
     */
    public function getConcreteProductsByAbstractProductId($idProductAbstract)
    {
        return $this->productFacade->getConcreteProductsByAbstractProductId($idProductAbstract);
    }


    /**
     * @param int $idAbstractProduct
     * @return void
     */
    public function touchProductAbstract(int $idAbstractProduct)
    {
        return $this->productFacade->touchProductAbstract($idAbstractProduct);
    }
}
