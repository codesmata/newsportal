<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Utils\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Utils\Mailer as Mail;

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
        $parameters['body'] = $this->buildVerificationMessage($user->email_token);

        Mailer::sendMail($parameters);
    }

    public function buildVerificationMessage($emailToken)
    {
        $link = config('app.url').'/verify/'.$emailToken;
        return
            "<p>Hi, please click the link below to verify your email and create password</p>"
            ."<a href='{$link}'>Verify</a>";
    }
}
