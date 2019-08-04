<?php

namespace Framework\Form\Message;

class SuccessMessage extends Message
{
    /**
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message, MessageLevel::SUCCESS);
    }
}
