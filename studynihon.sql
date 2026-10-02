-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2026-10-02 04:29:11
-- サーバのバージョン： 10.4.32-MariaDB
-- PHP のバージョン: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `studynihon`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `programs`
--

CREATE TABLE `programs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `logo_url` varchar(500) DEFAULT NULL,
  `program_type` varchar(100) NOT NULL DEFAULT 'Lainnya',
  `target_audience` varchar(255) NOT NULL DEFAULT 'Semua',
  `level` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `duration` varchar(100) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `info_url` varchar(500) DEFAULT NULL,
  `document_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_license` varchar(255) DEFAULT NULL,
  `image_source_url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `programs`
--

INSERT INTO `programs` (`id`, `title`, `logo_url`, `program_type`, `target_audience`, `level`, `city`, `duration`, `website_url`, `info_url`, `document_url`, `description`, `created_at`, `image_license`, `image_source_url`) VALUES
(3, 'Examination for Japanese University Admission for International Students (EJU)', '', 'Ujian Masuk', 'Calon Mahasiswa S1', 'S1', '', 'Dilaksanakan 2 kali per tahum; Skor EJU berlaku selama 2 tahun', 'https://www.jasso.go.jp/en/ryugaku/eju/?utm_source=chatgpt.com', '', NULL, 'Ujian untuk pelajar internasional yang ingin melanjutkan studi S1 di Jepang. Nilai EJU digunakan oleh banyak universitas sebagai bagian dari seleksi masuk. Mata ujian yang diambil berbeda sesuai universitas dan jurusan tujuan.\r\nBiaya Pendaftaran: Rp110.000 (Indonesia, 2026)\r\nTes/Sertifikat Tambahan: Tidak ada untuk mendaftar EJU\r\nCatatan:\r\nPeserta memilih Bahasa Jepang, Matematika, Sains, atau Japan and the World sesuai persyaratan universitas.', '2026-09-26 08:35:47', NULL, NULL),
(4, 'Japanese Government (MEXT) Scholarship', '', 'Beasiswa', 'Pelajar dan Mahasiswa', 'S1 / S2 / S3', '', 'S1 : 5 tahun, S2 : 2 tahun, S3 : 3 tahun', 'https://www.mext.go.jp/en/index.htm', '', NULL, 'Beasiswa Pemerintah Jepang untuk berbagai jenjang studi, termasuk S1, S2, dan S3. Beasiswa mencakup biaya kuliah, tunjangan hidup bulanan, dan tiket pesawat sesuai program yang dipilih. Persyaratan dan proses seleksi berbeda untuk setiap jenjang.\r\nBiaya Pendaftaran : Gratis\r\nTes/Sertifikat Tambahan :  \r\n・S1 : TOEFL/EJU tidak wajib secara umum. Nilai EJU, TKA, UTBK, atau SAT dapat menjadi nilai tambahan. Pada kondisi tertentu untuk jalur IPS, JLPT/J-Test/NAT-Test/EJU dapat digunakan untuk memenuhi ketentuan nilai. Kedutaan Besar Jepang di Indonesia\r\n・S2/S3 : wajib memiliki salah satu, misalnya TOEFL iBT 72, IELTS 5.5, TOEIC L&R 785, TOEIC S&W 310, atau JLPT N2.\r\nCatatan :\r\nSelain dokumen, pelamar mengikuti ujian dan wawancara MEXT. Untuk S2/S3 diperlukan rencana penelitian dan proses mendapatkan Letter of Acceptance dari universitas Jepang.\r\nUntuk S1, MEXT Undergraduate pada prinsipnya hanya menempatkan penerima di universitas nasional Jepang. Untuk S2/S3, pilihan universitas lebih luas dan dapat mencakup universitas negeri maupun swasta.', '2026-09-26 13:43:58', NULL, NULL),
(5, 'KUAS-E / Super KUAS-E Scholarship', '', 'Beasiswa', 'Pelajar dan Mahasiswa', 'S1 / S2 / S3', '', 'S1 : 4 tahun, S2 : 2 tahun, S3 : 3 tahun', 'https://www.kuas.ac.jp/en/admission/scholarship/', '', NULL, 'Beasiswa dari Universitas Sains Lanjuta Kyoto atau Kyoto University of Advanced Science (KUAS) untuk mahasiswa internasional jenjang S1, S2, dan S3 tertentu. Beasiswa dapat berupa pembebasan atau pengurangan biaya kuliah, sedangkan Super KUAS-E juga memberikan tunjangan ¥1.200.000 per tahun.\r\nBiaya Pendaftaran : ¥5.000\r\nTes/Sertifikat Tambahan:  \r\n・S1: TOEFL iBT 80, IELTS 6.0, PTE 55, atau Duolingo 120.\r\n・S2/S3 Engineering & Business: TOEFL iBT 85, IELTS 6.5, PTE 65, atau Duolingo 130.\r\n・S2/S3 Bioenvironmental Sciences: TOEFL iBT 80, IELTS 6.0, PTE 55, atau Duolingo 120.\r\nCatatan:\r\nKemampuan bahasa Jepang tidak diwajibkan untuk program internasional. Dalam kondisi tertentu, pelamar dapat memperoleh exemption/waiver untuk tes bahasa Inggris. Beasiswa harus dipilih saat mengajukan aplikasi KUAS dan jumlah penerimanya terbatas.', '2026-09-26 14:05:35', NULL, NULL),
(6, 'Mitsui-Bussan Scholarship', '', 'Beasiswa', 'Calon Mahasiswa S1', 'S1', '', '5.5 tahun', 'https://www.mbkscholarship-id.com/?utm_source=chatgpt.com', '', NULL, 'Beasiswa penuh untuk pelajar Indonesia yang ingin menempuh S1 di Jepang. Program berlangsung sekitar 5,5 tahun, terdiri dari 1,5 tahun pendidikan bahasa Jepang dan 4 tahun universitas. Beasiswa mencakup biaya pendidikan, tunjangan ¥150.000 per bulan, tiket pesawat, dan beberapa bantuan lainnya.\r\nBiaya Pendaftaran: Gratis\r\nTes/Sertifikat Tambahan:\r\nTOEFL, IELTS, EJU, atau JLPT tidak wajib untuk mendaftar.\r\nCatatan:\r\nPelamar harus siap belajar dalam bahasa Jepang. SMK dan SMA Bahasa tidak termasuk dalam ketentuan 2026, dan bidang Kedokteran, Farmasi, serta Kedokteran Hewan tidak dapat dipilih. Universitas tujuan ditentukan kemudian dan harus mendapat persetujuan program berdasarkan pilihan, prestasi akademik, dan bidang studi peserta.', '2026-09-26 14:34:04', NULL, NULL),
(7, 'Fast Retailing Foundation Scholarship', '', 'Beasiswa', 'Calon Mahasiswa S1', 'S1', '', '4 - 4.5 tahun', 'https://www.fastretailing-foundation.or.jp/eng/scholarships/', '', NULL, 'Beasiswa untuk pelajar Indonesia yang ingin mengikuti program S1 berbahasa Inggris di universitas Jepang yang ditunjuk Fast Retailing Foundation. Beasiswa dapat mencapai ¥4.500.000 per tahun dan mencakup biaya universitas, bantuan persiapan ¥200.000, serta tunjangan hidup bulanan.\r\nBiaya Pendaftaran : (Tidak ada info di panduan resmi)\r\nTes/Sertifikat Tambahan:\r\nStandar yang sangat disarankan:\r\nTOEFL iBT 90 / IELTS 7.0\r\ndan salah satu dari:\r\nSAT 1450 / ACT 33 / IB 40 / EJU Math Course 2 + Science 340 / A-Level A*AA.\r\nCatatan:\r\nKhusus program S1 berbahasa Inggris di designated universities. Pelamar harus berusia maksimal 19 tahun saat masuk universitas. Pada prinsipnya tidak boleh menerima beasiswa grant-type lain secara bersamaan. Penerima juga diharapkan mencapai JLPT N2 sebelum lulus.', '2026-09-26 14:45:34', NULL, NULL);

-- --------------------------------------------------------

--
-- テーブルの構造 `program_tags`
--

CREATE TABLE `program_tags` (
  `program_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `program_universities`
--

CREATE TABLE `program_universities` (
  `program_id` int(11) NOT NULL,
  `university_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `program_universities`
--

INSERT INTO `program_universities` (`program_id`, `university_id`) VALUES
(3, 3),
(3, 4),
(3, 6),
(3, 7),
(3, 8),
(3, 10),
(3, 11),
(3, 12),
(3, 13),
(3, 14),
(3, 15),
(3, 16),
(3, 17),
(3, 18),
(3, 19),
(3, 20),
(3, 21),
(3, 22),
(3, 23),
(3, 24),
(3, 25),
(4, 3),
(4, 4),
(4, 6),
(4, 7),
(4, 8),
(4, 10),
(4, 11),
(4, 12),
(4, 13),
(4, 14),
(4, 15),
(4, 16),
(4, 17),
(4, 18),
(4, 19),
(4, 20),
(4, 21),
(4, 22),
(4, 23),
(4, 24),
(4, 25),
(5, 25),
(6, 3),
(6, 4),
(6, 6),
(6, 7),
(6, 8),
(6, 10),
(6, 11),
(6, 12),
(6, 13),
(6, 14),
(6, 15),
(6, 16),
(6, 17),
(6, 18),
(6, 19),
(6, 20),
(6, 21),
(6, 22),
(6, 23),
(6, 24),
(6, 25),
(7, 3),
(7, 6),
(7, 7),
(7, 8),
(7, 10),
(7, 11),
(7, 12),
(7, 13),
(7, 17),
(7, 18),
(7, 19);

-- --------------------------------------------------------

--
-- テーブルの構造 `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- テーブルの構造 `universities`
--

CREATE TABLE `universities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `prefecture` varchar(100) DEFAULT NULL,
  `municipality` varchar(100) DEFAULT NULL,
  `institution_type` varchar(50) NOT NULL DEFAULT 'private',
  `location` varchar(255) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `website_url` varchar(255) DEFAULT NULL,
  `info_url` varchar(500) DEFAULT NULL,
  `document_url` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image_license` varchar(255) DEFAULT NULL,
  `image_source_url` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- テーブルのデータのダンプ `universities`
--

INSERT INTO `universities` (`id`, `name`, `prefecture`, `municipality`, `institution_type`, `location`, `photo_url`, `website_url`, `info_url`, `document_url`, `description`, `created_at`, `image_license`, `image_source_url`) VALUES
(3, 'Universitas Tokyo', 'Tokyo', 'Bunkyo', 'national', '7 Chome-3-1 Hongo, Bunkyo City, Tokyo 113-8654, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Yayoimon_of_the_Hongo_Campus%2C_the_University_of_Tokyo_P3097686.jpg', 'https://www.u-tokyo.ac.jp/en/index.html', '', NULL, 'Bidang / Keunggulan Utama : \r\n・Universitas umum\r\n・Penelitian\r\nTingkat Kesulitan : ★★★★★★ (Sangat Sangat Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp105,4 juta\r\nBahasa Pengantar : Utamanya Jepang (program bahasa inggris tersedia dari 2027)', '2026-09-08 06:55:30', 'CC BY-SA 4.0 — Author: Kestrel', 'https://commons.wikimedia.org/wiki/File:Yayoimon_of_the_Hongo_Campus,_the_University_of_Tokyo_P3097686.jpg'),
(4, 'Universitas Tsukuba', 'Ibaraki', 'Tsukuba', 'national', '1 Chome-1-1 Tennodai, Tsukuba, Ibaraki 305-8577, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Fountain%2C_Univ._of_Tsukuba.jpg', 'https://www.tsukuba.ac.jp/en/', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Universitas umum\r\n・Sains dan teknologi\r\n・Olahraga\r\n・Internasional\r\nTingkat Kesulitan : ★★★★☆ (Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp101,5 juta untuk mahasiswa internasional mulai 2027\r\nBahasa Pengantar : Jepang/Inggris', '2026-09-08 07:23:45', 'CC BY-SA 4.0 — Author: Miyuki Meinaka', 'https://commons.wikimedia.org/wiki/File:Fountain,_Univ._of_Tsukuba.jpg'),
(6, 'Universitas Kyoto', 'Kyoto', 'Kyoto', 'national', 'Yoshidahonmachi, Sakyo Ward, Kyoto, 606-8501, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Kyoto_University_Campus.jpg', 'https://www.kyoto-u.ac.jp/en', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Universitas umum\r\n・Penelitian\r\nTingkat Kesulitan : ★★★★★ (Sangat Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp93,2 juta\r\nBahasa Pengantar : Utamanya Jepang', '2026-09-16 01:56:13', 'CC BY-SA 4.0 — Author: Soraie8288', 'https://commons.wikimedia.org/wiki/File:Kyoto_University_Campus.jpg'),
(7, 'Universitas Osaka', 'Osaka', 'Suita', 'national', 'Administration Bureau, 1-1 Yamadaoka, Suita, Osaka 565-0871, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Suita_campus_Osaka.jpg', 'https://www.osaka-u.ac.jp/en', '', NULL, 'Bidang / Keunggulan Utama:\r\n・Universitas umum\r\n・Penelitian\r\n・Internasional\r\nTingkat Kesulitan : ★★★★★ (Sangat Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp93,2 juta\r\nBahasa Pengantar : Jepang/Inggris', '2026-09-16 02:11:13', 'CC BY-SA 4.0 — Author: Ganesh0909', 'https://commons.wikimedia.org/wiki/File:Suita_campus_Osaka.jpg'),
(8, 'Universitas Tohoku', 'Miyagi', 'Sendai', 'national', '2 Chome-1-1 Katahira, Aoba Ward, Sendai, Miyagi 980-8577, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Kawauchi_campus_of_Tohoku_University_20220910c.jpg', 'https://www.tohoku.ac.jp/en/', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Universitas umum\r\n・Sains dan teknologi\r\n・Peneliti\r\nTingkat Kesulitan : ★★★★☆ (Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp134,7 juta untuk mahasiswa internasional mulai 2027\r\nBahasa Pengantar : Jepang/Inggris', '2026-09-16 06:21:29', 'CC BY-SA 4.0 — Author: 掬茶', 'https://commons.wikimedia.org/wiki/File:Kawauchi_campus_of_Tohoku_University_20220910c.jpg'),
(10, 'Universitas Kyushu', 'Fukuoka', 'Fukuoka', 'national', '744 Motooka, Nishi Ward, Fukuoka, 819-0395, Jepang (Ito Campus)', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Ito_Campus_of_Kyushu_University_at_dusk.jpg', 'https://www.kyushu-u.ac.jp/en/', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Universitas umum\r\n・Sains dan teknologi\r\n・Internasional\r\nTingkat Kesulitan : ★★★★☆ (Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp93,2 juta\r\nBahasa Pengantar : Jepang/Inggris\r\nKampus Utama : Ito Campus\r\nKampus Lain :\r\n・Chikushi Campus\r\n・Ohashi Campus\r\n・Rumah Sakit Universitas Kyushu', '2026-09-16 06:40:42', 'CC BY-SA 4.0 — Author: そらみみ', 'https://commons.wikimedia.org/wiki/File:Ito_Campus_of_Kyushu_University_at_dusk.jpg'),
(11, 'Universitas Hokkaido', 'Hokkaido', 'Sapporo', 'national', '5 Chome Kita 8 Jonishi, Kita Ward, Sapporo, Hokkaido 060-0808, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Hokkaido_University_aerial_shot.jpg', 'https://www.global.hokudai.ac.jp/', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Universitas umum\r\n・Pertanian\r\n・Sains dan teknologi\r\nTingkat Kesulitan : ★★★★☆ (Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp93,2 juta\r\nBahasa Pengantar : Jepang/Inggris', '2026-09-16 06:47:25', 'CC BY-SA 4.0 — Author: ブルーノ・プラス', 'https://commons.wikimedia.org/wiki/File:Hokkaido_University_aerial_shot.jpg'),
(12, 'Universitas Nagoya', 'Aichi', 'Nagoya', 'national', 'Furocho, Chikusa Ward, Nagoya, Aichi 464-8601, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Nagoya_University_01.jpg', 'https://en.nagoya-u.ac.jp/', '', NULL, 'Bidang / Keunggulan Umum :\r\n・Universitas umum\r\n・Sains dan teknologi\r\n・Penelitian\r\nTingkat Kesulitan : ★★★★☆ (Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp93,2 juta\r\nBahasa Pengantar : Jepang/Inggris', '2026-09-16 06:56:24', 'CC BY-SA 4.0 — Author: いどれいざん (Idoreizan)', 'https://commons.wikimedia.org/wiki/File:Nagoya_University_01.jpg'),
(13, 'Institute of Science Tokyo', 'Tokyo', 'Meguro', 'national', '2 Chome-12-1 Ookayama, Meguro City, Tokyo 152-8550, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/West_Building_1_-_Ookayama_Campus%2C_the_Institute_of_Science_Tokyo.jpg', 'https://www.isct.ac.jp/en', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Sains dan teknologi\r\n・Kedokteran dan kedokteran gigi\r\nTingkat Kesulitan : ★★★★★ (Sangat Sulit)\r\nBiaya Studi Tahun Pertama :\r\n・± Rp104,6 juta bagi bidang sains/teknologi \r\n・± Rp105,4 juta bagi bidang kedokteran/kedokteran gigi\r\nBahasa Pengantar : Jepang/Inggris', '2026-09-16 07:11:19', 'CC BY-SA 4.0 — Author: Kakidai', 'https://commons.wikimedia.org/wiki/File:West_Building_1_-_Ookayama_Campus,_the_Institute_of_Science_Tokyo.jpg'),
(14, 'Universitas Hitotsubashi', 'Tokyo', 'Kunitachi', 'national', '2 Chome-1 Naka, Kunitachi, Tokyo 186-0004, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Hitotsubashi_University.jpg', 'https://www.hit-u.ac.jp/eng/', '', NULL, 'Bidang / Keunggulan Utama:\r\n・Ekonomi\r\n・Bisnis\r\n・Ilmu sosial\r\nTingkat kesulitan : ★★★★★ (Sangat Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp105,4 juta\r\nBahasa Pengantar : Utamanya Jepang', '2026-09-17 01:47:20', 'CC BY-SA 4.0 — Author: Kakidai', 'https://commons.wikimedia.org/wiki/File:Hitotsubashi_University.jpg'),
(15, 'Universitas Kobe', 'Hyogo', 'Kobe', 'national', '1-1 Rokkodaicho, Nada Ward, Kobe, Hyogo 657-8501, Jepang (Rokkodai 2nd Campus)', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Kobe-University-Entrance.jpg', 'https://www.kobe-u.ac.jp/en/', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Universitas umum\r\n・Ekonomi\r\n・Manajemen\r\n・Ilmu kelautan\r\nTingkat Kesulitan : ★★★★☆ (Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp93,2 juta\r\nBahasa Pengantar : Utamanya Jepang\r\nKampus Utama : Rokkodai 2nd Campus\r\nKampus Lain :\r\n・Rokkodai 1st Campus\r\n・Tsurukabuto 1st Campus\r\n・Tsurukabuto 2nd Campus\r\n・Kusunoki Campus\r\n・Myodani Campus\r\n・Fukae Campus', '2026-09-17 02:09:05', 'CC BY-SA 4.0 — Author: Soraie8288', 'https://commons.wikimedia.org/wiki/File:Kobe-University-Entrance.jpg'),
(16, 'Universitas Hiroshima', 'Hiroshima', 'Higashihiroshima', 'national', '1 Chome-3-2 Kagamiyama, Higashihiroshima, Hiroshima 739-0046, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Hiroshima_University%2C_Japan.jpg', 'https://www.hiroshima-u.ac.jp/en', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Universitas umum\r\n・Pendidikan\r\n・Sains dan teknologi\r\nTingkat Kesulitan : ★★★☆☆ (Menengah - Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp93,2 juta\r\nBahasa Pengantar : Jepang/Inggris', '2026-09-26 00:43:04', 'CC BY-SA 3.0 — Author: John Paul Antes', 'https://commons.wikimedia.org/wiki/File:Hiroshima_University,_Japan.jpg'),
(17, 'Universitas Waseda', 'Tokyo', 'Shinjuku City', 'private', '1 Chome-6-104 Totsukamachi, Shinjuku City, Tokyo 169-8050, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Waseda_University.jpg', 'https://www.waseda.jp/top/en/', '', NULL, 'Bidang / Keunggulan Utama : \r\n・Universitas umum\r\n・Internasional\r\n・Ekonomi dan politik\r\n・Sains dan teknologi\r\nTingkat Kesulitan : ★★★★★ (Sangat Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp143–216 juta\r\nBahasa Pengantar : Jepang/Inggris', '2026-09-26 00:49:43', 'CC BY-SA 3.0 — Author: John Paul Antes', 'https://commons.wikimedia.org/wiki/File:Waseda_University.jpg'),
(18, 'Universitas Keio', 'Tokyo', 'Minato City', 'private', '2 Chome-15-45 Mita, Minato City, Tokyo 108-0073, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Keio_university_Mita_campus_001.jpg', 'https://www.keio.ac.jp/en/', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Universitas umum\r\n・Ekonomi\r\n・Bisnis\r\n・Sains dan teknologi\r\nTingkat Kesulitan : ★★★★★ (Sangat Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp171–451 juta\r\nBahasa Pengantar : Utamanya Jepang', '2026-09-26 00:56:53', 'CC BY-SA 3.0 — Author: 塾生', 'https://commons.wikimedia.org/wiki/File:Keio_university_Mita_campus_001.jpg'),
(19, 'Universitas Sophia', 'Tokyo', 'Chiyoda City', 'private', '7-1 Kioicho, Chiyoda City, Tokyo 102-8554, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Sophia_University%2C_Yotsuya_Campus%2C_Tokyo%2C_Japan.jpg', 'https://www.sophia.ac.jp/eng/', '', NULL, 'Bidang / Keunggulan utama :\r\n・Studi internasional\r\n・Bahasa asing\r\n・Humaniora\r\nTingkat Kesulitan : ★★★★☆ (Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp161–223 juta\r\nBahasa Pengantar : Jepang/Inggris', '2026-09-26 01:10:08', 'CC BY-SA 3.0 — Author: John Paul Antes', 'https://commons.wikimedia.org/wiki/File:Sophia_University,_Yotsuya_Campus,_Tokyo,_Japan.jpg'),
(20, 'Universitas Ritsumeikan', 'Kyoto', 'Kyoto', 'private', '56-1 Tojiin Kitamachi, Kita Ward, Kyoto, 603-8577, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Ritsumeikan_University_Kinugasa_Campus_ac.JPG', 'https://en.ritsumei.ac.jp/', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Universitas umum\r\n・Internasional\r\n・Teknologi informasi\r\nTingkat Kesulitan : ★★★☆☆ (Menengah - Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp178–296 juta untuk English-medium programs\r\nBahasa Pengantar : Jepang/Inggris', '2026-09-26 01:16:11', 'CC BY-SA 4.0 — Author: Asturio Cantabrio', 'https://commons.wikimedia.org/wiki/File:Ritsumeikan_University_Kinugasa_Campus_ac.JPG'),
(21, 'Universitas Studi Asing Tokyo', 'Tokyo', 'Toshima City', 'national', '4 Chome-42-31 Higashiikebukuro, Toshima City, Tokyo 170-0013, Jepang (Ikebukuro Campus)', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Tokyo_University_of_Foreign_Studies_20221126.jpg', 'https://www.tiu.ac.jp/etrack/', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Bahasa asing\r\n・Hubungan internasional\r\nTingkat Kesulitan : ★★★★☆ (Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp93,2 juta\r\nBahasa Pengantar : Utamanya Jepang\r\nKampus Utama :\r\n・Ikebukuro Campus\r\n・Kawagoe 1st Campus\r\nKampus Lain :\r\n・Kawagoe 2nd Campus\r\n・Sakado Campus', '2026-09-26 01:22:56', 'CC BY-SA 4.0 — Author: Eugene Ormandy', 'https://commons.wikimedia.org/wiki/File:Tokyo_University_of_Foreign_Studies_20221126.jpg'),
(22, 'Univeritas Internasional Akita', 'Akita', 'Akita', 'public', 'Okutsubakidai-193-2 Yuwatsubakigawa, Akita, 010-1211, Jepang', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/AIU_Main_entrance_%26_bus_stop.jpg', 'https://web.aiu.ac.jp/en/', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Studi internasional\r\n・Bahasa inggris\r\nTingkat Kesulitan : ★★★☆☆ (Menengah - Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp150,4 juta untuk mahasiswa dari luar Akita\r\nBahasa Pengantar : Inggris', '2026-09-26 01:30:33', 'CC BY-SA 4.0 — Author: Mariwlqs', 'https://commons.wikimedia.org/wiki/File:AIU_Main_entrance_%26_bus_stop.jpg'),
(23, 'Universitas Aizu', 'Fukushima', 'Aizukawamatsu', 'public', 'Jepang, 〒965-0006 Fukushima, Aizuwakamatsu, Itsukimachi Oaza Tsuruga, Kamiiawase−９０', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/The_University_of_Aizu.jpg', 'https://u-aizu.ac.jp/en/', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Ilmu komputer\r\n・Teknologi informasi\r\nTingkat Kesulitan : ★★★☆☆ (Menengah - Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp123,7 juta untuk mahasiswa dari luar Fukushima\r\nBahasa Pengantar : Jepang/Inggris', '2026-09-26 01:42:22', 'CC BY-SA 3.0 — Author: Junya Terazono', 'https://commons.wikimedia.org/wiki/File:The_University_of_Aizu.jpg'),
(24, 'Universitas Metropolian Osaka', 'Osaka', 'Osaka', 'public', '2 Chome-1-132 Morinomiya, Joto Ward, Osaka, 536-0025, Jepang (Morinomiya Campus', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/Osaka_Metropolitan_University_Morinomiya_campus_courtyard_20251011.jpg', 'https://www.omu.ac.jp/en/', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Universitas umum\r\n・Sains dan teknologi\r\n・Bisnis\r\n・Kedokteran\r\nTingkat Kesulitan : ★★★☆☆ (Menengah - Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp104,6 juta untuk mahasiswa dari luar Osaka\r\nBahasa Pengantar : Jepang\r\nKampus Utama : Morinomiya Campus\r\nKampus Lain :\r\n・Sugimoto Campus\r\n・Nakamozu Campus\r\n・Abeno Campus\r\n・Rinku Campus', '2026-09-26 01:49:14', 'CC BY-SA 4.0 — Author: L26', 'https://commons.wikimedia.org/wiki/File:Osaka_Metropolitan_University_Morinomiya_campus_courtyard_20251011.jpg'),
(25, 'Universitas Sains Lanjutan Kyoto', 'Kyoto', 'Kyoto', 'private', '18-18 Yamanouchi Gotandacho, Ukyo Ward, Kyoto, 615-0096, Jepang (Uzumasa Campus)', 'https://commons.wikimedia.org/wiki/Special:Redirect/file/%E4%BA%AC%E9%83%BD%E5%A4%AA%E7%A7%A6%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%91%E3%82%B9%E5%8D%97%E9%A4%A8.jpg', 'https://www.kuas.ac.jp/en/', '', NULL, 'Bidang / Keunggulan Utama :\r\n・Engineering\r\n・Bioenvironmental Sciences\r\n・Business Administration\r\n・Internasional\r\nTingkat Kesulitan : ★★★☆☆ (Menengah - Sulit)\r\nBiaya Studi Tahun Pertama : ± Rp211–262 juta\r\nBahasa Pengantar : Jepang/Inggris', '2026-09-26 12:48:17', 'CC BY-SA 4.0 — Author: 京都先端科学大学広報課', 'https://commons.wikimedia.org/wiki/File:%E4%BA%AC%E9%83%BD%E5%A4%AA%E7%A7%A6%E3%82%AD%E3%83%A3%E3%83%B3%E3%83%91%E3%82%B9%E5%8D%97%E9%A4%A8.jpg');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `programs`
--
ALTER TABLE `programs`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `program_tags`
--
ALTER TABLE `program_tags`
  ADD PRIMARY KEY (`program_id`,`tag_id`),
  ADD KEY `tag_id` (`tag_id`);

--
-- テーブルのインデックス `program_universities`
--
ALTER TABLE `program_universities`
  ADD PRIMARY KEY (`program_id`,`university_id`),
  ADD KEY `university_id` (`university_id`);

--
-- テーブルのインデックス `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- テーブルのインデックス `universities`
--
ALTER TABLE `universities`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `programs`
--
ALTER TABLE `programs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- テーブルの AUTO_INCREMENT `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `universities`
--
ALTER TABLE `universities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `program_tags`
--
ALTER TABLE `program_tags`
  ADD CONSTRAINT `program_tags_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `program_tags_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- テーブルの制約 `program_universities`
--
ALTER TABLE `program_universities`
  ADD CONSTRAINT `program_universities_ibfk_1` FOREIGN KEY (`program_id`) REFERENCES `programs` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `program_universities_ibfk_2` FOREIGN KEY (`university_id`) REFERENCES `universities` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
