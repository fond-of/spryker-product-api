<?php

namespace FondOfSpryker\Zed\ProductApi\Business\Model;

use Exception;
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
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToApiFacadeInterface;
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface as BaseProductApiToProductInterface;
use Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiQueryBuilderInterface;
use Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainerInterface;

class ProductApi extends SprykerProductApi
{
    /**
     * @var \FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreInterface
     */
    protected $storeFacade;

    /**
     * @param \Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToApiFacadeInterface $apiFacade
     * @param \Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiQueryBuilderInterface $apiQueryBuilderQueryContainer
     * @param \Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\ProductApi\Business\Mapper\EntityMapperInterface $entityMapper
     * @param \Spryker\Zed\ProductApi\Business\Mapper\TransferMapperInterface $transferMapper
     * @param \Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface $productFacade
     * @param \FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreInterface $storeFacade
     */
    public function __construct(
            ProductApiToApiFacadeInterface $apiFacade,
        ProductApiToApiQueryBuilderInterface $apiQueryBuilderQueryContainer,
        ProductApiQueryContainerInterface $queryContainer,
        EntityMapperInterface $entityMapper,
        TransferMapperInterface $transferMapper,
        BaseProductApiToProductInterface $productFacade,
        ProductApiToStoreInterface $storeFacade
    ) {
        parent::__construct(
            $apiQueryBuilderQueryContainer,
            $queryContainer,
            $entityMapper,
            $transferMapper,
            $productFacade,
            $apiFacade,
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
        if (!($this->productFacade instanceof ProductApiToProductInterface)) {
            return parent::add($apiDataTransfer);
        }

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

        return $this->get($idProductAbstract);
    }

    /**
     * @param string|int $idProductAbstract
     * @param \Generated\Shared\Transfer\ApiDataTransfer $apiDataTransfer
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotFoundException
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function update($idProductAbstract, ApiDataTransfer $apiDataTransfer): ApiItemTransfer
    {
        if (!($this->productFacade instanceof ProductApiToProductInterface) || is_int($idProductAbstract)) {
            return parent::update($idProductAbstract, $apiDataTransfer);
        }

        $entityToUpdate = $this->queryContainer
            ->queryFind()
            ->filterBySku($idProductAbstract)
            ->findOne();

        if (!$entityToUpdate) {
            throw new EntityNotFoundException(sprintf('Product not found: %s', $idProductAbstract));
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
            ->toArray(),
        );

        foreach ($collection as $k => $productApiTransfer) {
            if (array_key_exists('fields', $queryData) && !empty($queryData['fields'])) {
                $collection[$k] = $productApiTransfer->toArray();
            } else {
                $collection[$k] = $this->get($productApiTransfer->getIdProductAbstract())->getData();
            }
        }

        $apiCollectionTransfer = $this->apiFacade->createApiCollection([])->setData($collection);

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
        if (!($this->productFacade instanceof ProductApiToProductInterface)) {
            return parent::get($idProductAbstract);
        }

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

        return $this->apiFacade->createApiItem($productTransfer, (string)$idProductAbstract);
    }

    /**
     * @param string $skuProductAbstract
     *
     * @throws \Spryker\Zed\Api\Business\Exception\EntityNotFoundException
     * @throws \Exception
     *
     * @return \Generated\Shared\Transfer\ApiItemTransfer
     */
    public function getBySku($skuProductAbstract): ApiItemTransfer
    {
        if (!($this->productFacade instanceof ProductApiToProductInterface)) {
            throw new Exception(sprintf('Product facade is not an instance of "%s"', ProductApiToProductInterface::class));
        }

        $idProductAbstract = $this->productFacade->findProductAbstractIdBySku($skuProductAbstract);

        if (!$idProductAbstract) {
            throw new EntityNotFoundException(sprintf('Product not found for sku %s', $skuProductAbstract));
        }

        return $this->get($idProductAbstract);
    }
}
