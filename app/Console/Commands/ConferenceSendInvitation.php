<?php

namespace App\Console\Commands;

use App\Models\Conference;
use App\Models\User;
use App\Notifications\ConferenceInvitationNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ConferenceSendInvitation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'conference:send-invitations {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Рассылает приглашения на мероприятие';

    private int $sent = 0;

    private ?Conference $conference;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->conference = Conference::findOrFail($this->argument('id'));

        if ($this->conference->isEnded())
        {
            $this->error(__("The conference is ended"));
            return Command::FAILURE;
        }

        if (!$this->conference->shouldNotifyAgain()) {
            $this->error(__("The notifications were sent very recently."));
            return Command::FAILURE;
        }

        if (empty($this->conference->available_for_subscriptions)) {
            $this->error(__("The conference is not available for subscriptions."));
            return Command::FAILURE;
        }

        $this->sent = 0;

        // Находим пользователей, которым ещё не отправляли
        $users = User::whereIn('subscription_level', $this->conference->available_for_subscriptions)
            ->activeSubscription()
            ->whereNotNull('email')
            ->get();

        foreach ($users as $user) {
            $this->sendToUser($user);
        }

        $this->conference->last_notified_at = Carbon::now();
        $this->conference->save();

        $this->info("Отправлено $this->sent.");

        return Command::SUCCESS;
    }

    public function sendToUser(User $user): bool
    {
        if (!$user->isSubscriptionActive())
            return false;

        $user->notify((new ConferenceInvitationNotification($this->conference))->delay([
            'mail' => now()->addMinutes($this->sent * 2)
        ]));

        $this->sent++;

        return true;
    }
}
