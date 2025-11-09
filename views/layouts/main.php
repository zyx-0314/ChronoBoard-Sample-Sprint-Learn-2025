<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= Html::encode($this->title) ?></title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    // CUSTOM COLOR PALETTE
                    // Define your brand colors here and use them throughout the app
                    colors: {
                        // Main brand colors
                        'primary-dark': '#272727', // Dark gray for main text and elements
                        'primary-blue': '#90A9B7', // Soft blue for accents
                        'primary-light': '#D2D8B3', // Light greenish for highlights

                        // Soft palette colors for alerts and notifications
                        // Each alert type has a background color and text color
                        'soft-warning': '#FEF3C7', // Light yellow background
                        'soft-warning-text': '#92400E', // Dark brown text
                        'soft-error': '#FEE2E2', // Light red background
                        'soft-error-text': '#991B1B', // Dark red text
                        'soft-success': '#D1FAE5', // Light green background
                        'soft-success-text': '#065F46', // Dark green text
                        'soft-info': '#DBEAFE', // Light blue background
                        'soft-info-text': '#1E40AF', // Dark blue text
                    },

                    // CUSTOM FONT FAMILIES
                    // Define font stacks for consistent typography
                    fontFamily: {
                        'display': ['Playfair Display', 'serif'], // For headings (h1, h2, h3)
                        'body': ['Source Sans Pro', 'sans-serif'], // For body text (p, div, span)
                    },

                    // CUSTOM BORDER RADIUS
                    // Define standard border radius values
                    borderRadius: {
                        'card': '5px', // Use "rounded-card" class for consistent card styling
                    }
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Source+Sans+Pro:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* Set default body font */
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }

        /* Set default heading font */
        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
        }

        .collapse {
            visibility: visible !important;
        }
    </style>

    <?php $this->head() ?>
</head>

<body class="d-flex flex-column bg-gray-50 h-100 font-body">
    <?php $this->beginBody() ?>

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

    <?= $this->render('components/_header'); ?>

    <main id="main" class="flex-shrink-0" role="main">
        <div class="container">
            <?php if (!empty($this->params['breadcrumbs'])): ?>
                <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
            <?php endif ?>
            <?= Alert::widget() ?>
            <?= $content ?>
        </div>
    </main>

    <footer id="footer" class="bg-light mt-auto py-3">
        <div class="container">
            <div class="text-muted row">
                <div class="text-md-start text-center col-md-6">&copy; ChronoBoard <?= date('Y') ?></div>
                <div class="text-md-end text-center col-md-6"><?= Yii::powered() ?></div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>