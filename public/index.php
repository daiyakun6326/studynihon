<?php
// filepath: C:\xampp\htdocs\alpha-05\main.php

require __DIR__ . '/../private/connect.php';

function h($value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

$keyword = trim($_GET['q'] ?? '');
$selectedUniversityId = (int)($_GET['university_id'] ?? 0);

$universityOptions = $pdo->query("
    SELECT id, name
    FROM universities
    ORDER BY name ASC
")->fetchAll(PDO::FETCH_ASSOC);

/* 大学 */
$universityConditions = [];
$universityParams = [];

if ($keyword !== '') {
    $universityConditions[] = "(
        u.name LIKE :u_name
        OR u.prefecture LIKE :u_prefecture
        OR u.municipality LIKE :u_municipality
        OR u.location LIKE :u_location
        OR u.institution_type LIKE :u_type
        OR u.description LIKE :u_description
    )";

    $like = '%' . $keyword . '%';
    $universityParams = [
        ':u_name' => $like,
        ':u_prefecture' => $like,
        ':u_municipality' => $like,
        ':u_location' => $like,
        ':u_type' => $like,
        ':u_description' => $like,
    ];
}

if ($selectedUniversityId > 0) {
    $universityConditions[] = 'u.id = :selected_university';
    $universityParams[':selected_university'] = $selectedUniversityId;
}

$universitySql = "
    SELECT
        u.id,
        u.name AS title,
        u.prefecture,
        u.municipality,
        u.institution_type,
        u.location AS city,
        u.photo_url,
        u.website_url,
        u.info_url,
        u.description,
        u.image_license,
        u.image_source_url,
        'university' AS item_type
    FROM universities u
";

if ($universityConditions) {
    $universitySql .= ' WHERE ' . implode(' AND ', $universityConditions);
}

$universitySql .= ' ORDER BY u.name ASC';

$universityStmt = $pdo->prepare($universitySql);
$universityStmt->execute($universityParams);
$universityItems = $universityStmt->fetchAll(PDO::FETCH_ASSOC);

/* プログラム */
$programConditions = [];
$programParams = [];

if ($keyword !== '') {
    $programConditions[] = "(
        p.title LIKE :p_title
        OR p.program_type LIKE :p_type
        OR p.target_audience LIKE :p_audience
        OR p.level LIKE :p_level
        OR p.city LIKE :p_city
        OR p.duration LIKE :p_duration
        OR p.description LIKE :p_description
        OR EXISTS (
            SELECT 1
            FROM program_universities pu_search
            JOIN universities u_search
                ON u_search.id = pu_search.university_id
            WHERE pu_search.program_id = p.id
              AND u_search.name LIKE :p_university
        )
    )";

    $like = '%' . $keyword . '%';
    $programParams = [
        ':p_title' => $like,
        ':p_type' => $like,
        ':p_audience' => $like,
        ':p_level' => $like,
        ':p_city' => $like,
        ':p_duration' => $like,
        ':p_description' => $like,
        ':p_university' => $like,
    ];
}

if ($selectedUniversityId > 0) {
    $programConditions[] = "EXISTS (
        SELECT 1
        FROM program_universities pu_filter
        WHERE pu_filter.program_id = p.id
          AND pu_filter.university_id = :program_university_id
    )";
    $programParams[':program_university_id'] = $selectedUniversityId;
}

$programSql = "
    SELECT
        p.id,
        p.title,
        p.logo_url,
        p.program_type,
        p.target_audience,
        p.level,
        p.city,
        p.duration,
        p.website_url,
        p.info_url,
        p.description,
        p.image_license,
        p.image_source_url,
        GROUP_CONCAT(DISTINCT u.name ORDER BY u.name SEPARATOR ', ') AS university_names,
        'program' AS item_type
    FROM programs p
    LEFT JOIN program_universities pu
        ON pu.program_id = p.id
    LEFT JOIN universities u
        ON u.id = pu.university_id
";

if ($programConditions) {
    $programSql .= ' WHERE ' . implode(' AND ', $programConditions);
}

$programSql .= ' GROUP BY p.id ORDER BY p.title ASC';

$programStmt = $pdo->prepare($programSql);
$programStmt->execute($programParams);
$programItems = $programStmt->fetchAll(PDO::FETCH_ASSOC);

$items = array_merge($universityItems, $programItems);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>StudyNihon</title>
  <style>
    :root {
      --primary: #0f172a;
      --secondary: #1d4ed8;
      --accent: #f59e0b;
      --bg: #f8fafc;
      --card: #ffffff;
      --text: #0f172a;
      --muted: #475569;
      --border: #e2e8f0;
    }

    * { box-sizing: border-box; }
    html { scroll-behavior: smooth; }

    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
      background: linear-gradient(180deg, #f8fafc 0%, #eef6ff 100%);
      color: var(--text);
    }

    a { text-decoration: none; color: inherit; }
    img { max-width: 100%; display: block; }

    .container {
      width: min(1120px, calc(100% - 32px));
      margin: 0 auto;
    }

    header {
      background: rgba(15, 23, 42, 0.96);
      color: #fff;
      position: sticky;
      top: 0;
      z-index: 10;
      box-shadow: 0 2px 12px rgba(15, 23, 42, 0.15);
    }

    .nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 18px 0;
    }

    .logo {
      font-weight: 700;
      font-size: 1.3rem;
      letter-spacing: 0.6px;
    }

    .nav-links {
      display: flex;
      gap: 24px;
      align-items: center;
      font-size: 0.95rem;
      color: #dbeafe;
    }

    .nav-links a:hover { color: #fff; }

    .btn {
      display: inline-block;
      border: none;
      border-radius: 12px;
      padding: 12px 18px;
      font-weight: 700;
      cursor: pointer;
      transition: 0.2s ease;
    }

    .btn-primary {
      background: var(--secondary);
      color: #fff;
      box-shadow: 0 8px 20px rgba(29, 78, 216, 0.18);
    }

    .btn-primary:hover { transform: translateY(-1px); }

    .btn-outline {
      background: transparent;
      color: #fff;
      border: 1px solid rgba(255, 255, 255, 0.35);
    }

    .hero { padding: 70px 0 40px; }

    .hero-wrap {
      display: grid;
      grid-template-columns: 1.1fr 0.9fr;
      gap: 32px;
      align-items: center;
    }

    .hero h1 {
      margin: 0 0 18px;
      font-size: clamp(2.2rem, 4vw, 4rem);
      line-height: 1.1;
      letter-spacing: -0.04em;
    }

    .hero p {
      margin: 0;
      color: var(--muted);
      line-height: 1.7;
      font-size: 1.08rem;
    }

    .hero-actions {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      margin: 24px 0 28px;
    }

    .stats {
      display: flex;
      gap: 22px;
      flex-wrap: wrap;
    }

    .stat {
      padding: 12px 16px;
      background: rgba(255, 255, 255, 0.8);
      border: 1px solid var(--border);
      border-radius: 14px;
      min-width: 130px;
    }

    .stat strong { display: block; font-size: 1.35rem; margin-bottom: 4px; }
    .stat span { color: var(--muted); font-size: 0.9rem; }

    .hero-card {
      background: linear-gradient(135deg, #0f172a 0%, #1d4ed8 100%);
      border-radius: 28px;
      padding: 24px;
      color: #fff;
      box-shadow: 0 28px 60px rgba(29, 78, 216, 0.2);
    }

    .mini-panel {
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.14);
      border-radius: 18px;
      padding: 18px;
      margin-bottom: 16px;
    }

    .mini-panel:last-child { margin-bottom: 0; }
    .mini-panel h3 { margin: 0 0 8px; font-size: 1.05rem; }

    .pill {
      display: inline-flex;
      align-items: center;
      background: #fff;
      color: var(--primary);
      padding: 7px 12px;
      border-radius: 999px;
      font-size: 0.8rem;
      font-weight: 700;
      margin: 6px 6px 0 0;
    }

    .search-section { padding: 40px 0 10px; }

    .panel {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 22px;
      box-shadow: 0 15px 36px rgba(15, 23, 42, 0.05);
      padding: 24px;
    }

    .search-row {
      display: grid;
      grid-template-columns: 1fr minmax(190px, 260px) auto;
      gap: 12px;
      margin-bottom: 22px;
    }

    .search-box,
    .university-select {
      width: 100%;
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 14px 16px;
      font-size: 1rem;
      outline: none;
      background: #fff;
      color: var(--text);
    }

    .search-box:focus,
    .university-select:focus {
      border-color: var(--secondary);
      box-shadow: 0 0 0 4px rgba(29, 78, 216, 0.08);
    }

    .content-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 18px;
    }

    .card {
      min-width: 0;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 18px;
      padding: 18px;
      transition: 0.2s ease;
      cursor: pointer;
    }

    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 18px 35px rgba(15, 23, 42, 0.08);
    }

    .card.expanded {
      border-color: var(--secondary);
      box-shadow: 0 18px 35px rgba(15, 23, 42, 0.1);
    }

    .card-image-wrap { position: relative; margin-bottom: 14px; }

    .card-image {
      display: block;
      width: 100%;
      height: 175px;
      margin: 0;
      border-radius: 11px;
      object-fit: cover;
      background: #f1f5f9;
    }

    .program-logo { padding: 16px; object-fit: contain; }

    .no-image {
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--muted);
      font-size: 0.9rem;
      font-weight: 700;
    }

    .image-info-button {
      position: absolute;
      top: 9px;
      right: 9px;
      width: 30px;
      min-height: 30px;
      height: 30px;
      padding: 0;
      border: 0;
      border-radius: 50%;
      background: rgba(15, 23, 42, 0.82);
      color: #fff;
      cursor: pointer;
      font-weight: 700;
    }

    .badge,
    .type-badge,
    .program-type-badge,
    .audience-badge {
      display: inline-block;
      padding: 5px 9px;
      border-radius: 999px;
      font-size: 0.75rem;
      font-weight: 700;
    }

    .badge { margin-bottom: 9px; background: #eff6ff; color: #1d4ed8; }
    .type-badge { margin: 0 0 9px 5px; background: #fef3c7; color: #92400e; }

    .card h3 { margin: 4px 0 10px; font-size: 1.12rem; }

    .program-tags { display: flex; flex-wrap: wrap; gap: 7px; margin-bottom: 10px; }
    .program-type-badge { background: #ecfdf5; color: #047857; }
    .audience-badge { background: #eff6ff; color: #1d4ed8; }

    .meta {
      display: flex;
      flex-wrap: wrap;
      gap: 7px;
      margin: 0;
      color: var(--muted);
      font-size: 0.83rem;
    }

    .meta span {
      padding: 4px 8px;
      border-radius: 7px;
      background: #f1f5f9;
    }

    .card-description,
    .card-related-universities {
      display: none;
      color: var(--muted);
      font-size: 0.93rem;
      line-height: 1.6;
      white-space: pre-line;
    }

    .card-description { margin: 12px 0 0; }
    .card-related-universities { margin-top: 12px; }
    .card-related-universities strong { color: var(--text); }
    .card-related-universities p { margin: 5px 0 0; }

    .card.expanded .card-description,
    .card.expanded .card-related-universities { display: block; }

    .card-footer {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-top: 14px;
    }

    .website-btn {
      display: inline-block;
      padding: 8px 10px;
      border-radius: 8px;
      background: #eff6ff;
      color: #1d4ed8;
      font-size: 0.82rem;
      font-weight: 700;
    }

    .empty-message {
      grid-column: 1 / -1;
      padding: 22px;
      border: 1px solid var(--border);
      border-radius: 14px;
      background: white;
    }

    .info-section { padding: 54px 0 24px; }

    .section-head {
      display: flex;
      justify-content: space-between;
      align-items: end;
      gap: 16px;
      margin-bottom: 24px;
    }

    .section-head h2 { margin: 0; font-size: clamp(1.7rem, 2vw, 2.4rem); }
    .section-head p { margin: 0; color: var(--muted); }

    .feature-grid {
      display: grid;
      grid-template-columns: repeat(3, minmax(0, 1fr));
      gap: 18px;
    }

    .feature {
      padding: 22px;
      border: 1px solid var(--border);
      border-radius: 20px;
      background: #fff;
    }

    .feature-icon {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 48px;
      height: 48px;
      margin-bottom: 14px;
      border-radius: 14px;
      background: linear-gradient(135deg, #dbeafe, #e0f2fe);
      font-size: 1.4rem;
    }

    .feature h3 { margin: 0 0 10px; font-size: 1.08rem; }
    .feature p { margin: 0; color: var(--muted); line-height: 1.7; }

    footer {
      margin-top: 50px;
      padding: 36px 0;
      background: #0f172a;
      color: #dbeafe;
    }

    .footer-wrap {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 14px;
      flex-wrap: wrap;
    }

    .footer-meta {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      gap: 4px;
    }

    .footer-note,
    .footer-warning {
      margin-top: 8px;
      font-size: 0.76rem;
      line-height: 1.6;
    }

    dialog {
      width: min(420px, calc(100% - 32px));
      padding: 22px;
      border: 0;
      border-radius: 14px;
      box-shadow: 0 20px 60px rgba(15, 23, 42, 0.25);
    }

    dialog::backdrop { background: rgba(15, 23, 42, 0.5); }
    dialog form { margin-top: 18px; text-align: right; }

    @media (max-width: 900px) {
      .hero-wrap,
      .content-grid,
      .feature-grid { grid-template-columns: 1fr; }
      .nav-links { display: none; }
      .search-row { grid-template-columns: 1fr; }
    }

    @media (max-width: 560px) {
      .hero { padding-top: 52px; }
      .section-head { flex-direction: column; align-items: flex-start; }
      .hero-actions { flex-direction: column; align-items: stretch; }
      .hero-actions .btn { width: 100%; text-align: center; }
      .stats { gap: 10px; }
      .stat { min-width: 0; flex: 1 1 100px; }
    }
  </style>
</head>
<body>
  <header>
    <div class="container nav">
      <div class="logo">StudyNihon</div>
      <nav class="nav-links">
        <a href="#search">Cari</a>
        <a href="#program">Program</a>
        <a href="#fitur">Fitur</a>
        <a href="#tentang">Tentang</a>
      </nav>
      <div>
        <a class="btn btn-outline" href="#search">Mulai Cari</a>
      </div>
    </div>
  </header>

  <main>
    <section class="hero">
      <div class="container hero-wrap">
        <div>
          <h1>Temukan universitas dan program studi di Jepang.</h1>
          <p>
            Cari universitas, program studi, dan informasi pendukung untuk mewujudkan rencana studi di Jepang.
          </p>

          <div class="hero-actions">
            <a class="btn btn-primary" href="#search">Cari Sekarang</a>
            <a class="btn btn-outline" href="#program" style="color:#0f172a;border-color:#cbd5e1;background:#fff;">Lihat Program</a>
          </div>

          <div class="stats">
            <div class="stat">
              <strong><?= count($universityItems) ?></strong>
              <span>Universitas</span>
            </div>
            <div class="stat">
              <strong><?= count($programItems) ?></strong>
              <span>Program</span>
            </div>
            <div class="stat">
              <strong>1</strong>
              <span>Platform</span>
            </div>
          </div>
        </div>

        <div class="hero-card">
          <div class="mini-panel">
            <h3>Universitas</h3>
            <span class="pill">Nasional</span>
            <span class="pill">Swasta</span>
            <span class="pill">Publik</span>
          </div>

          <div class="mini-panel">
            <h3>Program</h3>
            <span class="pill">S1</span>
            <span class="pill">S2</span>
            <span class="pill">Beasiswa</span>
          </div>

          <div class="mini-panel">
            <h3>Pencarian</h3>
            <span class="pill">Kota</span>
            <span class="pill">Universitas</span>
            <span class="pill">Program</span>
          </div>
        </div>
      </div>
    </section>

    <section class="search-section" id="search">
      <div class="container">
        <div class="panel">
          <div class="section-head" id="program">
            <div>
              <h2>Cari Universitas dan Program</h2>
            </div>
            <p>Gunakan kata kunci atau pilih universitas.</p>
          </div>

          <form class="search-row" id="search-form" method="GET">
            <input
              id="searchInput"
              class="search-box"
              type="search"
              name="q"
              value="<?= h($keyword) ?>"
              placeholder="Cari kota, program, universitas..."
            >

            <select class="university-select" name="university_id">
              <option value="0">Semua universitas</option>
              <?php foreach ($universityOptions as $option): ?>
                <option
                  value="<?= (int)$option['id'] ?>"
                  <?= $selectedUniversityId === (int)$option['id'] ? 'selected' : '' ?>
                >
                  <?= h($option['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>

            <button type="submit" class="btn btn-primary">Cari</button>
          </form>

          <?php if (!$items): ?>
            <div class="empty-message">
              <h3>Hasil tidak ditemukan</h3>
              <p>Coba kata kunci atau pilihan universitas lain.</p>
            </div>
          <?php else: ?>
            <section class="content-grid" aria-label="Hasil pencarian">
              <?php foreach ($items as $item): ?>
                <?php
                  $type = $item['item_type'];
                  $title = $item['title'] ?? '';
                  $imageUrl = $type === 'university'
                      ? ($item['photo_url'] ?? '')
                      : ($item['logo_url'] ?? '');

                  $institutionLabels = [
                      'private' => 'Swasta',
                      'public' => 'Negeri Daerah',
                      'national' => 'Negeri',
                  ];
                  $institutionLabel = $institutionLabels[$item['institution_type'] ?? ''] ?? 'Lainnya';
                ?>

                <article
                  class="card expandable-card"
                  tabindex="0"
                  aria-expanded="false"
                >
                  <div class="card-image-wrap">
                    <?php if ($imageUrl !== ''): ?>
                      <img
                        src="<?= h($imageUrl) ?>"
                        alt="<?= h($title) ?>"
                        class="card-image <?= $type === 'program' ? 'program-logo' : '' ?>"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"
                      >
                      <div class="card-image no-image" style="display:none;">NO IMAGE</div>
                    <?php else: ?>
                      <div class="card-image no-image">NO IMAGE</div>
                    <?php endif; ?>

                    <button
                      type="button"
                      class="image-info-button"
                      aria-label="Informasi gambar"
                      data-license="<?= h($item['image_license'] ?? '') ?>"
                      data-image-source-url="<?= h($item['image_source_url'] ?? '') ?>"
                      data-info-url="<?= h($item['info_url'] ?? '') ?>"
                      data-website-url="<?= h($item['website_url'] ?? '') ?>"
                    >i</button>
                  </div>

                  <span class="badge"><?= $type === 'university' ? 'Universitas' : 'Program' ?></span>

                  <?php if ($type === 'university'): ?>
                    <span class="type-badge"><?= h($institutionLabel) ?></span>
                  <?php endif; ?>

                  <h3><?= h($title) ?></h3>

                  <?php if ($type === 'program'): ?>
                    <div class="program-tags">
                      <?php if (!empty($item['program_type'])): ?>
                        <span class="program-type-badge"><?= h($item['program_type']) ?></span>
                      <?php endif; ?>
                      <?php if (!empty($item['target_audience'])): ?>
                        <span class="audience-badge"><?= h($item['target_audience']) ?></span>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>

                  <div class="meta">
                    <?php if ($type === 'university'): ?>
                      <?php foreach (['prefecture', 'municipality', 'city'] as $field): ?>
                        <?php if (!empty($item[$field])): ?>
                          <span><?= h($item[$field]) ?></span>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <?php if (!empty($item['city'])): ?>
                        <span><?= h($item['city']) ?></span>
                      <?php endif; ?>
                      <?php if (!empty($item['duration'])): ?>
                        <span><?= h($item['duration']) ?></span>
                      <?php endif; ?>
                    <?php endif; ?>
                  </div>

                  <?php if (!empty($item['description'])): ?>
                    <p class="card-description"><?= h($item['description']) ?></p>
                  <?php endif; ?>

                  <?php if ($type === 'program' && !empty($item['university_names'])): ?>
                    <div class="card-related-universities">
                      <strong>Universitas yang tersedia</strong>
                      <p><?= h($item['university_names']) ?></p>
                    </div>
                  <?php endif; ?>

                  <div class="card-footer">
                    <?php if (!empty($item['info_url'])): ?>
                      <a class="website-btn" href="<?= h($item['info_url']) ?>" target="_blank" rel="noopener noreferrer">Informasi</a>
                    <?php endif; ?>

                    <?php if (!empty($item['website_url'])): ?>
                      <a class="website-btn" href="<?= h($item['website_url']) ?>" target="_blank" rel="noopener noreferrer">Website</a>
                    <?php endif; ?>
                  </div>
                </article>
              <?php endforeach; ?>
            </section>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section class="info-section" id="fitur">
      <div class="container">
        <div class="section-head">
          <div>
            <h2>Kenapa website ini membantu?</h2>
          </div>
          <p>Semua kebutuhan studi ke Jepang bisa dicari dalam satu tempat.</p>
        </div>

        <div class="feature-grid">
          <div class="feature">
            <div class="feature-icon">🎓</div>
            <h3>Pilihan program relevan</h3>
            <p>Cari universitas dan program yang sesuai dengan minat dan target studi kamu.</p>
          </div>

          <div class="feature">
            <div class="feature-icon">📍</div>
            <h3>Informasi universitas</h3>
            <p>Bandingkan lokasi, jenis universitas, dan informasi terkait dengan mudah.</p>
          </div>

          <div class="feature">
            <div class="feature-icon">🔎</div>
            <h3>Pencarian cepat</h3>
            <p>Temukan universitas dan program yang relevan menggunakan satu pencarian.</p>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer id="tentang">
    <div class="container footer-wrap">
      <div>
        <strong>StudyNihon</strong><br />
        <div class="footer-note">
          Proyek siswa Sekolah Islam Athirah
        </div>
      </div>
      <div class="footer-meta">
        <div>© 2026 StudyNihon</div>
        <div class="version">Version rl-0001</div>
      </div>
    </div>
  </footer>

  <dialog id="image-info-dialog">
    <h2>Informasi Gambar</h2>
    <p><strong>Lisensi:</strong> <span id="dialog-image-license"></span></p>
    <div id="dialog-image-links"></div>
    <form method="dialog">
      <button type="submit" class="btn btn-primary">Tutup</button>
    </form>
  </dialog>

<script>
  const searchForm = document.getElementById('search-form');

  searchForm.addEventListener('submit', function () {
    sessionStorage.setItem('searchScrollPosition', String(window.scrollY));
  });

  document.querySelectorAll('.expandable-card').forEach(function (card) {
    function toggleCard() {
      const expanded = card.classList.toggle('expanded');
      card.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    }

    card.addEventListener('click', function (event) {
      if (event.target.closest('a, button')) return;
      toggleCard();
    });

    card.addEventListener('keydown', function (event) {
      if (event.target.closest('a, button')) return;
      if (event.key === 'Enter' || event.key === ' ') {
        event.preventDefault();
        toggleCard();
      }
    });
  });

  const infoDialog = document.getElementById('image-info-dialog');

  document.querySelectorAll('.image-info-button').forEach(function (button) {
    button.addEventListener('click', function (event) {
      event.stopPropagation();

      document.getElementById('dialog-image-license').textContent =
        button.dataset.license || 'Belum dicantumkan';

      const linksContainer = document.getElementById('dialog-image-links');
      linksContainer.replaceChildren();

      const sourceUrl = button.dataset.imageSourceUrl;

      if (sourceUrl) {
        try {
          const url = new URL(sourceUrl, window.location.href);

          if (['http:', 'https:'].includes(url.protocol)) {
            const link = document.createElement('a');
            link.href = url.href;
            link.target = '_blank';
            link.rel = 'noopener noreferrer';
            link.textContent = 'Sumber Gambar';
            linksContainer.appendChild(link);
          }
        } catch (error) {
          // 無効なURLは表示しません
        }
      }

      infoDialog.showModal();
    });
  });

  window.addEventListener('load', function () {
    const savedPosition = sessionStorage.getItem('searchScrollPosition');

    if (savedPosition !== null) {
      window.scrollTo(0, Number(savedPosition));
      sessionStorage.removeItem('searchScrollPosition');
    }
  });
</script>
</body>
</html>