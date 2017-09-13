<?php

namespace Tests\Unit\Authentication;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserRegistrationTest extends TestCase
{

    use DatabaseMigrations;

    public function testVisitRegistrationPage()
    {
        $response = $this->call('GET', '/register');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testRegisterUserWithFailedValidation()
    {
        $credentials = [
            'name' => 'Abraham Davies',
            'email' => str_random(5).'.smail.com'
        ];

        $response = $this->call('POST', '/register', $credentials);
        $response->assertSessionHasErrors();
    }

    public function testRegisterUserSuccess()
    {
        $this->withoutEvents();

        $credentials = [
            'name' => 'Abraham Davies',
            'email' => str_random(5).'@smail.com'
        ];

        $this->post('/register', $credentials)
            ->assertRedirect('/success')
            ->assertSessionHas(['email']);
    }
}
