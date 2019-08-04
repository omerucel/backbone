<?php

namespace Project\Controller\Admin;

use Project\Controller\BaseControllerAbstract;
use Project\Entity\Meta\UserRole;
use Project\Entity\User;
use Symfony\Component\HttpFoundation\Response;

abstract class ControllerAbstract extends BaseControllerAbstract
{
    /**
     * @var User
     */
    protected $currentUser;

    /**
     * @var array
     */
    protected $allowedRoles = [UserRole::ADMIN];

    /**
     * @param array $params
     * @return null|Response
     */
    protected function beforeHandleRequest(array $params = []): ?Response
    {
        $currentRoute = $this->container->get('current_route');
        if ($currentRoute['_route'] == 'admin.login') {
            return null;
        }
        if ($this->getSession()->has('admin.user_id') == false) {
            return $this->redirectToRoute('admin.login');
        }
        $adminUserId = $this->getSession()->get('admin.user_id');
        $this->currentUser = User::query()->where('id', $adminUserId)->first();
        if ($this->currentUser == null) {
            return $this->redirectToRoute('admin.login');
        }
        if (empty($this->allowedRoles) === false && in_array($this->currentUser->role, $this->allowedRoles) === false) {
            return $this->redirectToRoute('admin.dashboard');
        }
        return null;
    }

    /**
     * @param $template
     * @param array $context
     * @param int $statusCode
     * @param array $headers
     * @return Response
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function render($template, array $context = [], $statusCode = 200, array $headers = [])
    {
        $context['current_user'] = $this->currentUser;
        return parent::render($template, $context, $statusCode, $headers);
    }
}
