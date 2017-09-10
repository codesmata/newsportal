<?php

namespace App\Utils;

use PHPMailer\PHPMailer;

class Mailer
{
    public static function sendMail(array $parameters)
    {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = config('mail.host');
        $mail->Port = config('mail.port');
        $mail->SMTPSecure = config('mail.port');

        $mail->SMTPAuth = true;
        $mail->Username = config('mail.username');
        $mail->Password = config('mail.password');
        $mail->setFrom(config('mail.username'), 'News Portal');
        $mail->addAddress($parameters['address'], $parameters['name']);
        $mail->Subject = $parameters['subject'];
        $mail->msgHTML($parameters['message']);

        return $mail->send();
    }
}
