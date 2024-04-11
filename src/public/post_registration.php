<?php

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['psw'];
$passwordRep = $_POST['psw-repeat'];

$errors = [];
if (strtoupper($name[0]) !== $name[0]){
    $errors['name'] = 'Имя начинается с большой буквы!';
}
if (!ctype_alpha($name)) {
    $errors['name'] = 'Имя состоит только из букв!';
}
if (strlen($name) < 2) {
    $errors['name'] = 'Имя состоит из 2-х и более букв!';
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Email некорректен!';
}
if (preg_match("/^[a-zA-Z0-9]+$/", $password)) {
    $errors['psw'] = 'Пароль должен состоять из цифр, букв и символов!';
}
if ($password !== $passwordRep) {
    $errors['psw-repeat'] = 'Повторный пароль введен не верно!';
}
if (empty($errors)) {

    $pdo = new PDO("pgsql:host=db; port=5432; dbname=dbname", "dbuser", "dbpwd");

//$pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
    $password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt -> execute(['email' => $email]);
    $result = $stmt->fetch();
}
?>
<form method="POST" action="post_registration.php">
    <div class="container">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>

        <label for="name"><b>Name</b></label>
        <label style="color: green"><?php if (empty($errors['name']))
            {echo 'Готово';} ?> </label>
        <label style="color: red"><?php if (isset($errors['name']))
            {echo $errors['name'];} ?> </label>
        <input type="text" placeholder="Enter Name" name="name" id="name" required>

        <label for="email"><b>Email</b></label>
        <label style="color: green"><?php if (empty($errors['email']))
            {echo 'Готово';} ?> </label>
        <label style="color: red"><?php if (isset($errors['email']))
            {echo $errors['email'];} ?> </label>
        <input type="text" placeholder="Enter Email" name="email" id="email" required>

        <label for="psw"><b>Password</b></label>
        <label style="color: green"><?php if (empty($errors['psw']))
            {echo 'Готово';} ?> </label>
        <label style="color: red"><?php if (isset($errors['psw']))
            {echo $errors['psw'];} ?> </label>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" required>

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <label style="color: green"><?php if (empty($errors['psw-repeat']))
            {echo 'Готово';} ?> </label>
        <label style="color: red"><?php if (isset($errors['psw-repeat']))
            {echo $errors['psw-repeat'];} ?> </label>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" required>
        <hr>

        <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
        <button type="submit" class="registerbtn">Register</button>
    </div>

    <div class="container signin">
        <p>Already have an account? <a href="#">Sign in</a>.</p>
    </div>
</form>

<style>
    * {box-sizing: border-box}

    /* Add padding to containers */
    .container {
        padding: 16px;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit/register button */
    .registerbtn {
        background-color: #04AA6D;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity:1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>
