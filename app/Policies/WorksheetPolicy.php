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
        if ($worksheet->isVideo())
            return Response::deny(__("The video file cannot be downloaded."));

        if ($authUser->isStaff())
            return Response::allow();

        if ($worksheet->isPaid())
            if (!$authUser->isSubscriptionActive())
                return Response::deny(__("You don't have a subscription or your subscription is inactive."));

        return Response::allow();
    }

    /**
     * Determine whether the user can watch the worksheet.
     */
    public function watch(User $authUser, Worksheet $worksheet): Response
    {
        if (!$worksheet->isVideo())
            return Response::deny(__("You can only watch it if the file is a video file."));

        if ($authUser->isStaff())
            return Response::allow();

        if ($worksheet->isPaid())
            if (!$authUser->isSubscriptionActive())
                return Response::deny(__("You don't have a subscription or your subscription is inactive."));

        return Response::allow();
    }

    /**
     * Determine whether the user can buy the worksheet.
     */
    public function buy(?User $authUser, Worksheet $worksheet): Response
    {
        if (empty($authUser))
            return Response::allow();

        if (!$worksheet->isPaid())
            return Response::deny(__("The worksheet is not paid."));

        if ($authUser->isStaff())
            return Response::deny();

        if ($worksheet->isPaid())
            if ($authUser->isSubscriptionActive())
                return Response::deny(__("You can't buy it because you already have a subscription"));

        return Response::allow();
    }
}
