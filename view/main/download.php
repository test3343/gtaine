<?php
$downloads = [
    'launcher' => [
        'url' => 'https://batkivshina-gta.cdn.express/~/share/3011bd650d2f/setup_BATKIVSHINA_GTA.exe',
        'filename' => 'GTAINE-Launcher.exe',
    ],
];

if (isset($_GET['download'], $downloads[$_GET['download']])) {
    $file = $downloads[$_GET['download']];
    $url = $file['url'];
    $filename = $file['filename'];

    while (ob_get_level() > 0) {
        ob_end_clean();
    }

    if (function_exists('set_time_limit')) {
        @set_time_limit(0);
    }

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    header('Pragma: public');
    header('Expires: 0');
    header('X-Content-Type-Options: nosniff');

    if (function_exists('curl_init')) {
        $output = fopen('php://output', 'wb');
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_FILE => $output,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CONNECTTIMEOUT => 20,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FAILONERROR => true,
            CURLOPT_USERAGENT => 'GTAINE-Downloader/1.0',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
        ]);
        curl_exec($ch);
        curl_close($ch);
        fclose($output);
        exit;
    }

    if (filter_var(ini_get('allow_url_fopen'), FILTER_VALIDATE_BOOL) || ini_get('allow_url_fopen') === '1') {
        $input = @fopen($url, 'rb');
        if ($input !== false) {
            while (!feof($input)) {
                echo fread($input, 8192);
                flush();
            }
            fclose($input);
            exit;
        }
    }

    header('Location: ' . $url);
    exit;
}
?>
<!DOCTYPE html>
<html data-bs-theme="dark" lang="uk">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>GTAINE - Завантаження</title>
<link href="https://fonts.googleapis.com" rel="preconnect"/>
<link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>
<style>
        :root {
            --ukraine-blue: #0057b7;
            --ukraine-yellow: #ffd700;
            --navy: #04101f;
            --navy-soft: #0a1d33;
            --panel: rgba(6, 18, 34, 0.84);
            --panel-border: rgba(255, 255, 255, 0.1);
            --text-soft: rgba(255, 255, 255, 0.74);
            --success: #18b36b;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            font-family: 'Montserrat', sans-serif;
            color: #fff;
            background:
                radial-gradient(circle at top left, rgba(0, 87, 183, 0.35), transparent 36%),
                radial-gradient(circle at right center, rgba(255, 215, 0, 0.18), transparent 28%),
                linear-gradient(145deg, #020814 0%, #071325 48%, #020814 100%);
            padding: 32px 18px;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background:
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 255, 255, 0.02) 1px, transparent 1px);
            background-size: 36px 36px;
            mask-image: radial-gradient(circle at center, black 45%, transparent 100%);
            pointer-events: none;
        }

        .shell {
            width: 100%;
            max-width: 1120px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        .hero {
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(320px, 0.9fr);
            gap: 22px;
            align-items: stretch;
        }

        .hero-panel,
        .download-card,
        .footer-note {
            background: var(--panel);
            border: 1px solid var(--panel-border);
            backdrop-filter: blur(16px);
            box-shadow: 0 24px 60px rgba(0, 0, 0, 0.28);
        }

        .hero-panel {
            border-radius: 32px;
            padding: 34px;
            position: relative;
            overflow: hidden;
        }

        .hero-panel::after {
            content: '';
            position: absolute;
            right: -100px;
            top: -100px;
            width: 240px;
            height: 240px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 215, 0, 0.22), transparent 70%);
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: rgba(255, 255, 255, 0.88);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .hero h1 {
            font-size: clamp(2.2rem, 4vw, 4rem);
            line-height: 1.04;
            margin-bottom: 16px;
        }

        .hero h1 span {
            background: linear-gradient(135deg, var(--ukraine-yellow), #fff2a8);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .lead {
            max-width: 630px;
            color: var(--text-soft);
            line-height: 1.7;
            font-size: 1rem;
            margin-bottom: 22px;
        }

        .quick-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 24px;
        }

        .stat-chip {
            padding: 12px 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            min-width: 130px;
        }

        .stat-chip strong {
            display: block;
            font-size: 1rem;
            margin-bottom: 4px;
        }

        .stat-chip span {
            color: var(--text-soft);
            font-size: 0.86rem;
        }

        .helper-card {
            border-radius: 32px;
            padding: 28px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.03)),
                rgba(4, 16, 31, 0.92);
        }

        .helper-card h2 {
            font-size: 1.35rem;
            margin-bottom: 14px;
        }

        .helper-list {
            display: grid;
            gap: 12px;
            margin-bottom: 18px;
        }

        .helper-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            color: var(--text-soft);
            line-height: 1.55;
        }

        .helper-item i {
            color: var(--ukraine-yellow);
            margin-top: 3px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #fff;
            text-decoration: none;
            font-weight: 600;
            padding: 13px 16px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: 0.25s ease;
        }

        .back-link:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.07);
        }

        .downloads {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
            margin-top: 22px;
        }

        .download-card {
            border-radius: 28px;
            padding: 28px;
            position: relative;
            overflow: hidden;
        }

        .download-card::before {
            content: '';
            position: absolute;
            inset: 0 auto 0 0;
            width: 5px;
            background: linear-gradient(180deg, var(--ukraine-blue), var(--ukraine-yellow));
        }

        .card-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 999px;
            padding: 8px 12px;
            margin-bottom: 16px;
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.86);
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .download-card h3 {
            font-size: 1.65rem;
            margin-bottom: 12px;
        }

        .download-card p {
            color: var(--text-soft);
            line-height: 1.7;
            margin-bottom: 18px;
        }

        .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 22px;
        }

        .meta span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.05);
            font-size: 0.88rem;
            color: rgba(255, 255, 255, 0.82);
        }

        .btn {
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            min-height: 58px;
            padding: 16px 22px;
            border: 0;
            border-radius: 18px;
            text-decoration: none;
            font-weight: 700;
            color: #fff;
            cursor: pointer;
            transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
        }

        .btn:hover {
            transform: translateY(-3px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--ukraine-blue), #3186e5 55%, var(--ukraine-yellow));
            box-shadow: 0 18px 30px rgba(0, 87, 183, 0.28);
        }

        .btn-secondary {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08), rgba(255, 255, 255, 0.03));
            border: 1px solid rgba(255, 255, 255, 0.12);
            box-shadow: 0 18px 30px rgba(0, 0, 0, 0.2);
        }

        .download-note {
            margin-top: 16px;
            padding: 14px 16px;
            border-radius: 16px;
            background: rgba(24, 179, 107, 0.1);
            border: 1px solid rgba(24, 179, 107, 0.22);
            color: rgba(255, 255, 255, 0.84);
            line-height: 1.6;
            font-size: 0.92rem;
        }

        .footer-note {
            margin-top: 22px;
            border-radius: 24px;
            padding: 20px 24px;
            color: var(--text-soft);
            line-height: 1.7;
            font-size: 0.94rem;
        }

        .footer-note strong {
            color: #fff;
        }

        @media (max-width: 920px) {
            .hero,
            .downloads {
                grid-template-columns: 1fr;
            }

            .hero-panel,
            .helper-card,
            .download-card {
                padding: 24px;
            }
        }

        @media (max-width: 540px) {
            body {
                padding: 16px 12px;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .meta,
            .quick-stats {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
<main class="shell">
<section class="hero">
<div class="hero-panel">
<div class="eyebrow"><i class="fa-solid fa-shield-heart"></i> Офіційний центр завантаження</div>
<h1>Завантаж GTAINE <span>без зайвих кроків</span></h1>
<p class="lead">
                Ми прибрали пряме відкриття `.exe` як тексту в браузері. Тепер лаунчер віддається як нормальний файл для завантаження, а окремо є варіант отримати повну збірку через Discord.
            </p>
<div class="quick-stats">
<div class="stat-chip">
<strong>Launcher</strong>
<span>Автооновлення і швидкий старт</span>
</div>
<div class="stat-chip">
<strong>Windows</strong>
<span>Підходить для встановлення гри</span>
</div>
<div class="stat-chip">
<strong>6.5 GB</strong>
<span>Повна гра після встановлення</span>
</div>
</div>
<a class="back-link" href="../../index.html"><i class="fa-solid fa-arrow-left"></i> Повернутися на головну</a>
</div>

<aside class="helper-card">
<div>
<h2>Що змінилось</h2>
<div class="helper-list">
<div class="helper-item">
<i class="fa-solid fa-download"></i>
<span>Кнопка лаунчера тепер веде на серверне завантаження з `Content-Disposition: attachment`.</span>
</div>
<div class="helper-item">
<i class="fa-solid fa-file-zipper"></i>
<span>Архів залишив окремо як запасний варіант через Discord, якщо потрібне ручне встановлення.</span>
</div>
<div class="helper-item">
<i class="fa-solid fa-circle-info"></i>
<span>Якщо браузер блокує файл, підтвердьте збереження або перевірте список завантажень.</span>
</div>
</div>
</div>
<div class="download-note">
                Якщо раніше після натискання з'являлися дивні символи, це був неправильний спосіб віддачі `.exe`. На цій сторінці це виправлено.
            </div>
</aside>
</section>

<section class="downloads">
<article class="download-card" id="launcher">
<div class="card-label"><i class="fa-solid fa-star"></i> Рекомендовано</div>
<h3>Лаунчер</h3>
<p>Найзручніший спосіб для більшості гравців: автоматичне оновлення, просте встановлення і запуск без ручного розпакування архівів.</p>
<div class="meta">
<span><i class="fa-solid fa-file"></i> `.exe` інсталятор</span>
<span><i class="fa-solid fa-bolt"></i> Швидкий старт</span>
<span><i class="fa-solid fa-rotate"></i> Автооновлення</span>
</div>
<a class="btn btn-primary" href="?download=launcher" id="launcher-btn">
<i class="fa-solid fa-download"></i>
<span>Завантажити лаунчер</span>
</a>
<div class="download-note">
                    Після натискання браузер має одразу запропонувати зберегти файл, а не відкривати сторінку з набором символів.
                </div>
</article>

<article class="download-card">
<div class="card-label"><i class="fa-brands fa-discord"></i> Запасний варіант</div>
<h3>Повна збірка</h3>
<p>Ручний варіант для тих, кому потрібен архів гри або допомога від спільноти. Посилання веде в Discord, де можна взяти актуальні файли.</p>
<div class="meta">
<span><i class="fa-solid fa-hard-drive"></i> Орієнтовно 6.5 GB</span>
<span><i class="fa-solid fa-user-group"></i> Підтримка спільноти</span>
<span><i class="fa-solid fa-screwdriver-wrench"></i> Ручне встановлення</span>
</div>
<a class="btn btn-secondary" href="https://discord.gg/9prJVHJnNP" rel="noopener" target="_blank">
<i class="fa-brands fa-discord"></i>
<span>Відкрити Discord</span>
</a>
</article>
</section>

<div class="footer-note">
<strong>Порада:</strong> якщо файл не почав качатися, перевірте блокування завантажень у браузері або антивірусі. Для більшості користувачів достатньо саме лаунчера.
        </div>
</main>

<script>
        document.getElementById('launcher-btn').addEventListener('click', function () {
            const label = this.querySelector('span');
            const icon = this.querySelector('i');
            label.textContent = 'Починаємо завантаження...';
            icon.className = 'fa-solid fa-spinner fa-spin';
        });
    </script>
</body>
</html>
