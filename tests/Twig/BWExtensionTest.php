<?php


namespace BW\ActiveMenuItemBundle\Tests\Twig;

use BW\ActiveMenuItemBundle\Twig\BWExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class BWExtensionTest extends TestCase
{
    public function testIsActiveUriFilter()
    {
        $extension = $this->createExtension(Request::create('/hello/victor'));

        $this->assertEquals('current active', $extension->isActiveUriFilter('/hello/victor'));
        $this->assertEmpty($extension->isActiveUriFilter('/hello/world'));
    }

    public function testIsActiveUriFunction()
    {
        $extension = $this->createExtension(Request::create('/hello/victor'));

        $this->assertEquals('active', $extension->isActiveUriFunction([
            '/hello',
            '/hello/victor',
        ], '/hello'));
        $this->assertEquals('current active', $extension->isActiveUriFunction([
            '/hello',
            '/hello/victor',
        ], '/hello/victor'));
        $this->assertEmpty($extension->isActiveUriFunction([
            '/hello',
            '/hello/world',
        ]));
    }

    public function testIsActiveFilter()
    {
        $request = new Request([], [], ['_route' => 'hello_victor']);
        $extension = $this->createExtension($request);

        $this->assertEquals('current active', $extension->isActiveFilter('hello_victor'));
        $this->assertEmpty($extension->isActiveFilter('hello_world'));
    }

    public function testIsActiveFunction()
    {
        $request = new Request([], [], ['_route' => 'hello_victor']);
        $extension = $this->createExtension($request);

        $this->assertEquals('active', $extension->isActiveFunction([
            'hello',
            'hello_victor',
        ], 'hello'));
        $this->assertEquals('current active', $extension->isActiveFunction([
            'hello',
            'hello_victor',
        ], 'hello_victor'));
        $this->assertEmpty($extension->isActiveFunction([
            'hello',
            'hello_world',
        ]));
    }

    private function createExtension(Request $request)
    {
        $requestStack = new RequestStack();
        $requestStack->push($request);

        return new BWExtension($requestStack);
    }
}
