<?php
session_start();

require __DIR__ . '/connect.php';

$message = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'delete_university') {
            $id = (int)$_POST['id'];

            $stmt = $pdo->prepare("DELETE FROM universities WHERE id = :id");
            $stmt->execute([':id' => $id]);

            $_SESSION['flash'] = 'Universitas berhasil dihapus.';
            header('Location: manage.php');
            exit;
        }

        if ($action === 'delete_program') {
            $id = (int)$_POST['id'];

            $stmt = $pdo->prepare("DELETE FROM programs WHERE id = :id");
            $stmt->execute([':id' => $id]);

            $_SESSION['flash'] = 'Program studi berhasil dihapus.';
            header('Location: manage.php');
            exit;
        }

        if ($action === 'update_university') {
            $id = (int)$_POST['id'];

            $name = trim($_POST['name'] ?? '');
            $prefecture = trim($_POST['prefecture'] ?? '');
            $municipality = trim($_POST['municipality'] ?? '');
            $institutionType = trim($_POST['institution_type'] ?? 'private');
            $institutionType = in_array($institutionType, ['private', 'public', 'national'], true)
                ? $institutionType
                : 'private';

            $location = trim($_POST['location'] ?? '');
            $photoUrl = trim($_POST['photo_url'] ?? '');
            $websiteUrl = trim($_POST['website_url'] ?? '');
            $infoUrl = trim($_POST['info_url'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $imageLicense = trim($_POST['image_license'] ?? '');

            if ($name === '' || $prefecture === '' || $municipality === '') {
                throw new RuntimeException('Nama universitas, provinsi, dan kota wajib diisi.');
            }

            $stmt = $pdo->prepare("
                UPDATE universities
                SET name = :name,
                    prefecture = :prefecture,
                    municipality = :municipality,
                    institution_type = :institution_type,
                    location = :location,
                    photo_url = :photo_url,
                    website_url = :website_url,
                    info_url = :info_url,
                    description = :description,
                    image_license = :image_license
                WHERE id = :id
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
                ':description' => $description,
                ':image_license' => $imageLicense,
                ':id' => $id,
            ]);

            $_SESSION['flash'] = 'Data universitas berhasil diperbarui.';
            header('Location: manage.php');
            exit;
        }

        if ($action === 'update_program') {
            $id = (int)$_POST['id'];

            $title = trim($_POST['title'] ?? '');
            $logoUrl = trim($_POST['logo_url'] ?? '');
            $imageLicense = trim($_POST['image_license'] ?? '');
            $programType = trim($_POST['program_type'] ?? '');
            $targetAudience = trim($_POST['target_audience'] ?? '');
            $level = trim($_POST['level'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $duration = trim($_POST['duration'] ?? '');
            $websiteUrl = trim($_POST['website_url'] ?? '');
            $infoUrl = trim($_POST['info_url'] ?? '');
            $description = trim($_POST['description'] ?? '');

            $universityIds = $_POST['university_ids'] ?? [];
            $universityIds = array_values(
                array_unique(
                    array_filter(array_map('intval', $universityIds))
                )
            );

            if ($title === '' || empty($universityIds)) {
                throw new RuntimeException('Nama program dan universitas wajib diisi.');
            }

            $pdo->beginTransaction();

            $stmt = $pdo->prepare("
                UPDATE programs
                SET title = :title,
                    logo_url = :logo_url,
                    image_license = :image_license,
                    program_type = :program_type,
                    target_audience = :target_audience,
                    level = :level,
                    city = :city,
                    duration = :duration,
                    website_url = :website_url,
                    info_url = :info_url,
                    description = :description
                WHERE id = :id
            ");

            $stmt->execute([
                ':title' => $title,
                ':logo_url' => $logoUrl,
                ':image_license' => $imageLicense,
                ':program_type' => $programType,
                ':target_audience' => $targetAudience,
                ':level' => $level,
                ':city' => $city,
                ':duration' => $duration,
                ':website_url' => $websiteUrl,
                ':info_url' => $infoUrl,
                ':description' => $description,
                ':id' => $id,
            ]);

            $stmt = $pdo->prepare("
                DELETE FROM program_universities
                WHERE program_id = :program_id
            ");
            $stmt->execute([':program_id' => $id]);

            $stmt = $pdo->prepare("
                INSERT INTO program_universities
                (program_id, university_id)
                VALUES (:program_id, :university_id)
            ");

            foreach ($universityIds as $universityId) {
                $stmt->execute([
                    ':program_id' => $id,
                    ':university_id' => $universityId,
                ]);
            }

            $pdo->commit();

            $_SESSION['flash'] = 'Data program berhasil diperbarui.';
            header('Location: manage.php');
            exit;
        }
    }
} catch (Throwable $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    $_SESSION['flash'] = $e->getMessage();
    header('Location: manage.php');
    exit;
}

$universities = $pdo->query("
    SELECT *
    FROM universities
    ORDER BY name ASC
")->fetchAll();

$programs = $pdo->query("
    SELECT
        p.*,
        GROUP_CONCAT(pu.university_id) AS university_ids,
        GROUP_CONCAT(u.name SEPARATOR ', ') AS university_names
    FROM programs p
    LEFT JOIN program_universities pu
        ON pu.program_id = p.id
    LEFT JOIN universities u
        ON u.id = pu.university_id
    GROUP BY p.id
    ORDER BY p.id DESC
")->fetchAll();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Manajemen StudyNihon</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f8fafc;
      color: #0f172a;
      margin: 0;
    }

    .container {
      width: min(1100px, calc(100% - 32px));
      margin: 32px auto;
    }

    .box {
      background: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 16px;
      padding: 20px;
      margin-bottom: 24px;
    }

    .item {
      border-top: 1px solid #e2e8f0;
      padding: 18px 0;
    }

    .item:first-child {
      border-top: 0;
    }

    input,
    select,
    textarea {
      width: 100%;
      padding: 10px;
      margin: 6px 0 12px;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      box-sizing: border-box;
    }

    textarea {
      min-height: 80px;
    }

    button {
      border: 0;
      border-radius: 8px;
      padding: 10px 14px;
      color: #fff;
      background: #1d4ed8;
      cursor: pointer;
      margin-right: 6px;
    }

    .delete {
      background: #dc2626;
    }

    .message {
      background: #dcfce7;
      padding: 12px;
      border-radius: 8px;
      margin-bottom: 20px;
    }

    .edit-form {
      display: none;
      margin-top: 14px;
      padding: 16px;
      background: #f8fafc;
      border-radius: 10px;
    }

    .edit-form.open {
      display: block;
    }

    .program-list {
      color: #475569;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
<div class="container">
  <h1>Manajemen StudyNihon</h1>

  <?php if ($message !== ''): ?>
    <div class="message">
      <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
    </div>
  <?php endif; ?>

  <div class="box">
    <h2>Data Universitas</h2>

    <?php foreach ($universities as $university): ?>
      <div class="item">
        <strong>
          <?= htmlspecialchars($university['name'], ENT_QUOTES, 'UTF-8') ?>
        </strong>

        <p>
          <?= htmlspecialchars($university['prefecture'], ENT_QUOTES, 'UTF-8') ?>
          /
          <?= htmlspecialchars($university['municipality'], ENT_QUOTES, 'UTF-8') ?>
        </p>

        <button type="button"
          onclick="toggleForm('university-<?= (int)$university['id'] ?>')">
          Edit
        </button>

        <form method="POST" style="display:inline">
          <input type="hidden" name="action" value="delete_university">
          <input type="hidden" name="id" value="<?= (int)$university['id'] ?>">
          <button class="delete" type="submit"
            onclick="return confirm('Yakin ingin menghapus universitas ini?')">
            Hapus
          </button>
        </form>

        <form
          id="university-<?= (int)$university['id'] ?>"
          class="edit-form"
          method="POST"
          enctype="multipart/form-data"
        >
          <input type="hidden" name="action" value="update_university">
          <input type="hidden" name="id" value="<?= (int)$university['id'] ?>">

          <label>Nama Universitas</label>
          <input name="name" required value="<?= htmlspecialchars($university['name'], ENT_QUOTES, 'UTF-8') ?>">

          <label>Provinsi</label>
          <input name="prefecture" required value="<?= htmlspecialchars($university['prefecture'], ENT_QUOTES, 'UTF-8') ?>">

          <label>Kota</label>
          <input name="municipality" required value="<?= htmlspecialchars($university['municipality'], ENT_QUOTES, 'UTF-8') ?>">

          <label>Alamat</label>
          <input name="location" value="<?= htmlspecialchars($university['location'], ENT_QUOTES, 'UTF-8') ?>">

          <label>Gambar</label>
          <input name="photo_url" value="<?= htmlspecialchars($university['photo_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

          <label>Lisensi Gambar</label>
          <input
            type="text"
            name="image_license"
            placeholder="Contoh: © Nama pemilik / CC BY 4.0"
            value="<?= htmlspecialchars($university['image_license'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
          >

          <label>Jenis Universitas</label>
          <select name="institution_type" required>
            <option value="private" <?= (($university['institution_type'] ?? 'private') === 'private') ? 'selected' : '' ?>>Swasta</option>
            <option value="public" <?= (($university['institution_type'] ?? 'private') === 'public') ? 'selected' : '' ?>>Negeri Daerah</option>
            <option value="national" <?= (($university['institution_type'] ?? 'private') === 'national') ? 'selected' : '' ?>>Negeri</option>
          </select>

          <label>Website Universitas</label>
          <input name="website_url" value="<?= htmlspecialchars($university['website_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

          <label>Link Informasi Lain</label>
          <input
            type="url"
            name="info_url"
            value="<?= htmlspecialchars($university['info_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
          >

          <label>Deskripsi Universitas</label>
          <textarea name="description"><?= htmlspecialchars(
              $university['description'] ?? '',
              ENT_QUOTES,
              'UTF-8'
          ) ?></textarea>

          <button type="submit">Simpan</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="box">
    <h2>Program Studi</h2>

    <?php foreach ($programs as $program): ?>
      <?php
        $selectedIds = array_map(
            'intval',
            array_filter(explode(',', $program['university_ids'] ?? ''))
        );
      ?>

      <div class="item">
        <strong>
          <?= htmlspecialchars($program['title'], ENT_QUOTES, 'UTF-8') ?>
        </strong>

        <p class="program-list">
          Universitas yang tersedia:
          <?= htmlspecialchars($program['university_names'] ?? '-', ENT_QUOTES, 'UTF-8') ?>
        </p>

        <button type="button"
          onclick="toggleForm('program-<?= (int)$program['id'] ?>')">
          Edit
        </button>

        <form method="POST" style="display:inline">
          <input type="hidden" name="action" value="delete_program">
          <input type="hidden" name="id" value="<?= (int)$program['id'] ?>">
          <button class="delete" type="submit"
            onclick="return confirm('Yakin ingin menghapus program ini?')">
            Hapus
          </button>
        </form>

        <form
          id="program-<?= (int)$program['id'] ?>"
          class="edit-form"
          method="POST"
          enctype="multipart/form-data"
        >
          <input type="hidden" name="action" value="update_program">
          <input type="hidden" name="id" value="<?= (int)$program['id'] ?>">

          <label>Nama Program</label>
          <input name="title" required value="<?= htmlspecialchars($program['title'], ENT_QUOTES, 'UTF-8') ?>">

          <label>Level</label>
          <input name="level" value="<?= htmlspecialchars($program['level'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
          <label>Durasi</label>
          <input name="duration" value="<?= htmlspecialchars($program['duration'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

          <label>Website Program</label>
          <input name="website_url" value="<?= htmlspecialchars($program['website_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>">

          <label>Link Informasi Lain</label>
          <input
            type="url"
            name="info_url"
            value="<?= htmlspecialchars($program['info_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
          >

          <label>Jenis Program</label>
          <input
            name="program_type"
            required
            value="<?= htmlspecialchars($program['program_type'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
          >

          <label>Ditujukan Untuk</label>
          <input
            name="target_audience"
            required
            value="<?= htmlspecialchars($program['target_audience'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
          >

          <label>Logo Program (URL Gambar)</label>
          <input
            type="url"
            name="logo_url"
            value="<?= htmlspecialchars($program['logo_url'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
          >
          <label>Lisensi Gambar</label>
          <input
            type="text"
            name="image_license"
            placeholder="Contoh: © Nama pemilik / CC BY 4.0"
            value="<?= htmlspecialchars($program['image_license'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
          >

          <label>Deskripsi</label>
          <textarea name="description"><?= htmlspecialchars($program['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>

          <label>Universitas yang Tersedia</label>
          <select name="university_ids[]" multiple required>
            <?php foreach ($universities as $university): ?>
              <option
                value="<?= (int)$university['id'] ?>"
                <?= in_array((int)$university['id'], $selectedIds, true) ? 'selected' : '' ?>
              >
                <?= htmlspecialchars($university['name'], ENT_QUOTES, 'UTF-8') ?>
              </option>
            <?php endforeach; ?>
          </select>

          <button type="submit">Simpan</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<script>
function toggleForm(id) {
  const form = document.getElementById(id);
  form.classList.toggle('open');
}
</script>
</body>
</html>