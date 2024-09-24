<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form_type is set
if (!isset($_POST['form_type'])) {
    echo "No form type specified.";
    $conn->close();
    exit();
}

$form_type = $_POST['form_type'];

switch ($form_type) {
    case 'add-book':
        // Code for adding book
        $title = $_POST['book-title'];
        $author = $_POST['book-author'];
        $year = $_POST['book-year'];
        $stmt = $conn->prepare("INSERT INTO books (title, author, year) VALUES (?, ?, ?)");
        $stmt->bind_param("ssi", $title, $author, $year);
        break;

    case 'update-delete-book':
        // Code for updating or deleting book
        $book_id = $_POST['book-id'];
        $new_title = $_POST['update-book-title'];
        $new_author = $_POST['update-book-author'];
        $new_year = $_POST['update-book-year'];

        if (!empty($new_title) || !empty($new_author) || !empty($new_year)) {
            $update_sql = "UPDATE books SET";
            $params = [];
            $types = '';
            if (!empty($new_title)) {
                $update_sql .= " title=?,";
                $params[] = $new_title;
                $types .= 's';
            }
            if (!empty($new_author)) {
                $update_sql .= " author=?,";
                $params[] = $new_author;
                $types .= 's';
            }
            if (!empty($new_year)) {
                $update_sql .= " year=?,";
                $params[] = $new_year;
                $types .= 'i';
            }
            $update_sql = rtrim($update_sql, ',');
            $update_sql .= " WHERE id=?";
            $params[] = $book_id;
            $types .= 'i';

            $stmt = $conn->prepare($update_sql);
            $stmt->bind_param($types, ...$params);
        } else {
            $stmt = $conn->prepare("DELETE FROM books WHERE id=?");
            $stmt->bind_param("i", $book_id);
        }
        break;

    case 'issue-book':
        // Code for issuing book
        $book_id = $_POST['issue-book-id'];
        $student_id = $_POST['student-id'];
        $stmt = $conn->prepare("INSERT INTO issued_books (book_id, student_id, issue_date) VALUES (?, ?, NOW())");
        $stmt->bind_param("ii", $book_id, $student_id);
        break;

    case 'return-book':
        // Code for returning book
        $book_id = $_POST['return-book-id'];
        $student_id = $_POST['return-student-id'];
        $stmt = $conn->prepare("DELETE FROM issued_books WHERE book_id=? AND student_id=?");
        $stmt->bind_param("ii", $book_id, $student_id);
        break;

    case 'make-fine':
        // Code for making fine
        $student_id = $_POST['fine-student-id'];
        $amount = $_POST['fine-amount'];
        $stmt = $conn->prepare("INSERT INTO fines (student_id, amount, fine_date) VALUES (?, ?, NOW())");
        $stmt->bind_param("id", $student_id, $amount);
        break;

    case 'update-material':
        // Code for updating material
        $year = $_POST['material-year'];
        $semester = $_POST['material-semester'];
        $stmt = $conn->prepare("UPDATE materials SET year=?, semester=? WHERE year=? AND semester=?");
        $stmt->bind_param("ssss", $year, $semester, $year, $semester);
        break;

    case 'view-material':
        // Code for viewing material
        $year = $_POST['view-material-year'];
        $semester = $_POST['view-material-semester'];
        $stmt = $conn->prepare("SELECT * FROM materials WHERE year=? AND semester=?");
        $stmt->bind_param("ss", $year, $semester);
        break;

    case 'register-user':
        // Code for registering user
        $username = $_POST['register-username'];
        $password = $_POST['register-password'];
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $password);
        break;

    case 'search-book':
        // Code for searching book
        $title = $_POST['search-title'];
        $author = $_POST['search-author'];
        $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? AND author LIKE ?");
        $title = "%$title%";
        $author = "%$author%";
        $stmt->bind_param("ss", $title, $author);
        break;

    case 'borrow-history':
        // Code for borrow history
        $student_id = $_POST['student-id'];
        $stmt = $conn->prepare("SELECT b.title, ib.issue_date, DATE_ADD(ib.issue_date, INTERVAL 30 DAY) AS expiration_date 
                                FROM issued_books ib 
                                JOIN books b ON ib.book_id = b.id 
                                WHERE ib.student_id=?");
        $stmt->bind_param("i", $student_id);
        break;

    case 'check-fine':
        // Code for checking fine
        $student_id = $_POST['student-id-fine'];
        $stmt = $conn->prepare("SELECT SUM(amount) AS total_fine FROM fines WHERE student_id=?");
        $stmt->bind_param("i", $student_id);
        break;

    case 'search-material':
        // Code for searching material
        $year = $_POST['material-year-search'];
        $semester = $_POST['material-semester-search'];
        $stmt = $conn->prepare("SELECT * FROM materials WHERE year=? AND semester=?");
        $stmt->bind_param("ss", $year, $semester);
        break;

    case 'download-material':
        // Implement file download logic here
        break;

    case 'edit-profile':
        // Code for editing user profile
        $username = $_POST['profile-username'];
        $email = $_POST['profile-email'];
        $stmt = $conn->prepare("UPDATE users SET username=?, email=? WHERE username=?");
        $stmt->bind_param("sss", $username, $email, $username);
        break;

    default:
        echo "Invalid form type.";
        $conn->close();
        exit();
}

// Execute the prepared statement
if ($stmt->execute()) {
    if ($form_type === 'view-material' || $form_type === 'search-book' || $form_type === 'borrow-history' || $form_type === 'check-fine' || $form_type === 'search-material') {
        // Output results in JSON format for AJAX requests
        $data = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        echo json_encode($data);
    } else {
        echo "Operation successful";
    }
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>