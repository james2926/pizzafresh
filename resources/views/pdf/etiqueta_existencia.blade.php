<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Presupuesto</title>
    <style>
        * body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 14px;
        }

        th,
        td {
            text-align: left;
            padding: 8px;
        }

        /*div table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }*/
        .titulo {
            width: 100% !important;
            text-align: center;
            padding-top: 1rem;
            padding-bottom: 1rem;
            font-weight: bold;
            font-size: 1.2rem;
            text-transform: uppercase;
        }
        .codigo {
            margin-left: auto;  margin-right: auto;  text-align:center;
        }
        .codigo_text {
            width: 100% !important;
            text-align: center;
            padding-top: 0.2rem;
        
       
        }
        .almacen{
            padding-top:0;
        }

    </style>
</head>

<body>

    <div style="border:1px solid grey;width:50%">
        <div class="titulo">{{$existencia['nombre']}}</div>
        <div style="width:100% !important; ">
            <div class="codigo">
                <img src="data:image/jpeg;base64,{{$barcode}}" /><br>
            </div>
            <div class="codigo_text">
                {{$existencia['codigo']}}
            </div>
             <div class="titulo">
                {{$existencia['color']}}
            </div>
            <div class="titulo almacen">
                {{$existencia['estante']}}
            </div>
        </div>
    </div>
</body>

</html>
