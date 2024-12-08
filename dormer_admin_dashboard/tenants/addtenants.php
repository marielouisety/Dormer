<?php
// Include the database connection file
include 'db_connect.php';

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $email = $_POST['email'];
    $password = $_POST['password'];
    $surname = $_POST['surname'];
    $firstName = $_POST['first-name'];
    $date_of_birth = $_POST['dob'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $contact_number = $_POST['phone'];
    $roomnumber = $_POST['roomnumber'];
    $room_fee = $_POST['room-fee'];

    // Debug: Print form data
    echo "Email: $email<br>";
    echo "Password: $password<br>";
    echo "Surname: $surname<br>";
    echo "First Name: $firstName<br>";
    echo "DOB: $date_of_birth<br>";
    echo "Gender: $gender<br>";
    echo "Age: $age<br>";
    echo "Contact Number: $contact_number<br>";
    echo "Room Number: $roomnumber<br>";
    echo "Room Fee: $room_fee<br>";

    // Verify if the room number exists in the rooms table
    $check_room_sql = "SELECT room_number FROM rooms WHERE room_number='$roomnumber'";
    $check_room_result = $conn->query($check_room_sql);

    if ($check_room_result->num_rows > 0) {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Insert tenant data into the tenants table
        $sql = "INSERT INTO tenants (email, password, lName, fName, date_of_birth, gender, age, contact_number, room_number) 
                VALUES ('$email', '$hashed_password', '$surname', '$firstName', '$date_of_birth', '$gender', '$age', '$contact_number', '$roomnumber')";

        if ($conn->query($sql) === TRUE) {
            // Update the room availability to 'Occupied' and set the room fee
            $update_room_sql = "UPDATE rooms SET availability='Occupied', room_fee='$room_fee' WHERE room_number='$roomnumber'";
            if ($conn->query($update_room_sql) === TRUE) {
                // Redirect back to tenants.php
                header("Location: tenants.php");
                exit();
            } else {
                echo "Error updating room: " . $conn->error;
            }
        } else {
            echo "Error inserting tenant: " . $conn->error;
        }
    } else {
        echo "Error: Room number does not exist.";
    }

    $conn->close();
}
?>
