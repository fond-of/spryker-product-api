<?php

namespace FondOfSprykerTest\Zed\ProductApi;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\ProductApi\ProductApiDependencyProvider;
use ReflectionClass;
use Spryker\Shared\Kernel\AbstractLocator;
use Spryker\Shared\Kernel\BundleProxy;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\ProductApi\Dependency\Facade\ProductApiToProductBridge;

class ProductApiDependencyProviderTest extends Unit
{
    /**
     * @var \Spryker\Zed\Kernel\Container|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $containerMock;

    /**
     * @var \Spryker\Shared\Kernel\AbstractLocator|\PHPUnit\Framework\MockObject\MockObject|null
     */
    protected $locatorMock;

    /**
     * @var \Spryker\Shared\Kernel\BundleProxy|\PHPUnit\Framework\MockObject\MockObject|null
     */
    protected $productMock;

    /**
     * @var \Spryker\Zed\Product\Business\ProductFacade|\PHPUnit\Framework\MockObject\MockObject|null
     */
    protected $productFacadeMock;

    /**
     * @return void
     */
    public function _before()
    {
        $this->containerMock = $this->getMockBuilder(Container::class)
            ->setMethods(['getLocator'])
            ->getMock();

        $this->locatorMock = $this->getMockBuilder(AbstractLocator::class)
            ->disableOriginalConstructor()
            ->setMethods(['product', 'locate'])
            ->getMock();

        $this->productMock = $this->getMockBuilder(BundleProxy::class)
            ->disableOriginalConstructor()
            ->setMethods(['facade'])
            ->getMock();
    }

    /**
     * @return void
     */
    public function testProvideProductFacade()
    {
        $this->containerMock->expects($this->atLeastOnce())
            ->method('getLocator')
            ->willReturn($this->locatorMock);

        $this->locatorMock->expects($this->atLeastOnce())
            ->method('product')
            ->willReturn($this->productMock);

        $this->productMock->expects($this->atLeastOnce())
             ->method('facade')
            ->willReturn($this->productFacadeMock);

        $productApiDependencyProvider = new ProductApiDependencyProvider();
        $reflectionClass = new ReflectionClass(get_class($productApiDependencyProvider));
        $method = $reflectionClass->getMethod('provideProductFacade');
        $method->setAccessible(true);
        $container = $method->invokeArgs($productApiDependencyProvider, [$this->containerMock]);

        $this->assertInstanceOf(Container::class, $container);
        $this->assertNotNull($container[ProductApiDependencyProvider::FACADE_PRODUCT]);
        $this->assertInstanceOf(ProductApiToProductBridge::class, $container[ProductApiDependencyProvider::FACADE_PRODUCT]);
    }
}
