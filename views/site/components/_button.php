<?php

use yii\helpers\Html;

/**
 * Single button partial
 * Variables:
 *  - $label string
 *  - $icon string (optional, a short char like ✓ or ⓘ)
 *  - $btnClass string
 *  - $type string (button|submit|reset)
 */
$label = $label ?? 'Button';
$icon = $icon ?? '';
$btnClass = $btnClass ?? 'bg-gray-200 px-6 py-3 rounded-card font-body font-semibold text-gray-800 transition-colors';
$type = $type ?? 'button';
?>
<button type="<?= Html::encode($type) ?>" class="<?= Html::encode($btnClass) ?>">
    <?php if ($icon !== ''): ?><span class="mr-2"><?= Html::encode($icon) ?></span><?php endif; ?>
    <?= Html::encode($label) ?>
</button>