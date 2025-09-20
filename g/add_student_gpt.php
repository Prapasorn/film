<?php
// ดึงไฟล์เชื่อมต่อฐานข้อมูล
require('connectdb.php');

// ตรวจสอบว่ามีการ submit ฟอร์มหรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $s_id      = mysqli_real_escape_string($conn, $_POST['s_id']);
    $s_name    = mysqli_real_escape_string($conn, $_POST['s_name']);
    $s_address = mysqli_real_escape_string($conn, $_POST['s_address']);
    $s_gpax    = mysqli_real_escape_string($conn, $_POST['s_gpax']);
    $f_id      = mysqli_real_escape_string($conn, $_POST['f_id']);

    $sql = "INSERT INTO student (s_id, s_name, s_address, s_gpax, f_id)
            VALUES ('$s_id', '$s_name', '$s_address', '$s_gpax', '$f_id')";

    if (mysqli_query($conn, $sql)) {
        $msg = "<div class='alert alert-success mt-3'>บันทึกข้อมูลเรียบร้อยแล้ว</div>";
    } else {
        $msg = "<div class='alert alert-danger mt-3'>เกิดข้อผิดพลาด: " . mysqli_error($conn) . "</div>";
    }
}

// ดึงข้อมูลคณะจากฐานข้อมูล
$faculties = mysqli_query($conn, "SELECT * FROM faculty ORDER BY f_name ASC");
?>

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>เพิ่มข้อมูลนิสิต</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
  <div class="card shadow-lg border-0 rounded-3">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">ฟอร์มเพิ่มข้อมูลนิสิต</h4>
    </div>
    <div class="card-body">
      <?php if (!empty($msg)) echo $msg; ?>

      <form method="POST">
        <div class="mb-3">
          <label class="form-label">รหัสนิสิต</label>
          <input type="text" name="s_id" class="form-control" required maxlength="11">
        </div>

        <div class="mb-3">
          <label class="form-label">ชื่อนิสิต</label>
          <input type="text" name="s_name" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">ที่อยู่</label>
          <textarea name="s_address" class="form-control" rows="2" required></textarea>
        </div>

        <div class="mb-3">
          <label class="form-label">GPAX</label>
          <input type="number" name="s_gpax" class="form-control" step="0.01" min="0" max="4" required>
        </div>

        <div class="mb-3">
          <label class="form-label">คณะ</label>
          <select name="f_id" class="form-select" required>
            <option value="">-- เลือกคณะ --</option>
            <?php while($row = mysqli_fetch_assoc($faculties)): ?>
              <option value="<?= $row['f_id'] ?>"><?= $row['f_name'] ?></option>
            <?php endwhile; ?>
          </select>
        </div>

        <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
        <button type="reset" class="btn btn-secondary">ล้างข้อมูล</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>
