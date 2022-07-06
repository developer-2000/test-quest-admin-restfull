<!-- Главная страница клиента -->
@extends('layouts.app-auth')

    @section('content')

        <div id="auth" class="login-box">
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    {{-- авторизация --}}
                    <form action="#" id="form_signin">
                        <!-- Email -->
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" id="email_signin">
                        </div>
                        <!-- Password -->
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" id="password_signin">
                        </div>
                        <button type="submit" class="btn btn-block but_auth" id="but_signin">Авторизация</button>
                    </form>

                    {{-- регистрация --}}
                    <form action="#" id="form_signup">
                        <!-- Email -->
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" id="email_signup">
                        </div>
                        <!-- Password -->
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" id="password_signup">
                        </div>
                        <!-- Confirm Password -->
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Confirm password" id="confirm_password_signup">
                        </div>
                        <button type="submit" class="btn btn-block but_auth" id="but_signup">Регистрация</button>
                    </form>

                    {{-- переключение действий --}}
                    <div id="switch_auth">Выполнить регистрацию</div>

                </div>
            </div>
        </div>

    @endsection

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            let loc = window.location;
            let domen = loc.protocol+"//"+loc.hostname;

            // =================
            // переключатель form
            $('#switch_auth').click(function () {
                let stringSwitch = ["Выполнить регистрацию", "Выполнить авторизацию"];

                // заменить надпись
                for (var i=0; i < stringSwitch.length; i++) {
                    if(stringSwitch[i] != $("#switch_auth").text()){
                        $("#switch_auth").text(stringSwitch[i]);
                        break;
                    }
                }
                // отобразить другую form
                $('form').each(function() {
                    if($(this).css('display') == 'none') {
                        $(this).css({'display':'block'})
                    }
                    else {
                        $(this).css({'display':'none'})
                    }
                });
            });

            // =================
            // клик по кнопке авторизации
            $('#but_signin').click(function() {
               makeAuth()
            });

            async function makeAuth(){

                await fetch(domen+'/api/auth/signin', {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    method: 'post',
                    credentials: "same-origin",
                    body: JSON.stringify({
                        email: $("#email_signin").val(),
                        password: $("#password_signin").val()
                    })
                })
                .then(data => data.json())
                .then( response => {
                    if (response.api_token !== undefined) {
                        localStorage.setItem('bearer_token', 'Bearer '+response.api_token);
                        window.location.href = '/admin';
                    }
                    else {
                        console.log(response.errors);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            }

            // =================
            // клик по кнопке регистрации
            $('#but_signup').click(function() {
                fetch(domen+'api/auth/signup', {
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json, text-plain, */*",
                        "X-Requested-With": "XMLHttpRequest",
                    },
                    method: 'post',
                    // credentials: "same-origin",
                    body: JSON.stringify({
                        email: $("#email_signup").val(),
                        password: $("#password_signup").val(),
                        password_confirmation: $("#confirm_password_signup").val()
                    })
                })
                    .then(data => data.json())
                    .then( response => {
                        if (response.errors === undefined) {
                            localStorage.setItem('bearer_token', 'Bearer '+response.api_token);
                            localStorage.setItem('auth_email', $("#email_signup").val());
                            localStorage.setItem('auth_password', $("#password_signup").val());
                            window.location.href = '/admin';
                        }
                        else {
                            console.log(response.errors);
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            });

        // END
        });
    </script>
@endsection

@section('style')
    @parent
    <style>
        #auth {
            margin: 10% auto 0px;
        }
        #form_signup {
            display: none;
        }
        #switch_auth {
            cursor: pointer;
            color: blue;
            margin-top: 20px;
        }
        .but_auth {
            outline: 1px solid #c6c6c6;
            background: #f2f2f2;
        }
    </style>
@endsection


