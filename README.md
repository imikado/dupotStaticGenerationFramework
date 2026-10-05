# Dupot Static Generation Framework

[![Latest Version](https://img.shields.io/packagist/v/dupot/static-generation-framework.svg)](https://packagist.org/packages/dupot/static-generation-framework)
[![Total Downloads](https://img.shields.io/packagist/dt/dupot/static-generation-framework.svg)](https://packagist.org/packages/dupot/static-generation-framework)
[![License](https://img.shields.io/packagist/l/dupot/static-generation-framework.svg)](LICENSE)

**Build static websites in plain PHP: no template engine, no build pipeline, no runtime dependencies.**

Dupot Static Generation Framework is a tiny PHP library for generating static HTML sites, ready to host on GitHub Pages, GitLab Pages, Netlify, an S3 bucket or any basic web server.

You write pages and components as small PHP classes, render them with regular PHP views, and write the output as `.html` files. That's all there is to it.

---

## ✨ Why use it?

- 🪶 **Lightweight**: a handful of classes and zero Composer dependencies.
- 🐘 **Plain PHP**: your views are `.php` files. You don't have to learn a new templating language.
- 🧩 **Component-based**: split your site into reusable pieces (header, menu, cards, footer…).
- 📄 **One class per page**: each page knows its filename and how it renders.
- 🚀 **Host it anywhere**: the output is plain HTML, so it's fast and secure, and there's no server-side code in production.
- 🔧 **Fully under your control**: no magic and no conventions forced on you, so it fits into any workflow (scripts, CI, GitHub Actions…).

---

## 📦 Installation

```bash
composer require dupot/static-generation-framework
```

Or add it to your `composer.json`:

```json
{
    "require": {
        "dupot/static-generation-framework": "2.*.*"
    }
}
```

> 💡 **The fastest way to start** is the ready-to-use skeleton project:
> 👉 [imikado/dupotStaticGenerationSkeleton](https://github.com/imikado/dupotStaticGenerationSkeleton)

---

## 🚀 Quick start

### 1. Create a component

```php
<?php

use Dupot\StaticGenerationFramework\Component\ComponentAbstract;
use Dupot\StaticGenerationFramework\Component\ComponentInterface;

class MenuComponent extends ComponentAbstract implements ComponentInterface
{
    public function render(): string
    {
        return $this->renderViewWithParamList(__DIR__ . '/views/menu.php', [
            'linkList' => [
                'index.html' => 'Home',
                'about.html' => 'About',
            ],
        ]);
    }
}
```

`views/menu.php`:

```php
<nav>
    <?php foreach ($this->paramList['linkList'] as $url => $label): ?>
        <a href="<?= $url ?>"><?= htmlspecialchars($label) ?></a>
    <?php endforeach; ?>
</nav>
```

### 2. Create a page

```php
<?php

use Dupot\StaticGenerationFramework\Page\PageAbstract;
use Dupot\StaticGenerationFramework\Page\PageInterface;

class IndexPage extends PageAbstract implements PageInterface
{
    public function getFilename(): string
    {
        return 'index.html';
    }

    public function render(): string
    {
        return $this->renderLayoutWithParamList(__DIR__ . '/layouts/default.php', [
            'title'   => 'Welcome',
            'menu'    => (new MenuComponent())->render(),
            'content' => '<h1>Hello world 👋</h1>',
        ]);
    }
}
```

`layouts/default.php`:

```php
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($this->paramList['title']) ?></title>
</head>
<body>
    <?= $this->paramList['menu'] ?>
    <main><?= $this->paramList['content'] ?></main>
</body>
</html>
```

### 3. Generate your site

```php
<?php

require __DIR__ . '/vendor/autoload.php';

$outputDir = __DIR__ . '/docs'; // e.g. the folder served by GitHub Pages

foreach ([new IndexPage(), new AboutPage()] as $page) {
    $page->generateTo($outputDir);
}
```

```bash
php generate.php
```

Your static site is now in `docs/`. Commit it, push it, and you're online. 🎉

---

## 🧱 API overview

| Class / Interface | Role | Main methods |
|---|---|---|
| `Page\PageInterface` | Contract for a page | `getFilename(): string`, `render(): string` |
| `Page\PageAbstract` | Base class for pages | `renderLayoutWithParamList($layoutPath, $paramList)`, `generateTo($generationPath)` |
| `Component\ComponentInterface` | Contract for a component | `render(): string` |
| `Component\ComponentAbstract` | Base class for components | `renderViewWithParamList($viewPath, $paramList)` |

Inside a view or layout, the parameters you passed are available in `$this->paramList`.

---

## 🔗 Related projects

- [dupotStaticGenerationSkeleton](https://github.com/imikado/dupotStaticGenerationSkeleton): a starter project built on this framework
- [dupot.org](https://www.dupot.org): author's website

---

## 🤝 Contributing

Issues, ideas and pull requests are welcome! If you find this project useful, please consider giving it a ⭐ on GitHub; it helps other people discover it.

---

## 📄 License

Released under the GNU Lesser General Public License (LGPL). See [LICENSE](LICENSE).

Author: **Michael Bertocchi** ([@imikado](https://github.com/imikado))
