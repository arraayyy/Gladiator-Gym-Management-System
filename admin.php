<?php

    include_once "connectdb.php";
    if(isset($_POST['submit'])){
        $name= $_POST['name'];
        $user= $_POST['username'];
        $pass= $_POST['password'];
        
        $update = "UPDATE `user` 
                   SET `user_name`='$name', `user_username`='$user',`user_password`='$pass'";

        $change =mysqli_query($conn,$update);

        if(!$change) {
            echo "<script> 
            alert('ERROR CHANGES')
            window.location.replace('home.php');
            </script>";
        } else{
            echo "<script> 
            alert('UPDATED SUCCESSFULLY!')
            window.location.replace('home.php');
            </script>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gladiator Fitness Gym</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="login.css">
    <style>
        .logo{
            width:6vw;
            margin:auto;
            border-radius:20px;
        }

        form i {
			margin-left: -30px;
			cursor: pointer;
		}
    </style>
</head>
<body>
    <header>
        <?php
         $display = "SELECT * FROM `user`";
         $displaying = mysqli_query($conn,$display); 
                         
        if(mysqli_num_rows($displaying)> 0){
            while($row = mysqli_fetch_assoc( $displaying)){
        
        ?>

    
        <div class="container">
            <form class="card mt-5 px-3 py-3 container bg-white  form" action="" style="width: 25rem;" method="POST">
                <img src="glad.jpg" class="logo" alt="Gladiator Gym Logo">
                <br>
                <div class="card-header border border-bg-light dark h4 text-center fw-bold text-dark">PROFILE INFORMATION</div>
                    <div class="row align-items-center text-dark">
                        
                        <!---------- NAME ---------->
                        <div class="mt-4">
                            <label for="name">Name</label>
                            
                            <input type="text" class="form-control mt-2" name="name" autocomplete="off" value="<?php echo $row['user_name']?>">
                        </div>
                        
                        <!---------- USERNAME ---------->
                        <div class="mt-4">
                            <label for="username">Username</label>
                            <input type="text" class="form-control mt-2" name="username" autocomplete="off" value="<?php echo $row['user_username']?>">
                        </div>

                        <!---------- PASSWORD ---------->
                        <div class="mt-4">
                            <p>
                                <label for="password">Password</label>
                                <!-- <input type="password" class="form-control mt-2" name="password" > -->
                                <div class="form-control">
                                    <input type="password" class="border-0" style="outline:none" name="password" id="password" value="<?php echo $row['user_password']?>">
                                    <i class="bi bi-eye-slash float-end" id="togglePassword"></i>
                                </div>
                            </p>
                        </div>

                        <!---------- SAVE BUTTON ---------->
                        <div class="container">
                            <div class="row p-4 text-center">
                                <div class="col-md-12">
                                    <input type="submit" class="btn btn-primary" name="submit" value="Save">
                                    <a href="home.php"><input type="button" class="btn btn-secondary" name="cancel" value="Cancel"></a>
                                </div>
                            </div>
                        </div>

                        
                        
                </div>
            </form>
        </div>
        <?php
            }
        }    
        ?>          
             
    </header>

    <script>
		const togglePassword = document
			.querySelector('#togglePassword');

		const password = document.querySelector('#password');

		togglePassword.addEventListener('click', () => {

			// Toggle the type attribute using
			// getAttribure() method
			const type = password
				.getAttribute('type') === 'password' ?
				'text' : 'password';
				
			password.setAttribute('type', type);

			// Toggle the eye and bi-eye icon
			this.classList.toggle('bi-eye');
		});
	</script>
</body>
</html>

