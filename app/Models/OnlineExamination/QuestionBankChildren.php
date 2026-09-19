<?php

namespace App\Models\OnlineExamination;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionBankChildren extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'question_bank_id',
        'option'
    ];
}
