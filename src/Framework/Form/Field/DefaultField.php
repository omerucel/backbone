<?php

namespace Framework\Form\Field;

use Framework\Form\Message\Message;
use Respect\Validation\Validatable;

class DefaultField implements Field
{
    public $value;

    /**
     * @var Message
     */
    public $message;

    /**
     * @var array
     */
    private $rules = [];

    /**
     * @param $value
     */
    public function __construct($value = null)
    {
        $this->value = $value;
    }

    /**
     * @param Validatable $rule
     * @param Message $message
     */
    public function addRule(Validatable $rule, Message $message = null)
    {
        $this->rules[] = [$rule, $message];
    }

    /**
     * @return bool
     */
    public function validate()
    {
        /**
         * @var Validatable $validatable
         */
        foreach ($this->rules as $rule) {
            $validatable = $rule[0];
            if ($validatable->validate($this->value) == false) {
                $this->message = $rule[1];
                return false;
            }
        }
        return true;
    }
}
