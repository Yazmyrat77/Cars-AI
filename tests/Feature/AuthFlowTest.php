<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('unauthenticated users visiting root are redirected to login gate', function () {
    $response = $this->get('/');

    $response->assertRedirect(route('login'));
});

test('login page renders with glassmorphism elements', function () {
    $response = $this->get(route('login'));

    $response->assertStatus(200);
    $response->assertSee('AutoMarket');
});

test('user can log in with valid credentials', function () {
    $user = User::factory()->create([
        'email' => 'testuser@automarket.com',
        'password' => Hash::make('secret123'),
    ]);

    $response = $this->post(route('login.submit'), [
        'login' => 'testuser@automarket.com',
        'password' => 'secret123',
    ]);

    $response->assertRedirect(route('cars.index'));
    $this->assertAuthenticatedAs($user);
});

test('wrong password triggers OTP recovery flow and redirects to verify-login', function () {
    $user = User::factory()->create([
        'email' => 'recoverme@automarket.com',
        'password' => Hash::make('correct-password'),
    ]);

    $response = $this->post(route('login.submit'), [
        'login' => 'recoverme@automarket.com',
        'password' => 'wrong-password-attempt',
    ]);

    $response->assertRedirect(route('auth.verify'));
    $response->assertSessionHas('otp_email', 'recoverme@automarket.com');
    $response->assertSessionHas('demo_code');

    $user->refresh();
    expect($user->login_code)->not->toBeNull();
    expect(strlen($user->login_code))->toBe(6);
});

test('user can regain access using the dispatched OTP code', function () {
    $user = User::factory()->create([
        'email' => 'verified_otp@automarket.com',
        'password' => Hash::make('some-password'),
        'login_code' => '654321',
        'login_code_expires_at' => now()->addMinutes(15),
    ]);

    $response = $this->post(route('auth.verify.submit'), [
        'email' => 'verified_otp@automarket.com',
        'code' => '654321',
    ]);

    $response->assertRedirect(route('cars.index'));
    $this->assertAuthenticatedAs($user);

    $user->refresh();
    expect($user->login_code)->toBeNull();
});

test('user can switch application language to en, ru, and tk', function () {
    foreach (['en', 'ru', 'tk'] as $locale) {
        $response = $this->get(route('lang.switch', $locale));
        $response->assertSessionHas('locale', $locale);
    }
});

