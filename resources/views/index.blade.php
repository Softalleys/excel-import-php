<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Importar archivo</title>

    <!-- <style>
                /* Style the form */
                form {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Style the file input */
        input[type="file"] {
            padding: 10px;
            background: #f8f8f8;
            border: 1px solid #ddd;
        }

        /* Style the submit button */
        button {
            padding: 10px 20px;
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }
    </style> -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Importar archivo</h1>
                <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file" class="form-control">
                    <br>
                    <button class="btn btn-primary">Enviar archivo</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>