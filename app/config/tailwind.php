<?php
/**
 * Shared Tailwind CSS Configuration
 * Production-ready dynamic theme system
 */

function hex2hsl($hex) {
    if (!$hex || $hex[0] !== '#') return '0 0% 0%';
    $hex = ltrim($hex, '#');
    if (strlen($hex) == 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    if (strlen($hex) !== 6) return '0 0% 0%';
    
    $r = hexdec(substr($hex, 0, 2)) / 255;
    $g = hexdec(substr($hex, 2, 2)) / 255;
    $b = hexdec(substr($hex, 4, 2)) / 255;
    
    $max = max($r, $g, $b);
    $min = min($r, $g, $b);
    $l = ($max + $min) / 2;
    $d = $max - $min;
    
    if ($d == 0) {
        $h = $s = 0;
    } else {
        $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
        if ($max == $r) {
            $h = ($g - $b) / $d + ($g < $b ? 6 : 0);
        } elseif ($max == $g) {
            $h = ($b - $r) / $d + 2;
        } else {
            $h = ($r - $g) / $d + 4;
        }
        $h /= 6;
    }
    return round($h * 360) . ' ' . round($s * 100) . '% ' . round($l * 100) . '%';
}

$theme = null;
if (isset($pdo)) {
    try {
        $stmt = $pdo->query("SELECT * FROM themes WHERE is_active = 1 LIMIT 1");
        $theme = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {}
}

if (!$theme) {
    // Fallback exactly matches DB defaults
    $theme = [
        'font_sans' => 'Inter',
        'font_display' => 'Outfit',
        'light_primary' => '#085ae6',
        'light_accent' => '#f1501a',
        'light_secondary' => '#1b2434',
        'light_dark' => '#f4f6f9',
        'light_navy' => '#34455f',
        'light_teal' => '#14b8a6',
        'light_tech' => '#f4f6f9',
        'light_text_heading' => '#0f172a',
        'light_text_body' => '#64748b',
        'light_text_muted' => '#94a3b8',
        'light_text_inverse' => '#ffffff',
        'light_btn_bg' => '#085ae6',
        'light_btn_text' => '#ffffff',
        'dark_primary' => '#3b82f6',
        'dark_accent' => '#fd5d26',
        'dark_secondary' => '#050b14',
        'dark_dark' => '#050b14',
        'dark_navy' => '#0f172a',
        'dark_teal' => '#2dd4bf',
        'dark_tech' => '#0f172a',
        'dark_text_heading' => '#ffffff',
        'dark_text_body' => '#94a3b8',
        'dark_text_muted' => '#64748b',
        'dark_text_inverse' => '#ffffff',
        'dark_btn_bg' => '#3b82f6',
        'dark_btn_text' => '#ffffff',
    ];
}

$fontSansUrl = urlencode($theme['font_sans']) . ':wght@400;500;600';
$fontDisplayUrl = urlencode($theme['font_display']) . ':wght@400;600;700;800';
?>

<!-- Dynamic Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=<?= $fontSansUrl ?>&family=<?= $fontDisplayUrl ?>&display=swap" rel="stylesheet">

<style>
:root {
    /* LIGHT MODE */
    --brand-primary: <?= hex2hsl($theme['light_primary']) ?>;
    --brand-accent: <?= hex2hsl($theme['light_accent']) ?>;
    --brand-secondary: <?= hex2hsl($theme['light_secondary']) ?>;
    --brand-dark: <?= hex2hsl($theme['light_dark']) ?>;
    --brand-navy: <?= hex2hsl($theme['light_navy']) ?>;
    --brand-teal: <?= hex2hsl($theme['light_teal']) ?>;
    --brand-tech: <?= hex2hsl($theme['light_tech']) ?>;
    --brand-red: 348 83% 47%;

    --glass-bg: hsla(0, 0%, 100%, 0.95);
    --glass-border: hsla(var(--brand-primary) / 0.08);

    --text-heading: <?= hex2hsl($theme['light_text_heading']) ?>;
    --text-body: <?= hex2hsl($theme['light_text_body']) ?>;
    --text-muted: <?= hex2hsl($theme['light_text_muted']) ?>;
    --text-inverse: <?= hex2hsl($theme['light_text_inverse']) ?>;

    --btn-primary-bg: hsl(<?= hex2hsl($theme['light_btn_bg']) ?>);
    --btn-primary-text: <?= $theme['light_btn_text'] ?>; /* Real HEX for direct color prop */
    --btn-primary-hover: hsl(<?= hex2hsl($theme['light_btn_bg']) ?> / 0.9);
}

.dark {
    /* DARK MODE */
    --brand-primary: <?= hex2hsl($theme['dark_primary']) ?>;
    --brand-accent: <?= hex2hsl($theme['dark_accent']) ?>;
    --brand-secondary: <?= hex2hsl($theme['dark_secondary']) ?>;
    --brand-dark: <?= hex2hsl($theme['dark_dark']) ?>;
    --brand-navy: <?= hex2hsl($theme['dark_navy']) ?>;
    --brand-teal: <?= hex2hsl($theme['dark_teal']) ?>;
    --brand-tech: <?= hex2hsl($theme['dark_tech']) ?>;
    --brand-red: 348 83% 55%;

    --glass-bg: hsla(222, 47%, 4%, 0.9);
    --glass-border: hsla(var(--brand-primary) / 0.15);

    --text-heading: <?= hex2hsl($theme['dark_text_heading']) ?>;
    --text-body: <?= hex2hsl($theme['dark_text_body']) ?>;
    --text-muted: <?= hex2hsl($theme['dark_text_muted']) ?>;
    --text-inverse: <?= hex2hsl($theme['dark_text_inverse']) ?>;

    --btn-primary-bg: hsl(<?= hex2hsl($theme['dark_btn_bg']) ?>);
    --btn-primary-text: <?= $theme['dark_btn_text'] ?>; /* Real HEX */
    --btn-primary-hover: hsl(<?= hex2hsl($theme['dark_btn_bg']) ?> / 0.9);
}
</style>

<script>
tailwind.config = {
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['"<?= $theme['font_sans'] ?>"', 'sans-serif'],
                display: ['"<?= $theme['font_display'] ?>"', 'sans-serif'],
            },
            colors: {
                brand: {
                    primary: "hsl(var(--brand-primary) / <alpha-value>)",
                    accent: "hsl(var(--brand-accent) / <alpha-value>)",
                    secondary: "hsl(var(--brand-secondary) / <alpha-value>)",
                    dark: "hsl(var(--brand-dark) / <alpha-value>)",
                    navy: "hsl(var(--brand-navy) / <alpha-value>)",
                    teal: "hsl(var(--brand-teal) / <alpha-value>)",
                    tech: "hsl(var(--brand-tech) / <alpha-value>)",
                    red: "hsl(var(--brand-red) / <alpha-value>)",
                },
                heading: "hsl(var(--text-heading) / <alpha-value>)",
                body: "hsl(var(--text-body) / <alpha-value>)",
                muted: "hsl(var(--text-muted) / <alpha-value>)",
                inverse: "hsl(var(--text-inverse) / <alpha-value>)",
                button: {
                    primary: "var(--btn-primary-bg)",
                    primaryHover: "var(--btn-primary-hover)",
                    primaryText: "var(--btn-primary-text)",
                }
            }
        }
    }
};
</script>

<!-- =========================
     CUSTOM COMPONENT STYLES
========================= -->
<style>

/* =========================
   KEYFRAMES (IMPORTANT FIX)
========================= */
@keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}

/* Font Utility */
.font-display {
    font-family: 'Outfit', sans-serif;
}

/* Glass Navbar */
.glass-nav {
    background: var(--glass-bg);
    backdrop-filter: blur(12px);
    border-bottom: 1px solid var(--glass-border);
    transition: background 0.3s ease, border 0.3s ease;
}

/* =========================
   PREMIUM BUTTON (UPGRADED)
========================= */
.btn-primary {
    background: linear-gradient(
        -45deg,
        var(--btn-primary-bg),
        hsl(var(--brand-accent)),
        var(--btn-primary-bg),
        hsl(var(--brand-accent))
    );
    background-size: 300% 300%;
    animation: gradient 6s ease infinite;

    color: var(--btn-primary-text);
    border: none;
    border-radius: 12px;
    padding: 10px 20px;

    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

/* Glow effect */
.btn-primary::before {
    content: "";
    position: absolute;
    inset: 0;
    background: inherit;
    filter: blur(12px);
    opacity: 0.4;
    z-index: -1;
}

/* Hover */
.btn-primary:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 30px -10px var(--brand-primary);
}

/* Active */
.btn-primary:active {
    transform: translateY(0) scale(0.98);
}

/* Glass Sidebar */
.glass-sidebar {
    background: var(--brand-dark);
    backdrop-filter: blur(12px);
    border-right: 1px solid rgba(255, 255, 255, 0.05);
}

/* Premium Background Glow */
.premium-bg {
    background:
        radial-gradient(circle at top right, color-mix(in srgb, var(--brand-primary) 8%, transparent), transparent),
        radial-gradient(circle at bottom left, color-mix(in srgb, var(--brand-accent) 8%, transparent), transparent);
}

</style>