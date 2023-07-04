<?php

namespace App\Http\Controllers;

use App\Models\Nucleotide;
use Illuminate\Http\Request;

class NucleotideController extends Controller
{
    public function checkNucleotide(Request $request)
    {
        // Se obtiene la cadena de nucleótidos
        $nucleotide = $request->nucleotide;

        // Contabilizar caracteres del nucleótido (string)
        $total_characters = strlen($nucleotide);

        // Se define el número de filas y columnas de una matriz. N*N de la matriz que queremos formar. Raiz cuadrada del número de $total_characters
        $matrix_sides = sqrt($total_characters);
        // return $matrix_sides;

        // Se separan los nucleótidos en una matriz, según el número de filas y columnas definido anteriormente
        $matrix = str_split($nucleotide, round($matrix_sides));
        // return $matrix;

        //Arrays de los caracteres que se van a obtener de las diagonales de la matriz
        $first_diagonal = [];
        $second_diagonal = [];

        foreach ($matrix as $key => $row) {
            // Creo un array con los caracteres de una fila de la matriz y los separo. Ejemplo: "ABC" --> ["A", "B", "C"]
            $arrayRow = str_split($row);

            // Obtengo los caracteres de la primer diagonal. Tomo la fila de la matriz, en cada iteración, 
            //y obtengo un caracter según la posición de $key en el array de cada fila.
            if (isset($arrayRow[$key])) {  // Se valida que el nucleotido este definido (caso donde la raíz de los caracteres totales de $nucleotides no se una cuadrado perfecto)
                $first_diagonal[] = $arrayRow[$key];
            }

            // Genero una posición inversa a la anterior. Ejemplo de 2 a 0.
            // La longitud de la matriz, menos uno, menos la posición de la iteración
            $position = round($matrix_sides) - 1 - $key;

            // Obtengo los caracteres de la segunda diagonal. Tomo la fila de la matriz, en cada iteración, 
            //y obtengo un caracter según la posición de $position en el array de cada fila.
            if (isset($arrayRow[$position])) {
                $second_diagonal[] = $arrayRow[$position];
            }
        }
        // return $second_diagonal;

        // return $second_diagonal;
        $countValues = array_count_values($second_diagonal);

        foreach ($countValues as $key => $value) {
            if ($value === 2) {
                return "Se repite " . $key;
            }
        }

        return "NO mutante";

        $newNucleotide = Nucleotide::create([
            'nucleotide' => $request->nucleotide,
            'mutation' => $request->mutation,
        ]);

        return "check";
    }
}
