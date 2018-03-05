<?php

namespace FondOfSpryker\Zed\ProductApi\Business\Model;

use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\ProductApi\Business\Mapper\EntityMapperInterface;
use Spryker\Zed\ProductApi\Business\Mapper\TransferMapperInterface;
use Spryker\Zed\ProductApi\Business\Model\ProductApi as BaseProductApi;
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface;
use Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiInterface;
use Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiQueryBuilderInterface;
use Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainerInterface;

class ProductApi extends BaseProductApi
{
    /**
     * @param \Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiInterface $apiQueryContainer
     * @param \Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiQueryBuilderInterface $apiQueryBuilderQueryContainer
     * @param \Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\ProductApi\Business\Mapper\EntityMapperInterface $entityMapper
     * @param \Spryker\Zed\ProductApi\Business\Mapper\TransferMapperInterface $transferMapper
     * @param \Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface $productFacade
     */
    public function __construct(
        ProductApiToApiInterface $apiQueryContainer,
        ProductApiToApiQueryBuilderInterface $apiQueryBuilderQueryContainer,
        ProductApiQueryContainerInterface $queryContainer,
        EntityMapperInterface $entityMapper,
        TransferMapperInterface $transferMapper,
        ProductApiToProductInterface $productFacade
    ) {
        $this->apiQueryContainer = $apiQueryContainer;
        $this->apiQueryBuilderQueryContainer = $apiQueryBuilderQueryContainer;
        $this->queryContainer = $queryContainer;
        $this->entityMapper = $entityMapper;
        $this->transferMapper = $transferMapper;
        $this->productFacade = $productFacade;
    }

    /**
     * @param string $identifierProduct
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotFoundException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update($identifierProduct, ApiDataTransfer $apiDataTransfer)
    {
        $entityToUpdate = $this->queryContainer
            ->queryFind()
            ->filterBySku($identifierProduct)
            ->findOne();

        if (!$entityToUpdate) {
            throw new EntityNotFoundException(sprintf('Product not found: %s', $identifierProduct));
        }

        $data = (array)$apiDataTransfer->getData();
        $productAbstractTransfer = new ProductAbstractTransfer();
        $productAbstractTransfer->setIdProductAbstract($entityToUpdate->getIdProductAbstract());
        $productAbstractTransfer->fromArray($data, true);

        $productConcreteCollection = [];
        if (!isset($data['product_concretes'])) {
            $data['product_concretes'] = [];
        }
        foreach ($data['product_concretes'] as $productConcrete) {
            $productConcreteCollection[] = (new ProductConcreteTransfer())->fromArray($productConcrete, true);
        }

        $idProductAbstract = $this->productFacade->saveProduct($productAbstractTransfer, $productConcreteCollection);
        
        return $this->get($idProductAbstract);
    }
}
