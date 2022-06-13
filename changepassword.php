<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
}

if(Input::exists()) {
    if(Token::check(Input::get('token'))) {
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'current_password' => array(
                'required' => true,
                'min' => 6
            ),
            'new_password' => array(
                'required' => true,
                'min' => 6
            ),
            'new_password_again' => array(
                'required' => true,
                'min' => 6,
                'matches' => 'new_password'
            )
        ));
    }

    if($validate->passed()) {
        if(Input::get('current_password') !== $user->data()->password) {
            echo 'Your current password is wrong.';

        } else {
            $salt = Hash::salt(32);
            $user->update(array(
                'password' => Input::get('new_password'),
                'salt' => $salt
            ));

            Session::flash('home', 'Your password has been changed!');
            Redirect::to('index.php');
        }
    } else {
        foreach($validate->errors() as $error) {
            echo $error, '<br>';
        }
    }
}
?>

<?php if($user->isLoggedIn())?>
<div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light container">
        <a class="navbar-brand" href="index.php">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">

                <li class="nav-item"><a class="nav-link" href="update.php">Update Profile</a></li>
                <li class="nav-item"><a class="nav-link" href="changepassword.php">Change Password</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Log out</a></li>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php?user=<?php echo escape($user->data()->username);?>"><?php echo escape($user->data()->username); ?></a>
                </li>
            </ul>
        </div>
    </nav>

</div>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css" integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <title>Change Password</title>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center mt-5">
        <div class="card w-25">
            <div class="card-body">
                <form action="" method="post">
                    <div class="field form-group">
                        <label for="current_password">Current Password</label>
                        <input class="form-control" class="form-control" type="password" name="current_password" id="current_password">
                    </div>

                    <div class="field form-group">
                        <label for="new_password">New Password</label>
                        <input class="form-control" type="password" name="new_password" id="new_password">
                    </div>

                    <div class="field form-group">
                        <label for="new_password_again">New Password Again</label>
                        <input class="form-control" type="password" name="new_password_again" id="new_password_again">
                    </div>

                    <input type="hidden" name="token" id="token" value="<?php echo escape(Token::generate()); ?>">
                    <div class="form-group">
                        <input class="form-control btn btn-primary" type="submit" value="Change Password">
                    </div>

                </form>
            </div>
        </div>
    </div>


</body>
</html>

