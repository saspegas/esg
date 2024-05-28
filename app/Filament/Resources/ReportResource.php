<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Topic;
use App\Models\Choice;
use App\Models\Report;
use App\Models\Question;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Wizard;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ReportResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ReportResource\RelationManagers;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        // $topics = Topic::all();
        $topics = Topic::where('id', '<=', 20)->get();

        $steps = $topics->map(function($topic) {
            $questions = Question::where('topic_id', $topic->id)->get();

            $questionSchemas = $questions->map(function($question) {
                $choices = Choice::where('question_id', $question->id)->get()->pluck('choice', 'id');

                return Radio::make($question->id)
                    ->label($question->question)
                    ->options($choices->toArray())
                    ->required();
            });

            return Wizard\Step::make($topic->name)
                ->schema($questionSchemas->toArray());
        });

        return $form
            ->schema([
                Wizard::make($steps->toArray())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name'),
                TextColumn::make('status'),
                TextColumn::make('score')->getStateUsing(fn (Model $record) => $record->score ?? 'calculating...'),
                TextColumn::make('updated_at'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // 
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReports::route('/'),
            'create' => Pages\CreateReport::route('/create'),
            'edit' => Pages\EditReport::route('/{record}/edit'),
        ];
    }
}
