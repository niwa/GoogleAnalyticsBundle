<?php

namespace Happyr\GoogleAnalyticsBundle\Tests\Service;

use Happyr\GoogleAnalyticsBundle\Service\GATrackerService;
use Symfony\Component\HttpFoundation\Request;

class GATrackerServiceTest extends \PHPUnit_Framework_TestCase
{

    public function testTrackEvent()
    {
        $payload = array(
            'User-Agent' => 'Symfony/2.X',
            'dl' => 'http://www.test.com/api/endpoint',
            'dh' => 'http://www.test.com',
            'dp' => '/api/endpoint',
            'dr' => null,
            'ec' => 'test',
            'ea' => 'download',
            'el' => 'test-label',
            'ev' => 1
        );
        $request = Request::create('http://www.test.com/api/endpoint?param=value');
        $request->attributes->set('_GA_category', 'test');

        $requestStack = $this->getMockBuilder('Symfony\Component\HttpFoundation\RequestStack')
            ->setMethods(array('getMasterRequest'))
            ->disableOriginalConstructor()
            ->getMock();

        $requestStack->expects($this->once())
            ->method('getMasterRequest')
            ->willReturn($request);


        $tracker = $this->getMockBuilder('Happyr\GoogleAnalyticsBundle\Service\Tracker')
            ->setMethods(array('send'))
            ->disableOriginalConstructor()
            ->getMock();

        $tracker->expects($this->once())
            ->method('send')
            ->with($payload)
            ->willReturn(true);

        $service = new GATrackerService($tracker, $requestStack);
        $service->trackEvent('test-label');
    }

}
