<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body class="container">
    <?php
    $errors = [];
    $nis = $name = $gender = $class = "";
    $extracurricular = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["nis"])) {
            $errors['nis'] = "NIS harus diisi.";
        } elseif (!preg_match("/^[0-9]{10}$/", $_POST["nis"])) {
            $errors['nis'] = "NIS harus berisi 10 angka.";
        } else {
            $nis = $_POST["nis"];
        }

        if (empty($_POST["name"])) {
            $errors['name'] = "Nama harus diisi.";
        } else {
            $name = $_POST["name"];
        }

        if (empty($_POST["gender"])) {
            $errors['gender'] = "Jenis kelamin harus dipilih.";
        } else {
            $gender = $_POST["gender"];
        }

        if (empty($_POST["class"])) {
            $errors['class'] = "Kelas harus dipilih.";
        } else {
            $class = $_POST["class"];
        }

        if ($class === 'X' || $class === 'XI') {
            if (!isset($_POST["extracurricular"]) || count($_POST["extracurricular"]) < 1 || count($_POST["extracurricular"]) > 3) {
                $errors['extracurricular'] = "Pilih minimal 1 dan maksimal 3 kegiatan ekstrakurikuler.";
            } else {
                $extracurricular = $_POST["extracurricular"];
            }
        }

        if (empty($errors)) {
            echo "<script>alert('Form telah terkirim!');</script>";
        }
    }
    ?>

    <h1 class="mb-4">Form Input Siswa</h1>
    <form method="POST" action="" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="nis" class="form-label">NIS:</label>
            <input type="text" id="nis" name="nis" class="form-control <?php echo isset($errors['nis']) ? 'is-invalid' : ''; ?>" 
            value="<?php echo isset($_POST['nis']) ? htmlspecialchars($_POST['nis']) : ''; ?>" maxlength="10">
            <div class="invalid-feedback">
                <?php echo $errors['nis'] ?? ''; ?>
            </div>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nama:</label>
            <input type="text" id="name" name="name" class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" 
            value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
            <div class="invalid-feedback">
                <?php echo $errors['name'] ?? ''; ?>
            </div>
        </div>

        <div class="mb-3">
            <label for="gender" class="form-label">Jenis Kelamin:</label>
            <select id="gender" name="gender" class="form-select <?php echo isset($errors['gender']) ? 'is-invalid' : ''; ?>">
                <option value="Pria" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Pria') ? 'selected' : ''; ?>>Pria</option>
                <option value="Wanita" <?php echo (isset($_POST['gender']) && $_POST['gender'] == 'Wanita') ? 'selected' : ''; ?>>Wanita</option>
            </select>
            <div class="invalid-feedback">
                <?php echo $errors['gender'] ?? ''; ?>
            </div>
        </div>

        <div class="mb-3">
            <label for="class" class="form-label">Kelas:</label>
            <select id="class" name="class" class="form-select <?php echo isset($errors['class']) ? 'is-invalid' : ''; ?>" onchange="toggleExtracurricular()">
                <option value="X" <?php echo (isset($_POST['class']) && $_POST['class'] == 'X') ? 'selected' : ''; ?>>X</option>
                <option value="XI" <?php echo (isset($_POST['class']) && $_POST['class'] == 'XI') ? 'selected' : ''; ?>>XI</option>
                <option value="XII" <?php echo (isset($_POST['class']) && $_POST['class'] == 'XII') ? 'selected' : ''; ?>>XII</option>
            </select>
            <div class="invalid-feedback">
                <?php echo $errors['class'] ?? ''; ?>
            </div>
        </div>

        <div id="extracurricularSection" class="mb-3" style="display: <?php echo (isset($_POST['class']) && $_POST['class'] === 'XII') ? 'none' : 'block'; ?>">
            <label for="extracurricular" class="form-label">Ekstrakurikuler:</label><br>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="extracurricular[]" value="Pramuka" <?php echo (isset($_POST['extracurricular']) && in_array('Pramuka', $_POST['extracurricular'])) ? 'checked' : ''; ?>>
                <label class="form-check-label">Pramuka</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="extracurricular[]" value="Seni Tari" <?php echo (isset($_POST['extracurricular']) && in_array('Seni Tari', $_POST['extracurricular'])) ? 'checked' : ''; ?>>
                <label class="form-check-label">Seni Tari</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="extracurricular[]" value="Semanggiat" <?php echo (isset($_POST['extracurricular']) && in_array('Sinematografi', $_POST['extracurricular'])) ? 'checked' : ''; ?>>
                <label class="form-check-label">Sinematografi</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="extracurricular[]" value="Basket" <?php echo (isset($_POST['extracurricular']) && in_array('Basket', $_POST['extracurricular'])) ? 'checked' : ''; ?>>
                <label class="form-check-label">Basket</label>
            </div>
            <div class="kesalahan_input d-block">
                <?php echo $errors['extracurricular'] ?? ''; ?>
            </div>
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
            <button type="reset" class="btn btn-secondary" onclick="resetForm()">Reset</button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script>
        function toggleExtracurricular() {
            const classDipilih = document.getElementById('class').value;
            const extracurricularSection = document.getElementById('extracurricularSection');
            extracurricularSection.style.display = (classDipilih === 'XII') ? 'none' : 'block';
        }
    </script>

</body>
</html>