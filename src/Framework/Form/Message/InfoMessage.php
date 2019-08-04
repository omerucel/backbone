<?php

namespace Framework\Form\Message;

class InfoMessage extends Message
{
    /**
     * @param $message
     */
    public function __construct($message)
    {
        parent::__construct($message, MessageLevel::INFO);
    }
}
