<?php

namespace MVC\services;

class EmailSender
{
    public static function send(\MVC\model\User $receiver, string $subject, string $templateName, array $templateVars = []): void
    {
        extract($templateVars);

        ob_start();
        require __DIR__ . '/../view/mail/' . $templateName . '.phtml';
        $body = ob_get_contents();
        ob_end_clean();

        mail($receiver->getEmail(), $subject, $body, 'Content-Type: text/html; charset=UTF-8');
    }
}
