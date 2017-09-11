<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Utils\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailVerification implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user = $event->user;
        $parameters['address'] = $user->email;
        $parameters['name'] = $user->name;
        $parameters['subject'] = 'Email Verification';
        $parameters['body'] = $this->buildVerificationMessage($user->email, $user->email_token);

        Mailer::sendMail($parameters);
    }

    /**
     * @param $email
     * @param $emailToken
     * @return string
     */
    public function buildVerificationMessage($email, $emailToken)
    {
        $email = base64_encode($email);
        $link = config('app.url').'/verify/'.$email.'?h='.$emailToken;
        return
            "<p>Hi, please click the link below to verify your email and create password</p>"
            ."<a href='{$link}'>Verify</a>";
    }
}
