<?php

namespace App\Console\Commands;

use App\Enums\PaymentProvider;
use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use App\Services\RobokassaService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PaymentUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payments:update {id : ID платежа}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновляет информацию о платеже';
    private ?Payment $payment;
    private RobokassaService $robokassaService;

    public function __construct(RobokassaService $robokassaService)
    {
        parent::__construct();
        $this->robokassaService = $robokassaService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');

        $this->payment = Payment::findOrFail($id);

        DB::transaction(function () {
            if ($this->payment->payment_provider == PaymentProvider::RoboKassa)
                $this->robokassa();
            else
                throw new \Exception('Payment provider '.$this->payment->payment_provider.' not implemented');
        });

        return Command::SUCCESS;
    }

    /**
     * @throws \Exception
     */
    public function robokassa(): void
    {
        $data = $this->robokassaService->checkPaymentStatus($this->payment->payment_id);
        Log::info('Robokassa payment show', $data);

        $this->payment->meta = $data;

        if (intval($this->payment->meta['Result']['Code']) == 3) {
            $this->payment->status = PaymentStatusEnum::CANCELED;
        } elseif (intval($this->payment->meta['Result']['Code']) == 0) {
            $this->payment->amount = $this->payment->meta['Info']['OutSum'];
            $this->payment->status = PaymentStatusEnum::SUCCEEDED;
        } else {
            throw new \Exception('Invalid code '.$this->payment->meta['Result']['Code'].'');
        }

        $this->payment->save();
    }
}
