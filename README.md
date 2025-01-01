
# Kirby robots.txt Plugin

The **datenliebe/kirby-robots** plugin for Kirby CMS makes it easy to manage your `robots.txt` file. Define default rules, extend them with custom rules via the Kirby Panel or `config.php`, and serve the combined rules dynamically.

## Features

- **Plug & Play**: Placing the plugin into your `site/plugins` directory already provides a basic robots.txt with default rules - no configuration needed.
- **Default Disallow Rules**: Automatically disallows:
  - `/kirby`
  - `/site`
- **Custom Rules via Config**: Add additional `Disallow`, `Allow`, and `Sitemap` rules in `config.php`.
- **Custom Rules via Panel**: Manage additional rules through a `robotsRules` field in the Kirby Panel.
- **Dynamic robots.txt**: Serves the combined rules dynamically at `/robots.txt`.
- **Translation Support**: Field labels and help text support English (`en`) and German (`de`).

---

## Installation

1. Clone or download this repository into your `site/plugins` directory:

   ```bash
   git clone https://github.com/datenliebe/kirby-robots.git site/plugins/robots

2. The plugin is now installed and ready to use.

---

## Usage

### Default Rules

The plugin automatically adds the following default rules:

```text
User-agent: *
Disallow: /kirby
Disallow: /site
```

---

### Adding Custom Rules in Config

To extend the default rules, you can define additional rules in your `config.php` using the `datenliebe.robots.rules` option.

#### Example Config

```php
return [
    'datenliebe.robots.rules' => [
        '*' => [ // Rules for all user agents
            'Disallow' => ['/hidden'], // Block specific directories
            'Allow' => ['/public'],    // Allow specific directories
            'Sitemap' => ['https://example.com/sitemap.xml'], // Add sitemap URL
        ],
        'Googlebot' => [ // Rules specific to Googlebot
            'Disallow' => ['/no-google'],
        ],
    ],
];
```

#### Example Output

When you combine default and custom rules, your `robots.txt` might look like this:

```text
User-agent: *
Disallow: /kirby
Disallow: /site
Disallow: /hidden
Allow: /public
Sitemap: https://example.com/sitemap.xml

User-agent: Googlebot
Disallow: /no-google
```

---

### Adding the robots.txt Tab to the Site Blueprint

You can manage additional `robots.txt` rules directly from the Kirby Panel by adding the `robotsRules` field to your site's blueprint.

#### Option 1: Add as a Dedicated Tab

To add a dedicated **robots.txt** tab to the panel, extend the plugin's `tabs/robots` blueprint in your `site.yml`:

```yaml
title: Site

tabs:
  content:
    label: Content
    sections:
      pages:
        type: pages

  robots:
    $extend: tabs/robots
```

#### Option 2: Add as a Field in an Existing Tab

To include the `robotsRules` field in an existing tab (e.g., **Content**), extend the `fields/robotsRules` blueprint:

```yaml
title: Site

tabs:
  content:
    label: Content
    fields:
      robotsRules:
        $extend: fields/robotsRules

    sections:
      pages:
        type: pages
```

---

### robots.txt Output Priority

The `robots.txt` rules are combined in this order:
1. **Default rules** (`/kirby`, `/site`).
2. **Custom rules** from `config.php`.
3. **Custom rules** from the Panel field.

This ensures that all rules are applied, with user-defined rules taking precedence.

---

## Example robots.txt

With both custom config and Panel rules, the output might look like this:

```text
User-agent: *
Disallow: /kirby
Disallow: /site
Disallow: /hidden
Allow: /public
Sitemap: https://example.com/sitemap.xml

User-agent: Googlebot
Disallow: /no-google

User-agent: *
Allow: /special-content
Sitemap: https://example.com/custom-sitemap.xml
```

---

## Translation Support

This plugin currently supports English (`en`) and German (`de`) for the field labels and help text. You can add translations by adding them to the `/translations` folder and the `translations` section in the plugin.

---

## License

This plugin is licensed under the [MIT License](LICENSE).

---

## Contributing

Feel free to submit issues or pull requests to improve this plugin. Contributions are always welcome!

---

## Questions?

If you have any questions or need assistance, feel free to reach out or create an issue in the repository.
