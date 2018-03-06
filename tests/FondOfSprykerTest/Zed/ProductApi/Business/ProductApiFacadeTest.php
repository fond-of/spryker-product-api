<?php

namespace FondOfSprykerTest\Zed\ProductApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ProductApi\Business\Model\ProductApi;
use FondOfSpryker\Zed\ProductApi\Business\ProductApiBusinessFactory;
use FondOfSpryker\Zed\ProductApi\Business\ProductApiFacade;

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
    protected $productApiBusinessFactoryMock;

    /**
     * return void
     *
     * @return void
     */
    protected function _before()
    {
        $this->apiDataTransferMock = $this->getMockBuilder('\Generated\Shared\Transfer\ApiDataTransfer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder('\Generated\Shared\Transfer\ApiItemTransfer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->productApiMock = $this->getMockBuilder(ProductApi::class)
            ->disableOriginalConstructor()
            ->setMethods(['update'])
            ->getMock();

        $this->productApiBusinessFactoryMock = $this->getMockBuilder(ProductApiBusinessFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['createProductApi'])
            ->getMock();
    }

    /**
     * @return void
     */
    public function testUpdateProduct()
    {
        $identifierProduct = '214_123';

        $this->productApiMock->expects($this->atLeastOnce())
            ->method('update')
            ->willReturn($this->apiItemTransferMock);

        $this->productApiBusinessFactoryMock->expects($this->atLeastOnce())
            ->method('createProductApi')
            ->willReturn($this->productApiMock);

        $productApiFacade = new ProductApiFacade();
        $productApiFacade->setFactory($this->productApiBusinessFactoryMock);
        $product = $productApiFacade->updateProduct($identifierProduct, $this->apiDataTransferMock);

        $this->assertInstanceOf('\Generated\Shared\Transfer\ApiItemTransfer', $product);
    }
}
