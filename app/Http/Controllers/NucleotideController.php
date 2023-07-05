<?php

namespace App\Http\Controllers;

use App\Models\Nucleotide;
use Illuminate\Http\Request;

class NucleotideController extends Controller
{
    public function checkNucleotide(Request $request)
    {
        // Se obtiene la cadena de nucleótidos, se les quita los espacios y pone el texto todo en mayúscula
        $nucleotide = strtoupper(str_replace(' ', '', $request->nucleotide));

        // Contabilizar caracteres del nucleótido (string)
        $total_characters = strlen($nucleotide);

        // Se definen variable $matrix y $matrix_sides en el método para generar una matriz
        list($matrix, $matrix_sides) = $this->generateMatrix($nucleotide, $total_characters);

        // En el caso de que los lados de la matriz sean flotantes no se podra seguir con el proceso
        if(is_float($matrix_sides)) {
            return "No es posible realizar una matriz con la cantidad de caracteres ingresados";
        }

        //Arrays de los caracteres que se van a obtener de las diagonales de la matriz
        $first_diagonal = [];
        $second_diagonal = [];

        foreach ($matrix as $key => $row) {
            // Creo un array con los caracteres de una fila de la matriz y los separo. Ejemplo: "ABC" --> ["A", "B", "C"]
            $arrayRow = str_split($row);

            // Obtengo los caracteres de la primer diagonal. Tomo la fila de la matriz, en cada iteración, 
            //y obtengo un caracter según la posición de $key en el array de cada fila.
            $first_diagonal[] = $arrayRow[$key];


            // Genero una posición inversa a la anterior. Ejemplo de 2 a 0.
            // La longitud de la matriz, menos uno, menos la posición de la iteración
            $position = round($matrix_sides) - 1 - $key;

            // Obtengo los caracteres de la segunda diagonal. Tomo la fila de la matriz, en cada iteración, 
            //y obtengo un caracter según la posición de $position en el array de cada fila.
            $second_diagonal[] = $arrayRow[$position];
        }

        // return $first_diagonal;
        // return $second_diagonal;

        // Se contabilizan los caracteres de cada Diagonal. Ejemplo ["G": 1, "U": 2]
        $first_diagonal_count_values = array_count_values($first_diagonal);
        // return $first_diagonal_count_values;
        $second_diagonal_count_values = array_count_values($second_diagonal);
        // return $second_diagonal_count_values;

        // Método que verifica si es mutante ó no el ARN. Retorna un boolean 
        $mutation = $this->countAndVerifyCharacters($first_diagonal_count_values);
        
        // Si la primera diagonal no es mutante se pasa a verificar la segunda diagonal
        if (!$mutation) {
            $mutation = $this->countAndVerifyCharacters($second_diagonal_count_values);
        }

        // $newNucleotide = Nucleotide::create([
        //     'nucleotide' => $request->nucleotide,
        //     'mutation' => $request->mutation,
        // ]);
        // return $first_diagonal;
        // return $second_diagonal;

        if ($mutation) {
            return "Es mutante";
        } else {
            return "no es mutante";
        }
    }

    public function generateMatrix($nucleotide, $total_characters) : array 
    {
        // Se define el número de filas y columnas de una matriz. N*N de la matriz que queremos formar. Raiz cuadrada del número de $total_characters
        $matrix_sides = sqrt($total_characters);

        // Verifico si los lados de la matriz son valores enteros y no flotantes. Ya que si es flotante no se podra realizar una matriz (según el enunciado por comodidad de utiliza N*N)
        if ($matrix_sides == (int)$matrix_sides) {
            $matrix_sides = (int)$matrix_sides;
        }

        // En el caso de que los lados de la matriz sean flotantes no se podra seguir con el proceso
        // if(is_float($matrix_sides)) {
        //     return "No es posible realizar una matriz con la cantidad de caracteres ingresados";
        // }

        // Se separan los nucleótidos en una matriz, según el número de filas y columnas definido anteriormente. Ejemplo: "AUGAUCUCG" en 3 partes ($matrix_sides) -> ["AUG", "AUC", "UCG"]
        $matrix = str_split($nucleotide, round($matrix_sides));

        return array($matrix, $matrix_sides);
    }

    public function countAndVerifyCharacters($diagonal) : bool
    {
        // Se recorre cada caracter de $diagonal y si uno de ellos esta duplicado entonces se define que es mutante (return true), si no sucede la duplicación esta OK el ARN (return false)
        foreach ($diagonal as $value) {
            if ($value === 2) {
                return true;
            }
        }

        return false;
    }
}
