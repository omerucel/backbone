<?php

namespace Framework\Form\Field;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class CsrfField extends DefaultField
{
    /**
     * @var Session
     */
    protected $session;

    /**
     * @var string
     */
    protected $formName;

    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var string
     */
    protected $sessionKey;

    /**
     * @param Request $request
     * @param Session $session
     * @param string $formName
     * @param string $keyName
     * @throws \Exception
     */
    public function __construct(
        Request $request,
        Session $session,
        $formName = 'default',
        $keyName = '__csrf_token'
    ) {
        parent::__construct();
        $this->session = $session;
        $this->formName = $formName;
        $this->fieldName = $keyName;
        $this->sessionKey = $this->formName . '.' . $this->fieldName;
        if ($request->isMethod('POST')) {
            $this->value = $request->get($this->fieldName);
        } else {
            $this->createNewToken();
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function validate()
    {
        $isValid = hash_equals($this->session->get($this->sessionKey), $this->value);
        $this->createNewToken();
        return $isValid;
    }

    /**
     * @throws \Exception
     */
    protected function createNewToken()
    {
        $token = hash_hmac('sha256', $this->formName, bin2hex(random_bytes(32)));
        $this->session->set($this->sessionKey, $token);
        $this->value = $token;
    }
}
