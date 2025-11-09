<?php
use yii\helpers\Html;
/**
 * Card with image/header placeholder partial
 * Variables:
 *  - $title string
 *  - $body string
 *  - $swatchClass string (background class for header)
 *  - $imageText string
 */
$title = $title ?? 'Card with Header';
$body = $body ?? '';
$swatchClass = $swatchClass ?? 'bg-primary-blue';
$imageText = $imageText ?? 'Image Area';
?>
<div class="bg-white shadow-lg rounded-card overflow-hidden">
    <div class="flex justify-center items-center <?= Html::encode($swatchClass) ?> h-40">
        <span class="font-body text-white text-lg"><?= Html::encode($imageText) ?></span>
    </div>
    <div class="p-6">
        <h3 class="mb-2 font-display font-bold text-primary-dark text-xl"><?= Html::encode($title) ?></h3>
        <?php if ($body !== ''): ?><p class="font-body text-gray-600"><?= Html::encode($body) ?></p><?php endif; ?>
    </div>
</div>
