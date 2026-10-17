# UCF Bands V4 Theme

## Asset Structure for "Views" and Block Types

See [`@wordpress/scripts` documentation](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/#importing-styles-in-javascript).

| Property | Description | Source File | Built File |
|----------|-------------|-------------|------------|
| `viewScript` | Front end-only JS | `view.js` | `view.js` |
| `style` | Shared CSS | `style.scss` | `style-index.css` |
| `editorScript` | Editor-only JS | `index.js` | `index.js` |
| `editorStyle` | Editor-only CSS | Any import in `index.js` (ex: `editor.scss`) | `index.css` |
