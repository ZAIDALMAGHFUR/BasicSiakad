<?php

namespace App\Models;

use App\Models\ProgramStudy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dosen extends Model
{
    use HasFactory;


    protected $table = 'dosens';
    protected $guarded = ['id'];

    public function program_study()
    {
        return $this->belongsTo(ProgramStudy::class);
    }
}
