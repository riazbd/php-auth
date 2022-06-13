<?php

require_once 'core/init.php';

if (Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validate->check($_POST, array(
            'name' => array(
                'name' => 'Name',
                'required' => true,
                'min' => 2,
                'max' => 50
            ),
            'email' => array(
                'name' => 'Email',
                'required' => true,
                'unique' => 'users'
            ),
            'username' => array(
                'name' => 'Username',
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users'
            ),
            'password' => array(
                'name' => 'Password',
                'required' => true,
                'min' => 6
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
        ));

        if ($validate->passed()) {
            $user = new User();
            $salt = Hash::salt(32);
            $passwoord = Input::get('password');

            try {
                $user->create(array(
                    'name' => Input::get('name'),
                    'email' =>  Input::get('email'),
                    'username' => Input::get('username'),
                    'password' => $passwoord,
                    'salt' => $salt,
                    'join_date' => date('Y-m-d H:i:s'),
                    'group' => 1
                ));

                Session::flash('home', 'Welcome ' . Input::get('username') . '! Your account has been registered. You may now log in.');
                Redirect::to('index.php');
            } catch(Exception $e) {
                //echo $e->getTraceAsString(), '<br>';
                echo $e;
            }
        } else {
            foreach ($validate->errors() as $error) {
                echo $error . "<br>";
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
    <title>Document</title>
</head>
<body>
    <div class="d-flex justify-content-center items-center">
        <div class="card mt-5 w-25">
            <div class="card-body">
                <form class="" action="" method="post">
                    <div class="field form-group">
                        <label for="name">Name</label>
                        <input class="form-control" type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name">
                    </div>

                    <div class="field form-group">
                        <label for="name">Email</label>
                        <input class="form-control" type="email" name="email" value="<?php echo escape(Input::get('email')); ?>" id="email">
                    </div>

                    <div class="field form-group">
                        <label for="username">Username</label>
                        <input class="form-control" type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>">
                    </div>

                    <div class="field form-group">
                        <label for="password">Password</label>
                        <input class="form-control" type="password" name="password" id="password">
                    </div>

                    <div class="field form-group">
                        <label for="password_again">Password Again</label>
                        <input class="form-control" type="password" name="password_again" id="password_again" value="">
                    </div>

                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                    <div class="form-group">
                        <input class="form-control btn btn-primary" type="submit" value="Register">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>


