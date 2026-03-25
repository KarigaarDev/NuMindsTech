<?php
use UI\Component;
$t = $theme ?? [];

function getHexInputs($mode, $t) {
    $colors = [
        'primary' => 'Brand Primary',
        'accent' => 'Brand Accent',
        'secondary' => 'Container / Secondary',
        'dark' => 'Deep Dark',
        'navy' => 'Navy Tone',
        'teal' => 'Teal Highlight',
        'tech' => 'Tech Background',
        'text_heading' => 'Heading Text',
        'text_body' => 'Body Text',
        'text_muted' => 'Muted Text',
        'text_inverse' => 'Inverse Text',
        'btn_bg' => 'Button Background',
        'btn_text' => 'Button Text'
    ];
    
    // In new DB schema, default values are full hex strings like '#085ae6'
    
    $html = '<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">';
    foreach ($colors as $key => $label) {
        $field = "{$mode}_{$key}";
        $val = $t[$field] ?? '#000000';
        $v = e($val);

        $html .= "
        <div class=\"space-y-2\">
            <label class=\"block text-[10px] font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400\">$label</label>
            <div class=\"flex items-center gap-3 bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl p-2 focus-within:ring-2 focus-within:ring-brand-primary/50 transition-all\">
                <input type=\"color\" id=\"picker_$field\" value=\"$v\" class=\"w-8 h-8 p-0 cursor-pointer rounded-lg bg-transparent border-none appearance-none shadow-sm\" 
                    oninput=\"document.getElementById('text_$field').value = this.value.toUpperCase();\">
                    
                <input type=\"text\" name=\"$field\" id=\"text_$field\" value=\"$v\" class=\"w-full bg-transparent border-none text-xs font-bold focus:outline-none dark:text-white uppercase tracking-wider\" 
                    oninput=\"document.getElementById('picker_$field').value = this.value;\" placeholder=\"#HEXCODE\">
            </div>
        </div>";
    }
    $html .= '</div>';
    return $html;
}
?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 relative z-10">
    <div>
        <h2 class="text-[10px] font-bold uppercase tracking-[0.3em] text-brand-primary mb-3">Theme Builder</h2>
        <h1 class="font-display text-4xl font-extrabold text-heading dark:text-inverse tracking-tight"><?= e($title) ?></h1>
    </div>
    <a href="<?= url('admin/themes.php') ?>" class="px-6 py-3 rounded-xl bg-white dark:bg-brand-navy border border-slate-200 dark:border-white/10 font-bold text-xs uppercase tracking-widest text-slate-500 hover:text-brand-primary transition-all shadow-sm">
        <i class="fa-solid fa-arrow-left mr-2"></i> Back to Gallery
    </a>
</div>

<form method="post" class="space-y-8 pb-32 relative z-10">
    <?= csrf_field() ?>

    <?= Component::card('
        <div class="grid md:grid-cols-3 gap-8">
            ' . Component::input('name', 'Theme Name', $t['name'] ?? '', 'text', 'My Custom Theme', true) . '
            ' . Component::input('font_sans', 'Sans Font (Body)', $t['font_sans'] ?? 'Inter', 'text', 'Inter', true) . '
            ' . Component::input('font_display', 'Display Font (Headings)', $t['font_display'] ?? 'Outfit', 'text', 'Outfit', true) . '
        </div>
        <div class="mt-4 p-4 bg-brand-primary/5 rounded-xl border border-brand-primary/10">
            <p class="text-xs text-brand-primary font-medium flex items-center gap-2"><i class="fa-solid fa-circle-info"></i> Fonts must be exact Google Fonts family names (e.g. "Roboto", "Open Sans").</p>
        </div>
    ', 'General Details', 'fa-tag') ?>

    <?= Component::card('
        <div class="mb-4 text-xs text-slate-500 dark:text-slate-400 font-medium">Use the color picker or specify 6-digit Hex codes (e.g. <code class="bg-slate-100 dark:bg-white/10 px-2 py-1 rounded">#F4F6F9</code>).</div>
        ' . getHexInputs('light', $t) . '
    ', 'Light Mode Palette', 'fa-sun') ?>

    <?= Component::card('
        <div class="mb-4 text-xs text-slate-500 dark:text-slate-400 font-medium">Use the color picker or specify 6-digit Hex codes (e.g. <code class="bg-slate-100 dark:bg-white/10 px-2 py-1 rounded">#0F172A</code>).</div>
        ' . getHexInputs('dark', $t) . '
    ', 'Dark Mode Palette', 'fa-moon') ?>

    <!-- Fixed Bottom Actions -->
    <div class="fixed bottom-0 left-0 right-0 p-6 bg-white/80 dark:bg-brand-dark/80 backdrop-blur-xl border-t border-slate-200 dark:border-white/10 z-50 transform md:pl-64 flex justify-end gap-4 shadow-[0_-10px_40px_rgba(0,0,0,0.05)]">
        <?php if (!($t['id'] ?? false)): ?>
            <label class="flex items-center gap-3 cursor-pointer mr-auto ml-4">
                <input type="checkbox" name="activate_now" value="1" class="w-5 h-5 rounded text-brand-primary bg-slate-100 border-transparent focus:border-transparent focus:ring-2 focus:ring-brand-primary/50">
                <span class="text-xs font-bold uppercase tracking-widest text-slate-600 dark:text-slate-300">Activate Immediately</span>
            </label>
        <?php endif; ?>
        <button type="submit" class="btn-primary px-10 py-4 rounded-xl font-display font-bold text-sm uppercase tracking-widest shadow-xl flex items-center gap-3 transform hover:scale-105 transition-all">
            <i class="fa-solid fa-save"></i> Save Theme Preset
        </button>
    </div>
</form>
