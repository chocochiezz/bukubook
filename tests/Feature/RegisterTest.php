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


    }


    public function test_user_can_register_to_app()
    {
        $response = $this->post("/register", [
            "name" => "QA Tester2",
            "email" => "tester2@test.com",
            "password" => "hepit35t3r2",
            "password_confirmation" => "hepit35t3r2"
        ]);

        //$this->assertTrue(User::whereEmail("tester2@test.com")->exists());

        //diarahkan ke halaman home
        $response->assertRedirect("/home");

        // Di halaman home ada welcome Admin
        $responseHome = $this->get("/home");
        $responseHome->assertSeeText("Dashboard");
    }
}
