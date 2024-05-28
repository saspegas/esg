<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Filament\Actions;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\ReportResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReport extends CreateRecord
{
    protected static string $resource = ReportResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        DB::beginTransaction();

        try {
            $report = Report::create([
                'user_id' => auth()->id(),
                'title' => 'Report ' . date('Y-m-d H:i:s'),
                'status' => 'in_progress',
            ]);

            \collect($data)->each(function($value, $questionId) use ($report) {
                $report->answers()->create([
                    'question_id' => $questionId,
                    'choice_id' => $value,
                ]);
            });

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }

        return $report;
    }
}
