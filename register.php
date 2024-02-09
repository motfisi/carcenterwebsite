
<?php
session_start();
?>
<!DOCTYPE html>
<html>
 <head>
  <meta charset="utf-8">
  <link href="css/reg.css" rel="stylesheet">
  <script src="js/maskinput.js" defer></script>
  <meta content="width=device-width, initial-scale=1" name="viewport">
  <title>Регистрация</title>

  <!--[if lt IE 9] --> 
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script> 
  <!--[endif]-->

 </head>
 <body>
    <a href="index.php"><div class="back"><Назад</div></a>
    <div class="text">Регистрация</div>
    <?php if (isset($_SESSION['error'])): ?>

<p style="color: red; position: absolute; left: 28%; top: 10vw;"><?php echo $_SESSION['error']; ?></p> 
<?php unset($_SESSION['error']); ?> <?php endif; ?> 

    <div class="form_text">
        <form action="php/reg.php" method="POST"> 
            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            <label for="tel">Телефон:</label>
            <input type="text" id="tel" name="tel" required> 
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" required>
            <input type="submit" name="submit" value="Зарегистрироваться">
            <label for="login">Уже зарегистрированы?  <a href="auth.php">Войти</a></label> 
        </form> 
    </div>
    </form>
 </body>
</html>