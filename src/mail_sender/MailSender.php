<?php

namespace mail_sender;

require_once __DIR__.'/../../vendor/autoload.php';

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailSender
{
    protected $mail;
    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        if (file_exists(__DIR__ . '/../../.env')) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../..');
            $dotenv->load();
        }

        $this->mail->isSMTP();
        $this->mail->Host       = $_ENV['SMTP_HOST'];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $_ENV['SMTP_USER'];
        $this->mail->Password   = $_ENV['SMTP_PASS'];
        $this->mail->SMTPSecure = 'tls';
        $this->mail->Port       = $_ENV['SMTP_PORT'];

    }

    public function sendEmail($name, $emailFrom, $emailTo, $subject, $message)
    {
        try {
            $this->mail->setFrom($emailFrom, $name);
            $this->mail->addAddress($emailTo);

            $this->mail->isHTML();
            $this->mail->Subject = $subject;
            $this->mail->Body    = $message;
            $this->mail->addReplyTo($emailFrom, $name);

            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}