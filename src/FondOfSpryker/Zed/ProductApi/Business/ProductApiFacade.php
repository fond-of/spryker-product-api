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
     * {@inheritdoc}
     *
     * @api
     *
     * @param string $identifierProduct
     *
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function updateProduct($identifierProduct, ApiDataTransfer $apiDataTransfer)
    {
        return $this->getFactory()
            ->createProductApi()
            ->update($identifierProduct, $apiDataTransfer);
    }
}
