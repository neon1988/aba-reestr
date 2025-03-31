<?php

namespace App\Console\Commands;

use App\Models\Payment;
use App\Enums\PaymentStatusEnum;
use Illuminate\Console\Command;
use Carbon\Carbon;

class PaymentUpdateBatch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:batch-update {minutes : Время в минутах}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновляет информацию о нескольких платежах, которые ожидают обработки и созданы более чем за указанное время';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $timeThreshold = Carbon::now()->subMinutes($this->argument('minutes'));

        $payments = Payment::where('status', PaymentStatusEnum::PENDING)
            ->where('created_at', '<', $timeThreshold)
            ->get();

        if ($payments->isEmpty()) {
            $this->info(__('Нет платежей для обновления.'));
            return Command::SUCCESS;
        }

        foreach ($payments as $payment) {
            $this->call('payments:update', ['id' => $payment->id]);
        }

        return Command::SUCCESS;
    }
}
