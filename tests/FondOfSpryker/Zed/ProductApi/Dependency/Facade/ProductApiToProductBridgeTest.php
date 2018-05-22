<?php

namespace FondOfSprykerTest\Zed\ProductApi;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge;
use Spryker\Zed\Product\Business\ProductFacade;

class ProductApiToProductBridgeTest extends Unit
{
    /**
     * @var \Spryker\Zed\Product\Business\ProductFacade|\PHPUnit\Framework\MockObject\MockObject|null
     */
    protected $productFacadeMock;

    /**
     * @var \Generated\Shared\Transfer\ProductAbstractTransfer
     */
    protected $productAbstractTransferMock;

    /**
     * @return void
     */
    public function _before()
    {
        $this->productAbstractTransferMock = $this->getMockBuilder("\Generated\Shared\Transfer\ProductAbstractTransfer")
            ->disableOriginalConstructor()
            ->getMock();

        $this->productFacadeMock = $this->getMockBuilder(ProductFacade::class)
            ->disableOriginalConstructor()
            ->setMethods(['addProduct', 'getConcreteProductsByAbstractProductId', 'findProductAbstractIdBySku', 'findProductAbstractById'])
            ->getMock();
    }

    /**
     * @return void
     */
    public function testAddProduct()
    {
        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method("addProduct")
            ->willReturn(1);

        $productApitToProductBridge = new ProductApiToProductBridge($this->productFacadeMock);
        $idProductAbstract = $productApitToProductBridge->addProduct($this->productAbstractTransferMock, []);

        $this->assertTrue(is_int($idProductAbstract));
        $this->assertEquals(1, $idProductAbstract);
    }

    /**
     * @return void
     */
    public function testFindProductAbstractBySku()
    {
        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method("findProductAbstractIdBySku")
            ->willReturn("SKU");

        $this->productFacadeMock->expects($this->atLeastOnce())
            ->method("findProductAbstractById")
            ->willReturn($this->productAbstractTransferMock);

        $productApitToProductBridge = new ProductApiToProductBridge($this->productFacadeMock);

        $product = $productApitToProductBridge->findProductAbstractBySku("SKU");

        $this->assertNotNull($product);
        $this->assertInstanceOf("\Generated\Shared\Transfer\ProductAbstractTransfer", $product);
    }

    /**
     * @return void
     */
    public function testGetConcreteProductsByAbstractProductId()
    {
         $this->productFacadeMock->expects($this->atLeastOnce())
             ->method("getConcreteProductsByAbstractProductId")
             ->willReturn([]);

        $productApitToProductBridge = new ProductApiToProductBridge($this->productFacadeMock);
        $productConcreteTransferObjects = $productApitToProductBridge->getConcreteProductsByAbstractProductId(1);

        $this->assertTrue(is_array($productConcreteTransferObjects));
    }
}
