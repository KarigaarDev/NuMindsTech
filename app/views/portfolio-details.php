<?php
$currentId = $item['id'];

$related = $pdo->prepare("
    SELECT * FROM portfolio_items 
    WHERE status = 'published' 
    AND id != ? 
    ORDER BY RAND() 
    LIMIT 4
");
$related->execute([$currentId]);
$relatedItems = $related->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="py-8 sm:py-12 md:py-16 bg-white dark:bg-brand-dark min-h-screen relative overflow-hidden">

    <!-- Grid Background -->
    <div class="absolute inset-0 opacity-[0.03] dark:opacity-10 pointer-events-none">
        <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="grid-details" width="40" height="40" patternUnits="userSpaceOnUse">
                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="currentColor" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#grid-details)" />
        </svg>
    </div>

    <div class="max-w-7xl mx-auto px-5 sm:px-6 md:px-8 relative z-10">

        <!-- Back -->
        <a href="<?= url('') ?>#solutions"
           class="inline-flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-brand-primary mb-8 sm:mb-12">
            <i class="fa-solid fa-arrow-left"></i> Back to Showcase
        </a>

        <div class="grid lg:grid-cols-2 gap-10 md:gap-16 items-start">

            <!-- Image -->
            <div>
                <div class="aspect-[4/3] rounded-2xl sm:rounded-3xl overflow-hidden bg-slate-100 dark:bg-white/5 border border-slate-200 dark:border-white/10 shadow-xl">
                    <?php if ($item['featured_image']): ?>
                        <img src="<?= url('public/uploads/' . $item['featured_image']) ?>" class="w-full h-full object-cover">
                    <?php endif; ?>
                </div>
            </div>

            <!-- Content -->
            <div class="pt-2 sm:pt-4">

                <!-- Tags -->
                <div class="flex flex-wrap gap-2 mb-5">
                    <span class="px-3 py-1 rounded-full bg-brand-primary/10 text-brand-primary text-[9px] font-bold uppercase tracking-widest">
                        <?= e($item['category']) ?>
                    </span>
                </div>

                <!-- Title -->
                <h1 class="font-display text-2xl sm:text-3xl md:text-5xl font-extrabold text-heading dark:text-white mb-5 leading-tight">
                    <?= e($item['title']) ?>
                </h1>

                <!-- Description -->
                <p class="text-sm sm:text-base text-slate-500 dark:text-slate-400 leading-relaxed mb-8">
                    <?= nl2br(e($item['description'])) ?>
                </p>

                <!-- Meta -->
                <div class="grid grid-cols-2 gap-6 border-t border-slate-100 dark:border-white/5 pt-6 mb-8 text-sm">
                    <div>
                        <p class="text-[9px] uppercase text-slate-400 mb-1">Client</p>
                        <p class="font-bold"><?= e($item['client_name'] ?: 'Internal Project') ?></p>
                    </div>
                    <div>
                        <p class="text-[9px] uppercase text-slate-400 mb-1">Completion</p>
                        <p class="font-bold"><?= $item['completion_date'] ? date('M Y', strtotime($item['completion_date'])) : 'Ongoing' ?></p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">

                    <?php if ($item['project_url']): ?>
                        <a href="<?= e($item['project_url']) ?>" target="_blank"
                           class="w-full sm:w-auto text-center px-6 py-3 bg-brand-primary text-white rounded-xl text-[11px] font-bold uppercase tracking-widest">
                            Launch Project
                        </a>
                    <?php endif; ?>

                    <button @click="modalOpen = true"
                        class="w-full sm:w-auto px-6 py-3 bg-white/5 border border-slate-200 dark:border-white/10 rounded-xl text-[11px] font-bold uppercase tracking-widest">
                        Request Similar
                    </button>

                </div>

            </div>
        </div>
    </div>
</section>
<?php if (!empty($relatedItems)): ?>
<section class="py-8 sm:py-12 bg-white dark:bg-brand-secondary">

    <div class="max-w-7xl mx-auto px-5 sm:px-6 md:px-8">

        <div class="text-center mb-10 sm:mb-14">
            <h3 class="text-[10px] uppercase tracking-widest text-brand-primary mb-3">
                Explore More
            </h3>
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold">
                Related Projects
            </h2>
        </div>

        <!-- GRID -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">

            <?php foreach($relatedItems as $r): 
                $slug = str_replace([' ', '/', '\\'], '-', strtolower($r['title']));
            ?>

            <a href="<?= url('portfolio/' . $slug) ?>" class="group block">

                <div class="rounded-xl overflow-hidden bg-white dark:bg-brand-navy border border-slate-200 dark:border-white/10 shadow-sm hover:shadow-xl transition-all hover:-translate-y-1">

                    <div class="p-2">
                        <img src="<?= url('public/uploads/') . $r['featured_image'] ?>"
                             class="rounded-lg object-contain w-full">
                    </div>

                    <div class="p-3">
                        <p class="text-[9px] uppercase text-brand-accent mb-1">
                            <?= e($r['category']) ?>
                        </p>

                        <h4 class="text-sm font-bold leading-tight">
                            <?= e($r['title']) ?>
                        </h4>
                    </div>

                </div>

            </a>

            <?php endforeach; ?>

        </div>

    </div>
</section>
<?php endif; ?>