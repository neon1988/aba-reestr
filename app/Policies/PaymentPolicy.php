<?php

namespace App\Policies;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PaymentPolicy extends Policy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Payment $payment): Response
    {
        if ($user->isStaff())
            return Response::allow();

        if ($user->is($payment->user))
            return Response::allow(__('You are allowed to view this payment.'));

        return Response::deny(__('You are not authorized to view this payment.'));
    }
}
