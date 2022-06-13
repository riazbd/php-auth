<?php

require_once 'core/init.php';

if(Session::exists('home')) {
    $message = Session::flash('home');
}

$user = new User(); //Current

if($user->isLoggedIn()) {
?>

    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light container">
            <a class="navbar-brand" href="#">Navbar</a>
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

        <h4>Hello, <?php echo escape($user->data()->username)?></h4>
    </div>

<?php

    if($user->hasPermission('admin')) {
        $message =  'You are a Administrator!';
    }

} else {
    $message =  'You need to <a href="login.php">login</a> or <a href="register.php">register.</a>';
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
    <title>Helloo</title>
</head>
<body>
    <div>
        <p><?php echo isset($message) ? $message : '' ?></p>

    </div>
</body>
</html>
