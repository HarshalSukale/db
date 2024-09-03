<?php
// Database connection
$host = 'localhost';
$dbname = 'student_registration';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Initialize variables
$errors = [];
$successMessage = '';
$action = $_POST['action'] ?? '';
$id = $_POST['id'] ?? '';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($id)) {
        $errors['id'] = "Student ID is required.";
    }

    if (empty($errors)) {
        switch ($action) {
            case 'create':
                // Collect other fields only for create and update
                $username = $_POST['username'] ?? '';
                $email = $_POST['email'] ?? '';
                $phone = $_POST['phone'] ?? '';
                $dob = $_POST['dob'] ?? '';
                $gender = $_POST['gender'] ?? '';
                $address = $_POST['address'] ?? '';
                $course = $_POST['course'] ?? '';
                $password = $_POST['password'] ?? '';
                $confirmPassword = $_POST['confirmPassword'] ?? '';

                if ($password !== $confirmPassword) {
                    $errors['password'] = "Passwords do not match.";
                }

                if (empty($errors)) {
                    try {
                        $stmt = $pdo->prepare("INSERT INTO students (id, username, email, phone, dob, gender, address, course, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                        $stmt->execute([$id, $username, $email, $phone, $dob, $gender, $address, $course, password_hash($password, PASSWORD_BCRYPT)]);
                        $successMessage = "Student registered successfully!";
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
                break;

            case 'update':
                // Collect other fields only for create and update
                $username = $_POST['username'] ?? '';
                $email = $_POST['email'] ?? '';
                $phone = $_POST['phone'] ?? '';
                $dob = $_POST['dob'] ?? '';
                $gender = $_POST['gender'] ?? '';
                $address = $_POST['address'] ?? '';
                $course = $_POST['course'] ?? '';
                $password = $_POST['password'] ?? '';
                $confirmPassword = $_POST['confirmPassword'] ?? '';

                if ($password !== $confirmPassword) {
                    $errors['password'] = "Passwords do not match.";
                }

                if (empty($errors)) {
                    try {
                        $stmt = $pdo->prepare("UPDATE students SET username=?, email=?, phone=?, dob=?, gender=?, address=?, course=?, password=? WHERE id=?");
                        $stmt->execute([$username, $email, $phone, $dob, $gender, $address, $course, password_hash($password, PASSWORD_BCRYPT), $id]);
                        $successMessage = "Student updated successfully!";
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                }
                break;

            case 'delete':
                try {
                    $stmt = $pdo->prepare("DELETE FROM students WHERE id=?");
                    $stmt->execute([$id]);

                    if ($stmt->rowCount() > 0) {
                        $successMessage = "Student deleted successfully!";
                    } else {
                        $errors['id'] = "Student ID not found.";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;
        }
    }
}

// Fetch all records to display
$students = [];
try {
    $stmt = $pdo->query("SELECT * FROM students");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error fetching records: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="date"],
        input[type="password"],
        textarea,
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .error {
            color: red;
            font-size: 0.875em;
            margin-bottom: 10px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .checkbox-label {
            display: flex;
            align-items: center;
        }

        .checkbox-label input[type="checkbox"] {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Registration Form</h2>

        <!-- Display success message -->
        <?php if ($successMessage): ?>
            <p style="color: green;"><?php echo $successMessage; ?></p>
        <?php endif; ?>

        <!-- Display error messages -->
        <?php if (!empty($errors)): ?>
            <ul style="color: red;">
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <!-- Hidden input to specify the action -->
            <input type="hidden" name="action" id="form-action" value="create">

            <!-- ID Field (required for all operations) -->
            <label for="id">Student ID:</label>
            <input type="text" id="id" name="id" required>
            <span class="error"><?php echo $errors['id'] ?? ''; ?></span>

            <!-- Other fields are shown/hidden based on the action -->
            <div id="additional-fields">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
                <span class="error"><?php echo $errors['username'] ?? ''; ?></span>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
                <span class="error"><?php echo $errors['email'] ?? ''; ?></span>

                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone">
                <span class="error"><?php echo $errors['phone'] ?? ''; ?></span>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob">
                <span class="error"><?php echo $errors['dob'] ?? ''; ?></span>

                <label>Gender:</label>
                <label><input type="radio" name="gender" value="male"> Male</label>
                <label><input type="radio" name="gender" value="female"> Female</label>
                <label><input type="radio" name="gender" value="other"> Other</label>
                <span class="error"><?php echo $errors['gender'] ?? ''; ?></span>

                <label for="address">Address:</label>
                <textarea id="address" name="address" rows="4"></textarea>
                <span class="error"><?php echo $errors['address'] ?? ''; ?></span>

                <label for="course">Course of Study:</label>
                <select id="course" name="course">
                    <option value="">Select a course</option>
                    <option value="computer_science">Computer Science</option>
                    <option value="business_administration">Business Administration</option>
                    <option value="engineering">Engineering</option>
                    <option value="arts">Arts</option>
                </select>
                <span class="error"><?php echo $errors['course'] ?? ''; ?></span>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
                <span class="error"><?php echo $errors['password'] ?? ''; ?></span>

                <label for="confirmPassword">Confirm Password:</label>
                <input type="password" id="confirmPassword" name="confirmPassword">
                <span class="error"><?php echo $errors['confirmPassword'] ?? ''; ?></span>
            </div>

            <label>
                <input type="checkbox" id="terms" name="terms"> I agree to the terms and conditions
            </label>
            <span class="error"><?php echo $errors['terms'] ?? ''; ?></span>

            <!-- Buttons for different operations -->
            <button type="submit" onclick="document.getElementById('form-action').value='create';">Register</button>
            <button type="submit" onclick="document.getElementById('form-action').value='update';">Update</button>
            <button type="submit" onclick="document.getElementById('form-action').value='delete'; document.getElementById('additional-fields').style.display='none';">Delete</button>
        </form>

        <!-- Display all student records -->
        <h3>All Registered Students</h3>
        <?php if ($students): ?>
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th>Course</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($students as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['id']); ?></td>
                            <td><?php echo htmlspecialchars($student['username']); ?></td>
                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                            <td><?php echo htmlspecialchars($student['phone']); ?></td>
                            <td><?php echo htmlspecialchars($student['dob']); ?></td>
                            <td><?php echo htmlspecialchars($student['gender']); ?></td>
                            <td><?php echo htmlspecialchars($student['address']); ?></td>
                            <td><?php echo htmlspecialchars($student['course']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No students registered yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>