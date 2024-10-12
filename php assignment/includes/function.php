<?php

function connectToDB() {
    $host = 'localhost';
    $database_name = 'library_management';
    $database_user= 'root';
    $database_password = 'Sheryn0524.';

    $database = new PDO(
        "mysql:host=$host;dbname=$database_name",
        $database_user,
        $database_password
    );

    return $database;
}

function setError( $error_message, $redirect_page ) {
    $_SESSION["error"] = $error_message;
    // redirect back to login page
    header("Location: " . $redirect_page );
    exit;
}


// check if user is logged in or not
function checkIfuserIsNotLoggedIn() {
  if ( !isset( $_SESSION['user'] ) ) {
    header("Location: /login");
    exit;
  }
}

// check if current user is an admin or not
function checkIfIsNotAdmin() {
    if ( isset( $_SESSION['user'] ) && $_SESSION['user']['role'] != 'admin' ) {
        echo "<p>Access denied. Only admins can access this page.</p>";
        header("Location: /");
        exit;
    }
}

function checkIfIsNotAdminOrEditor() {
    // Check if the user is logged in and if the role is neither 'admin' nor 'editor'
    if (!isset($_SESSION['user']) || ($_SESSION['user']['role'] != 'admin' && $_SESSION['user']['role'] != 'editor')) {
        // Set an error message in the session to be displayed after redirecting
        $_SESSION['error'] = "Access denied. Only admins or editors can access this page.";

        // Redirect to the home page or another appropriate page
        header("Location: /");
        exit;
    }
}
