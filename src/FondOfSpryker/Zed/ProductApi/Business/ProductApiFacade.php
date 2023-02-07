<?php

namespace FondOfSpryker\Zed\ProductApi\Business;

use FondOfSpryker\Zed\ProductApi\Business\Model\ProductApi;
use Generated\Shared\Transfer\ApiDataTransfer;
use Spryker\Zed\ProductApi\Business\ProductApiFacade as BaseProductApiFacade;

/**
 * @method \Spryker\Zed\ProductApi\Business\ProductApiBusinessFactory getFactory()
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
     * @param string|int $idProductAbstract
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function updateProduct($idProductAbstract, ApiDataTransfer $apiDataTransfer)
    {
        return $this->getFactory()
            ->createProductApi()
            ->update($idProductAbstract, $apiDataTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param string|int $idProductAbstract
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function getProduct($idProductAbstract)
    {
        $productApi = $this->getFactory()
            ->createProductApi();

        if (!is_int($idProductAbstract) && $productApi instanceof ProductApi) {
            return $productApi->getBySku($idProductAbstract);
        }

        return $productApi->get($idProductAbstract);
    }
}
