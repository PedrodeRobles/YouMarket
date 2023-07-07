<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Sobre el proyecto

Se trata de una API que recive una cadenas de nucleótidos, esta diseñada para un laboratorio y su funciones son las siguientes:

- Verificar si la cadena de nucleótidos se trata de una mutación o no
- Almacenar información de las cadenas de nucleótidos ingresadas (solo si logran formar una matriz, ver casos de prueba)
- Consultar y calcular estadisticas de casos mutantes, y no mutantes, historicos.

## EndPoints

**Endpoint: /check-nucleotide**

Método: POST

Descripción:
Este endpoint se utiliza para verificar y analizar un nucleótido proporcionado. Se espera que el nucleótido sea enviado en el cuerpo de la solicitud en formato JSON con el siguiente parámetro:

Parámetros de la solicitud:

- nucleotide (string): El nucleótido a analizar.

Requisitos y comportamiento:

- La raíz cuadrada de la cantidad de caracteres en el nucleótido debe ser un número entero (cuadrado perfecto) para poder formar una matriz. En caso contrario, el proceso terminará, no se registrará ningún resultado y se recibe un mensaje explicando el inconveniente.
- Se verificará si hay caracteres repetidos en cualquier diagonal de la matriz generada. Si se encuentra un carácter repetido exactamente dos veces en cualquier diagonal, se considerará una mutación. Si no se cumple esta condición, se considerará normal. En ambos casos se almacenara el registro en la base de datos.

Respuesta:

- En caso de éxito, se devolverá un estado 201 (Creación) junto con un mensaje indicando si se trata de una mutación o no.
- En caso de error, se devolverá un mensaje de error y el estado correspondiente.



**Endpoint: /statistics**
Método: GET

Descripción:
Este endpoint se utiliza para obtener estadísticas basicas relacionadas con las mutaciones registradas en la base de datos.

Requisitos:

- No se requiere ningún parámetro en la solicitud.

Respuesta:

- Se devolverá un estado 200 (OK) junto con la siguiente información:
  - Porcentaje de mutaciones registradas en la base de datos.
  - Total de casos registrados en la base de datos.
  - Total de casos mutantes registrados en la base de datos.



### Casos de prueba

Caso de Prueba 1:

- Descripción: Cadena de ADN válida con repeticiones en diagonales.
- Entrada:
```
{
  "nucleotide": "AUGAUCUCG"
}
```
- Resultado Esperado:
  - Estado de respuesta: 201 (OK)
  - Cuerpo de respuesta: El nucleótido: AUGAUCUCG TIENE UNA MUTACIÓN


Caso de Prueba 2:

- Descripción: Cadena de ADN válida sin repeticiones en diagonales.
- Entrada:
```
{
  "nucleotide": "CGTAGTACT"
}
```
- Resultado Esperado:
  - Estado de respuesta: 201 (OK)
  - Cuerpo de respuesta: El nucleótido: CGTAGTACT NO IENE UNA MUTACIÓN 


Caso de Prueba 3:

- Descripción: Cadena de ADN inválida sin cuadrado perfecto para formar una matriz.
- Entrada:
```
{
  "nucleotide": "AUGAUCUC"
}
```
- Resultado Esperado:
  - Estado de respuesta: 400 (Bad Request)
  - Cuerpo de respuesta: No es posible realizar una matriz con la cantidad de caracteres ingresados


Caso de Prueba 4:

- Descripción:  Cadena de ADN válida con espacios. Los espación se eliminan
- Entrada:
```
{
  "nucleotide": " AUGAU C P UC "
}
```
- Resultado Esperado:
  - Estado de respuesta: 201 (OK)
  - Cuerpo de respuesta: El nucleótido: AUGAUCPUC NO IENE UNA MUTACIÓN 


Caso de Prueba 5:

- Descripción:  Cadena de ADN con caracteres especiales. Se consideran validas tambien
- Entrada:
```
{
  "nucleotide": "!???!?&?="
}
```
- Resultado Esperado:
  - Estado de respuesta: 201 (OK)
  - Cuerpo de respuesta: El nucleótido: !???!?&?= IENE UNA MUTACIÓN
 

Caso de Prueba 6:

- Descripción:  Cadena de ADN con minúsculas. La minúsculas se transfroman en mayúsculas.
- Entrada:
```
{
  "nucleotide": "aUgAUCuCg"
}
```
- Resultado Esperado:
  - Estado de respuesta: 201 (OK)
  - Cuerpo de respuesta: El nucleótido: AUGAUCUCG IENE UNA MUTACIÓN
