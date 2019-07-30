<?php

namespace Project\Controller\Api;

use Symfony\Component\HttpFoundation\Response;

class NotFoundController extends ControllerAbstract
{
    /**
     * @param array $params
     * @return Response
     * @throws \Exception
     */
    public function handleRequest(array $params = []): Response
    {
        $json = ['meta' => ['httpStatusCode' => 404, 'errorCode' => 1, 'errorMessage' => 'Resource not found!']];
        return $this->toJson($json, 404);
    }
}
