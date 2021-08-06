<?php

namespace Tests\V1\Feature;

use Tests\V1\Traits\User as TraitsUser;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\V1\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseTransactions, TraitsUser;

    public function setUp(): void
    {
        parent::setup();
    }

    public function testRequiredDetailsPresentInAccountCreation()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email_address' => $this->faker->email,
            'password' => 'secret',
            'phone_number' => ''
        ];
        
        $response = $this->json('POST', $this->route("/accounts/register"), $data);
        $response->assertStatus(400);
        $this->assertEquals($response->getData()->status, 'error');
        $this->assertEquals($response->getData()->message, 'Phone number is required');
    }

    public function testPasswordMinimumCharacters()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email_address' => $this->faker->email,
            'password' => 'secre',
            'phone_number' => '080'.rand(111111111, 999999999),
        ];

        $response = $this->json('POST', $this->route("/accounts/register"), $data);
        $response->assertStatus(400);
        $this->assertEquals($response->getData()->status, 'error');
        $this->assertEquals($response->getData()->message, 'Password must not be less than 6 characters');
    }

    public function testPhoneNumberMinimumCharacters()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email_address' => $this->faker->email,
            'password' => 'secret',
            'phone_number' => '080'.rand(111, 999),
        ];

        $response = $this->json('POST', $this->route("/accounts/register"), $data);
        $response->assertStatus(400);
        $this->assertEquals($response->getData()->status, 'error');
        $this->assertEquals($response->getData()->message, 'Phone number should not be less than 10 characters');
    }

    public function testPhoneNumberMaximumCharacters()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email_address' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
            'phone_number' => '080'.rand(11111111111111, 99999999999999),
        ];

        $response = $this->json('POST', $this->route("/accounts/register"), $data);
        $response->assertStatus(400);
        $this->assertEquals($response->getData()->status, 'error');
        $this->assertEquals($response->getData()->message, 'Phone number should not be more than 15 characters');
    }

    public function testEmailAddressExist()
    {
        $user = $this->registerUser();
        $emailAddress = $user->getData()->data->email_address;
        $response = $this->registerUser($emailAddress);

        $response->assertStatus(400);
        $this->assertEquals($response->getData()->status, 'error');
        $this->assertEquals($response->getData()->message, 'Email address already exist');
    }

    public function testRegistrationSuccessful()
    {
        $response = $this->registerUser();
        $response->assertStatus(200);
        $response->assertJsonStructure(
            [
                'status',
                'data',
                'message'
            ]
        );

        $this->assertEquals($response->getData()->status, 'success');
        $this->assertEquals($response->getData()->message, 'Registration successful.');
    }

    public function testIncorrectLoginDetails()
    {
        $data = [
            'email_address' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
        ];

        $response = $this->json('POST', $this->route("/accounts/login"), $data);
        $response->assertStatus(400);
        $this->assertEquals($response->getData()->status, 'error');
        $this->assertEquals($response->getData()->message, 'Incorrect login credentials. Try again.');
    }

    public function testLoginSuccessful()
    {
        $user = $this->registerUser();
        
        $data = [
            'email_address' => $user->getData()->data->email_address,
            'password' => 'secret',
        ];
        
        $response = $this->json('POST', $this->route("/accounts/login"), $data);
        $response->assertStatus(200);
        $this->assertEquals($response->getData()->status, 'success');
        $this->assertEquals($response->getData()->data->message, 'Login successful');
    }
}
