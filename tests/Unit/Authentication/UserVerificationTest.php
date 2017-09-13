<?php

namespace Tests\Unit\Authentication;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class UserVerificationTest extends TestCase
{

    use DatabaseMigrations;

    public function testVerifyEmail()
    {
        $user = $user = factory(User::class)->create();

        $encodedEmail = base64_encode($user->email);
        $verificationUrl = '/verify/'.$encodedEmail.'?h='.$user->email_token;

        $this->get($verificationUrl)
            ->assertViewIs('auth.passwords.create')
            ->assertViewHas(['email']);
    }

    public function testCreatePasswordWithFailedValidation()
    {
        $user = $user = factory(User::class)->create();
        $credential = [
            'password' => '123456789',
            'password_confirmation' => '12345678999',

        ];

        $url = '/verify/'.$user->email.'/create-password';
        $this->post($url, $credential)
            ->assertSessionHasErrors();
    }

    public function testCreatePasswordSuccess()
    {
        $user = $user = factory(User::class)->create();
        $credential = [
            'password' => '123456789',
            'password_confirmation' => '123456789',

        ];

        $url = '/verify/'.$user->email.'/create-password';
        $this->post($url, $credential)
            ->assertRedirect('/user-news');
    }
}
