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
}
