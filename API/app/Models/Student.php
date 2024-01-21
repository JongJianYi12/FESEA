<?php

namespace App\Models;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = ['name','gender','email','yearOfStudy','fingerId'];
    //case id from auto-inc int to string
    protected $casts = [
        'id' => 'string'
    ];
    use HasFactory;

    public function exams()
    {
        return $this->belongsToMany(Exam::class)->withTimestamps();
    }

}
