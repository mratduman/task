<!doctype html>
<html lang="tr">
<head>
    <title>Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="loginStyle/css/style.css">

    <script src="loginStyle/js/jquery.min.js"></script>
    <script src="loginStyle/js/popper.js"></script>
    <script src="loginStyle/js/bootstrap.min.js"></script>
    <script src="loginStyle/js/main.js"></script>

    <script type="text/javascript">
        function login(isAdmin) {
            let endPoint;
            let redirect_url;

            if (isAdmin) {
                endPoint = "{{route('login.admin')}}";
                redirect_url = "{{route('admin')}}";
            }else {
                endPoint = "{{route('login.login')}}";
                redirect_url = "{{route('home')}}";
            }

            let data = $('#login_form').serialize();

            $.post(endPoint, data, function (result) {
                if (result.success) {
                    window.location.href = redirect_url;
                }else {
                    console.log(result);
                    alert(result.message);
                }
            });
        }
    </script>
</head>
<body>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-5">
                <div class="login-wrap p-4 p-md-5">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="fa fa-user-o"></span>
                    </div>
                    <h3 class="text-center mb-4">Giris Yap</h3>
                    <form action="#" class="login-form" id="login_form" method="post">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" class="form-control rounded-left" placeholder="E-posta" required>
                        </div>
                        <div class="form-group d-flex">
                            <input type="password" name="password" class="form-control rounded-left" placeholder="Şifre" required>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-100">
                                <button type="button" onclick="javascript:login(false);" class="form-control btn btn-primary rounded submit px-3">Giriş</button>
                            </div>
                        </div>
                        <div class="form-group d-md-flex">
                            <div class="w-100">
                                <button type="button" onclick="javascript:login(true);" class="form-control btn btn-default btn btn-sm">Admin Girişi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>
