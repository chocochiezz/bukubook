<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Psy\Readline\Hoa\Console;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_register_page_is_accesible(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200); //berhasil ke halaman login
        // ada input name
        $response->assertSeeText("Name");
        // ada input email address
        $response->assertSeeText("Email Address");
        //ada input password
        $response->assertSeeText("Password");
        //ada input confirm password
        $response->assertSeeText("Confirm Password");

        $response = $this->post("/register", [
            "name" => "QA Tester3",
            "email" => "tester3@test.com",
            "password" => "hepit35t3r3",
            "password_confirmation" => "hepit35t3r3"
        ]);

        //diarahkan ke halaman home
        $response->assertRedirect("/home");

        // Di halaman home ada welcome Admin
        $responseHome = $this->get("/home");
        $responseHome->assertSeeText("You are logged in! ");
    }


    public function user_can_register_to_app()
    {
        $response = $this->post("/register", [
            "name" => "QA Tester",
            "email" => "tester@test.com",
            "password" => "t35t3r",
            "password-confirm" => "t35t3r"
        ]);

        //berhasil dapat session
        $this->assertAuthenticated();

        //diarahkan ke halaman home
        $response->assertRedirect("/home");

        // Di halaman home ada welcome Admin
        $responseHome = $this->get("/home");
        $responseHome->assertSeeText("You are logged in! ");

    }
}
