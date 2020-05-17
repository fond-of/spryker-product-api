<?php

namespace FondOfSpryker\Zed\ProductApi\Business;

use Generated\Shared\Transfer\ApiDataTransfer;
use Spryker\Zed\ProductApi\Business\ProductApiFacade as BaseProductApiFacade;

/**
 * @method \FondOfSpryker\Zed\ProductApi\Business\ProductApiBusinessFactory getFactory()
 */
class ProductApiFacade extends BaseProductApiFacade
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function addProduct(ApiDataTransfer $apiDataTransfer)
    {
        return $this->getFactory()
            ->createProductApi()
            ->add($apiDataTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $sku
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function updateProduct($sku, ApiDataTransfer $apiDataTransfer)
    {
        return $this->getFactory()
            ->createProductApi()
            ->update($sku, $apiDataTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string $sku
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function getProductAbstractBySku($sku)
    {
        return $this->getFactory()
            ->createProductApi()
            ->getBySku($sku);
    }
}
