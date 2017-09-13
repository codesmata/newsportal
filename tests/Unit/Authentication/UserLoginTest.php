<?php

namespace Tests\Unit\Authentication;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\User;

class UserLoginTest extends TestCase
{

    use DatabaseMigrations;

    protected $user;

    public function setup()
    {
        parent::setUp();
        $this->user = factory(User::class, 'verifiedUser')->create();
    }

    public function testUserLoginFailure()
    {
        $credential = [
            'email' => $this->user->email,
            'password' => 'secretiswrong'
        ];

        $this->post('/login', $credential)
            ->assertSessionHasErrors();
    }

    public function testUserLoginSuccess()
    {
        $credential = [
            'email' => $this->user->email,
            'password' => 'secret'
        ];

        $this->post('/login', $credential)
            ->assertRedirect('/user-news');
    }
}
