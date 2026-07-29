# Oja Talu — setup checklist

This theme is code-complete but **not deployable as-is**. The items below
are real dependencies scattered across the design/development phases of
this project — consolidated here so a maintainer has one place to check,
rather than five different documents.

## 1. Build the blocks

```
cd oja-talu
npm install
npm run build
```

`blocks/build/` doesn't exist until this runs. The theme's 8 custom
Gutenberg blocks won't register without it — `inc/blocks.php` checks
whether the build directory exists and silently no-ops if it doesn't
(no fatal error, but also no blocks).

## 2. Add font files

`theme.json` declares `@font-face` rules pointing at three files that
aren't in this repo (licensing hygiene — see `assets/fonts/README.md`):

- `Fraunces-Variable.woff2`
- `Fraunces-Italic-Variable.woff2`
- `WorkSans-Variable.woff2`

Download from Google Fonts, subset to at least Latin + Latin Extended
(Estonian needs š, ž, õ, ä, ö, ü), place in `assets/fonts/`.

## 3. Required plugins

| Plugin | Why |
|---|---|
| WooCommerce | Shop, Cart, Checkout blocks |
| Polylang | ET/EN bilingual site — header/footer include a `polylang/language-switcher` block that renders nothing until Polylang is active |
| A payment gateway (Montonio or Maksekeskus) | WooCommerce core has no Estonian bank-transfer support built in |

Deliberately **not** installed: an SEO plugin, a security suite, a page
builder, a caching plugin (add one only if the host doesn't already
provide page caching) — see `inc/seo.php`, `inc/security.php`, and
Phase 4 §14 for the reasoning.

## 4. Create the primary navigation menu

`parts/header.html`'s Navigation block is populated with real
`navigation-link` children (not left empty — an empty Navigation block
falls back to auto-listing every top-level Page) at these best-guess
paths:

`/meie-lugu/` · `/oja-aed/` · `/rohebaar/` · `/pood/` · `/paevik/` · `/kulasta-meid/`

Once the real pages exist, open the header template in the Site Editor
and re-point each link if any slug differs from the guess above.

## 5. Create the four footer link groups

Same situation, four times over, in `parts/footer.html` — each of the
four columns (Oja Talu / Oja Aed / Rohebaar / Pood & külastus) has its
own real links already, not an empty Navigation block. Re-point them
the same way once real content exists.

## 6. Create these pages, with these exact slugs

`inc/urls.php` (`oja_talu_url()`) resolves internal links dynamically
via `get_page_by_path()` — but it still needs the pages to exist at
these slugs to resolve correctly, otherwise it falls back to a
best-guess path:

| Page | Expected slug | Template |
|---|---|---|
| Oja Talu story | `meie-lugu` | Oja Talu — Story Page |
| Oja Aed | `oja-aed` | Oja Aed Page |
| Rohebaar | `rohebaar` | Rohebaar Page |
| Visit | `kulasta-meid` | Visit Page |
| Contact (Rohebaar's "Broneeri laud" links here) | `kontakt` | — |

Shop and Journal resolve automatically (WooCommerce's shop page setting,
and the `oja_journal` post type's own archive) — no manual page needed
for either.

## 7. Create WooCommerce product categories with these slugs

`patterns/shop-intro.php`'s category tabs and `patterns/page-oja-aed-sections.php`'s
"Vaata kõiki Oja Aed tooteid" link expect these `product_cat` term slugs
to exist: `aiasaadused`, `piimatooted`, `hoidised`, `kasitoo`, `oja-aed`.
Until they exist, tabs/links fall back to sensible but non-final URLs.

## 8. Decide on fulfilment model

Shipping zones vs. local pickup vs. both — still an open decision from
Phase 1/4. Configure in WooCommerce → Settings → Shipping once decided;
nothing in the theme code needs to change either way.

## 9. Generate JS translation files

If the site needs the Journal/Visit blocks' fixed UI strings (labels
like "Aadress"/"Avatud") to actually translate into English, generate
`.json` translation files with `wp i18n make-json` from a `.po` file in
`/languages` — the PHP side (`wp_set_script_translations()`) is already
wired up in `inc/blocks.php` and `inc/seo.php`, it just needs the files.

## 10. Verify, don't assume

Nothing in this theme has been tested against a live WordPress install —
run through the testing checklist at the end of each phase's build
notes (colour contrast, keyboard navigation, the contact form's
end-to-end submission, a real Lighthouse pass) before launch.
