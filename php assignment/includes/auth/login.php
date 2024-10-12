<?php

    // connect to the database
    $database = connectToDB();

    //3. get all the data from the login page form
    $email = $_POST['email'];
    $password = $_POST['password'];

    //4. check for error (make sure all the fields are filled and that the password is correct)
    if ( empty($email) || empty($password) ) {
        setError( "Please fill in all the fields!", "/login");
    } else {
        //5. check if the email entered is registered in our database or not
        //5.1 sql command
        $sql = "SELECT * FROM users WHERE email = :email";    

        //5.2 prepare
        $query = $database -> prepare($sql);

        //5.3 execute
        $query -> execute([
            'email' => $email
        ]);

        //5.4 fetch
        $user = $query -> fetch(); //return the first row starting from the query row

        //check if email exists in database
        if ($user) {
            //6. check if the password is correct
            if( password_verify ($password, $user["password"]) ) {
                //7.login the user
                $_SESSION['user'] = $user;


                //8. redirect back to main page
                header("Location: /");
                exit;
            } else {
                setError( "The password provided is incorrect, please try again.", "/login" );
            }
        } else {
            setError( "This email is not registered inside our database.", "/login" );
        }
    }