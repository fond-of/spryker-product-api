<?php

namespace FondOfSpryker\Zed\ProductApi\Business;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ProductApi\Business\Model\ProductApi;
use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge;
use FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreBridge;
use FondOfSpryker\Zed\ProductApi\ProductApiDependencyProvider;
use Spryker\Zed\Kernel\AbstractBundleConfig;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductApi\Business\Mapper\EntityMapper;
use Spryker\Zed\ProductApi\Business\Mapper\TransferMapper;
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToApiFacadeInterface;
use Spryker\Zed\ProductApi\Dependency\QueryContainer\ProductApiToApiQueryBuilderBridge;
use Spryker\Zed\ProductApi\Persistence\ProductApiQueryContainer;

class ProductApiBusinessFactoryTest extends Unit
{
    /**
     * @var \Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToApiFacadeInterface|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $apiFacadeMock;

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
     * @var \FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge|\PHPUnit\Framework\MockObject\MockObject
     * \MockObject
     */
    protected $productFacadeMock;

    /**
     * @var \Spryker\Zed\ProductApi\Business\Mapper\TransferMapper|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $transferMapperMock;

    /**
     * @var \FondOfSpryker\Zed\ProductApi\Dependency\Facade\ProductApiToStoreBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeFacadeMock;

    /**
     * @var \FondOfSpryker\Zed\ProductApi\Business\ProductApiBusinessFactory
     */
    protected $factory;

    /**
     * @return void
     */
    public function _before(): void
    {
        $this->configMock = $this->getMockBuilder(AbstractBundleConfig::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->apiFacadeMock = $this->getMockBuilder(ProductApiToApiFacadeInterface::class)
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

        $this->storeFacadeMock = $this->getMockBuilder(ProductApiToStoreBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->factory = new ProductApiBusinessFactory();

        $this->factory->setConfig($this->configMock);
        $this->factory->setContainer($this->containerMock);
        $this->factory->setQueryContainer($this->productApiQueryContainerMock);
    }

    /**
     * @return void
     */
    public function testCreateProductApi(): void
    {
        $this->containerMock->expects(static::atLeastOnce())
            ->method('has')
            ->willReturn(true);

        $this->containerMock->expects(static::atLeastOnce())
            ->method('get')
            ->withConsecutive(
                [ProductApiDependencyProvider::FACADE_API],
                [ProductApiDependencyProvider::QUERY_CONTAINER_API_QUERY_BUILDER],
                [ProductApiDependencyProvider::FACADE_PRODUCT],
                [ProductApiDependencyProvider::FACADE_STORE],
            )->willReturnOnConsecutiveCalls(
                $this->apiFacadeMock,
                $this->productApiToApiQueryBuilderBridgeMock,
                $this->productFacadeMock,
                $this->storeFacadeMock,
            );

        static::assertInstanceOf(
            ProductApi::class,
            $this->factory->createProductApi(),
        );
    }
}
