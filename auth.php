<?php
session_start();
?>

<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link href="css/auth.css" rel="stylesheet">

  <meta content="width=device-width, initial-scale=1" name="viewport">
  <title>Авторизация</title>

  <!--[if lt IE 9] --> 
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> 
  <!--[endif]-->

 </head>
 <body>
 <?php if (isset($_SESSION['error'])): ?>

<p style="color: red; position: absolute; left: 43%; top: 10vw;"><?php echo $_SESSION['error']; ?></p> 
<?php unset($_SESSION['error']); ?> <?php endif; ?> 
    <a href="index.php"><div class="back"><Назад</div></a>
    <div class="text">Вход</div>
    <div class="form_text">
        <form action="php/login.php" method="POST"> 
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" name="submit" value="Войти">
            <label for="login">Ещё не зарегистрированы?  <a href="register.php">Зарегистрироваться</a></label> 
        </form> 
    </div>
    </form>
 </body>
</html>