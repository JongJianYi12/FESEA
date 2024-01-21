<?php

namespace App\Models;

use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exam extends Model
{


    protected $table = 'exams';

    protected $fillable = ['title','venue','date','time','duration'];
    protected $casts = [
        'id' => 'string'
    ];
    use HasFactory;

    public function students()
    {
        return $this->belongsToMany(Student::class)->withTimestamps();
    }
}
