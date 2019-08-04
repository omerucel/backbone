<?php

namespace Framework\Form\Message;

class Message
{
    public $level;
    public $message;

    /**
     * @param $message
     * @param string $level
     */
    public function __construct($message, $level = MessageLevel::SUCCESS)
    {
        $this->message = $message;
        $this->level = $level;
    }

    public function __toString()
    {
        return $this->message;
    }
}
