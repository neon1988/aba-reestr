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
    public function create(User $authUser): Response
    {
        if ($authUser->isStaff())
            return Response::allow();
        return Response::deny(__('You do not have permission to create worksheets.'));
    }

    /**
     * Determine whether the user can update the worksheet.
     */
    public function update(User $authUser, Worksheet $worksheet): Response
    {
        if ($authUser->isStaff())
            return Response::allow();
        return Response::deny(__('You do not have permission to update this worksheet.'));
    }

    /**
     * Determine whether the user can delete the worksheet.
     */
    public function delete(User $authUser, Worksheet $worksheet): Response
    {
        if ($authUser->isStaff())
            return Response::allow();
        return Response::deny(__('You do not have permission to delete this worksheet.'));
    }

    /**
     * Determine whether the user can download the worksheet.
     */
    public function download(User $authUser, Worksheet $worksheet): Response
    {
        if ($authUser->isStaff())
            return Response::allow();
        if (!$authUser->isSubscriptionActive())
            return Response::deny(__("You don't have a subscription or your subscription is inactive."));

        return Response::allow();
    }
}
