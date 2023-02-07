<?php

namespace FondOfSpryker\Zed\ProductApi\Communication\Plugin\Api;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ProductApi\Business\ProductApiFacade;
use Generated\Shared\Transfer\ApiDataTransfer;
use Generated\Shared\Transfer\ApiItemTransfer;

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
     * @var \FondOfSpryker\Zed\ProductApi\Business\ProductApiFacade|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productApiFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\ProductApi\Communication\Plugin\Api\ProductApiResourcePlugin
     */
    protected $plugin;

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

        $this->productApiFacadeMock = $this->getMockBuilder(ProductApiFacade::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->plugin = new ProductApiResourcePlugin();
        $this->plugin->setFacade($this->productApiFacadeMock);
    }

    /**
     * @return void
     */
    public function testUpdate(): void
    {
        $sku = '214_123';

        $this->productApiFacadeMock->expects($this->atLeastOnce())
            ->method('updateProduct')
            ->with($sku, $this->apiDataTransferMock)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals(
            $this->apiItemTransferMock,
            $this->plugin->update($sku, $this->apiDataTransferMock),
        );
    }

    /**
     * @return void
     */
    public function testGet(): void
    {
        $sku = '214_123';

        $this->productApiFacadeMock->expects($this->atLeastOnce())
            ->method('getProduct')
            ->with($sku)
            ->willReturn($this->apiItemTransferMock);

        static::assertEquals($this->apiItemTransferMock, $this->plugin->get($sku));
    }
}
