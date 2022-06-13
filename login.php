<?php

require_once 'core/init.php';

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));

        if($validate->passed()) {
            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if($login) {
                Redirect::to('index.php');
            } else {
                echo '<p>Incorrect username or password</p>';
            }
        } else {
            foreach($validate->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Login</title>
</head>
<body>
    <div class="d-flex justify-content-center items-center mt-5">
        <div class="card">
            <div class="card-body">
                <form action="" method="post">
                    <div class="field form-group">
                        <label for='username'>Username</label>
                        <input class="form-control" type="text" name="username" id="username">
                    </div>

                    <div class="field form-group">
                        <label for='password'>Password</label>
                        <input class="form-control" type="password" name="password" id="password">
                    </div>


                        <label for="remember">
                            <input class="checkbox" type="checkbox" name="remember" id="remember">Remember me
                        </label>


                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    <div class="form-group">
                        <input class="form-control btn btn-primary" type="submit" value="Login">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>


