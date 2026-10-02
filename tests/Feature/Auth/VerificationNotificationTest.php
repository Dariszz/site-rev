<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;
use Tests\TestCase;

class VerificationNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->skipUnlessFortifyHas(Features::emailVerification());
    }

    public function test_sends_verification_notification(): void
    {
        Notification::fake();

        $user = User::factory()->unverified()->create();

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect(route('home'));

        Notification::assertSentTo($user, VerifyEmail::class);
    }

    public function test_verification_email_is_written_in_portuguese(): void
    {
        app()->setLocale('pt_BR');

        $user = User::factory()->unverified()->create(['name' => 'Maria']);

        $mail = (new VerifyEmail)->toMail($user);
        $html = (string) $mail->render();

        $this->assertSame('Confirme seu e-mail no '.config('app.name'), $mail->subject);
        $this->assertSame('Olá, Maria!', $mail->greeting);
        $this->assertSame('Confirmar e-mail', $mail->actionText);
        $this->assertStringContainsString('/email/verify/'.$user->id.'/', $mail->actionUrl);
        $this->assertStringContainsString('Este link é válido por 60 minutos.', $html);
        $this->assertStringContainsString('Abraços,', $html);
        $this->assertStringContainsString('copie e cole o endereço abaixo', $html);
    }

    public function test_does_not_send_verification_notification_if_email_is_verified(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertRedirect(route('dashboard', absolute: false));

        Notification::assertNothingSent();
    }
}
