<?php

namespace FondOfSpryker\Zed\ProductApi\Business\Model;

use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface;
use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreInterface;
use Generated\Shared\Transfer\ApiCollectionTransfer;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ApiRequestTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractStoreTableMap;
use Orm\Zed\Product\Persistence\Map\SpyProductAbstractTableMap;
use Propel\Runtime\ActiveQuery\Criteria;
use Spryker\Zed\Api\Business\Exception\EntityNotFoundException;
use Spryker\Zed\ProductApi\Business\Mapper\EntityMapperInterface;
use Spryker\Zed\ProductApi\Business\Mapper\TransferMapperInterface;
use Spryker\Zed\ProductApi\Business\Model\ProductApi as SprykerProductApi;
use Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiInterface;
use Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiQueryBuilderInterface;
use Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainerInterface;

class ProductApi extends SprykerProductApi
{
    /**
     * @var \FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface
     */
    protected $productFacade;

    /**
     * @var \FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreInterface
     */
    protected $storeFacade;

    /**
     * @param \Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiInterface $apiQueryContainer
     * @param \Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiQueryBuilderInterface $apiQueryBuilderQueryContainer
     * @param \Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\ProductApi\Business\Mapper\EntityMapperInterface $entityMapper
     * @param \Spryker\Zed\ProductApi\Business\Mapper\TransferMapperInterface $transferMapper
     * @param \FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface $productFacade
     * @param \FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreInterface $storeFacade
     */
    public function __construct(
        ProductApiToApiInterface $apiQueryContainer,
        ProductApiToApiQueryBuilderInterface $apiQueryBuilderQueryContainer,
        ProductApiQueryContainerInterface $queryContainer,
        EntityMapperInterface $entityMapper,
        TransferMapperInterface $transferMapper,
        ProductApiToProductInterface $productFacade,
        ProductApiToStoreInterface $storeFacade
    ) {
        parent::__construct(
            $apiQueryContainer,
            $apiQueryBuilderQueryContainer,
            $queryContainer,
            $entityMapper,
            $transferMapper,
            $productFacade
        );

        $this->storeFacade = $storeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function add(ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        $data = (array)$apiDataTransfer->getData();

        $productAbstractTransfer = new ProductAbstractTransfer();
        $productAbstractTransfer->fromArray($data, true);

        $productConcreteCollection = [];
        if (!isset($data['product_concretes'])) {
            $data['product_concretes'] = [];
        }
        foreach ($data['product_concretes'] as $productConcrete) {
            $productConcreteCollection[] = (new ProductConcreteTransfer())->fromArray($productConcrete, true);
        }

        $idProductAbstract = $this->productFacade->addProduct($productAbstractTransfer, $productConcreteCollection);

        $this->productFacade->touchProductAbstract($idProductAbstract);

        return $this->get($idProductAbstract);
    }

    /**
     * @param string $sku
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotFoundException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update($sku, ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        $entityToUpdate = $this->queryContainer
            ->queryFind()
            ->filterBySku($sku)
            ->findOne();

        if (!$entityToUpdate) {
            throw new EntityNotFoundException(sprintf('Product not found: %s', $sku));
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
            $idProductConcrete = $this->productFacade->findProductConcreteIdBySku($productConcrete['sku']);

            if ($idProductConcrete) {
                $productConcrete['id_product_concrete'] = $idProductConcrete;
            }

            $productConcreteCollection[] = (new ProductConcreteTransfer())->fromArray($productConcrete, true);
        }

        $idProductAbstract = $this->productFacade->saveProduct($productAbstractTransfer, $productConcreteCollection);

        $this->productFacade->touchProductAbstract($idProductAbstract);

        return $this->get($idProductAbstract);
    }

    /**
     * @param \Generated\Shared\Transfer\ApiRequestTransfer $apiRequestTransfer
     *
     * @return \Generated\Shared\Transfer\ApiCollectionTransfer
     */
    public function find(ApiRequestTransfer $apiRequestTransfer): ApiCollectionTransfer
    {
        $query = $this->buildQuery($apiRequestTransfer);

        // force limit of -1 if is set
        $queryData = $apiRequestTransfer->getQueryData();

        if (array_key_exists('limit', $queryData) && $queryData['limit'] == -1) {
            $query->setOffset(0);
            $query->setLimit(-1);
            $apiRequestTransfer->getFilter()->setLimit($query->count());
        }

        $collection = $this->transferMapper->toTransferCollection(
            $query->addJoin(SpyProductAbstractTableMap::COL_ID_PRODUCT_ABSTRACT, SpyProductAbstractStoreTableMap::COL_FK_PRODUCT_ABSTRACT, Criteria::INNER_JOIN)
            ->where(sprintf('%s = %s', SpyProductAbstractStoreTableMap::COL_FK_STORE, $this->storeFacade->getCurrentStore()->getIdStore()))
            ->withColumn(SpyProductAbstractStoreTableMap::COL_FK_STORE, 'id_store')
            ->find()
            ->toArray()
        );

        foreach ($collection as $k => $productApiTransfer) {
            if (array_key_exists('fields', $queryData) && !empty($queryData['fields'])) {
                $collection[$k] = $productApiTransfer->toArray();
            } else {
                $collection[$k] = $this->get($productApiTransfer->getIdProductAbstract())->getData();
            }
        }

        $apiCollectionTransfer = $this->apiQueryContainer->createApiCollection($collection);

        $apiCollectionTransfer = $this->addPagination($query, $apiCollectionTransfer, $apiRequestTransfer);

        return $apiCollectionTransfer;
    }

    /**
     * @param int $idProductAbstract
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotFoundException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function get($idProductAbstract): ApiItemTransfer
    {
        $productTransfer = $this->productFacade->findProductAbstractById($idProductAbstract);
        if (!$productTransfer) {
            throw new EntityNotFoundException(sprintf('Product Abstract not found for id %s', $idProductAbstract));
        }

        $productConcreteCollection = [];
        $productConcretes = $this->productFacade
            ->getConcreteProductsByAbstractProductId($productTransfer->getIdProductAbstract());

        foreach ($productConcretes as $productConcrete) {
            $productConcreteArray = $productConcrete->toArray();

            foreach ($productConcreteArray['stocks'] as &$stock) {
                $stock['quantity'] = $stock['quantity']->toInt();
            }

            $productConcreteCollection[] = $productConcreteArray;
        }

        $productTransfer->setProductConcretes($productConcreteCollection);

        return $this->apiQueryContainer->createApiItem($productTransfer, $idProductAbstract);
    }

    /**
     * @param string $skuProductAbstract
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotFoundException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function getBySku($skuProductAbstract): ApiItemTransfer
    {
        $idProductAbstract = $this->productFacade->findProductAbstractIdBySku($skuProductAbstract);

        if (!$idProductAbstract) {
            throw new EntityNotFoundException(sprintf('Product not found for sku %s', $skuProductAbstract));
        }

        return $this->get($idProductAbstract);
    }
}
