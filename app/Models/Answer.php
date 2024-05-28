<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'choice_id',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
    
    public function choice()
    {
        return $this->belongsTo(Choice::class);
    }
}
