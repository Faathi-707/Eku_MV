<?php

namespace App\Policies;

use App\Models\DisruptionReport;
use App\Models\User;

class DisruptionReportPolicy
{
    public function view(User $user, DisruptionReport $disruptionReport): bool
    {
        return $user->id === $disruptionReport->user_id;
    }

    public function update(User $user, DisruptionReport $disruptionReport): bool
    {
        return $user->id === $disruptionReport->user_id;
    }

    public function delete(User $user, DisruptionReport $disruptionReport): bool
    {
        return $user->id === $disruptionReport->user_id;
    }
}
