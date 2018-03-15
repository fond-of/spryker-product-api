<?php

namespace FondOfSpryker\Zed\ProductApi\Communication\Plugin\Api;

use Generated\Shared\Transfer\ApiDataTransfer;
use Spryker\Zed\ProductApi\Communication\Plugin\Api\ProductApiResourcePlugin as BaseProductApiResourcePlugin;

/**
 * @method \FondOfSpryker\Zed\ProductApi\Business\ProductApiFacadeInterface getFacade()
 * @method \Spryker\Zed\Product\Communication\ProductCommunicationFactory getFactory()
 */
class ProductApiResourcePlugin extends BaseProductApiResourcePlugin
{
    /**
     * @param string $sku
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update($sku, ApiDataTransfer $apiDataTransfer)
    {
        return $this->getFacade()->updateProduct($sku, $apiDataTransfer);
    }

    /**
     * @internal param ApiFilterTransfer $apiFilterTransfer
     *
     * @param string $skuProductAbstract
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function get($skuProductAbstract)
    {
        return $this->getFacade()->getProductAbstractBySku($skuProductAbstract);
    }
}
