<?php

namespace App\Models\OnlineExamination;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Answer extends BaseModel
{
    use HasFactory;

    protected $guarded = [];

    public function allAnswers()
    {
        return $this->hasMany(AnswerChildren::class, 'answer_id', 'id');
    }

}
