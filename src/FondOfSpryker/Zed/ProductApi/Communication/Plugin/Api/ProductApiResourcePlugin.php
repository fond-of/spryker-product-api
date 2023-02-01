<?php

namespace FondOfSpryker\Zed\ProductApi\Communication\Plugin\Api;

use Generated\Shared\Transfer\ApiDataTransfer;
use Spryker\Zed\ProductApi\Communication\Plugin\Api\ProductApiResourcePlugin as BaseProductApiResourcePlugin;

/**
 * @method \Spryker\Zed\ProductApi\Business\ProductApiFacadeInterface getFacade()
 * @method \Spryker\Zed\Product\Communication\ProductCommunicationFactory getFactory()
 * @method \Spryker\Zed\ProductApi\ProductApiConfig getConfig()
 * @method \Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainerInterface getQueryContainer()
 */
class ProductApiResourcePlugin extends BaseProductApiResourcePlugin
{
    /**
     * @param string|int $id
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update($id, ApiDataTransfer $apiDataTransfer)
    {
        return $this->getFacade()->updateProduct($id, $apiDataTransfer);
    }

    /**
     * @param string|int $id
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function get($id)
    {
        return $this->getFacade()->getProduct($id);
    }
}
