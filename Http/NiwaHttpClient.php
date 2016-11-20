<?php

namespace Happyr\Google\AnalyticsBundle\Http;

use Niwa\UtilitiesBundle\Interfaces\CurlInterface;


class NiwaHttpClient implements HttpClientInterface
{
    /**
     * @var string endpoint
     *
     */
    protected $endpoint;

    /**
     * @var integer requestTimeout
     *
     */
    protected $requestTimeout;

    /**
     * @var boolean fireAndForget
     *
     */
    protected $fireAndForget;

    /**
     * @var CurlInterface curl
     */
    protected $curl;

    /**
     * @param CurlInterface $curl
     * @param string $endpoint
     * @param boolean $fireAndForget
     * @param integer $requestTimeout
     */
    public function __construct(CurlInterface $curl, $endpoint, $fireAndForget, $requestTimeout)
    {
        $this->curl = $curl;
        $this->endpoint = $endpoint;
        $this->fireAndForget = $fireAndForget;
        $this->requestTimeout = $requestTimeout;
    }

    /**
     * Send a post request to the endpoint
     *
     * @param array $data
     *
     * @return bool
     */
    public function send(array $data = array())
    {
        if (array_key_exists('User-Agent', $data)) {
            $userAgent = $data['User-Agent'];
            array_splice($data, array_search('User-Agent', array_keys($data)), 1);
        } else {
            $userAgent = 'sdt/1.0';
        }
        $headers = array('User-Agent' => $userAgent);

        $response = $this->curl->postRequest($this->endpoint, http_build_query($data), null, $headers);

        return $response->getHTTPStatusCode() == '200';
    }

}