<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Worksheet;
use Illuminate\Auth\Access\Response;

class WorksheetPolicy extends Policy
{
    /**
     * Determine whether the user can create worksheets.
     */
    public function create(User $user): Response
    {
        return Response::deny(__('You do not have permission to create worksheets.'));
    }

    /**
     * Determine whether the user can update the worksheet.
     */
    public function update(User $user, Worksheet $worksheet): Response
    {
        return Response::deny(__('You do not have permission to update this worksheet.'));
    }

    /**
     * Determine whether the user can delete the worksheet.
     */
    public function delete(User $user, Worksheet $worksheet): Response
    {
        return Response::deny(__('You do not have permission to delete this worksheet.'));
    }

    /**
     * Determine whether the user can download the worksheet.
     */
    public function download(User $user, Worksheet $worksheet): Response
    {
        if (!$user->isSubscriptionActive())
            return Response::deny(__("You don't have a subscription or your subscription is inactive."));

        return Response::allow();
    }
}
