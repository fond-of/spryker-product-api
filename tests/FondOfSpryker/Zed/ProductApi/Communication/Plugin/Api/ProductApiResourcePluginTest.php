<?php

namespace FondOfSprykerTest\Zed\ProductApi\Communication\Plugin\Api;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ProductApi\Business\ProductApiFacade;
use FondOfSpryker\Zed\ProductApi\Communication\Plugin\Api\ProductApiResourcePlugin;

class ProductApiResourcePluginTest extends Unit
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
     * @var \FondOfSpryker\Zed\ProductApi\Business\ProductApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productApiFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\ProductApi\Communication\Plugin\Api\ProductApiResourcePlugin|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productApiResourcePlugin;

    /**
     * @return void
     */
    public function _before()
    {
        $this->apiDataTransferMock = $this->getMockBuilder('\Generated\Shared\Transfer\ApiDataTransfer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiItemTransferMock = $this->getMockBuilder('\Generated\Shared\Transfer\ApiItemTransfer')
            ->disableOriginalConstructor()
            ->getMock();

        $this->productApiFacadeMock = $this->getMockBuilder(ProductApiFacade::class)
            ->disableOriginalConstructor()
            ->setMethods(['getProductAbstractBySku', 'updateProduct'])
            ->getMock();
    }

    /**
     * @return void
     */
    public function testUpdate()
    {
        $skuProductAbstract = '214_123';

        $this->productApiFacadeMock->expects($this->atLeastOnce())
            ->method('updateProduct')
            ->willReturn($this->apiItemTransferMock);

        $productApiResourcePlugin = new ProductApiResourcePlugin();
        $productApiResourcePlugin->setFacade($this->productApiFacadeMock);
        $product = $productApiResourcePlugin->update($skuProductAbstract, $this->apiDataTransferMock);

        $this->assertInstanceOf('\Generated\Shared\Transfer\ApiItemTransfer', $product);
    }

    /**
     * @return void
     */
    public function testGet()
    {
        $this->productApiFacadeMock->expects($this->atLeastOnce())
            ->method('getProductAbstractBySku')
            ->willReturn($this->apiItemTransferMock);

        $productApiResourcePlugin = new ProductApiResourcePlugin();
        $productApiResourcePlugin->setFacade($this->productApiFacadeMock);

        $product = $productApiResourcePlugin->get('SKU');

        $this->assertInstanceOf('\Generated\Shared\Transfer\ApiItemTransfer', $product);
    }
}
