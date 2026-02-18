<?php
/**
 * Shared Tailwind CSS Configuration
 * Production-ready dynamic theme system
 */
?>

<!-- =========================
     THEME VARIABLES (LOAD FIRST)
========================= -->
<style>
:root {
    /* LIGHT MODE COLORS */
    --brand-primary: #0d47a1;
    --brand-accent: #06b6d4;
    --brand-secondary: #0f172a;
    --brand-dark: #031849;
    --brand-navy: #1e293b;
    --brand-teal: #06b6d4;
    --brand-tech: #e3f2fd;
    --brand-red: #c3317d;

    --glass-bg: rgba(255, 255, 255, 0.95);
    --glass-border: rgba(37, 99, 235, 0.1);

    --text-heading: #0f172a;
--text-body: #334155;
--text-muted: #64748b;
--text-inverse: #ffffff;
--btn-primary-bg: var(--brand-red);
--btn-primary-text: #ffffff;
--btn-primary-hover: color-mix(in srgb, var(--brand-red) 85%, black);
--btn-primary-shadow: color-mix(in srgb, var(--brand-red) 35%, transparent);

}

.dark {
    /* DARK MODE COLORS */
    --brand-primary: #3b82f6;
    --brand-accent: #22d3ee;
    --brand-secondary: #020617;
    --brand-dark: #020617;
    --brand-navy: #0a2a74;
    --brand-teal: #2dd4bf;
    --brand-tech: #e3f2fd;
    --brand-red: #ef44d2;

    --glass-bg: rgba(15, 23, 42, 0.95);
    --glass-border: rgba(37, 99, 235, 0.2);

    --text-heading: #f1f5f9;
--text-body: #cbd5e1;
--text-muted: #94a3b8;
--text-inverse: #ffffff;
--btn-primary-bg: var(--brand-primary);
--btn-primary-text: #ffffff;
--btn-primary-hover: color-mix(in srgb, var(--brand-primary) 75%, white);
--btn-primary-shadow: color-mix(in srgb, var(--brand-primary) 45%, transparent);


}
</style>

<!-- =========================
     TAILWIND CONFIG
========================= -->
<script>
tailwind.config = {
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'sans-serif'],
                display: ['Outfit', 'sans-serif'],
            },
            colors: {
                brand: {
                    primary: "var(--brand-primary)",
                    accent: "var(--brand-accent)",
                    secondary: "var(--brand-secondary)",
                    dark: "var(--brand-dark)",
                    navy: "var(--brand-navy)",
                    teal: "var(--brand-teal)",
                    tech: "var(--brand-tech)",
                    red: "var(--brand-red)",
                },
              text: {
        heading: "var(--text-heading)",
        body: "var(--text-body)",
        muted: "var(--text-muted)",
        inverse: "var(--text-inverse)",
    }, button: {
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

/* Primary Button */
.btn-primary {
    background-color: var(--btn-primary-bg);
    color: var(--btn-primary-text);
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: var(--btn-primary-hover);
    transform: translateY(-1px);
}

.btn-primary:active {
    transform: translateY(0);
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
