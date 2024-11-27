<!DOCTYPE html>
<html>
@php
$logo = 'data:image/jpeg;base64,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';
@endphp
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Etiqueta</title>
    <style>
        @page {
            margin: 15px;
        }

        body {
            margin: 0px;
        }

        * body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            padding: 0 !important;
            margin: 0 !important;
            font-size: 5;

        }


        .page_break {
            page-break-before: always;
        }

        table {
            width: 100%;
        }

        :where(th, td):not(.max) {
            width: 0;
            white-space: nowrap;
        }

        /* For demo purposes */
        table,
        th,
        td {}

        /*div table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }*/
        .bold {
            font-weight: bold
        }


        .almacen {
            padding-top: 0;
        }

    </style>
</head>

<body>
    @php
        $inicio = 0;
    @endphp
    @foreach($articulos as $key => $articulo)
    @for($i = 0; $i < $articulo['cantidad_imprimir']; $i++)
    @if($inicio >0)
          <div class="page_break"></div>
    @endif
    @php
        $inicio = 1;
    @endphp
     <table>
        <tr>
            <td style="vertical-align:top; padding-bottom:0.259rem">
                <img width="80px" src="{{$logo}}">
            </td>
            <td class=".max" style="text-align:right;; vertical-align:top;">
                <div class="bold">Hermanos Viudes S.L.</div>
                <div class="bold">RGSEAA: 20.044822/A</div>
            </td>
        </tr>
        </table>
        <div class="bold">{{strtoupper($articulo['articulo']['nombre'])}} 100g (UNIDAD)</div>
        <div class="bold">{{$language['fecha_elaboracion']}} {{date("d - m - Y")}} – {{$language['consumo_preferente']}} {{$caducidad}}</div>
        <div><span class="bold">{{$language['ingredientes_1']}}</span>{{$language['ingredientes_2']}}</div>
        <div class="bold">{{$language['informacion_nutricional']}}</div>
        <div class="">{{$language['valor_energetico']}}</div>
        <div><span class="bold">{{$language['conservacion_1']}}</span>{{$language['conservacion_2']}}</div>
        <div><span class="bold">{{$language['elaboracion_1']}}</span>{{$language['elaboracion_2']}}</div>
        
        @endfor
        @endforeach


</body>

</html>
