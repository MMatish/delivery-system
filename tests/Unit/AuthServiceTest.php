<?php

namespace Tests\Unit\Services\Auth;

use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    protected AuthService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AuthService();
    }

    public function test_successful_login_clears_rate_limiter_and_regenerates_session()
    {
        $user = User::factory()->create([
            'password' => bcrypt('secret123'),
        ]);

        RateLimiter::shouldReceive('tooManyAttempts')->once()->andReturn(false);
        Auth::shouldReceive('attempt')->once()->andReturn(true);
        Auth::shouldReceive('user')->once()->andReturn($user);
        RateLimiter::shouldReceive('clear')->once();
        Session::shouldReceive('regenerate')->once();

        $result = $this->service->login(['email' => $user->email, 'password' => 'secret123'], '127.0.0.1');
        $this->assertEquals($user, $result);
    }

    public function test_login_throws_exception_on_too_many_attempts()
    {
        RateLimiter::shouldReceive('tooManyAttempts')->once()->andReturn(true);
        RateLimiter::shouldReceive('availableIn')->once()->andReturn(30);

        $this->expectException(ValidationException::class);
        $this->service->login(['email' => 'test@test.com', 'password' => '123'], '127.0.0.1');
    }

    public function test_login_throws_exception_on_invalid_credentials()
    {
        RateLimiter::shouldReceive('tooManyAttempts')->once()->andReturn(false);
        RateLimiter::shouldReceive('hit')->once();
        Auth::shouldReceive('attempt')->once()->andReturn(false);

        $this->expectException(ValidationException::class);
        $this->service->login(['email' => 'test@test.com', 'password' => 'wrong'], '127.0.0.1');
    }

    public function test_logout_calls_auth_logout_and_session_methods()
    {
        Auth::shouldReceive('logout')->once();
        Session::shouldReceive('invalidate')->once();
        Session::shouldReceive('regenerateToken')->once();

        $this->service->logout();
        $this->assertTrue(true);
    }
}
