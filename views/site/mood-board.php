<!-- 
    ============================================================
    MOOD BOARD PAGE - LEARNING GUIDE
    ============================================================
    
    PURPOSE:
    This page demonstrates design patterns, color schemes, typography,
    and component examples for the ChronoBoard application.
    
    WHAT YOU'LL LEARN:
    1. How to integrate Tailwind CSS with Yii2
    2. Creating custom color palettes
    3. Typography with custom Google Fonts
    4. Building reusable card components
    5. Responsive grid layouts
    6. Interactive form elements
    7. Alert/notification patterns
    
    TAILWIND CSS:
    - Utility-first CSS framework
    - Classes are applied directly in HTML (e.g., "bg-blue-500", "p-4")
    - No need to write custom CSS for most styling
    - CDN version is used here for quick prototyping
    
    FILE LOCATION: views/site/mood-board.php
    CONTROLLER ACTION: SiteController::actionMoodBoard()
    URL: /site/mood-board
-->

<?php

/** @var yii\web\View $this */

$this->title = 'ChronoBoard Mood Board';
?>

<div class="mx-auto px-4 py-8 max-w-7xl container">

    <!-- 
            ============================================================
            HEADER SECTION
            ============================================================
            Page title and subtitle
            Classes explained:
            - mb-12: Margin bottom of 3rem (48px)
            - text-center: Centers all text
        -->
    <header class="mb-12 text-center">
        <!-- 
                Main heading
                Classes:
                - text-5xl: Very large text size (3rem = 48px)
                - font-display: Uses Playfair Display font
                - font-bold: Bold font weight (700)
                - text-primary-dark: Uses custom dark color (#272727)
                - mb-4: Margin bottom of 1rem (16px)
            -->
        <h1 class="mb-4 font-display font-bold text-primary-dark text-5xl">
            ChronoBoard Mood Board
        </h1>

        <!-- 
                Subtitle
                Classes:
                - text-xl: Large text size (1.25rem = 20px)
                - text-primary-blue: Uses custom blue color (#90A9B7)
                - font-body: Uses Source Sans Pro font
            -->
        <p class="font-body text-primary-blue text-xl">
            Learning Guide: Frontend Basics with Custom Colors & Fonts
        </p>
    </header>

    <!-- 
            ============================================================
            COLOR PALETTE SECTION
            ============================================================
            Displays all custom colors defined in the theme
            This helps developers see available colors at a glance
        -->
    <section class="mb-12">
        <!-- Section heading -->
        <h2 class="mb-6 font-display font-bold text-primary-dark text-3xl">
            Global Color Palette
        </h2>

        <!-- 
                RESPONSIVE GRID
                Classes explained:
                - grid: Creates a CSS grid layout
                - grid-cols-1: 1 column on mobile (default)
                - md:grid-cols-3: 3 columns on medium screens and up (768px+)
                - gap-6: 1.5rem (24px) gap between grid items
                
                RESPONSIVE BREAKPOINTS IN TAILWIND:
                - sm: 640px
                - md: 768px
                - lg: 1024px
                - xl: 1280px
                - 2xl: 1536px
            -->
        <div class="gap-6 grid grid-cols-1 md:grid-cols-3">

            <!-- 
                    COLOR CARD 1: Primary Dark
                    Card structure:
                    1. Outer div: Card container with shadow and rounded corners
                    2. Color swatch: Shows the actual color
                    3. Details: Name, hex code, and Tailwind class name
                -->
            <div class="shadow-lg rounded-card overflow-hidden">
                <!-- Color swatch - Shows the actual color -->
                <div class="bg-primary-dark h-32"></div>

                <!-- Card content area -->
                <div class="bg-white p-4">
                    <h3 class="mb-2 font-display text-xl">Primary Dark</h3>
                    <p class="font-body text-gray-600">#272727</p>
                    <!-- Shows the Tailwind class to use -->
                    <code class="bg-gray-100 px-2 py-1 rounded text-sm">bg-primary-dark</code>
                </div>
            </div>

            <!-- COLOR CARD 2: Primary Blue -->
            <div class="shadow-lg rounded-card overflow-hidden">
                <div class="bg-primary-blue h-32"></div>
                <div class="bg-white p-4">
                    <h3 class="mb-2 font-display text-xl">Primary Blue</h3>
                    <p class="font-body text-gray-600">#90A9B7</p>
                    <code class="bg-gray-100 px-2 py-1 rounded text-sm">bg-primary-blue</code>
                </div>
            </div>

            <!-- COLOR CARD 3: Primary Light -->
            <div class="shadow-lg rounded-card overflow-hidden">
                <div class="bg-primary-light h-32"></div>
                <div class="bg-white p-4">
                    <h3 class="mb-2 font-display text-xl">Primary Light</h3>
                    <p class="font-body text-gray-600">#D2D8B3</p>
                    <code class="bg-gray-100 px-2 py-1 rounded text-sm">bg-primary-light</code>
                </div>
            </div>
        </div>
    </section>

    <!-- 
            ============================================================
            TYPOGRAPHY SECTION
            ============================================================
            Shows different heading sizes and text styles
            Demonstrates the two custom fonts (Playfair Display & Source Sans Pro)
        -->
    <section class="mb-12">
        <h2 class="mb-6 font-display font-bold text-primary-dark text-3xl">
            Typography Examples
        </h2>

        <div class="bg-white shadow-lg p-8 rounded-card">
            <h1 class="mb-4 font-display font-bold text-primary-dark text-4xl">
                Heading 1 - Playfair Display
            </h1>
            <h2 class="mb-4 font-display font-bold text-primary-blue text-3xl">
                Heading 2 - Playfair Display
            </h2>
            <h3 class="mb-4 font-display text-primary-dark text-2xl">
                Heading 3 - Playfair Display
            </h3>
            <p class="mb-3 font-body text-gray-700 text-lg">
                Body text using Source Sans Pro (Regular weight). This is the default font for paragraphs and general content throughout the application.
            </p>
            <p class="mb-3 font-body font-light text-gray-600 text-base">
                Light variant of Source Sans Pro for subtle text elements.
            </p>
            <p class="font-body font-semibold text-primary-dark text-base">
                Semibold variant of Source Sans Pro for emphasis.
            </p>
        </div>
    </section>

    <!-- Card Examples Section -->
    <section class="mb-12">
        <h2 class="mb-6 font-display font-bold text-primary-dark text-3xl">
            Card Components (5px Rounded Edges)
        </h2>

        <div class="gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            <!-- Simple Card -->
            <div class="bg-white shadow-lg p-6 rounded-card">
                <h3 class="mb-3 font-display font-bold text-primary-dark text-xl">
                    Basic Card
                </h3>
                <p class="mb-4 font-body text-gray-600">
                    A simple card with 5px rounded edges using the custom rounded-card class.
                </p>
                <code class="bg-gray-100 px-2 py-1 rounded text-xs">rounded-card</code>
            </div>

            <!-- Card with Image Placeholder -->
            <div class="bg-white shadow-lg rounded-card overflow-hidden">
                <div class="flex justify-center items-center bg-primary-blue h-40">
                    <span class="font-body text-white text-lg">Image Area</span>
                </div>
                <div class="p-6">
                    <h3 class="mb-2 font-display font-bold text-primary-dark text-xl">
                        Card with Header
                    </h3>
                    <p class="font-body text-gray-600">
                        Card with image header section and content below.
                    </p>
                </div>
            </div>

            <!-- Colored Card -->
            <div class="bg-primary-light shadow-lg p-6 rounded-card">
                <h3 class="mb-3 font-display font-bold text-primary-dark text-xl">
                    Colored Card
                </h3>
                <p class="mb-4 font-body text-gray-700">
                    Card using custom background color from our palette.
                </p>
                <code class="bg-white px-2 py-1 rounded text-xs">bg-primary-light</code>
            </div>
        </div>
    </section>

    <!-- Alert Buttons Section -->
    <section class="mb-12">
        <h2 class="mb-6 font-display font-bold text-primary-dark text-3xl">
            Soft Color Palette - Alert Buttons
        </h2>

        <div class="bg-white shadow-lg p-8 rounded-card">
            <div class="gap-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4">

                <!-- Success Button -->
                <button class="bg-soft-success hover:bg-green-200 px-6 py-3 border-2 border-soft-success-text rounded-card font-body font-semibold text-soft-success-text transition-colors duration-200">
                    ✓ Success
                </button>

                <!-- Info Button -->
                <button class="bg-soft-info hover:bg-blue-200 px-6 py-3 border-2 border-soft-info-text rounded-card font-body font-semibold text-soft-info-text transition-colors duration-200">
                    ⓘ Info
                </button>

                <!-- Warning Button -->
                <button class="bg-soft-warning hover:bg-yellow-200 px-6 py-3 border-2 border-soft-warning-text rounded-card font-body font-semibold text-soft-warning-text transition-colors duration-200">
                    ⚠ Warning
                </button>

                <!-- Error Button -->
                <button class="bg-soft-error hover:bg-red-200 px-6 py-3 border-2 border-soft-error-text rounded-card font-body font-semibold text-soft-error-text transition-colors duration-200">
                    ✕ Error
                </button>

            </div>

            <!-- Alert Messages -->
            <div class="space-y-4 mt-8">
                <!-- Success Alert -->
                <div class="bg-soft-success p-4 border-soft-success-text border-l-4 rounded-card text-soft-success-text">
                    <h4 class="mb-1 font-display font-bold">Success!</h4>
                    <p class="font-body">Your changes have been saved successfully.</p>
                </div>

                <!-- Info Alert -->
                <div class="bg-soft-info p-4 border-soft-info-text border-l-4 rounded-card text-soft-info-text">
                    <h4 class="mb-1 font-display font-bold">Information</h4>
                    <p class="font-body">Please review the updated terms and conditions.</p>
                </div>

                <!-- Warning Alert -->
                <div class="bg-soft-warning p-4 border-soft-warning-text border-l-4 rounded-card text-soft-warning-text">
                    <h4 class="mb-1 font-display font-bold">Warning</h4>
                    <p class="font-body">You are about to delete important data. This action cannot be undone.</p>
                </div>

                <!-- Error Alert -->
                <div class="bg-soft-error p-4 border-soft-error-text border-l-4 rounded-card text-soft-error-text">
                    <h4 class="mb-1 font-display font-bold">Error</h4>
                    <p class="font-body">An error occurred while processing your request. Please try again.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Code Examples Section -->
    <section class="mb-12">
        <h2 class="mb-6 font-display font-bold text-primary-dark text-3xl">
            Tailwind Code Examples
        </h2>

        <div class="bg-white shadow-lg p-8 rounded-card">
            <h3 class="mb-4 font-display font-bold text-primary-dark text-xl">
                How to Use Custom Colors
            </h3>

            <div class="space-y-4">
                <div class="bg-gray-50 p-4 rounded-card">
                    <p class="mb-2 font-body font-semibold text-primary-dark">Text Color:</p>
                    <code class="font-mono text-sm">text-primary-dark</code>,
                    <code class="font-mono text-sm">text-primary-blue</code>,
                    <code class="font-mono text-sm">text-primary-light</code>
                </div>

                <div class="bg-gray-50 p-4 rounded-card">
                    <p class="mb-2 font-body font-semibold text-primary-dark">Background Color:</p>
                    <code class="font-mono text-sm">bg-primary-dark</code>,
                    <code class="font-mono text-sm">bg-primary-blue</code>,
                    <code class="font-mono text-sm">bg-primary-light</code>
                </div>

                <div class="bg-gray-50 p-4 rounded-card">
                    <p class="mb-2 font-body font-semibold text-primary-dark">Border Color:</p>
                    <code class="font-mono text-sm">border-primary-dark</code>,
                    <code class="font-mono text-sm">border-primary-blue</code>
                </div>

                <div class="bg-gray-50 p-4 rounded-card">
                    <p class="mb-2 font-body font-semibold text-primary-dark">Fonts:</p>
                    <code class="font-mono text-sm">font-display</code> (Playfair Display),
                    <code class="font-mono text-sm">font-body</code> (Source Sans Pro)
                </div>

                <div class="bg-gray-50 p-4 rounded-card">
                    <p class="mb-2 font-body font-semibold text-primary-dark">Card Border Radius:</p>
                    <code class="font-mono text-sm">rounded-card</code> (5px)
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Demo Section -->
    <section class="mb-12">
        <h2 class="mb-6 font-display font-bold text-primary-dark text-3xl">
            Interactive Component Demo
        </h2>

        <div class="bg-white shadow-lg p-8 rounded-card">
            <form class="space-y-6">
                <!-- Input Field -->
                <div>
                    <label class="block mb-2 font-body font-semibold text-primary-dark">
                        Name
                    </label>
                    <input
                        type="text"
                        class="px-4 py-2 border-2 border-primary-blue focus:border-primary-dark rounded-card focus:outline-none w-full font-body transition-colors"
                        placeholder="Enter your name">
                </div>

                <!-- Textarea -->
                <div>
                    <label class="block mb-2 font-body font-semibold text-primary-dark">
                        Description
                    </label>
                    <textarea
                        class="px-4 py-2 border-2 border-primary-blue focus:border-primary-dark rounded-card focus:outline-none w-full font-body transition-colors"
                        rows="4"
                        placeholder="Enter description"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button
                        type="submit"
                        class="bg-primary-dark hover:bg-gray-800 px-6 py-2 rounded-card font-body font-semibold text-white transition-colors">
                        Submit
                    </button>
                    <button
                        type="reset"
                        class="bg-primary-blue hover:bg-blue-400 px-6 py-2 rounded-card font-body font-semibold text-white transition-colors">
                        Reset
                    </button>
                    <button
                        type="button"
                        class="bg-primary-light hover:bg-yellow-300 px-6 py-2 rounded-card font-body font-semibold text-primary-dark transition-colors">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Learning Notes Section -->
    <section class="mb-12">
        <h2 class="mb-6 font-display font-bold text-primary-dark text-3xl">
            Learning Notes
        </h2>

        <div class="gap-6 grid grid-cols-1 md:grid-cols-2">
            <div class="bg-soft-info shadow-lg p-6 rounded-card">
                <h3 class="mb-3 font-display font-bold text-soft-info-text text-xl">
                    📚 Yii View Files
                </h3>
                <ul class="space-y-2 font-body text-soft-info-text list-disc list-inside">
                    <li>Located in <code>/views/controller-name/</code></li>
                    <li>Use <code>$this->render('view-name')</code> in controller</li>
                    <li>Access via <code>/mood-board/index</code></li>
                    <li>Layout wraps all views (optional)</li>
                </ul>
            </div>

            <div class="bg-soft-success shadow-lg p-6 rounded-card">
                <h3 class="mb-3 font-display font-bold text-soft-success-text text-xl">
                    🎨 Tailwind Configuration
                </h3>
                <ul class="space-y-2 font-body text-soft-success-text list-disc list-inside">
                    <li>Custom colors in <code>tailwind.config</code></li>
                    <li>Use <code>extend</code> to add custom values</li>
                    <li>Google Fonts loaded in <code>&lt;head&gt;</code></li>
                    <li>CDN for quick prototyping</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="mt-16 pb-8 text-center">
        <p class="font-body text-primary-blue">
            Built with ❤️ using Yii Framework & Tailwind CSS
        </p>
    </footer>

</div>