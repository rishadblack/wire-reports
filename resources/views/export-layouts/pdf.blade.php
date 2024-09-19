<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Report PDF Component</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        @font-face {
            font-family: 'SolaimanLipi';
            src: url('{{ url('fonts/SolaimanLipi.ttf') }}') format('truetype');
        }

        /* body {
            font-family: 'SolaimanLipi', sans-serif;
            font-size: 12px;
        } */

        /* .bold {
            font-weight: bold;
        } */

        /* td {
            border: 1px solid black;
        } */
    </style>
</head>

<body>
    @includeIf($view)
</body>

</html>
