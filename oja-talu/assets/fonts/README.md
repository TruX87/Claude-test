# Required font files (not included)

`theme.json` declares `@font-face` rules pointing at three variable font
files that must be placed in this folder before typography will render
correctly:

- `Fraunces-Variable.woff2`
- `Fraunces-Italic-Variable.woff2`
- `WorkSans-Variable.woff2`

Both typefaces are open source (SIL Open Font License) and are not
bundled in this repository for licensing-hygiene reasons — download the
variable woff2 builds from Google Fonts (fonts.google.com/specimen/Fraunces
and fonts.google.com/specimen/Work+Sans), subset them to at least Latin +
Latin Extended (for Estonian diacritics: š, ž, õ, ä, ö, ü), and drop the
three files in here with the exact names above. No code change is needed
once the files exist — `theme.json` already points at them.
