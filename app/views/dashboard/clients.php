<?php if (!defined('APP_RUNNING')) { /* Guard if desired by framework */ } ?>
<div class="p-8">
    <h2 class="text-2xl font-bold mb-4">Clients</h2>

    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="mb-4 p-3 bg-red-50 text-red-700 rounded"><?= e($_SESSION['flash_error']) ?></div>
        <?php unset($_SESSION['flash_error']); endif; ?>
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="mb-4 p-3 bg-green-50 text-green-700 rounded"><?= e($_SESSION['flash_success']) ?></div>
        <?php unset($_SESSION['flash_success']); endif; ?>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-brand-navy p-6 rounded-2xl border">
            <?php if (!empty($editClient)): ?>
                <h3 class="font-bold mb-4">Edit Client</h3>
                <form action="<?= url('admin/clients.php') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token'] ?? '') ?>">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?= (int)$editClient['id'] ?>">
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Client Name</label>
                        <input type="text" name="name" class="w-full border px-4 py-2 rounded" placeholder="Client name" value="<?= e($editClient['name']) ?>">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Website (optional)</label>
                        <input type="text" name="link" class="w-full border px-4 py-2 rounded" placeholder="https://example.com" value="<?= e($editClient['link']) ?>">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Sort Order</label>
                        <input type="number" name="sort_order" class="w-40 border px-4 py-2 rounded" value="<?= (int)$editClient['sort_order'] ?>">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Current Logo</label>
                        <div class="mb-2 w-40 h-20 flex items-center justify-center bg-slate-50 rounded overflow-hidden">
                            <img src="<?= url('public/uploads/clients/' . $editClient['logo']) ?>" class="max-h-12 object-contain">
                        </div>
                        <label class="block text-sm font-bold mb-2">Replace Logo (optional)</label>
                        <input type="file" name="logo" accept="image/*">
                    </div>
                    <div>
                        <button class="btn-primary px-6 py-3 rounded">Save Changes</button>
                        <a href="<?= url('admin/clients.php') ?>" class="ml-4 text-sm text-slate-500">Cancel</a>
                    </div>
                </form>
            <?php else: ?>
                <h3 class="font-bold mb-4">Upload New Client</h3>
                <form action="<?= url('admin/clients.php') ?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token'] ?? '') ?>">
                    <input type="hidden" name="action" value="store">
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Client Name</label>
                        <input type="text" name="name" class="w-full border px-4 py-2 rounded" placeholder="Client name">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Website (optional)</label>
                        <input type="text" name="link" class="w-full border px-4 py-2 rounded" placeholder="https://example.com">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Sort Order</label>
                        <input type="number" name="sort_order" class="w-40 border px-4 py-2 rounded" value="0">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-bold mb-2">Logo (PNG/JPG/SVG/WEBP)</label>
                        <input type="file" name="logo" accept="image/*" required>
                    </div>
                    <div>
                        <button class="btn-primary px-6 py-3 rounded">Upload Logo</button>
                    </div>
                </form>
            <?php endif; ?>
        </div>

        <div class="bg-white dark:bg-brand-navy p-6 rounded-2xl border">
            <h3 class="font-bold mb-4">Existing Clients (drag to reorder)</h3>
            <?php if (empty($clients)): ?>
                <div class="text-sm text-slate-500">No clients uploaded yet.</div>
            <?php else: ?>
                <div class="grid grid-cols-2 gap-4" id="clientsList">
                    <?php foreach($clients as $c): ?>
                        <div class="flex items-center gap-4 p-2 border rounded cursor-move hover:bg-slate-50 dark:hover:bg-slate-700 transition" data-id="<?= (int)$c['id'] ?>">
                            <i class="fa-solid fa-grip text-slate-400"></i>
                            <div class="w-20 h-12 flex items-center justify-center bg-slate-50 rounded overflow-hidden">
                                <img src="<?= url('public/uploads/clients/' . $c['logo']) ?>" alt="<?= e($c['name']) ?>" class="max-h-10 object-contain">
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-sm"><?= e($c['name']) ?></div>
                                <?php if (!empty($c['link'])): ?><a href="<?= e($c['link']) ?>" class="text-xs text-blue-500" target="_blank">Visit</a><?php endif; ?>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <a href="<?= url('admin/clients.php?edit=' . (int)$c['id']) ?>" class="text-xs text-brand-primary">Edit</a>
                                <form action="<?= url('admin/clients.php') ?>" method="post" onsubmit="return confirm('Delete this client?');">
                                    <input type="hidden" name="csrf_token" value="<?= e($_SESSION['csrf_token'] ?? '') ?>">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= (int)$c['id'] ?>">
                                    <button type="submit" class="text-xs text-red-600">Delete</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const listEl = document.getElementById('clientsList');
                    if (listEl && typeof Sortable !== 'undefined') {
                        Sortable.create(listEl, {
                            handle: '.fa-grip',
                            ghostClass: 'opacity-50',
                            onEnd: function(evt) {
                                const ids = Array.from(listEl.querySelectorAll('[data-id]')).map(el => el.dataset.id);
                                fetch('<?= url('public/api/clients-reorder.php') ?>', {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ ids: ids })
                                }).then(r => r.json()).then(d => {
                                    if (d.success) {
                                        console.log('Clients reordered');
                                    }
                                }).catch(e => console.error('Reorder error:', e));
                            }
                        });
                    }
                });
                </script>
            <?php endif; ?>
        </div>
    </div>
</div>
