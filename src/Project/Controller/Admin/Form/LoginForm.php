<?php

namespace Project\Controller\Admin\Form;

use Framework\Form\Field\CsrfField;
use Framework\Form\Field\DefaultField;
use Framework\Form\Form;
use Framework\Form\Message\DangerMessage;
use Respect\Validation\Rules\Email;
use Respect\Validation\Rules\NotEmpty;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Translation\Translator;

class LoginForm extends Form
{
    public $csrf;
    public $email;
    public $password;

    /**
     * @param Request $request
     * @param Translator $translator
     * @param Session $session
     * @throws \Exception
     */
    public function __construct(Request $request, Translator $translator, Session $session)
    {
        $this->csrf = new CsrfField($request, $session, LoginForm::class);
        $this->email = new DefaultField($request->get('email'));
        $this->email->addRule(new Email(), new DangerMessage($translator->trans('Please enter a valid email address!')));
        $this->password = new DefaultField($request->get('password'));
        $this->password->addRule(new NotEmpty(), new DangerMessage($translator->trans('Please do not leave the password field blank!')));
    }
}
