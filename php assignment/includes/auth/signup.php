<?php
    // connect to the database
    $database = connectToDB();

    // Storing the details the user has entered in the sign-up page
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirm_password"];

    // Check if the user has filled all fields
    if(empty($name) || empty($email) || empty($password) || empty($confirm_password)){
        echo '<script>alert("Please ensure all the fields are filled up!");window.location.href="/signup";</script>';
    // Check if the user's password matches the confirm password
    } else if($password !== $confirm_password){
        echo '<script>alert("Your password does not match the confirmation, try again!");window.location.href="/signup";</script>';
    // Check if the password is at least 8 characters long or more
    } else if(strlen($password) < 8){
        echo '<script>alert("Please ensure your password is 8 characters or more!");window.location.href="/signup";</script>';
    // Update the database with the new user and their details if all above checks have passed
    } else {
        // check if the email already in-used or not
        // sql command
        $sql = "SELECT * FROM users WHERE email = :email";    

        //prepare
        $query = $database -> prepare($sql);

        // execute
        $query -> execute([
            'email' => $email
        ]);

        // fetch
        $user = $query -> fetch(); //return the first row starting from the query row

        // if user exists, it means the email already in-used
        if ( $user ) {
            echo '<script>alert("The email entered already in-used! Please use another email");window.location.href="/signup";</script>';
        } else {
            // create the user
            // SQL Command (Recipe)
            $sql = "INSERT INTO users (`name`, `email`, `password`) VALUES (:name, :email, :password)";
            // Prepare SQL query (Prepare Ingredients)
            $query = $database->prepare($sql);
            // Execute SQL query (Cook)
            $query->execute([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT)
            ]);
            // Redirect user back to index.php after the process
            echo '<script>alert("Successfully signed up!");window.location.href="/login"</script>';
            exit;
        }

    }
?>