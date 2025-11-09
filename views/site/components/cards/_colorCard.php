<?php
use yii\helpers\Html;
/**
 * Color card partial
 * Variables:
 *  - $title string
 *  - $hex string
 *  - $swatchClass string (Tailwind class for the swatch)
 *  - $code string (class name displayed)
 */
$title = $title ?? 'Color';
$hex = $hex ?? '';
$swatchClass = $swatchClass ?? 'bg-gray-200';
$code = $code ?? '';
?>
<div class="shadow-lg rounded-card overflow-hidden">
    <div class="<?= Html::encode($swatchClass) ?> h-32"></div>

    <div class="bg-white p-4">
        <h3 class="mb-2 font-display text-xl"><?= Html::encode($title) ?></h3>
        <?php if ($hex !== ''): ?><p class="font-body text-gray-600"><?= Html::encode($hex) ?></p><?php endif; ?>
        <?php if ($code !== ''): ?><code class="bg-gray-100 px-2 py-1 rounded text-sm"><?= Html::encode($code) ?></code><?php endif; ?>
    </div>
</div>
