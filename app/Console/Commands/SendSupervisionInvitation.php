<?php

namespace App\Console\Commands;

use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use App\Notifications\SupervisionInvitation;
use App\Notifications\SupervisionReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendSupervisionInvitation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:supervision-invitation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Рассылает приглашение на супервизию';

    private int $sent = 0;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $deadline = Carbon::create(2025, 5, 20, 19, 0); // 20 мая 2025 в 19:00

        if (now()->greaterThanOrEqualTo($deadline)) {
            $this->info("Супервизия уже началась. Рассылка остановлена.");
            return;
        }

        $this->sent = 0;

        // Находим пользователей, которым ещё не отправляли
        $users = User::where('subscription_level', SubscriptionLevelEnum::B)
            ->whereNotNull('email')
            ->get();

        foreach ($users as $user) {
            $this->sendToUser($user);
        }

        $this->info("Отправлено $this->sent.");
    }

    public function sendToUser(User $user): void
    {
        $user->notify((new SupervisionReminder())->delay([
            'mail' => now()->addMinutes($this->sent * 2)
        ]));

        $this->sent++;
    }
}
