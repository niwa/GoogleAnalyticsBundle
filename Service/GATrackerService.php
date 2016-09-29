<?php

namespace Happyr\GoogleAnalyticsBundle\Service;

use Happyr\GoogleAnalyticsBundle\Service\Tracker;
use Symfony\Component\HttpFoundation\RequestStack;

class GATrackerService
{

    private $tracker;
    private $requestStack;

    public function __construct(Tracker $tracker, RequestStack $requestStack)
    {
        $this->tracker = $tracker;
        $this->requestStack = $requestStack;
    }

    public function trackEvent($label, $action = 'download', $category = 'data', $value = 1)
    {
        $data = array();
        $request = $this->requestStack->getMasterRequest();

        if ($request) {
            if ($request->attributes->has('_GA_category')) {
                $category = $request->attributes->get('_GA_category');
            }
            $data = array_merge($data, array(
                'User-Agent' => $request->headers->get('User-Agent'),
                'dl'         => str_replace($request->getRequestUri(), '', $request->getUri()) . parse_url($request->getRequestUri(), PHP_URL_PATH),
                'dh'         => str_replace($request->getRequestUri(), '', $request->getUri()),
                'dp'         => parse_url($request->getRequestUri(), PHP_URL_PATH),
                'dr'         => $request->headers->get('referer')
            ));
        }

        $data = array_merge($data, array(
            'ec' => $category,
            'ea' => $action,
            'el' => $label,
            'ev' => $value,
        ));


        return $this->tracker->send($data, 'event');
    }
}