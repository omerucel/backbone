<?php

namespace Project\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;

class NotFoundController extends ControllerAbstract
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
        return $this->render('admin/404.twig');
    }
}
