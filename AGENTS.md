# AGENTS.md
- Install deps: `pnpm install`
- Start dev server: `pnpm watch`
- Build production assets: `pnpm build`
- Build build-in blocks: `pnpm wp:build`

## Overview
- Type: `hybrid`;
- Stack: PHP `8.4+`, WordPress `7.1+`, JavaScript (ES modules), SCSS, Webpack Encore
- Framework: Bootstrap `5.3`
- Languages: `pl_PL|en_GB`. All user-facing strings must be translatable using English as a base.

## Structure
- `./` Theme root directory
- `./dev` Theme source assets directory
- `./dev/scss` Theme SCSS source directory
- `./dev/scss/components` Theme components SCSS source directory
- `./dev/scss/components/block` Theme blocks and block styles specific SCSS source directory
- `./dev/scss/extensions` Theme plugins and extensions styles SCSS source directory
- `./dev/scss/pages` Theme page-specific styles SCSS source directory
- `./dev/scss/tools` Theme tools styles SCSS source directory
- `./.dev/scss/_variables.scss` Theme SCSS variables
- `./.dev/scss/_mixins.scss` Theme SCSS mixins
- `./.dev/scss/_functions.scss` Theme SCSS functions
- `./.dev/scss/_fonts.scss` Theme custom fonts SCSS
- `./.dev/scss/_dev.scss` Theme CSS development stylesheet file executed only on the development environment
- `./.dev/scss/_theme.scss` Theme main SCSS file holding references to all other SCSS files. New stylesheets should be registered here.
- `./.dev/scss/editor-styles.scss` Theme block editor SCSS file holding references to all other SCSS files. New stylesheets should be registered here.
- `./.dev/scss/index.scss` Theme entrypoint, do not modify.
- `./dev/js` Theme JavaScript source directory
- `./dev/js/theme.js` Theme JavaScript entrypoint (a theme main script file)
- `./dev/js/dev.js` Theme JavaScript development script file executed only on the development environment
- `./dev/js/lightbox.js` Theme JavaScript lightbox entrypoint
- `./dev/images` Theme images source directory
- `./dev/images/icons` Theme icons source directory
- `./dev/blocks` Theme blocks source directory
- `./.sample-data` Theme sample data (including typography samples)
- `./langauges` Theme translations files
- `./src/BestProject` Theme creator classes and helpers directory (do not modify)
- `./src/BaseTheme` Theme classes and helpers directory (any new classes should be added here)
- `./template-parts` Holds theme parts. If any part of the theme layout will be resued, it should be placed here.
- `./functions.php` Theme functions holding hooks and actions assignments.
- `./webpack.config.js` Theme WebPack Encore configuration file. If new entry points are required, they should be registered here.

## Coding standards
### PHP
- Prepare code compatible with a PHP version defined in `composer.json`
- Prefer creating classes and methods in `./src/BaseTheme` instead of functions. Except for situations where WordPress built-in function can be used (e.g. `__return_false`)
- Register behavior through hooks (`add_action` / `add_filter`) in `src/BaseTheme`. Keep `functions.php` as a loader only.
- Do not put business logic in template files. Templates render; `inc/` computes.
- Prefer WordPress APIs (`WP_Query`, `get_template_part`, `wp_enqueue_*`) over raw SQL or direct includes.
- Pass data from PHP with `wp_localize_script` or `wp_add_inline_script`, never inline `<script>` in templates.
- Use four spaces for indentation.
- Wherever possible define a method/function return type

### SCSS
- Follow the existing structure (`components/`, `extensions/`, `pages/`, `tools/`).
- Use project variables and mixins; do not hardcode colors, spacing, or breakpoints.
    - Variables should be defined in `./.dev/scss/_variables.scss`.
    - If possible, re-use variables from `./dev/scss/_variables.scss`.
- If a new stylesheet is created, it should be registered in `./.dev/scss/_theme.scss` and `./.dev/scss/editor-styles.scss`.
    - New layout tools register between `//> Tools` and `//< Tools`
    - New components register between `//> Components` and `//< Components`
    - New blocks and block styles register between `//> Blocks` and `//< Blocks`
    - Page-specific styles register between `//> Pages` and `//< Pages`
    - Plugins/Extensions specific styles register between `//> Plugins` and `//< Plugins`
- Class naming: `project convention`.
- New block styles file should be created using `composer make block-style <block-name>` command. This command will also prepare a proper hook to register this block style.
- New plugin styles file should be created using `composer make plugin-style <plugin-name>` command
- New component styles file should be created using `composer make component-style <component-name>` command
- Prefer using existing classes and mixins where possible.
- Prefer using `to-rem(<value in pixels>)` function instead of hardcoding pixel values.
- Use four spaces for indentation.

### Templating
- Prefer using WordPress built-in blocks over custom ones.
- Prefer creating custom patterns in `./patterns` for a reusable set of blocks.
    - Each pattern should define `Title`, `Slug`, and `Categories` according to WordPress specification `https://developer.wordpress.org/themes/patterns/registering-patterns/`
    - Each pattern should also be added to `BaseTheme` category.
- Prefer using existing font sizes defined in `editor-font-sizes` of `./src/BaseTheme/Action/after_setup_theme.php` unless specified otherwise.
- Prefer using existing colors defined in `editor-color-palette` of `./src/BaseTheme/Action/after_setup_theme.php` unless specified otherwise.
- If a new font size is needed, add it to `add_theme_support( editor-font-sizes)` in `./src/BaseTheme/Action/after_setup_theme.php` and register in `$font-sizes` of `.dev/scss/_variables.scss`.
- If a new color is needed, add it to `add_theme_support( 'editor-color-palette')` in `./src/BaseTheme/Action/after_setup_theme.php` and register in `$theme-colors` of `.dev/scss/_variables.scss`.

## Security
- **Escape on output**: `esc_html()`, `esc_attr()`, `esc_url()`, `wp_kses_post()`.
- **Sanitize on input**: `sanitize_text_field()`, `absint()`, etc.
- **Nonces and capability checks** on every form handler, AJAX action, and REST route.
- **Direct SQL queries** are strictly forbidden.
- Never commit secrets, API keys, or `.env` files.

## Internationalization
- Wrap strings: `__()`, `_e()`, `esc_html__()`, `_n()`, `_x()` with the text domain defined in`./style.css`.
- Never concatenate translatable strings; use `sprintf()` with placeholders.
- After adding strings, regenerate the POT: `wp i18n make-pot . languages/<text-domain>.pot`.

## Performance and accessibility
- Enqueue assets conditionally, only on pages that need them (using `\BestProject\Helper\AssetsHelper::addEntryPointAssets()`.
- Always set `width`/`height` on images and use `loading="lazy"` below the fold.
- Use semantic HTML, visible focus states, and `alt` text. Keep interactive components keyboard accessible.

## Git and change rules
- Do not modify `./assets` directory
- Do not upgrade dependencies, change build config, or rename files/hooks unless the task requires it.

## Testing and verification
- Manually check: front page, single post, archive, 404, search.
- Check at mobile (375px), tablet (768px), and desktop (1280px+ and 4K).
- Run with `WP_DEBUG` and `WP_DEBUG_LOG` enabled; there must be no new PHP notices or console errors.

## Agent behavior
- Read the surrounding code and match its existing patterns before adding new ones.
- Ask before making changes outside the scope of the request (DB schema, plugin dependencies, build tooling).
- Summarize what changed, which files were touched, and how it was verified.
- If a requirement is ambiguous, state your assumption explicitly instead of guessing silently.