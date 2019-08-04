<?php

namespace Framework\Form\Message;

class WarningMessage extends Message
{
    /**
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message, MessageLevel::WARNING);
    }
}
