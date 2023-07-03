<?php

namespace App\Http\Controllers;

use App\Models\Nucleotide;
use Illuminate\Http\Request;

class NucleotideController extends Controller
{
    public function checkNucleotide(Request $request)
    {
        $nucleotide = Nucleotide::create([
            'nucleotide' => $request->nucleotide,
            'mutation' => $request->mutation,
        ]);

        return "check";
    }
}
