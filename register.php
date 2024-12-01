<?php
include "config.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") 
{ //register user
  $Nama = $_POST['nama'];
  $email = $_POST ['email'];
  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

 // pengecekan email user
 $conn = new mysqli("localhost", "root", "", "data_user");
 $check_sql = "SELECT id FROM data_user WHERE email = ?;";
 $check_stmt = $conn->prepare($check_sql);
 $check_stmt->bind_param("s", $email);
 $check_stmt->execute();
 $check_stmt->store_result();
//jika sudah ada
if ($check_stmt->num_rows > 0) 
    { $error = "The email has already been registered"; }
else 
{
    // proses input data, jika belum ada
    $sql = "INSERT INTO data_user (nama, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nama, $email, $password);

    if ($stmt->execute()) 
    {
        header("Location: login.php");
        exit();
    } else 
    {
        $error = "There's Something Wrong, Please Try Again Later.";
    }
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Login</title>
</head>
<body>
 <h2>Register</h2>
 <?php if (isset($error)): ?>
  <p style="color: red;"><?php echo $error; ?></p>
 <?php endif; ?>
 <form method="post" action="">
            <div class="input-group">
                <label>Username</label>
                <input type="text" name="nama" required>
            </div>
            <div class="input-group">
                <label>Emailㅤ   </label>
                <input type="email" name="email" required>
            </div>
            <div class="input-group">
                <label>Password </label>
                <input type="password" name="password" required>
            </div>
            <button class="button" type="submit">Sign Up</button>
</form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
 </form>
</body>
</html>