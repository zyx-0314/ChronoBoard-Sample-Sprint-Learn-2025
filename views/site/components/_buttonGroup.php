<?php

/**
 * Button group partial: renders Submit / Reset / Cancel using the _button partial
 */
?>
<div class="flex gap-4">
    <?= $this->render('_button', [
        'label' => 'Submit',
        'type' => 'submit',
        'btnClass' => 'bg-primary-dark hover:bg-gray-800 px-6 py-2 rounded-card font-body font-semibold text-white transition-colors'
    ]) ?>

    <?= $this->render('_button', [
        'label' => 'Reset',
        'type' => 'reset',
        'btnClass' => 'bg-primary-blue hover:bg-blue-400 px-6 py-2 rounded-card font-body font-semibold text-white transition-colors'
    ]) ?>

    <?= $this->render('_button', [
        'label' => 'Cancel',
        'type' => 'button',
        'btnClass' => 'bg-primary-light hover:bg-yellow-300 px-6 py-2 rounded-card font-body font-semibold text-primary-dark transition-colors'
    ]) ?>
</div>