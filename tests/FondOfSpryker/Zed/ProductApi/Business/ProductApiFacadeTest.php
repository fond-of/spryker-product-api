<?php

namespace FondOfSpryker\Zed\ProductApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ProductApi\Business\Model\ProductApi;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;

class ProductApiFacadeTest extends Unit
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
     * @var \FondOfSpryker\Zed\ProductApi\Business\Model\ProductApi|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productApiMock;

    /**
     * @var \FondOfSpryker\Zed\ProductApi\Business\ProductApiBusinessFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $factoryMock;

    /**
     * @var \FondOfSpryker\Zed\ProductApi\Business\ProductApiFacade
     */
    protected $facade;

    /**
     * return void
     *
     * @return void
     */
    protected function _before(): void
    {
        $this->apiDataTransferMock = $this->getMockBuilder(ApiDataTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder(ApiItemTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productApiMock = $this->getMockBuilder(ProductApi::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factoryMock = $this->getMockBuilder(ProductApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facade = new ProductApiFacade();
        $this->facade->setFactory($this->factoryMock);
    }

    /**
     * @return void
     */
    public function testAddProduct(): void
    {
        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createProductApi')
            ->willReturn($this->productApiMock);

        $this->productApiMock->expects(static::atLeastOnce())
            ->method('add')
            ->with($this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->facade->addProduct($this->apiDataTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testUpdateProduct(): void
    {
        $id = '214_123';

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createProductApi')
            ->willReturn($this->productApiMock);

        $this->productApiMock->expects(static::atLeastOnce())
            ->method('update')
            ->with($id, $this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->facade->updateProduct($id, $this->apiDataTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGetProductAbstractBySku(): void
    {
        $id = '214_123';

        $this->factoryMock->expects(static::atLeastOnce())
            ->method('createProductApi')
            ->willReturn($this->productApiMock);

        $this->productApiMock->expects(static::atLeastOnce())
            ->method('getBySku')
            ->with($id)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->facade->getProduct($id),
        );
    }
}
