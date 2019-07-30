<?php

namespace Project\Controller\Api;

use Symfony\Component\HttpFoundation\Response;

class IndexController extends ControllerAbstract
{
    /**
     * @param array $params
     * @return Response
     */
    protected function handleRequest(array $params = []): Response
    {
        $json = ['meta' => ['httpStatusCode' => 200]];
        return $this->toJson($json);
    }
}
