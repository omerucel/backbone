<?php

namespace Project\Controller\Web;

use Symfony\Component\HttpFoundation\Response;

class IndexController extends ControllerAbstract
{
    /**
     * @param array $params
     * @return Response
     * @throws \Exception
     */
    public function handleRequest(array $params = []): Response
    {
        return $this->render('web/index.twig');
    }
}
