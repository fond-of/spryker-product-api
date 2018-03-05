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
     * @param string $identifierProduct
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update($identifierProduct, ApiDataTransfer $apiDataTransfer)
    {
        return $this->getFacade()->updateProduct($identifierProduct, $apiDataTransfer);
    }
}
