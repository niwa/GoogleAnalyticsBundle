<?php

namespace Happyr\GoogleAnalyticsBundle\Tests\Http;

use Niwa\UtilitiesBundle\Tests\Mock\MockCurl;

class NiwaHttpClientTest extends \PHPUnit_Framework_TestCase
{

    public function testSend()
    {

        $endpoint='foobar';
        $data=array(
            'baz'=>'biz',
            'bax'=>'foo'
        );
        $curlMock = new MockCurl('');

        $httpClient=$this->getMockBuilder('Happyr\GoogleAnalyticsBundle\Http\NiwaHttpClient')
            ->setMethods(array('getClient'))
            ->setConstructorArgs(array($curlMock, $endpoint, false, 1))
            ->getMock();

        $this->assertTrue($httpClient->send($data));

        $data=array(
            'baz'=>'biz',
            'User-Agent' => 'TEST',
            'bax'=>'foo'
        );
        $this->assertTrue($httpClient->send($data));

    }
}