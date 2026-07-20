<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ConvertHtmlViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:convert-html-views';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Batch convert master HTML files to Laravel Blade templates with assets and route references';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $masterPath = resource_path('views/master-html');
        $destPath = resource_path('views/admin');

        if (!File::isDirectory($masterPath)) {
            $this->error("Master HTML directory not found at {$masterPath}");
            return 1;
        }

        File::ensureDirectoryExists($destPath);

        $files = File::files($masterPath);
        $this->info("Found " . count($files) . " HTML files to convert.");

        // First, extract sidebar.blade.php from index.html if it exists
        $indexFile = $masterPath . '/index.html';
        if (File::exists($indexFile)) {
            $this->info("Extracting sidebar from index.html...");
            $indexHtml = File::get($indexFile);
            $this->extractAndSaveSidebar($indexHtml);
        } else {
            $this->warn("index.html not found! Sidebar extraction skipped. Make sure to generate it.");
        }

        $bar = $this->output->createProgressBar(count($files));
        $bar->start();

        foreach ($files as $file) {
            $nameWithoutExt = $file->getFilenameWithoutExtension();
            $html = File::get($file->getRealPath());

            // Delete old file in root view directory if it exists
            $oldFile = resource_path('views/' . $nameWithoutExt . '.blade.php');
            if (File::exists($oldFile)) {
                File::delete($oldFile);
            }

            // Determine if it is a plain page (auth, error, coming-soon)
            $isPlain = str_starts_with($nameWithoutExt, 'auth-') || 
                       str_starts_with($nameWithoutExt, 'error-') || 
                       $nameWithoutExt === 'pages-coming-soon' ||
                       $nameWithoutExt === 'landing';

            if ($isPlain) {
                $converted = $this->convertPlainPage($html, $nameWithoutExt);
            } else {
                $converted = $this->convertStandardPage($html, $nameWithoutExt);
            }

            File::put($destPath . '/' . $nameWithoutExt . '.blade.php', $converted);
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Successfully converted all pages.");
        return 0;
    }

    /**
     * Extract sidebar navigation from index.html, convert its assets and links,
     * and save it as sidebar.blade.php.
     */
    private function extractAndSaveSidebar(string $html)
    {
        $sidebarStart = strpos($html, '<div class="sidenav-menu">');
        if ($sidebarStart === false) {
            $this->warn("Could not find sidebar container in index.html");
            return;
        }

        // Find "<!-- Sidenav Menu End -->"
        $sidebarEnd = strpos($html, '<!-- Sidenav Menu End -->');
        if ($sidebarEnd === false) {
            // fallback search for the wrapper closing tag or container end
            $sidebarEnd = strpos($html, '<!-- ============================================================== -->', $sidebarStart);
        }

        if ($sidebarEnd !== false) {
            // We want to include the comment if found or closing div
            $sidebarContent = substr($html, $sidebarStart, $sidebarEnd + strlen('<!-- Sidenav Menu End -->') - $sidebarStart);
        } else {
            // fallback: read a chunk
            $sidebarContent = substr($html, $sidebarStart, 80000);
        }

        // Convert asset references in sidebar
        $sidebarContent = $this->convertAssets($sidebarContent);

        // Convert links in sidebar
        $sidebarContent = $this->convertLinks($sidebarContent);


        $sidebarPath = resource_path('views/layouts/partials/sidebar.blade.php');
        File::ensureDirectoryExists(dirname($sidebarPath));
        File::put($sidebarPath, $sidebarContent);
    }

    /**
     * Convert links (e.g. href="xyz.html") to Laravel blade routes.
     */
    private function convertLinks(string $content): string
    {
        return preg_replace_callback('/href="([a-zA-Z0-9\-_]+)\.html"/i', function ($matches) {
            $page = $matches[1];
            if ($page === 'index') {
                return 'href="{{ route(\'home\') }}/"';
            }
            return 'href="{{ route(\'page\', \'' . $page . '\') }}"';
        }, $content);
    }

    /**
     * Convert assets (e.g. src="assets/...") to {{ asset('assets/...') }}.
     */
    private function convertAssets(string $content): string
    {
        // Replace src="assets/..."
        $content = preg_replace_callback('/src="assets\/([^"]+)"/i', function ($matches) {
            return 'src="{{ asset(\'assets/' . $matches[1] . '\') }}"';
        }, $content);

        // Replace href="assets/..."
        $content = preg_replace_callback('/href="assets\/([^"]+)"/i', function ($matches) {
            if (str_ends_with($matches[1], '.html')) {
                return $matches[0];
            }
            return 'href="{{ asset(\'assets/' . $matches[1] . '\') }}"';
        }, $content);

        // Replace background styles (e.g. background: url(assets/images/...))
        $content = preg_replace_callback('/background:\s*url\((assets\/[^)]+)\)/i', function ($matches) {
            return 'background: url({{ asset(\'' . $matches[1] . '\') }})';
        }, $content);

        // Replace background-image styles (e.g. background-image: url(assets/images/...))
        $content = preg_replace_callback('/background-image:\s*url\((assets\/[^)]+)\)/i', function ($matches) {
            return 'background-image: url({{ asset(\'' . $matches[1] . '\') }})';
        }, $content);

        return $content;
    }

    /**
     * Convert standard pages that extend layouts.app.
     */
    private function convertStandardPage(string $html, string $pageName): string
    {
        // 0. Extract HTML attributes
        $htmlClass = '';
        $htmlAttrs = $this->extractHtmlAttributes($html, $htmlClass);

        // 1. Extract title
        $title = 'INSPINIA';
        if (preg_match('/<title>(.*?)<\/title>/is', $html, $matches)) {
            $title = trim($matches[1]);
        }

        // 2. Extract page content inside <div class="content-page">
        $pageContent = '';
        $contentStart = strpos($html, '<div class="content-page">');
        if ($contentStart !== false) {
            $contentStart += strlen('<div class="content-page">');
            
            // Find where footer starts
            $footerStart = strpos($html, '<!-- Footer Start -->', $contentStart);
            if ($footerStart === false) {
                $footerStart = strpos($html, '<footer class="footer">', $contentStart);
            }

            if ($footerStart !== false) {
                $pageContent = substr($html, $contentStart, $footerStart - $contentStart);
            } else {
                // If footer not found, grab everything until the wrapper closes
                $offcanvasStart = strpos($html, '<div class="offcanvas offcanvas-end', $contentStart);
                if ($offcanvasStart !== false) {
                    $pageContent = substr($html, $contentStart, $offcanvasStart - $contentStart);
                } else {
                    $pageContent = substr($html, $contentStart);
                }
            }
        } else {
            // fallback: grab body
            $bodyStart = strpos($html, '<body>');
            $bodyEnd = strpos($html, '</body>');
            if ($bodyStart !== false && $bodyEnd !== false) {
                $pageContent = substr($html, $bodyStart + 6, $bodyEnd - $bodyStart - 6);
            } else {
                $pageContent = $html;
            }
        }

        $pageContent = trim($pageContent);

        // 3. Extract page-specific styles
        $pageStyles = [];
        $headStart = strpos($html, '<head>');
        $headEnd = strpos($html, '</head>');
        if ($headStart !== false && $headEnd !== false) {
            $head = substr($html, $headStart, $headEnd - $headStart);
            
            preg_match_all('/<link[^>]*>/is', $head, $linkMatches);
            foreach ($linkMatches[0] as $link) {
                if (stripos($link, 'vendors.min.css') === false && 
                    stripos($link, 'app.min.css') === false && 
                    stripos($link, 'favicon.ico') === false) {
                    $pageStyles[] = $this->convertAssets($link);
                }
            }

            preg_match_all('/<style[^>]*>.*?<\/style>/is', $head, $styleMatches);
            foreach ($styleMatches[0] as $style) {
                $pageStyles[] = $style;
            }
        }

        // 4. Extract page-specific scripts
        $pageScripts = [];
        $bodyEnd = strpos($html, '</body>');
        if ($bodyEnd !== false) {
            $scriptsBlockStart = strpos($html, '<!-- Vendor js -->');
            if ($scriptsBlockStart === false) {
                $scriptsBlockStart = strpos($html, '<script src="assets/js/vendors.min.js">');
            }

            if ($scriptsBlockStart !== false && $scriptsBlockStart < $bodyEnd) {
                $scriptsBlock = substr($html, $scriptsBlockStart, $bodyEnd - $scriptsBlockStart);
                
                preg_match_all('/<script[^>]*>.*?<\/script>/is', $scriptsBlock, $scriptMatches);
                foreach ($scriptMatches[0] as $script) {
                    if (stripos($script, 'vendors.min.js') === false && 
                        stripos($script, 'app.js') === false) {
                        $pageScripts[] = $this->convertAssets($script);
                    }
                }
            }
        }

        // Build the blade template content
        $blade = "@extends('layouts.app')\n\n";
        if (!empty($htmlClass)) {
            $blade .= "@section('html_class', '" . addslashes($htmlClass) . "')\n\n";
        }
        if (!empty($htmlAttrs)) {
            $blade .= "@section('html_attributes')\n" . $htmlAttrs . "\n@endsection\n\n";
        }
        $blade .= "@section('title', '" . addslashes($title) . "')\n\n";

        if (!empty($pageStyles)) {
            $blade .= "@push('styles')\n";
            foreach ($pageStyles as $style) {
                $blade .= "    " . $style . "\n";
            }
            $blade .= "@endpush\n\n";
        }

        $blade .= "@section('content')\n";
        $pageContent = $this->convertLinks($pageContent);
        $pageContent = $this->convertAssets($pageContent);
        $blade .= $pageContent . "\n";
        $blade .= "@endsection\n";

        if (!empty($pageScripts)) {
            $blade .= "\n@push('scripts')\n";
            foreach ($pageScripts as $script) {
                $blade .= "    " . $script . "\n";
            }
            $blade .= "@endpush\n";
        }

        return $blade;
    }

    /**
     * Convert plain pages (auth, error, coming soon, landing) that extend layouts.auth.
     */
    private function convertPlainPage(string $html, string $pageName): string
    {
        // 0. Extract HTML attributes
        $htmlClass = '';
        $htmlAttrs = $this->extractHtmlAttributes($html, $htmlClass);

        // Extract body attributes
        $bodyClass = '';
        $bodyAttrs = $this->extractBodyAttributes($html, $bodyClass);

        // 1. Extract title
        $title = 'INSPINIA';
        if (preg_match('/<title>(.*?)<\/title>/is', $html, $matches)) {
            $title = trim($matches[1]);
        }

        // 2. Extract content between <body> and </body>, excluding layout scripts
        $pageContent = '';
        $bodyStart = false;
        $bodyEnd = strpos($html, '</body>');

        if (preg_match('/<body([^>]*)>/i', $html, $bodyMatches, PREG_OFFSET_CAPTURE)) {
            $bodyStart = $bodyMatches[0][1] + strlen($bodyMatches[0][0]);
        }

        if ($bodyStart !== false && $bodyEnd !== false) {
            $scriptStart = strpos($html, '<!-- Vendor js -->', $bodyStart);
            if ($scriptStart === false) {
                $scriptStart = strpos($html, '<script src="assets/js/vendors.min.js">', $bodyStart);
            }

            if ($scriptStart !== false && $scriptStart < $bodyEnd) {
                $pageContent = substr($html, $bodyStart, $scriptStart - $bodyStart);
            } else {
                $pageContent = substr($html, $bodyStart, $bodyEnd - $bodyStart);
            }
        } else {
            $pageContent = $html;
        }

        $pageContent = trim($pageContent);

        // 3. Extract styles & scripts
        $pageStyles = [];
        $headStart = strpos($html, '<head>');
        $headEnd = strpos($html, '</head>');
        if ($headStart !== false && $headEnd !== false) {
            $head = substr($html, $headStart, $headEnd - $headStart);
            preg_match_all('/<link[^>]*>/is', $head, $linkMatches);
            foreach ($linkMatches[0] as $link) {
                if (stripos($link, 'vendors.min.css') === false && 
                    stripos($link, 'app.min.css') === false && 
                    stripos($link, 'favicon.ico') === false) {
                    $pageStyles[] = $this->convertAssets($link);
                }
            }
        }

        $pageScripts = [];
        if ($bodyEnd !== false && $bodyStart !== false) {
            $scriptStart = strpos($html, '<!-- Vendor js -->', $bodyStart);
            if ($scriptStart === false) {
                $scriptStart = strpos($html, '<script src="assets/js/vendors.min.js">', $bodyStart);
            }
            if ($scriptStart !== false && $scriptStart < $bodyEnd) {
                $scriptsBlock = substr($html, $scriptStart, $bodyEnd - $scriptStart);
                preg_match_all('/<script[^>]*>.*?<\/script>/is', $scriptsBlock, $scriptMatches);
                foreach ($scriptMatches[0] as $script) {
                    if (stripos($script, 'vendors.min.js') === false && 
                        stripos($script, 'app.js') === false) {
                        $pageScripts[] = $this->convertAssets($script);
                    }
                }
            }
        }

        $blade = "@extends('layouts.auth')\n\n";
        if (!empty($htmlClass)) {
            $blade .= "@section('html_class', '" . addslashes($htmlClass) . "')\n\n";
        }
        if (!empty($htmlAttrs)) {
            $blade .= "@section('html_attributes')\n" . $htmlAttrs . "\n@endsection\n\n";
        }
        if (!empty($bodyClass)) {
            $blade .= "@section('body_class', '" . addslashes($bodyClass) . "')\n\n";
        }
        if (!empty($bodyAttrs)) {
            $blade .= "@section('body_attributes')\n" . $bodyAttrs . "\n@endsection\n\n";
        }
        $blade .= "@section('title', '" . addslashes($title) . "')\n\n";

        if (!empty($pageStyles)) {
            $blade .= "@push('styles')\n";
            foreach ($pageStyles as $style) {
                $blade .= "    " . $style . "\n";
            }
            $blade .= "@endpush\n\n";
        }

        $blade .= "@section('content')\n";
        $pageContent = $this->convertLinks($pageContent);
        $pageContent = $this->convertAssets($pageContent);
        $blade .= $pageContent . "\n";
        $blade .= "@endsection\n";

        if (!empty($pageScripts)) {
            $blade .= "\n@push('scripts')\n";
            foreach ($pageScripts as $script) {
                $blade .= "    " . $script . "\n";
            }
            $blade .= "@endpush\n";
        }

        return $blade;
    }

    /**
     * Extract attributes of the <html> tag.
     */
    private function extractHtmlAttributes(string $html, &$class): string
    {
        $class = '';
        if (preg_match('/<html([^>]*)>/i', $html, $matches)) {
            $attrs = trim($matches[1]);
            // Remove lang attribute
            $attrs = preg_replace('/lang="[^"]*"/i', '', $attrs);
            
            // Extract class attribute if it exists
            if (preg_match('/class="([^"]*)"/i', $attrs, $classMatches)) {
                $class = trim($classMatches[1]);
                $attrs = preg_replace('/class="([^"]*)"/i', '', $attrs);
            }

            // Replace multiple spaces with a single space
            $attrs = preg_replace('/\s+/', ' ', $attrs);
            return trim($attrs);
        }
        return '';
    }

    /**
     * Extract attributes of the <body> tag.
     */
    private function extractBodyAttributes(string $html, &$class): string
    {
        $class = '';
        if (preg_match('/<body([^>]*)>/i', $html, $matches)) {
            $attrs = trim($matches[1]);
            
            // Extract class attribute if it exists
            if (preg_match('/class="([^"]*)"/i', $attrs, $classMatches)) {
                $class = trim($classMatches[1]);
                $attrs = preg_replace('/class="([^"]*)"/i', '', $attrs);
            }

            // Replace multiple spaces with a single space
            $attrs = preg_replace('/\s+/', ' ', $attrs);
            return trim($attrs);
        }
        return '';
    }
}
