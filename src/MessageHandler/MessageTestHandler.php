<?php

namespace App\MessageHandler;

use App\Message\MessageTest;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class MessageTestHandler implements MessageHandlerInterface
{
    public function __invoke(MessageTest $message)
    {
        // do something with your message
    }
}
