<?php

namespace Project\Controller\Admin;

use Framework\Form\Message\DangerMessage;
use Project\Controller\Admin\Form\LoginForm;
use Project\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends ControllerAbstract
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
        if ($this->getSession()->has('admin.user_id')) {
            return $this->redirectToRoute('admin.dashboard');
        }
        $form = $this->container->get(LoginForm::class);
        if ($this->request->isMethod('POST')) {
            if ($form->validate()) {
                $user = User::query()->where('email', $form->email->value)->first();
                if ($user instanceof User && $user->isValidPassword($form->password->value)) {
                    $this->getSession()->set('admin.user_id', $user->id);
                    return $this->redirectToRoute('admin.dashboard');
                }
            }
            $form->addMessage(new DangerMessage('Please check the information!'));
        }
        return $this->render('admin/login.twig', ['form' => $form]);
    }
}
