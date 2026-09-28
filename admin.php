<?php
session_start();

require __DIR__ . '/connect.php';

$message = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_university'])) {
        $name = trim($_POST['name'] ?? '');
        $prefecture = trim($_POST['prefecture'] ?? '');
        $municipality = trim($_POST['municipality'] ?? '');
        $location = trim($_POST['location'] ?? '');
        $photoUrl = trim($_POST['photo_url'] ?? '');
        $websiteUrl = trim($_POST['website_url'] ?? '');
        $infoUrl = trim($_POST['info_url'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($name !== '' && $prefecture !== '' && $municipality !== '') {
            $institutionType = trim($_POST['institution_type'] ?? 'private');
            $institutionType = in_array($institutionType, ['private', 'public', 'national'], true)
                ? $institutionType
                : 'private';

            $stmt = $pdo->prepare("
                INSERT INTO universities
                (
                    name,
                    prefecture,
                    municipality,
                    institution_type,
                    location,
                    photo_url,
                    website_url,
                    info_url,
                    description
                )
                VALUES
                (
                    :name,
                    :prefecture,
                    :municipality,
                    :institution_type,
                    :location,
                    :photo_url,
                    :website_url,
                    :info_url,
                    :description
                )
            ");

            $stmt->execute([
                ':name' => $name,
                ':prefecture' => $prefecture,
                ':municipality' => $municipality,
                ':institution_type' => $institutionType,
                ':location' => $location,
                ':photo_url' => $photoUrl,
                ':website_url' => $websiteUrl,
                ':info_url' => $infoUrl,
                ':description' => $description
            ]);

            $_SESSION['flash'] = 'Data universitas berhasil ditambahkan.';
            header('Location: admin.php');
            exit;
        } else {
            $_SESSION['flash'] = 'Nama universitas, provinsi, dan kabupaten/kota wajib diisi.';
            header('Location: admin.php');
            exit;
        }
    }

    if (isset($_POST['submit_program'])) {
        $universityIds = $_POST['university_ids'] ?? [];
        $universityIds = array_values(array_unique(array_filter(array_map('intval', $universityIds))));

        $title = trim($_POST['title'] ?? '');
        $logoUrl = trim($_POST['logo_url'] ?? '');
        $programType = trim($_POST['program_type'] ?? '');
        $targetAudience = trim($_POST['target_audience'] ?? '');
        $level = trim($_POST['level'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $duration = trim($_POST['duration'] ?? '');
        $websiteUrl = trim($_POST['program_website_url'] ?? '');
        $infoUrl = trim($_POST['info_url'] ?? '');
        $description = trim($_POST['program_description'] ?? '');

        if (empty($universityIds) || $title === '') {
            $_SESSION['flash'] = 'Universitas dan judul program wajib diisi.';
            header('Location: admin.php');
            exit;
        }

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                INSERT INTO programs
                (title, logo_url, program_type, target_audience, level, city, duration, website_url, info_url, description)
                VALUES
                (:title, :logo_url, :program_type, :target_audience, :level, :city, :duration, :website_url, :info_url, :description)
            ");

            $stmt->execute([
                ':title' => $title,
                ':logo_url' => $logoUrl,
                ':program_type' => $programType,
                ':target_audience' => $targetAudience,
                ':level' => $level,
                ':city' => $city,
                ':duration' => $duration,
                ':website_url' => $websiteUrl,
                ':info_url' => $infoUrl,
                ':description' => $description
            ]);

            $programId = (int)$pdo->lastInsertId();

            $linkStmt = $pdo->prepare("
                INSERT INTO program_universities
                (program_id, university_id)
                VALUES (:program_id, :university_id)
            ");

            foreach ($universityIds as $universityId) {
                $linkStmt->execute([
                    ':program_id' => $programId,
                    ':university_id' => $universityId
                ]);
            }

            $pdo->commit();

            $_SESSION['flash'] = 'Program studi berhasil ditambahkan.';
            header('Location: admin.php');
            exit;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            $_SESSION['flash'] = 'Gagal menambahkan program studi.';
            header('Location: admin.php');
            exit;
        }
    }
}

$universityStmt = $pdo->query("SELECT id, name FROM universities ORDER BY name ASC");
$universities = $universityStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin StudyNihon</title>
  <style>
    body{
      font-family: Arial, sans-serif;
      margin:0;
      background:#f8fafc;
      color:#0f172a;
    }
    .container{
      width:min(1000px, calc(100% - 32px));
      margin:40px auto;
    }
    .box{
      background:#fff;
      border:1px solid #e2e8f0;
      border-radius:18px;
      padding:24px;
      margin-bottom:24px;
      box-shadow:0 10px 25px rgba(15,23,42,0.04);
    }
    h2{
      margin-top:0;
    }
    .form-grid{
      display:grid;
      grid-template-columns:repeat(2, minmax(0, 1fr));
      gap:16px;
    }
    .field{
      display:flex;
      flex-direction:column;
      gap:8px;
      margin-bottom:12px;
    }
    .field.full{
      grid-column:1 / -1;
    }
    label{
      font-weight:700;
      font-size:0.9rem;
    }
    input, select, textarea, button{
      border:1px solid #cbd5e1;
      border-radius:10px;
      padding:12px 14px;
      font-size:1rem;
      font-family:inherit;
    }
    textarea{
      min-height:100px;
      resize:vertical;
    }
    button{
      background:#1d4ed8;
      color:#fff;
      border:none;
      cursor:pointer;
      font-weight:700;
    }
    .message{
      margin-bottom:16px;
      padding:12px 14px;
      border-radius:10px;
      background:#ecfeff;
      color:#0f172a;
      border:1px solid #a7f3d0;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="box">
      <h2>Tambah Universitas</h2>

      <?php if ($message !== ''): ?>
        <div class="message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
      <?php endif; ?>

      <form method="POST">
        <div class="form-grid">
          <div class="field">
            <label>Nama Universitas</label>
            <input type="text" name="name" required />
          </div>

          <div class="field">
            <label>Prefektur</label>
            <input type="text" name="prefecture" required />
          </div>

          <div class="field">
            <label>Kota</label>
            <input type="text" name="municipality" required />
          </div>

          <div class="field">
            <label>Jenis Universitas</label>
            <select name="institution_type" required>
              <option value="private">Swasta</option>
              <option value="public">Negeri Daerah</option>
              <option value="national">Negeri</option>
            </select>
          </div>

          <div class="field full">
            <label>Alamat</label>
            <input type="text" name="location" required />
          </div>

          <div class="field full">
            <label>URL Foto</label>
            <input type="text" name="photo_url" />
          </div>

          <div class="field full">
            <label>Website Universitas</label>
            <input type="text" name="website_url" placeholder="https://kampuscontoh.com"/>
          </div>

          <div class="field full">
            <label>Link Informasi Lain</label>
            <input
              type="url"
              name="info_url"
              placeholder="https://contoh.com/informasi"
            />
          </div>

          <div class="field full">
            <label>Deskripsi</label>
            <textarea name="description"></textarea>
          </div>

          <div class="field full">
            <button type="submit" name="submit_university">Simpan Universitas</button>
          </div>
        </div>
      </form>
    </div>

    <div class="box">
      <h2>Tambah Program Studi / Beasiswa</h2>

      <form method="POST">
        <div class="form-grid">
          <div class="field">
            <label>Judul Program</label>
            <input type="text" name="title" required />
          </div>
          <div class="field">
            <label>Jenis Program</label>
            <input
              type="text"
              name="program_type"
              placeholder="Beasiswa / Pertukaran Pelajar / Riset"
              required
            />
          </div>

          <div class="field">
            <label>Tingkat Pendidikan</label>
            <input type="text" name="level"/>
          </div>

          <div class="field">
            <label>Durasi / Periode</label>
            <input type="text" name="duration" placeholder="4 tahun" />
          </div>

          <div class="field">
            <label>Target Peserta</label>
            <input
              type="text"
              name="target_audience"
              placeholder="Siswa SMA / Mahasiswa S1 / Lulusan S1"
              required
            />
          </div>
          
          <div class="field">
            <label>Logo Program (URL Gambar)</label>
            <input
              type="url"
              name="logo_url"
              placeholder="https://contoh.com/logo.png"
            />
          </div>

          <div class="field full">
            <label>Situs Resmi</label>
            <input type="text" name="program_website_url" placeholder="https://programcontoh.com" />
          </div>

          <div class="field full">
            <label>Link Informasi / Pendaftaran</label>
            <input
              type="url"
              name="info_url"
              placeholder="https://contoh.com/informasi"
            />
          </div>

          <div class="field full">
            <label>Deskripsi</label>
            <textarea name="program_description"></textarea>
          </div>

          <div class="field full">
            <label>Universitas yang dapat dipilih</label>
            <select name="university_ids[]" multiple required>
              <?php foreach ($universities as $u): ?>
                <option value="<?= (int)$u['id'] ?>">
                  <?= htmlspecialchars($u['name'], ENT_QUOTES, 'UTF-8') ?>
                </option>
              <?php endforeach; ?>
            </select>
            <small>Tekan Ctrl untuk memilih beberapa opsi</small>
          </div>

          <div class="field full">
            <button type="submit" name="submit_program">Simpan Program</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>
</html>