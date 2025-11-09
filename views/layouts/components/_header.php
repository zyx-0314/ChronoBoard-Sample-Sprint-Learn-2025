<?php

/**
 * Navbar: renders Navigation header
 */

use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

?>
<header id="header">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => ['class' => 'navbar-expand-md navbar-dark bg-dark fixed-top']
    ]);
    // Navigation menu widget
    // This defines all the navigation links in the top navbar
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav'],
        'items' => [
            // Home page link - goes to site/index action
            ['label' => 'Home', 'url' => ['/site/index'], 'options' => ['class' => 'check']],

            // About page link - goes to site/about action
            ['label' => 'About', 'url' => ['/site/about']],

            // Mood Board link - goes to site/mood-board action
            // This page shows design patterns, colors, and typography examples
            ['label' => 'Mood Board', 'url' => ['/site/mood-board']],

            // Contact page link - goes to site/contact action
            ['label' => 'Contact', 'url' => ['/site/contact']],

            // Conditional menu item based on user authentication status
            // If user is not logged in (guest), show Login link
            // If user is logged in, show Logout button with username
            Yii::$app->user->isGuest
                ? ['label' => 'Login', 'url' => ['/site/login']]
                : '<li class="nav-item">'
                . Html::beginForm(['/site/logout'])
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'nav-link btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
        ]
    ]);
    NavBar::end();
    ?>
</header>