<?php

namespace Domain\Auth\Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Str;
use Domain\Auth\Models\User;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
  use RefreshDatabase;

  /** @test */
  public function it_can_login()
  {
    $user = User::factory()->create();

    $resp = $this->postJson(route('auth.login'), [
      'email' => $user->email,
      'password' => 'password'
    ]);

    $resp
      ->assertOk()
      ->assertJsonStructure([
        'success', 'code', 'message', 'data' => ['name', 'email']
      ])
      ->assertJson([
        'success' => true,
        'code' => Response::HTTP_OK
      ]);
  }

  /** @test */
  public function it_fails_when_credentials_are_incorrect()
  {
    $user = User::factory()->create();

    $resp = $this->postJson(route('auth.login'), [
      'email' => $user->email,
      'password' => 'password123'
    ]);

    $resp
      ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['email'])
      ->assertJson([
        'errors' => [
          'email' => [__('auth.failed')]
        ]
      ]);
  }

  /** @test */
  public function it_fails_when_email_or_password_field_are_not_filled()
  {
    $resp = $this->postJson(route('auth.login'), []);

    $resp
      ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['email', 'password'])
      ->assertJson([
        'errors' => [
          'email' => [__('validation.required', ['attribute' => 'email'])],
          'password' => [__('validation.required', ['attribute' => 'password'])]
        ]
      ]);
  }

  /** @test */
  public function it_fails_when_email_field_is_not_valid_email_format()
  {
    $resp = $this->postJson(route('auth.login'), ['email' => 'asd']);

    $resp
      ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['email'])
      ->assertJson([
        'errors' => [
          'email' => [__('validation.email', ['attribute' => 'email'])],
        ]
      ]);
  }

  /** @test */
  public function it_fails_when_password_field_is_not_long_enough()
  {
    $resp = $this->postJson(route('auth.login'), ['email' => 'test@test.com', 'password' => 'a']);

    $resp
      ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['password'])
      ->assertJson([
        'errors' => ['password' => [__('validation.min.string', ['attribute' => 'password', 'min' => 6])]]
      ]);
  }

  /** @test */
  public function it_fails_when_email_or_password_field_is_longer_than_expected()
  {
    $resp = $this->postJson(route('auth.login'), ['password' => Str::random(33)]);

    $resp
      ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
      ->assertJsonValidationErrors(['password'])
      ->assertJson([
        'errors' => ['password' => [__('validation.max.string', ['attribute' => 'password', 'max' => 32])]]
      ]);
  }
}
