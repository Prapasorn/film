<?php

// Check if connectdb.php exists, if not, create a placeholder file for demonstration
if (!file_exists('connectdb.php')) {
    file_put_contents('connectdb.php', '<?php $conn = new mysqli("localhost", "your_username", "your_password", "msu"); if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); } ?>');
}

// Include the database connection file
require_once 'connectdb.php';

$message = '';

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Sanitize and get form data
    $s_id = $conn->real_escape_string($_POST['s_id']);
    $s_name = $conn->real_escape_string($_POST['s_name']);
    $s_address = $conn->real_escape_string($_POST['s_address']);
    $s_gpax = $conn->real_escape_string($_POST['s_gpax']);
    $f_id = $conn->real_escape_string($_POST['f_id']);

    // SQL query to insert data into the student table
    $sql = "INSERT INTO student (s_id, s_name, s_address, s_gpax, f_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement
    if ($stmt) {
        $stmt->bind_param("sssdi", $s_id, $s_name, $s_address, $s_gpax, $f_id);
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success mt-3'>เพิ่มข้อมูลนิสิตสำเร็จ!</div>";
        } else {
            $message = "<div class='alert alert-danger mt-3'>เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='alert alert-danger mt-3'>เกิดข้อผิดพลาดในการเตรียมคำสั่ง SQL: " . $conn->error . "</div>";
    }
}

// Fetch faculty data for the dropdown
$sql_faculty = "SELECT f_id, f_name FROM faculty ORDER BY f_name ASC";
$result_faculty = $conn->query($sql_faculty);

// Close the connection
$conn->close();

?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แบบฟอร์มเพิ่มข้อมูลนิสิต</title>
    <!-- Bootstrap CSS v5.3.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" xintegrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center rounded-top-4 py-3">
                        <h3 class="mb-0">แบบฟอร์มเพิ่มข้อมูลนิสิต</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php echo $message; ?>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="s_id" class="form-label fw-semibold">รหัสนิสิต</label>
                                <input type="text" class="form-control rounded-pill px-4" id="s_id" name="s_id" maxlength="11" required>
                            </div>
                            <div class="mb-3">
                                <label for="s_name" class="form-label fw-semibold">ชื่อ-นามสกุล</label>
                                <input type="text" class="form-control rounded-pill px-4" id="s_name" name="s_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="f_id" class="form-label fw-semibold">คณะ</label>
                                <select class="form-select rounded-pill px-4" id="f_id" name="f_id" required>
                                    <option value="" selected disabled>-- เลือกคณะ --</option>
                                    <?php
                                    if ($result_faculty->num_rows > 0) {
                                        while ($row = $result_faculty->fetch_assoc()) {
                                            echo "<option value='" . htmlspecialchars($row['f_id']) . "'>" . htmlspecialchars($row['f_name']) . "</option>";
                                        }
                                    } else {
                                        echo "<option value='' disabled>ไม่พบข้อมูลคณะ</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="s_address" class="form-label fw-semibold">ที่อยู่</label>
                                <textarea class="form-control rounded-4 px-4" id="s_address" name="s_address" rows="3" required></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="s_gpax" class="form-label fw-semibold">เกรดเฉลี่ย (GPAX)</label>
                                <input type="number" step="0.01" class="form-control rounded-pill px-4" id="s_gpax" name="s_gpax" min="0" max="4" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" name="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-add me-2" viewBox="0 0 16 16">
                                      <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1h1a.5.5 0 0 1 0 1h-1v1a.5.5 0 0 1-1 0v-1h-1a.5.5 0 0 1 0-1h1v-1a.5.5 0 0 1 1 0m-2-6a3 3 0 1 1-6 0 3 3 0 0 1 6 0M8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                                      <path d="M8.256 14a4.5 4.5 0 0 1-.229-1.004H3c-.276 0-.5-.43-.5-.996s.224-.996.5-.996h4.978c.959 0 1.637.766 2.196 1.48C10.669 13.92 12 14 12 14zm-1.282-4.301A5.378 5.378 0 0 0 6.643 8H3c-.768 0-1.266 1.144-.863 2.112A9.773 9.773 0 0 0 5.485 12h.749a4.5 4.5 0 0 1-1.258-2.301"/>
                                    </svg>
                                    เพิ่มข้อมูลนิสิต
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" xintegrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
