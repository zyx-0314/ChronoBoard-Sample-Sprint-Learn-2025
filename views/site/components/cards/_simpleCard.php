<?php
use yii\helpers\Html;
/**
 * Simple card partial
 * Variables:
 *  - $title string
 *  - $body string
 *  - $code string (optional small code label)
 */
$title = $title ?? 'Card Title';
$body = $body ?? '';
$code = $code ?? '';
?>
<div class="bg-white shadow-lg p-6 rounded-card">
    <h3 class="mb-3 font-display font-bold text-primary-dark text-xl"><?= Html::encode($title) ?></h3>
    <?php if ($body !== ''): ?><p class="mb-4 font-body text-gray-600"><?= Html::encode($body) ?></p><?php endif; ?>
    <?php if ($code !== ''): ?><code class="bg-gray-100 px-2 py-1 rounded text-xs"><?= Html::encode($code) ?></code><?php endif; ?>
</div>
