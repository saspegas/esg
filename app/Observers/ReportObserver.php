<?php

namespace App\Observers;

use App\Models\Report;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class ReportObserver implements ShouldHandleEventsAfterCommit
{
    /**
     * Handle the Report "created" event.
     */
    public function created(Report $report): void
    {
        if ($report->status === 'in_progress') {
            $avg = $report->answers->avg('choice.score');
            $report->update([
                'score' => $avg,
                'status' => 'completed',
            ]);
        }
    }

    /**
     * Handle the Report "updated" event.
     */
    public function updated(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "restored" event.
     */
    public function restored(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "force deleted" event.
     */
    public function forceDeleted(Report $report): void
    {
        //
    }
}
