<?php

namespace FondOfSprykerTest\Zed\ProductApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ProductApi\Business\Model\ProductApi;
use FondOfSpryker\Zed\ProductApi\Business\ProductApiBusinessFactory;
use FondOfSpryker\Zed\ProductApi\ProductApiDependencyProvider;
use Spryker\Zed\Kernel\AbstractBundleConfig;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductApi\Business\Mapper\EntityMapper;
use Spryker\Zed\ProductApi\Business\Mapper\TransferMapper;
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge;
use Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiBridge as QueryContainerProductApiToProductBridge;
use Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiQueryBuilderBridge;
use Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainer;

class ProductApiBusinessFactoryTest extends Unit
{
    /**
     * @var \Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiQueryContainerMock;

    /**
     * @var \Spryker\Zed\Kernel\AbstractBundleConfig|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $configMock;

    /**
     * @var \Spryker\Zed\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $containerMock;
    
    /**
     * @var \Spryker\Zed\ProductApi\Business\Mapper\EntityMapper|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $entityMapperMock;

    /**
     * @var \Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiQueryBuilderBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productApiToApiQueryBuilderBridgeMock;

    /**
     * @var \Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productApiQueryContainerMock;

    /**
     * @var \Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $productFacadeMock;

    /**
     * @var \Spryker\Zed\ProductApi\Business\Mapper\TransferMapper|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $transferMapperMock;

    /**
     * @var \org\bovigo\vfs\vfsStreamDirectory
     */
    protected $vfsStreamDirectory;

    /**
     * @return void
     */
    public function _before()
    {
        $this->configMock = $this->getMockBuilder(AbstractBundleConfig::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $this->apiQueryContainerMock = $this->getMockBuilder(QueryContainerProductApiToProductBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->containerMock = $this->getMockBuilder(Container::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->entityMapperMock = $this->getMockBuilder(EntityMapper::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productApiToApiQueryBuilderBridgeMock = $this->getMockBuilder(ProductApiToApiQueryBuilderBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productFacadeMock = $this->getMockBuilder(ProductApiToProductBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->productApiQueryContainerMock = $this->getMockBuilder(ProductApiQueryContainer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferMapperMock = $this->getMockBuilder(TransferMapper::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return void
     */
    public function testCreateProductApi()
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('offsetExists')
            ->willReturn(true);

        $this->containerMock->expects($this->atLeastOnce())
            ->method('offsetGet')
            ->withConsecutive(
                [ProductApiDependencyProvider::QUERY_CONTAINER_API],
                [ProductApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER],
                [ProductApiDependencyProvider::FACADE_PRODUCT]
            )->willReturnOnConsecutiveCalls(
                $this->apiQueryContainerMock,
                $this->productApiToApiQueryBuilderBridgeMock,
                $this->productFacadeMock
            );

        $productBusinessFactory = new ProductApiBusinessFactory();
        $productBusinessFactory
            ->setConfig($this->configMock)
            ->setContainer($this->containerMock)
            ->setQueryContainer($this->productApiQueryContainerMock);

        $productApi = $productBusinessFactory->createProductApi();
        
        $this->assertInstanceOf(ProductApi::class, $productApi);
    }
}
