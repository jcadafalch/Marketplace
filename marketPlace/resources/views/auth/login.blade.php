<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>LogIn</title>
</head>

<body>
    <div class="LogInContent">
        <div class="LogInContent-left">
            <div class="card-header">
                <h1>Craft Made</h1>
            </div>
            <div>
                <form class="card-form">
                    <div class="form-item">
                        <input type="text" name="name" placeholder="Nombre">
                    </div>
                    <div class="form-item">
                        <input type="mail" name="mail" placeholder="E-mail">
                    </div>
                    <div class="form-item">
                        <input type="password" name="password" placeholder="Contaseña">
                    </div>
                    <div class="form-item">
                        <input type="password" name="password" placeholder="Repite contaseña">
                    </div>
                    <div class="form-item">
                        <button class="button-LogIn" type="submit">
                            Registarse
                        </button>
                    </div>

                </form>
            </div>
        </div>
        <div class="LogInContent-right">
            <div class="logoRegistre">
                <img src="{{ asset('/images/LogoFooter.png') }}" alt="Logo" />
            </div>
        </div>
    </div>
    </div>
</body>

</html>
