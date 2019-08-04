<?php

namespace Framework\Form;

use Framework\Form\Field\Field;
use Framework\Form\Message\Message;

class Form
{
    private $messages = [];

    /**
     * @param Message $message
     */
    public function addMessage(Message $message)
    {
        $this->messages[] = $message;
    }

    /**
     * @return array
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @return bool
     */
    public function validate(): bool
    {
        /**
         * @var Field $field
         */
        $isValid = true;
        foreach ($this as $field) {
            if ($field instanceof Field && $field->validate() == false) {
                $isValid = false;
            }
        }
        return $isValid;
    }
}
