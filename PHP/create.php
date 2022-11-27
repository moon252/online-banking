<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$first_name = $last_name = $address = $acc_type = $phone = $email = $password = "";
$first_name_err = $last_name_err = $address_err = $acc_type_err = $phone_err = $email_err = $password_err = "";


// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    $input_first_name = trim($_POST["first_name"]);
    if (empty($input_first_name)) {
        $first_name_err = "Please enter your first name.";
    } elseif (!filter_var($input_first_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $first_name_err = "Please enter a valid first name.";
    } else {
        $first_name = $input_first_name;
    }

    $input_last_name = trim($_POST["last_name"]);
    if (empty($input_last_name)) {
        $last_name_err = "Please enter your last name.";
    } elseif (!filter_var($input_last_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $last_name_err = "Please enter a valid last name.";
    } else {
        $last_name = $input_last_name;
    }

    // Validate address
    $input_address = trim($_POST["address"]);
    if (empty($input_address)) {
        $address_err = "Please enter an address.";
    } else {
        $address = $input_address;
    }

    // Validate acc type
    $input_acc_type = trim($_POST["acc_type"]);
    if (empty($input_acc_type)) {
        $acc_type_err = "Please choose acc type.";
    } else {
        $acc_type = $input_acc_type;
    }

    //validate phn
    $input_phone = trim($_POST["phone"]);
    if (empty($input_phone)) {
        $phone = "Please enter your phone number";
    } elseif (!filter_var($input_phone, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[0-9]{11}+$/")))) {
        $phone_err = "Please enter a valid phone number.";
    } else {
        $phone = $input_phone;
    }


    //validate email
    $input_email = trim($_POST["email"]);
    if (empty($input_email)) {
        $email = "Please enter your email";
    } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = $input_email;
    }

    //validate password
    $input_password = trim($_POST["password"]);
    if (empty($input_password)) {
        $password = "Please enter your email";
    } elseif (!filter_var($input_password, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^.{5,}$/")))) {
        $password_err = "Please enter a valid 5 digit password.";
    } else {
        $password = $input_password;
    }

    // Check input errors before inserting in database
    if (empty($first_name_err) && empty($last_name_err) && empty($address_err) && empty($acc_type_err) && empty($phone_err) && empty($email_err) && empty($password_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO  `customer` (`first_name`, `last_name`, `address`, `acc_type`, `phone`, `email`, `password`) VALUES (?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_first_name, $param_last_name, $param_address, $param_acc_type, $param_phone, $param_email, $param_password);

            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_address = $address;
            $param_acc_type = $acc_type;
            $param_phone = $phone;
            $param_email = $email;
            $param_password = $password;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name"
                                class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $first_name; ?>">
                            <span class="invalid-feedback">
                                <?php echo $first_name_err; ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name"
                                class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $last_name; ?>">
                            <span class="invalid-feedback">
                                <?php echo $last_name_err; ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address"
                                class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback">
                                <?php echo $address_err; ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Account Type</label>
                            <input type="text" name="acc_type"
                                class="form-control <?php echo (!empty($acc_type_err)) ? 'is-invalid' : ''; ?>"
                                value="<?php echo $acc_type; ?>">
                            <span class="invalid-feedback">
                                <?php echo $acc_type_err; ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Phone</label>
                            <textarea name="phone"
                                class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>"><?php echo $phone; ?></textarea>
                            <span class="invalid-feedback">
                                <?php echo $phone_err; ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <textarea name="email"
                                class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"><?php echo $email; ?></textarea>
                            <span class="invalid-feedback">
                                <?php echo $email_err; ?>
                            </span>
                        </div>

                        <div class="form-group">
                            <label>password</label>
                            <textarea name="password"
                                class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"><?php echo $password; ?></textarea>
                            <span class="invalid-feedback">
                                <?php echo $password_err; ?>
                            </span>
                        </div>

                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>