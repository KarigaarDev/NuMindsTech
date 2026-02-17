<?php
/**
 * Shared Tailwind CSS Configuration
 * Include this file to output consistent Tailwind config across all pages
 */

// This should be included in a <script> tag in HTML <head>
?>
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
                        primary: '#2563eb',      /* Solid Cobalt Blue */
                        accent: '#06b6d4',       /* Solid Cyan */
                        secondary: '#0f172a',    /* Midnight Navy */
                        dark: '#0f172a',         /* Unified Dark */
                        navy: '#1e293b',         /* Sidebar Navy */
                        teal: '#06b6d4',         /* Matching accent */
                    }
                }
            }
        }
    };
</script>

<style>
    .font-display { font-family: 'Outfit', sans-serif; }
    
    .glass-nav {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border-bottom: 1px solid rgba(37, 99, 235, 0.1);
    }
    .dark .glass-nav {
        background: rgba(15, 23, 42, 0.95);
        border-bottom: 1px solid rgba(37, 99, 235, 0.2);
    }
    
    /* Solid Brand Utilities */
    .text-brand-accent { color: #06b6d4; }
    .bg-brand-primary { background-color: #2563eb; }
    .bg-brand-secondary { background-color: #0f172a; }
    
    .btn-primary {
        background-color: #2563eb;
        color: white;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #1d4ed8;
        transform: translateY(-1px);
    }
    .btn-primary:active {
        transform: translateY(0);
    }
    
    .glass-sidebar {
        background: rgba(15, 23, 42, 0.98);
        backdrop-filter: blur(12px);
        border-right: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .premium-bg {
        background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.05), transparent),
                    radial-gradient(circle at bottom left, rgba(6, 182, 212, 0.05), transparent);
    }
</style>
