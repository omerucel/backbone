<?php

namespace Framework\Form\Message;

class DangerMessage extends Message
{
    /**
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message, MessageLevel::DANGER);
    }
}
