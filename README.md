# PAH llms.txt Generator

A free, browser-based **llms.txt generator** that creates a correctly formatted `llms.txt` file for your website in seconds.

**Live tool:** [llms.txt Generator on Pro Articles Hub](https://proarticleshub.com/llms-txt-generator/)

This repository contains the WordPress version of the tool, packaged as a single-file plugin that adds a shortcode.

## What is llms.txt?

`llms.txt` is a proposed plain-text Markdown file, placed at the root of a website (`/llms.txt`), that gives AI tools and large language models a short, curated overview of the site and links to its most important pages. See the proposal at [llmstxt.org](https://llmstxt.org/).

## Features

- Site name, short summary (shown as a quote) and optional notes for AI tools
- Add pages one per line: `URL | Title | Short description`
- Optional: create titles from URLs when a title is missing
- Optional: remove duplicate URLs
- Built-in example and clear buttons
- Copy to clipboard or download as `llms.txt`
- Runs entirely in the browser: no data is sent to any server

## Installation (WordPress)

1. Download `pah-llms-txt-generator.php`.
2. Upload it to `wp-content/plugins/` (or zip it and use **Plugins > Add New > Upload Plugin**).
3. Activate **PAH llms.txt Generator**.
4. Add this shortcode to any page or post:

```
[pah_llms_txt_generator]
```

## Example output

```markdown
# Example Coffee Blog

> Brewing guides, equipment reviews and coffee basics for home baristas.

## Brewing Guides

- [Pour-Over Coffee Guide](https://example.com/pour-over-guide/): Step-by-step pour-over method
```

## Tips

- List only pages you want AI tools to read first, such as guides, tools and key pages.
- Leave out pages set to noindex, thin pages and duplicates.
- Upload the file to your site root so it is available at `https://yourdomain.com/llms.txt`.

## More free SEO tools

This tool is part of a collection of [free online SEO tools](https://proarticleshub.com/free-online-seo-tools/) by Pro Articles Hub, including an [FAQ schema generator](https://proarticleshub.com/faq-schema-generator/), [broken link checker](https://proarticleshub.com/broken-link-checker/) and [XML sitemap checker](https://proarticleshub.com/free-xml-sitemap-checker/).

## Author

**Kamran Liaquat Ali** – .NET developer and founder of [Pro Articles Hub](https://proarticleshub.com/).
[LinkedIn](https://www.linkedin.com/in/kamranliaquatali)

## License

MIT
