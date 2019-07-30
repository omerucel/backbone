<?php

namespace Project\Controller\Admin;

use Project\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends ControllerAbstract
{
    /**
     * @param array $params
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function handleRequest(array $params = []): Response
    {
        return $this->render('admin/index.twig');
    }
}
