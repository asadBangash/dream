<?php

namespace App\Models\OnlineExamination;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\OnlineExamination\QuestionBank;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuestionGroup extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'session_id','name','status'
    ];

    public function scopeActive($query)
    {
        return $query->where('status', \App\Enums\Status::ACTIVE);
    }
    public function scopeLatest($query)
    {
        return $query->orderBy('id', 'desc');
    }

    public function onlineExams()
    {
        return $this->hasMany(OnlineExam::class, 'question_group_id','id');
    }

    public function questionBanks()
    {
        return $this->hasMany(QuestionBank::class, 'question_group_id', 'id');
    }
}
