<?php 

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Webxander\Application;
use Webxander\Request;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class FrameworkTest extends TestCase
{
    public function testNotFoundHandling()
    {


        $request = Request::create(
            '/not-found',
            'GET'
        );

        $framework = new Application($request);

        $response = $framework->handle();

        $this->assertEquals(404, $response->getStatusCode());
    }

    public function testControllerResponse()
    {

        // use getMock() on PHPUnit 5.3 or below
        // $matcher = $this->getMock(Routing\Matcher\UrlMatcherInterface::class);
        
        $request = new Request(['/']);

        $app = new Application($request);

        //$framework = new Router(new Request(), $app->getRoutes(), $app->getDispatcherEvents(), $app->getContainer(), $app->getController(), $app->getArguments());

        $response = $app->handle();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('OK', $response->getContent());
    }
}