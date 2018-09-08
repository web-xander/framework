<?php 

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Webxander\Application;
use Webxander\Routing\Router;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class FrameworkTest extends TestCase
{
    public function testNotFoundHandling()
    {
        $framework = $this->getFrameworkForException(new ResourceNotFoundException());

        $response = $framework->handle(new Request());

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testControllerResponse()
    {
        $matcher = $this->createMock(Routing\Matcher\UrlMatcher::class);
        // use getMock() on PHPUnit 5.3 or below
        // $matcher = $this->getMock(Routing\Matcher\UrlMatcherInterface::class);

        $matcher
            ->method('match')
            ->will($this->returnValue(array(
                '_route' => 'welcome',
                '_controller' => function ($name) {
                    return new Response('OK');
                }
            )))
        ;
        

        $app = new Application();

        //$framework = new Router(new Request(), $app->getRoutes(), $app->getDispatcherEvents(), $app->getContainer(), $app->getController(), $app->getArguments());

        $response = $app->handle($app->request);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('OK', $response->getContent());
    }

    private function getFrameworkForException($exception)
    {    

        return new Application();
    }
}