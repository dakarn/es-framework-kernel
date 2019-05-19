<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 21.04.2018
 * Time: 20:28
 */

namespace ES\Kernel\Http\Request;

class RequestBuilder implements RequestBuilderInterface
{
    /**
     * @var resource
     */
    private $curl;

    /**
     * RequestBuilder constructor.
     * @param RequestInterface $request
     */
    public function __construct(RequestInterface $request)
    {
       $this->build($request);
    }

    /**
     * @return resource
     */
    public function getBuilderData()
    {
        return $this->curl;
    }

    /**
     * @param RequestInterface $request
     */
    private function build(RequestInterface $request)
    {
        $this->curl = curl_init($request->getHost());

        \curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);

        if ($request->getMethod() === Request::POST) {
            \curl_setopt($this->curl, CURLOPT_POST, true);
            \curl_setopt($this->curl, CURLOPT_POSTFIELDS, $request->getBody());
        } else if ($request->getMethod() !== Request::GET) {
            \curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $request->getMethod());
        }

        if (!empty($request->getReferer())) {
            \curl_setopt($this->curl, CURLOPT_REFERER, $request->getReferer());
        }

        if (!empty($request->getUserAgent())) {
            \curl_setopt($this->curl, CURLOPT_REFERER, $request->getUserAgent());
        }

        if (!empty($request->getCookies())) {
            $cookies = '';
            foreach($request->getCookies() as $name => $value ) {
                $cookies .= $name . '=' . $value;
            };
            \curl_setopt($this->curl, CURLOPT_COOKIE, $cookies);
        }

        if (!empty($request->getHeaders())) {
            \curl_setopt($this->curl, CURLOPT_HTTPHEADER, $request->getHeaders());
        }

        \curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 0);
        \curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
    }
}