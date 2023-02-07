<?php

namespace FondOfSpryker\Zed\ProductApi\Business\Model;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface;
use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreBridge;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Orm\Zed\Product\Persistence\SpyProductAbstract;
use Orm\Zed\Product\Persistence\SpyProductAbstractQuery;
use Spryker\Zed\ProductApi\Business\Mapper\EntityMapperInterface;
use Spryker\Zed\ProductApi\Business\Mapper\TransferMapperInterface;
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToApiFacadeInterface;
use Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiQueryBuilderInterface;
use Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainerInterface;

class ProductApiTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\ApiDataTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiDataTransferMock;

    /**
     * @var \Generated\Shared\Transfer\ApiItemTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiItemTransferMock;

    /**
     * @var \Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiQueryBuilderInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiQueryBuilderQueryContainerMock;

    /**
     * @var \Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiFacadeMock;

    /**
     * @var \Spryker\Zed\ProductApi\Business\Mapper\EntityMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $entityMapperMock;

    /**
     * @var \Orm\Zed\Product\Persistence\SpyProductAbstractQuery|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $spyProductAbstractMock;

    /**
     * @var \Orm\Zed\Product\Persistence\SpyProductAbstractQuery|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $spyProductAbstractQueryMock;

    /**
     * @var \Generated\Shared\Transfer\ProductAbstractTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productAbstractTransferMock;

    /**
     * @var \Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productFacadeMock;

    /**
     * @var \Spryker\Zed\ProductApi\Business\Mapper\TransferMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $transferMapperMock;

    /**
     * @var \Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainerInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $queryContainerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $productConcreteTransferMock;

    /**
     * @var \FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\ProductApi\Business\Model\ProductApi
     */
    protected $productApi;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiQueryBuilderQueryContainerMock = $this->getMockBuilder(ProductApiToApiQueryBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiFacadeMock = $this->getMockBuilder(ProductApiToApiFacadeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityMapperMock = $this->getMockBuilder(EntityMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productConcreteTransferMock = $this->getMockBuilder(ProductConcreteTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productFacadeMock = $this->getMockBuilder(ProductApiToProductInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spyProductAbstractMock = $this->getMockBuilder(SpyProductAbstract::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->spyProductAbstractQueryMock = $this->getMockBuilder(SpyProductAbstractQuery::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferMapperMock = $this->getMockBuilder(TransferMapperInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->queryContainerMock = $this->getMockBuilder(ProductApiQueryContainerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeFacadeMock = $this->getMockBuilder(ProductApiToStoreBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productApi = new ProductApi(
            $this->apiFacadeMock,
            $this->apiQueryBuilderQueryContainerMock,
            $this->queryContainerMock,
            $this->entityMapperMock,
            $this->transferMapperMock,
            $this->productFacadeMock,
            $this->storeFacadeMock,
        );
    }

    /**
     * @return void
     */
    public function testAdd(): void
    {
        $transferData = [
            'sku' => '214_123',
            'attributes' => [],
            'product_concretes' => [],
            'id_tax_set' => 1,
        ];

        $this->apiDataTransferMock->expects(static::atLeastOnce())
            ->method('getData')
            ->willReturn($transferData);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('addProduct')
            ->willReturn(1);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('findProductAbstractById')
            ->willReturn($this->productAbstractTransferMock);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('getConcreteProductsByAbstractProductId')
            ->willReturn([$this->productConcreteTransferMock]);

        $this->productConcreteTransferMock
            ->method('toArray')
            ->willReturn(['stocks' => []]);

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(1);

        $this->apiFacadeMock->expects(static::atLeastOnce())
            ->method('createApiItem')
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->productApi->add($this->apiDataTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $idProductAbstract = 214;
        $identifierProduct = '214_123';
        $transferData = [
            'sku' => '214_123',
            'attributes' => [],
            'product_concretes' => [],
            'id_tax_set' => 1,
        ];

        $this->queryContainerMock->expects(static::atLeastOnce())
            ->method('queryFind')
            ->willReturn($this->spyProductAbstractQueryMock);

        $this->spyProductAbstractQueryMock->expects(static::atLeastOnce())
            ->method('filterBySku')
            ->willReturn($this->spyProductAbstractQueryMock);

        $this->spyProductAbstractQueryMock->expects(static::atLeastOnce())
            ->method('findOne')
            ->willReturn($this->spyProductAbstractMock);

        $this->apiDataTransferMock->expects(static::atLeastOnce())
            ->method('getData')
            ->willReturn($transferData);

        $this->spyProductAbstractMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn($idProductAbstract);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('getConcreteProductsByAbstractProductId')
            ->willReturn([$this->productConcreteTransferMock]);

        $this->productConcreteTransferMock
            ->method('toArray')
            ->willReturn(['stocks' => []]);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('saveProduct')
            ->willReturn(1);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('findProductAbstractById')
            ->willReturn($this->productAbstractTransferMock);

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn($idProductAbstract);

        $this->apiFacadeMock->expects(static::atLeastOnce())
            ->method('createApiItem')
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->productApi->update($identifierProduct, $this->apiDataTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdateWithoutEntityToUpdate(): void
    {
        $sku = '214_123';

        $this->queryContainerMock->expects(static::atLeastOnce())
            ->method('queryFind')
            ->willReturn($this->spyProductAbstractQueryMock);

        $this->spyProductAbstractQueryMock->expects(static::atLeastOnce())
            ->method('filterBySku')
            ->willReturn($this->spyProductAbstractQueryMock);

        $this->spyProductAbstractQueryMock->expects(static::atLeastOnce())
            ->method('findOne')
            ->willReturn(null);

        $this->expectExceptionMessage('Product not found: 214_123');

        $this->productApi->update($sku, $this->apiDataTransferMock);
    }

    /**
     * @return void
     */
    public function testGetBySku(): void
    {
        $this->apiFacadeMock->expects(static::atLeastOnce())
            ->method('createApiItem')
            ->willReturn($this->apiItemTransferMock);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('findProductAbstractIdBySku')
            ->willReturn(1);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('findProductAbstractById')
            ->willReturn($this->productAbstractTransferMock);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('findProductAbstractById')
            ->willReturn($this->productAbstractTransferMock);

        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('getConcreteProductsByAbstractProductId')
            ->willReturn([$this->productConcreteTransferMock]);

        $this->productConcreteTransferMock
            ->method('toArray')
            ->willReturn(['stocks' => []]);

        $this->productAbstractTransferMock->expects(static::atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(1);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->productApi->getBySku('SKU'),
        );
    }

    /**
     * @return void
     */
    public function testGetBySkuWithoutEntityToUpdate(): void
    {
        $this->productFacadeMock->expects(static::atLeastOnce())
            ->method('findProductAbstractIdBySku')
            ->willReturn(null);

        $this->expectExceptionMessage('Product not found for sku SKU');

        $this->productApi->getBySku('SKU');
    }
}
