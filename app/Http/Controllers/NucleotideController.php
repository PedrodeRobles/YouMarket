<?php

namespace App\Http\Controllers;

use App\Models\Nucleotide;
use Illuminate\Http\Request;

class NucleotideController extends Controller
{
    public function checkNucleotide(Request $request)
    {
        //Obtener nucleotido
        $nucleotide = $request->nucleotide;

        //Caracteres del string 
        $total_characters = strlen($nucleotide);

        //N*N de la matriz que queremos formar
        $matrix_sides = sqrt($total_characters);

        //Separar nucleotidos en una matriz
        $matrix = str_split($nucleotide, $matrix_sides);

        //Arrays de los caracteres que se van a obtener de las diagonales de la matriz
        $first_diagonal = [];
        $second_diagonal = [];

        foreach ($matrix as $key => $row) {
            // Creo un array con los caracteres de una fila de la matriz pero separados. Ejemplo: "ABC" --> ["A", "B", "C"]
            $arrayRow = str_split($row);
            
            // Obtengo los caracteres de la primer diagonal. Tomo la fila de la matriz, en cada iteración, 
            //y obtengo un caracter según la posición de $key en el array de cada fila.
            $first_diagonal[] = $arrayRow[$key];

            // Genero una posición inversa a la anterior. Ejemplo de 2 a 0.
            // La longitud de la matriz, menos uno, menos la posición de la iteración
            $position = $matrix_sides - 1 - $key;

            // Obtengo los caracteres de la segunda diagonal. Tomo la fila de la matriz, en cada iteración, 
            //y obtengo un caracter según la posición de $position en el array de cada fila.
            $second_diagonal[] = $arrayRow[$position];
        }

        return $second_diagonal;

        $newNucleotide = Nucleotide::create([
            'nucleotide' => $request->nucleotide,
            'mutation' => $request->mutation,
        ]);

        return "check";
    }
}
