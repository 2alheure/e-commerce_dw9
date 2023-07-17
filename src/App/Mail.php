<?php

namespace App;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

class Mail {

    private $phpMailer;

    function __construct($debug = false) {
        $this->phpMailer = new PHPMailer(true);

        if ($debug) {
            $this->phpMailer->SMTPDebug = SMTP::DEBUG_CONNECTION;
        }

        $this->phpMailer->isSMTP();
        $this->phpMailer->Host = Config::SMTP_HOST;
        $this->phpMailer->SMTPAuth = true;
        $this->phpMailer->Username = Config::SMTP_USER;
        $this->phpMailer->Password = Config::SMTP_PSW;
        $this->phpMailer->Port = Config::SMTP_PORT;
        // $this->phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

        $this->phpMailer->setFrom(Config::MAIL_CONTACT);
    }

    function send() {
        $this->phpMailer->send();
    }

    function to(string $email) {
        $this->phpMailer->addAddress($email);
        return $this;
    }

    function replyTo(string $email) {
        $this->phpMailer->addReplyTo($email);
        return $this;
    }

    function subject(string $subject) {
        $this->phpMailer->Subject = $subject;
        return $this;
    }

    function text(string $text) {
        $this->phpMailer->AltBody = $text;

        if (empty($this->phpMailer->Body)) $this->html($text);
        return $this;
    }

    function html(string $html) {
        $this->phpMailer->Body = $html;
        return $this;
    }
}
