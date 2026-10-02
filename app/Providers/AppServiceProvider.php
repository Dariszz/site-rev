<?php

namespace App\Providers;

use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureVerificationEmail();
    }

    /**
     * Configure the email verification message sent after registration.
     */
    protected function configureVerificationEmail(): void
    {
        VerifyEmail::toMailUsing(function (User $notifiable, string $url): MailMessage {
            $appName = config('app.name');
            $expires = config('auth.verification.expire', 60);

            return (new MailMessage)
                ->subject("Confirme seu e-mail no {$appName}")
                ->greeting("Olá, {$notifiable->name}!")
                ->line("Recebemos seu cadastro no {$appName}. Para ativar sua conta e acessar a plataforma, precisamos confirmar que este endereço de e-mail é seu.")
                ->action('Confirmar e-mail', $url)
                ->line("Este link é válido por {$expires} minutos. Se ele expirar, entre na sua conta e peça um novo link na tela de verificação.")
                ->line("Se você não se cadastrou no {$appName}, ignore esta mensagem: nenhuma ação é necessária.");
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
