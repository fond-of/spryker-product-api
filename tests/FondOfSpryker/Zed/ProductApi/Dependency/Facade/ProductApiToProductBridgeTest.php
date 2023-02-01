<?php

namespace FondOfSpryker\Zed\ProductApi\Dependency\Facade;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\ProductAbstractTransfer;
use Spryker\Zed\Product\Business\ProductFacade;

class ProductApiToProductBridgeTest extends Unit
{
    /**
     * @var \Spryker\Zed\Product\Business\ProductFacade|\PHPUnit\Framework\MockObject\MockObject|null
     */
    protected $facadeMock;

    /**
     * @var \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected $productAbstractTransferMock;

    /**
     * @var \FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge
     */
    protected $bridge;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->productAbstractTransferMock = $this->getMockBuilder(ProductAbstractTransfer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->facadeMock = $this->getMockBuilder(ProductFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->bridge = new ProductApiToProductBridge($this->facadeMock);
    }

    /**
     * @return void
     */
    public function testAddProduct(): void
    {
        $idProductAbstract = 1;

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('addProduct')
            ->with($this->productAbstractTransferMock, [])
            ->willReturn($idProductAbstract);

        static::assertEquals(
            $idProductAbstract,
            $this->bridge->addProduct($this->productAbstractTransferMock, []),
        );
    }

    /**
     * @return void
     */
    public function testFindProductAbstractBySku(): void
    {
        $idProductAbstract = 1;
        $sku = '1234_1234';

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('findProductAbstractIdBySku')
            ->with($sku)
            ->willReturn($idProductAbstract);

        $this->facadeMock->expects(static::atLeastOnce())
            ->method('findProductAbstractById')
            ->with($idProductAbstract)
            ->willReturn($this->productAbstractTransferMock);

        static::assertEquals(
            $this->productAbstractTransferMock,
            $this->bridge->findProductAbstractBySku($sku),
        );
    }

    /**
     * @return void
     */
    public function testGetConcreteProductsByAbstractProductId(): void
    {
        $idProductAbstract = 1;
        $concreteProducts = [];

         $this->facadeMock->expects(static::atLeastOnce())
             ->method('getConcreteProductsByAbstractProductId')
             ->with($idProductAbstract)
             ->willReturn($concreteProducts);

        static::assertEquals(
            $concreteProducts,
            $this->bridge->getConcreteProductsByAbstractProductId($idProductAbstract),
        );
    }
}
