<?php

namespace FondOfSprykerTest\Zed\ProductApi\Business\Model;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ProductApi\Business\Model\ProductApi;
use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductInterface;
use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreBridge;
use Generated\Shared\Transfer\ProductConcreteTransfer;
use Spryker\Zed\ProductApi\Business\Mapper\EntityMapperInterface;
use Spryker\Zed\ProductApi\Business\Mapper\TransferMapperInterface;
use Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiInterface;
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
     * @var \Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiQueryContainerMock;

    /**
     * @var \Spryker\Zed\ProductApi\Business\Mapper\EntityMapperInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $entityMapperMock;

    /**
     * @var Orm\Zed\Product\Persistence\SpyProductAbstractQuery|\PHPUnit\Framework\MockObject\MockObject
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
     * @var ProductApiToStoreBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeFacadeMock;

    /**
     * @return void
     */
    public function _before()
    {
        $this->apiDataTransferMock = $this->getMockBuilder('\Generated\Shared\Transfer\ApiDataTransfer')
            ->disableOriginalConstructor()
            ->setMethods(['getData'])
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder('\Generated\Shared\Transfer\ApiItemTransfer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiQueryBuilderQueryContainerMock = $this->getMockBuilder(ProductApiToApiQueryBuilderInterface::class)
            ->getMock();

        $this->apiQueryContainerMock = $this->getMockBuilder(ProductApiToApiInterface::class)
            ->setMethods(['queryFind', 'createApiCollection', 'createApiItem'])
            ->getMock();

        $this->entityMapperMock = $this->getMockBuilder(EntityMapperInterface::class)
            ->getMock();

        $this->productAbstractTransferMock = $this->getMockBuilder('\Generated\Shared\Transfer\ProductAbstractTransfer')
            ->disableOriginalConstructor()
            ->setMethods(['setIdProductAbstract', 'fromArray', 'setProductConcretes', 'getIdProductAbstract'])
            ->getMock();

        $this->productConcreteTransferMock = $this->getMockBuilder(ProductConcreteTransfer::class)
            ->disableOriginalConstructor()
            ->setMethods(['toArray'])
            ->getMock();

        $this->productConcreteTransferMock
            ->method('toArray')
            ->willReturn(['stocks' => []]);

        $this->productFacadeMock = $this->getMockBuilder(ProductApiToProductInterface::class)
            ->setMethods(['addProduct', 'get', 'findProductConcreteIdBySku', 'getConcreteProductsByAbstractProductId', 'findProductAbstractById', 'findProductAbstractIdBySku', 'findProductAbstractBySku', 'touchProductAbstract', 'saveProduct'])
            ->getMock();

        $this->spyProductAbstractQueryMock = $this->getMockBuilder('Orm\Zed\Product\Persistence\SpyProductAbstractQuery')
            ->disableOriginalConstructor()
            ->setMethods(['filterBySku', 'findOne', 'getIdProductAbstract'])
            ->getMock();

        $this->transferMapperMock = $this->getMockBuilder(TransferMapperInterface::class)
            ->getMock();

        $this->queryContainerMock = $this->getMockBuilder(ProductApiQueryContainerInterface::class)
            ->setMethods(['queryFind', 'queryGet', 'queryRemove', 'getConnection'])
            ->getMock();

        $this->storeFacadeMock = $this->getMockBuilder(ProductApiToStoreBridge::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return void
     */
    public function testAdd()
    {
        $transferData = [
            'sku' => '214_123',
            'attributes' => [],
            'product_concretes' => [],
            'id_tax_set' => 1,
        ];

        $this->apiDataTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn($transferData);

        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method('addProduct')
            ->willReturn(1);

        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method('findProductAbstractById')
            ->willReturn($this->productAbstractTransferMock);

        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method('getConcreteProductsByAbstractProductId')
            ->willReturn([$this->productConcreteTransferMock]);

        $this->productAbstractTransferMock->expects($this->atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(1);

        $this->apiQueryContainerMock->expects($this->atLeastOnce())
            ->method('createApiItem')
            ->willReturn($this->apiItemTransferMock);

        $productApi = new ProductApi(
            $this->apiQueryContainerMock,
            $this->apiQueryBuilderQueryContainerMock,
            $this->queryContainerMock,
            $this->entityMapperMock,
            $this->transferMapperMock,
            $this->productFacadeMock,
            $this->storeFacadeMock
        );

        $product = $productApi->add($this->apiDataTransferMock);

        $this->assertInstanceOf('\Generated\Shared\Transfer\ApiItemTransfer', $product);
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $identifierProduct = '214_123';
        $transferData = [
            'sku' => '214_123',
            'attributes' => [],
            'product_concretes' => [],
            'id_tax_set' => 1,
        ];

        $this->spyProductAbstractQueryMock->expects($this->atLeastOnce())
            ->method('filterBySku')
            ->willReturn($this->spyProductAbstractQueryMock);

        $this->spyProductAbstractQueryMock->expects($this->atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(214);

        $this->spyProductAbstractQueryMock->expects($this->atLeastOnce())
            ->method('findOne')
            ->willReturn($this->spyProductAbstractQueryMock);

        $this->queryContainerMock->expects($this->atLeastOnce())
            ->method('queryFind')
            ->willReturn($this->spyProductAbstractQueryMock);

        $this->apiQueryContainerMock->expects($this->atLeastOnce())
            ->method('createApiItem')
            ->willReturn($this->apiItemTransferMock);

        $this->apiDataTransferMock->expects($this->atLeastOnce())
            ->method('getData')
            ->willReturn($transferData);

        $this->productAbstractTransferMock->expects($this->atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(1);

        $this->productAbstractTransferMock->expects($this->any())
            ->method('setIdProductAbstract')
            ->willReturn($this->productAbstractTransferMock);

        $this->productAbstractTransferMock->expects($this->any())
            ->method('fromArray')
            ->willReturn($this->productAbstractTransferMock);

        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method('findProductAbstractById')
            ->willReturn($this->productAbstractTransferMock);

        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method('getConcreteProductsByAbstractProductId')
            ->willReturn([$this->productConcreteTransferMock]);

        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method('saveProduct')
            ->willReturn(1);

        $productApi = new ProductApi(
            $this->apiQueryContainerMock,
            $this->apiQueryBuilderQueryContainerMock,
            $this->queryContainerMock,
            $this->entityMapperMock,
            $this->transferMapperMock,
            $this->productFacadeMock,
            $this->storeFacadeMock
        );

        $product = $productApi->update($identifierProduct, $this->apiDataTransferMock);

        $this->assertInstanceOf('\Generated\Shared\Transfer\ApiItemTransfer', $product);
    }

    /**
     * @return void
     */
    public function testUpdateWithoutEntityToUpdate()
    {
        $sku = '214_123';

        $this->queryContainerMock->expects($this->atLeastOnce())
            ->method('queryFind')
            ->willReturn($this->spyProductAbstractQueryMock);

        $this->spyProductAbstractQueryMock->expects($this->atLeastOnce())
            ->method('filterBySku')
            ->willReturn($this->spyProductAbstractQueryMock);

        $this->spyProductAbstractQueryMock->expects($this->atLeastOnce())
            ->method('findOne')
            ->willReturn('');

        $this->expectExceptionMessage('Product not found: 214_123');

        $productApi = new ProductApi(
            $this->apiQueryContainerMock,
            $this->apiQueryBuilderQueryContainerMock,
            $this->queryContainerMock,
            $this->entityMapperMock,
            $this->transferMapperMock,
            $this->productFacadeMock,
            $this->storeFacadeMock
        );

        $productApi->update($sku, $this->apiDataTransferMock);
    }

    /**
     * @return void
     */
    public function testGetBySku()
    {
        $this->apiQueryContainerMock->expects($this->atLeastOnce())
            ->method('createApiItem')
            ->willReturn($this->apiItemTransferMock);

        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method('findProductAbstractIdBySku')
            ->willReturn(1);

        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method('findProductAbstractById')
            ->willReturn($this->productAbstractTransferMock);

        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method('findProductAbstractById')
            ->willReturn($this->productAbstractTransferMock);

        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method('getConcreteProductsByAbstractProductId')
            ->willReturn([$this->productConcreteTransferMock]);

        $this->productAbstractTransferMock->expects($this->atLeastOnce())
            ->method('getIdProductAbstract')
            ->willReturn(1);

        $productApi = new ProductApi(
            $this->apiQueryContainerMock,
            $this->apiQueryBuilderQueryContainerMock,
            $this->queryContainerMock,
            $this->entityMapperMock,
            $this->transferMapperMock,
            $this->productFacadeMock,
            $this->storeFacadeMock
        );

        $product = $productApi->getBySku('SKU');

        $this->assertInstanceOf('\Generated\Shared\Transfer\ApiItemTransfer', $product);
    }

    /**
     * @return void
     */
    public function testGetBySkuWithoutEntityToUpdate()
    {
        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method('findProductAbstractIdBySku')
            ->willReturn(null);

        $this->expectExceptionMessage('Product not found for sku SKU');

        $productApi = new ProductApi(
            $this->apiQueryContainerMock,
            $this->apiQueryBuilderQueryContainerMock,
            $this->queryContainerMock,
            $this->entityMapperMock,
            $this->transferMapperMock,
            $this->productFacadeMock,
            $this->storeFacadeMock
        );

        $productApi->getBySku('SKU');
    }
}
