<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_login_page_is_accesible(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200); //berhasil ke halaman login
        // ada input email address
        $response->assertSeeText("Email Address");
        //ada input password
        $response->assertSeeText("Password");
    }

    public function test_admin_can_login_to_app()
    {
        $response = $this->post("/login", [
            "email" => "admin@bukubook.com",
            "password" => "4dm1n"
        ]);

        //berhasil dapat session
        $this->assertAuthenticated();

        //diarahkan ke halaman home
        $response->assertRedirect("/home");

        // Di halaman home ada welcome Admin
        $responseHome = $this->get("/home");
        $responseHome->assertSeeText("ADMIN BUKUBOOK (ADMIN)");

    }

    public function test_logged_in_user_can_logout()
    {
        //Login Admin
        $response = $this->post("/login", [
            "email" => "admin@bukubook.com",
            "password" => "4dm1n"
        ]);

        //Dapat session atau assert authenticated
        $this->assertAuthenticated();

        //request get ke /home
        $response->assertRedirect("/home");

        //Buat request method POST ke /logout
        $response = $this->post('/logout');

        //Request get ke /home
        $response = $this->get('/home');

        //assert redirect ke halaman login
        $response->assertRedirect("/login");
    }

}
