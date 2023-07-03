<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nucleotide extends Model
{
    use HasFactory;

    protected $fillable = [
        'nucleotide',
        'mutation'
    ];
}
