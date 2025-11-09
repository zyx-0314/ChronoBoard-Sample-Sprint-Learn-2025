<?php
use yii\helpers\Html;
/**
 * Colored card partial
 * Variables:
 *  - $title string
 *  - $body string
 *  - $bgClass string (background class for the card)
 *  - $code string (optional small code label)
 */
$title = $title ?? 'Colored Card';
$body = $body ?? '';
$bgClass = $bgClass ?? 'bg-primary-light';
$code = $code ?? '';
?>
<div class="<?= Html::encode($bgClass) ?> shadow-lg p-6 rounded-card">
    <h3 class="mb-3 font-display font-bold text-primary-dark text-xl"><?= Html::encode($title) ?></h3>
    <?php if ($body !== ''): ?><p class="mb-4 font-body text-gray-700"><?= Html::encode($body) ?></p><?php endif; ?>
    <?php if ($code !== ''): ?><code class="bg-white px-2 py-1 rounded text-xs"><?= Html::encode($code) ?></code><?php endif; ?>
</div>
