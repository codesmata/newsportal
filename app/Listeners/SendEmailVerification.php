<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Utils\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;

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
        $parameters['subject'] = Lang::get('email.verification')['subject'];
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
            Lang::get('email.verification')['body']
            ."<a href='{$link}'>Verify</a>";
    }
}
