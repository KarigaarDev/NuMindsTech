<?php
/**
 * UI Components Helper for Numinds Tech
 * Provides consistent, premium UI elements for the Admin Dashboard
 */

namespace UI;

class Component {
    
    /**
     * Renders a premium card
     */
    public static function card($content, $title = '', $icon = '', $class = '') {
        $html = '<div class="bg-white dark:bg-brand-navy p-6 md:p-8 rounded-[2rem] border border-slate-100 dark:border-white/5 shadow-sm transition-all duration-500 hover:shadow-md ' . $class . '">';
        
        if ($title || $icon) {
            $html .= '<div class="flex items-center gap-4 mb-6">';
            if ($icon) {
                $html .= '<div class="w-10 h-10 rounded-xl bg-brand-primary/10 flex items-center justify-center text-brand-primary">';
                $html .= '<i class="fa-solid ' . $icon . '"></i>';
                $html .= '</div>';
            }
            if ($title) {
                $html .= '<h3 class="font-display font-bold text-lg dark:text-white tracking-tight">' . $title . '</h3>';
            }
            $html .= '</div>';
        }
        
        $html .= $content;
        $html .= '</div>';
        return $html;
    }

    /**
     * Renders a stats card (like the homepage strip)
     */
    public static function statsCard($value, $label, $icon = '', $color = 'brand-primary') {
        return '
        <div class="group p-8 bg-white dark:bg-brand-navy border border-slate-100 dark:border-white/5 rounded-3xl hover:border-'.$color.'/40 transition-all duration-500 hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-'.$color.'/10 rounded-2xl flex items-center justify-center text-'.$color.' group-hover:scale-110 transition-transform">
                    <i class="fa-solid '.( $icon ?: 'fa-chart-line' ).' text-xl"></i>
                </div>
            </div>
            <div class="text-3xl font-display font-extrabold text-brand-secondary dark:text-white mb-1 tracking-tight">'.$value.'</div>
            <div class="text-[10px] uppercase font-bold text-slate-400 tracking-[0.2em]">'.$label.'</div>
        </div>';
    }

    /**
     * Renders a premium button
     */
    public static function button($label, $type = 'button', $style = 'primary', $attr = '') {
        $classes = [
            'primary' => 'bg-brand-primary hover:bg-brand-primary/90 text-white shadow-lg shadow-brand-primary/20',
            'secondary' => 'bg-slate-100 dark:bg-white/5 hover:bg-slate-200 dark:hover:bg-white/10 text-slate-700 dark:text-white border border-slate-200 dark:border-white/10',
            'accent' => 'bg-brand-accent hover:bg-brand-accent/90 text-white shadow-lg shadow-brand-accent/20',
            'danger' => 'bg-red-500 hover:bg-red-600 text-white shadow-lg shadow-red-500/20'
        ];

        $class = $classes[$style] ?? $classes['primary'];
        
        // Extract any class attribute from $attr to merge with base classes
        $additionalClasses = '';
        $otherAttrs = '';
        if (preg_match('/class="([^"]*)"/', $attr, $matches)) {
            $additionalClasses = $matches[1];
            $otherAttrs = preg_replace('/class="[^"]*"/', '', $attr);
        } else {
            $otherAttrs = $attr;
        }
        
        $fullClass = $class . ' px-8 py-4 rounded-xl font-display font-bold text-[10px] uppercase tracking-widest transition-all active:scale-95' . ($additionalClasses ? ' ' . $additionalClasses : '');
        
        return '<button type="'.$type.'" '.$otherAttrs.' class="'.$fullClass.'">'.$label.'</button>';
    }

    /**
     * Renders a form input group
     */
    public static function input($name, $label, $value = '', $type = 'text', $placeholder = '', $help = '') {
        $html = '<div class="space-y-2 mb-6">';
        $html .= '<label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">' . $label . '</label>';
        $html .= '<input type="'.$type.'" name="'.$name.'" value="'.htmlspecialchars($value).'" placeholder="'.$placeholder.'" 
                    class="w-full bg-slate-50 dark:bg-brand-secondary/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary/50 transition-colors dark:text-white">';
        if ($help) {
            $html .= '<p class="text-[9px] text-slate-400 italic">' . $help . '</p>';
        }
        $html .= '</div>';
        return $html;
    }

    /**
     * Renders a styled select dropdown
     */
    public static function select($name, $label, $options, $selected = '') {
        $html = '<div class="space-y-2 mb-6">';
        $html .= '<label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400">' . $label . '</label>';
        $html .= '<select name="'.$name.'" class="w-full bg-slate-50 dark:bg-brand-secondary/50 border border-slate-200 dark:border-white/10 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-brand-primary/50 transition-colors dark:text-white appearance-none cursor-pointer">';
        foreach ($options as $val => $text) {
            $isSel = ($val == $selected) ? 'selected' : '';
            $html .= '<option value="'.$val.'" '.$isSel.'>'.$text.'</option>';
        }
        $html .= '</select></div>';
        return $html;
    }

    /**
     * Renders a checkbox/toggle
     */
    public static function checkbox($name, $label, $checked = false) {
        $isChecked = $checked ? 'checked' : '';
        return '
        <label class="relative inline-flex items-center cursor-pointer group mb-6">
            <input type="checkbox" name="'.$name.'" class="sr-only peer" '.$isChecked.'>
            <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-white/10 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[\'\'] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-brand-primary"></div>
            <span class="ml-3 text-[10px] font-bold uppercase tracking-widest text-slate-400 group-hover:text-slate-600 dark:group-hover:text-white transition-colors">'.$label.'</span>
        </label>';
    }

    /**
     * Renders a table container
     */
    public static function table($headers, $rows) {
        $html = '<div class="overflow-x-auto no-scrollbar">';
        $html .= '<table class="w-full text-left border-separate border-spacing-y-4">';
        $html .= '<thead><tr class="text-[9px] font-bold uppercase tracking-[0.2em] text-slate-400">';
        foreach($headers as $h) {
            $html .= '<th class="px-6 pb-2">' . $h . '</th>';
        }
        $html .= '</tr></thead>';
        $html .= '<tbody class="space-y-4">';
        foreach($rows as $row) {
            $html .= '<tr class="bg-white dark:bg-brand-navy border border-slate-100 dark:border-white/5 rounded-2xl shadow-sm hover:translate-x-1 transition-transform group">';
            foreach($row as $cell) {
                $html .= '<td class="px-6 py-5 text-sm dark:text-slate-300 first:rounded-l-2xl last:rounded-r-2xl">' . $cell . '</td>';
            }
            $html .= '</tr>';
        }
        $html .= '</tbody></table></div>';
        return $html;
    }

    /**
     * Renders a status badge
     */
    public static function badge($text, $type = 'neutral') {
        $colors = [
            'success' => 'bg-emerald-500/10 text-emerald-500',
            'warning' => 'bg-amber-500/10 text-amber-500',
            'danger' => 'bg-rose-500/10 text-rose-500',
            'info' => 'bg-sky-500/10 text-sky-500',
            'neutral' => 'bg-slate-500/10 text-slate-400'
        ];
        $color = $colors[$type] ?? $colors['neutral'];
        return '<span class="px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest '.$color.'">'.$text.'</span>';
    }
}
