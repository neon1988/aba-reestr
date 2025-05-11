<?php

namespace App\Console\Commands;

use App\Enums\SubscriptionLevelEnum;
use App\Models\User;
use App\Notifications\SupervisionInvitation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class SendSupervisionInvitation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:supervision-invitation {--limit=10 : Максимум писем}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Рассылает приглашение на супервизию';

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

        $limit = (int) $this->option('limit');
        $sent = 0;

        // Находим пользователей, которым ещё не отправляли
        $users = User::where('subscription_level', SubscriptionLevelEnum::B)
            ->whereNotNull('email')
            ->take($limit)
            ->get();

        foreach ($users as $user) {
            $this->sendToUser($user);
            $sent++;
        }

        $this->info("Отправлено $sent приглашений.");
    }

    public function sendToUser(User $user): void
    {
        if (!Cache::has($this->getKeyByID($user->id)))
        {
            $user->notify(new SupervisionInvitation());
            Cache::put($this->getKeyByID($user->id), 1);
        }
    }

    public function getKeyByID(int $id): string
    {
        return 'supervision_invitations_sent_'.$id;
    }
}
