<?php 
session_start();
require 'conn.php';

if (isset($_COOKIE['id']) && isset($_COOKIE['key'])) {
	$id = $_COOKIE['id'];
	$key = $_COOKIE['key'];

	$result = mysqli_query($conn, "SELECT username FROM user WHERE id = $id");
	$row = mysqli_fetch_assoc($result);


    if ($key === hash('sha256', $row['username'])) {
		$_SESSION['login'] = true;
	}
}

if( isset($_SESSION["login"]) ) {
	header("Location: index.php");
	exit;
}

if( isset($_POST["login"]) ) {

	$username = $_POST["username"];
	$password = $_POST["password"];

	echo $username;
	echo $password;

	$result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

	// cek username
	if( mysqli_num_rows($result) === 1 ) {
		echo "username ada";
		// cek password
		$row = mysqli_fetch_assoc($result);
		echo $row["password"];
		if( password_verify($password, $row["password"]) ) {
			$_SESSION["login"] = true;

			// cek remember me
			if( isset($_POST["remember"]) ) {
				// buat cookie
				setcookie('id', $row['id'], time()+60);
				setcookie('key', hash('sha256', $row['username']), time()+60);

				// setcookie('login', 'true', time()+60);
			}
			header("Location: index.php");
			exit;
		}
	}

	$error = true;

}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Apotek Sehat</title>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">
    <style>
    body {
        font-family: 'DM Sans', sans-serif;
        /* background-color: #ecc6ff; */
        opacity: 1;

        /* background: linear-gradient(135deg, #fefcff55 25%, transparent 25%) -12px 0/ 24px 24px, linear-gradient(225deg, #fefcff 25%, transparent 25%) -12px 0/ 24px 24px, linear-gradient(315deg, #fefcff55 25%, transparent 25%) 0px 0/ 24px 24px, linear-gradient(45deg, #fefcff 25%, #ecc6ff 25%) 0px 0/ 24px 24px; */
    }

    body {
        --s: 80px;
        /* the size */
        --c: #c4ffc8;

        --_s: calc(2*var(--s)) calc(2*var(--s));
        --_g: 35.36% 35.36% at;
        --_c: #0000 66%, #a3f0a9 68% 70%, #0000 72%;
        background:
            radial-gradient(var(--_g) 100% 25%, var(--_c)) var(--s) var(--s)/var(--_s),
            radial-gradient(var(--_g) 0 75%, var(--_c)) var(--s) var(--s)/var(--_s),
            radial-gradient(var(--_g) 100% 25%, var(--_c)) 0 0/var(--_s),
            radial-gradient(var(--_g) 0 75%, var(--_c)) 0 0/var(--_s),
            repeating-conic-gradient(var(--c) 0 25%, #0000 0 50%) 0 0/var(--_s),
            radial-gradient(var(--_c)) 0 calc(var(--s)/2)/var(--s) var(--s) var(--c);
    }
    </style>
</head>

<body>

    <div class="d-flex justify-content-center align-items-center vh-100">


        <div class="container  ">
            <h1 class="text-center fw-bold mb-4">Login</h1>

            <?php if( isset($error) ) : ?>
            <p style="color: red; font-style: italic;">username / password salah</p>
            <?php endif; ?>

            <div class="card p-3 col-3 mx-auto shadow-lg rounded">
                <form action="" method="post">

                    <div class="mb-3">

                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>

                    <div class="mb-3">

                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>


                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">
                                Remember Me
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" name="login">Login</button>

                </form>
            </div>

        </div>
    </div>



</body>

</html>