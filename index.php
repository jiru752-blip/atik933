<?php
// Developed by https://t.me/Infinity_Codex | owner: t.me/zerox6t9

require_once 'includes/config.php';

// Check maintenance mode
$site_active = getSetting('site_active', '1');
if ($site_active !== '1') {
    $site_name = getSetting('site_name', 'YTX Tools Hub');
    $site_logo = getSetting('site_logo', 'assets/img/ytx-logo.png');
    $site_favicon = getSetting('site_favicon', $site_logo);
    $maintenance_msg = getSetting('maintenance_msg', 'সাইটটি এখন মেইনটেন্যান্সে আছে।');
    $primary_color = getSetting('primary_color', '#007AFF');
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($site_name) ?> - Maintenance</title>
    <link rel="apple-touch-icon" href="<?= htmlspecialchars($site_favicon) ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>:root { --primary: <?= htmlspecialchars($primary_color) ?>; }</style>
</head>
<body>
<div class="maintenance-screen">
    <div class="maintenance-box">
        <span class="m-icon">🔧</span>
        <?php if ($site_logo): ?><img src="<?= htmlspecialchars($site_logo) ?>" alt="Logo"><br><?php endif; ?>
        <h2><?= htmlspecialchars($site_name) ?></h2>
        <p><?= htmlspecialchars($maintenance_msg) ?></p>
    </div>
</div>
</body>
</html>
<?php exit; } ?>
<?php
// Load all settings
$site_name       = getSetting('site_name', 'YTX Tools Hub');
$site_tagline    = getSetting('site_tagline', '🧑‍💻');
$site_logo       = getSetting('site_logo', 'assets/img/ytx-logo.png');
$site_favicon    = getSetting('site_favicon', $site_logo);
$site_banner     = getSetting('site_banner', '');
$primary_color   = getSetting('primary_color', '#007AFF');
$channel_url     = getSetting('channel_url', '#');
$group_url       = getSetting('group_url', '#');
$developer_url   = getSetting('developer_url', '#');
$developer_name  = getSetting('developer_name', '');
$channel_name    = getSetting('channel_name', 'Channel');
$group_name      = getSetting('group_name', 'Group');
    $footer_text     = getSetting('footer_text', 'YTX Tools Hub');
$search_ph       = getSetting('search_placeholder', 'Search premium tools...');
$tools_title     = getSetting('tools_title', 'Tools Menu');
$particles_on    = getSetting('particles_enabled', '1');
$glow_on         = getSetting('glow_enabled', '1');
$anim_on         = getSetting('animations_enabled', '1');
$sidebar_items   = json_decode(getSetting('sidebar_items', '[]'), true) ?: [];

// Get active tools
$db = getDB();
$tools_result = $db->query("SELECT * FROM tools WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
$tools = [];
if ($tools_result) {
    while ($row = $tools_result->fetch_assoc()) $tools[] = $row;
}

// Get active announcements
$ann_result = $db->query("SELECT * FROM announcements WHERE is_active = 1 ORDER BY id DESC LIMIT 3");
$announcements = [];
if ($ann_result) {
    while ($row = $ann_result->fetch_assoc()) $announcements[] = $row;
}
// Load active sliding banners
$banners = [];
$banner_result = $db->query("SELECT * FROM banners WHERE is_active = 1 ORDER BY sort_order ASC, id ASC");
if ($banner_result) {
    while ($row = $banner_result->fetch_assoc()) $banners[] = $row;
}

// Primary color RGB for CSS variable
$hex = ltrim($primary_color, '#');
$r = hexdec(substr($hex,0,2));
$g = hexdec(substr($hex,2,2));
$b = hexdec(substr($hex,4,2));
$primary_rgb = "$r, $g, $b";
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="theme-color" content="<?= htmlspecialchars($primary_color) ?>">
    <title><?= htmlspecialchars($site_name) ?> <?= htmlspecialchars($site_tagline) ?></title>
    <link rel="icon" type="image/png" href="<?= htmlspecialchars($site_favicon) ?>">
    <link rel="apple-touch-icon" href="<?= htmlspecialchars($site_favicon) ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        :root {
            --primary: <?= htmlspecialchars($primary_color) ?>;
            --primary-rgb: <?= $primary_rgb ?>;
        }
        <?php if (!$anim_on || $anim_on === '0'): ?>
        * { animation: none !important; transition: none !important; }
        <?php endif; ?>
    </style>
</head>
<body>

<?php if ($particles_on === '1'): ?>
<canvas id="bg-canvas"></canvas>
<?php endif; ?>
<div class="bg-gradient"></div>

<!-- ===== Sidebar Overlay ===== -->
<div class="sidebar-overlay" id="sidebar-overlay" onclick="toggleSidebar()"></div>

<!-- ===== Sidebar ===== -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-head">
        <?php if ($site_logo): ?><img src="<?= htmlspecialchars($site_logo) ?>" alt="Logo" class="sidebar-logo"><?php endif; ?>
        <div class="sidebar-name"><?= htmlspecialchars($site_name) ?></div>
        <div class="sidebar-sub">YTX Tools Hub</div>
    </div>
    <div class="menu-links">
        <?php foreach ($sidebar_items as $item): ?>
        <a href="<?= htmlspecialchars($item['url'] ?? '#') ?>"
           target="<?= htmlspecialchars($item['target'] ?? '_self') ?>"
           class="menu-item">
            <i class="<?= htmlspecialchars($item['icon'] ?? 'fas fa-link') ?>"></i>
            <?= htmlspecialchars($item['label'] ?? 'Menu Item') ?>
        </a>
        <?php endforeach; ?>
        <div class="menu-item danger" onclick="toggleSidebar()" style="cursor:pointer; margin-top:10px;">
            <i class="fas fa-times"></i> Close Menu
        </div>
    </div>
</div>

<!-- ===== Main Wrapper ===== -->
<div class="main-wrapper">

    <!-- Header -->
    <header class="app-header">
        <div class="brand">
            <?php if ($site_logo): ?><img src="<?= htmlspecialchars($site_logo) ?>" alt="Logo" class="brand-logo"><?php endif; ?>
            <?= htmlspecialchars($site_name) ?> <?= htmlspecialchars($site_tagline) ?>
        </div>
        <div class="header-right">
            <a href="<?= htmlspecialchars($developer_url) ?>" target="_blank" class="icon-btn" title="Contact Developer">
                <i class="fas fa-headset"></i>
            </a>
            <div class="icon-btn" onclick="toggleSidebar()" title="Menu">
                <i class="fas fa-bars"></i>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">

        <!-- Announcements -->
        <?php if (!empty($announcements)): ?>
        <?php foreach ($announcements as $ann): ?>
        <div class="announcement <?= htmlspecialchars($ann['type']) ?>">
            <i class="<?php
                $icons = ['info'=>'fas fa-info-circle','success'=>'fas fa-check-circle','warning'=>'fas fa-exclamation-triangle','error'=>'fas fa-times-circle'];
                echo $icons[$ann['type']] ?? 'fas fa-info-circle';
            ?>"></i>
            <span><?= htmlspecialchars($ann['message']) ?></span>
            <span class="announcement-close" onclick="closeAnnouncement(this)" title="Close">
                <i class="fas fa-times"></i>
            </span>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>

        <!-- Sliding Banners -->
        <?php if (!empty($banners) || $site_banner): ?>
        <section class="banner-slider" id="banner-slider" aria-label="Featured banners">
            <div class="banner-track">
                <?php if ($site_banner && empty($banners)): $banners[] = ['title'=>'YTX Tools Hub','subtitle'=>'Discover useful tools for your everyday workflow.','image_url'=>$site_banner,'link_url'=>'#','button_text'=>'Explore tools']; endif; ?>
                <?php foreach ($banners as $bi => $banner): ?>
                <article class="banner-slide <?= $bi === 0 ? 'active' : '' ?>" data-slide="<?= $bi ?>" <?= !empty($banner['image_url']) ? 'style="background-image:url(\'' . htmlspecialchars($banner['image_url'], ENT_QUOTES) . '\')"' : '' ?>>
                    <div class="banner-overlay"></div>
                    <div class="banner-content"><span class="banner-kicker"><i class="fas fa-sparkles"></i> FEATURED</span><h3><?= htmlspecialchars($banner['title']) ?></h3><?php if (!empty($banner['subtitle'])): ?><p><?= htmlspecialchars($banner['subtitle']) ?></p><?php endif; ?><?php if (!empty($banner['button_text']) && !empty($banner['link_url']) && $banner['link_url'] !== '#'): ?><a href="<?= htmlspecialchars($banner['link_url']) ?>" target="_blank" class="banner-cta"><?= htmlspecialchars($banner['button_text']) ?> <i class="fas fa-arrow-right"></i></a><?php else: ?><a href="#tools-grid" class="banner-cta"><?= htmlspecialchars($banner['button_text'] ?: 'Explore tools') ?> <i class="fas fa-arrow-right"></i></a><?php endif; ?></div>
                </article>
                <?php endforeach; ?>
            </div>
            <?php if (count($banners) > 1): ?><button class="banner-control prev" onclick="moveBanner(-1)" aria-label="Previous banner"><i class="fas fa-chevron-left"></i></button><button class="banner-control next" onclick="moveBanner(1)" aria-label="Next banner"><i class="fas fa-chevron-right"></i></button><div class="banner-dots"><?php foreach ($banners as $bi => $banner): ?><button class="banner-dot <?= $bi === 0 ? 'active' : '' ?>" onclick="showBanner(<?= $bi ?>)" aria-label="Banner <?= $bi + 1 ?>"></button><?php endforeach; ?></div><?php endif; ?>
        </section>
        <?php endif; ?>

        <!-- Search -->
        <div class="search-wrap">
            <i class="fas fa-search"></i>
            <input type="text" id="search-input" class="search-input"
                   placeholder="<?= htmlspecialchars($search_ph) ?>"
                   oninput="filterTools()" autocomplete="off">
        </div>

        <!-- Tools Section -->
        <div class="section-title">
            <i class="fas fa-tools"></i>
            <?= htmlspecialchars($tools_title ?: 'YTX Tools') ?>
        </div>

        <div class="tools-grid" id="tools-grid">
            <?php if (empty($tools)): ?>
            <div class="no-results">
                <i class="fas fa-tools"></i>
                <p>কোনো টুল পাওয়া যায়নি।</p>
            </div>
            <?php else: ?>
            <?php foreach ($tools as $i => $tool): ?>
            <?php
                $icon = $tool['icon'] ?: 'assets/img/ytx-logo.png';
                $esc_url = htmlspecialchars($tool['url']);
                $esc_name = htmlspecialchars($tool['name']);
                $esc_desc = htmlspecialchars($tool['description']);
                $esc_icon = htmlspecialchars($icon);
                $esc_cat = htmlspecialchars($tool['category']);
            ?>
            <div class="tool-card"
                 data-name="<?= $esc_name ?>"
                 data-desc="<?= $esc_desc ?>"
                 data-cat="<?= $esc_cat ?>"
                 style="animation-delay: <?= $i * 0.06 ?>s"
                 onclick="openTool(<?= htmlspecialchars(json_encode($tool['url']), ENT_QUOTES, 'UTF-8') ?>, <?= htmlspecialchars(json_encode($tool['name']), ENT_QUOTES, 'UTF-8') ?>, <?= htmlspecialchars(json_encode($icon), ENT_QUOTES, 'UTF-8') ?>)">
                <div class="tool-icon-wrap">
                    <?php if ($glow_on === '1'): ?>
                    <div class="tool-glow"></div>
                    <?php endif; ?>
                    <img src="<?= $esc_icon ?>" alt="<?= $esc_name ?>" class="tool-icon" loading="lazy"
                         onerror="this.src='assets/img/ytx-logo.png'">
                </div>
                <div class="tool-name"><?= $esc_name ?></div>
                <?php if ($tool['description']): ?>
                <div class="tool-desc"><?= $esc_desc ?></div>
                <?php endif; ?>
                <?php if ($tool['category']): ?>
                <span class="tool-cat"><?= $esc_cat ?></span>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div><!-- /container -->

    <!-- Footer -->
    <footer class="app-footer">
        <i class="fas fa-code"></i> <?= htmlspecialchars($footer_text) ?>
    </footer>

</div><!-- /main-wrapper -->

<!-- ===== Tool Viewer ===== -->
<div id="tool-viewer">
    <div class="viewer-bar">
        <button class="viewer-back" onclick="closeTool()">
            <i class="fas fa-chevron-left"></i> Exit Tool
        </button>
        <div class="viewer-title" id="viewer-title">YTX Tool</div>
        <img id="viewer-icon" src="" alt="icon" class="viewer-icon">
    </div>
    <iframe id="viewer-frame" src="" class="viewer-frame" allowfullscreen></iframe>
</div>

<script src="assets/js/app.js"></script>
</body>
</html>
