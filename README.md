# EME ARC Suite - Core
![GitHub release (latest by date)](https://img.shields.io/github/v/release/W9MDM/eme-arc-core)
![GitHub license](https://img.shields.io/github/license/W9MDM/eme-arc-core)

The **EME ARC Suite - Core** plugin provides core functionality for integrating callsign and custom fields with the [Events Made Easy](https://wordpress.org/plugins/events-made-easy/) plugin for WordPress. This plugin is designed to enhance EME forms and data management, particularly for amateur radio clubs or events requiring callsign integration.

## Features
- Adds a callsign field to EME person and member edit forms.
- Validates callsign format (e.g., `W9MDM`: 1-2 letters, 1 number, 1-3 letters).
- Saves callsign data to the EME answers table (field_id = 2).
- Provides placeholders (`#_CALLSIGN` for people, `#_MEMBERCALLSIGN` for members) for use in EME templates.
- Includes dependency checks for Events Made Easy.
- Supports automatic updates via GitHub.

## Requirements
- WordPress 5.0 or higher
- [Events Made Easy](https://wordpress.org/plugins/events-made-easy/) plugin (active with full functionality)

## Installation
1. Download the latest release from the [Releases](https://github.com/W9MDM/eme-arc-core/releases) page.
2. Upload the `eme-arc-core` folder to your `/wp-content/plugins/` directory.
3. Activate the plugin through the WordPress "Plugins" menu.
4. Ensure the Events Made Easy plugin is installed and active.

## Usage
- The callsign field will automatically appear in EME person and member edit forms.
- Use `#_CALLSIGN` in people templates or `#_MEMBERCALLSIGN` in member templates to display the callsign.
- Callsigns are validated and saved in uppercase (e.g., `w9mdm` becomes `W9MDM`).

## Development
This plugin uses the [Plugin Update Checker](https://github.com/YahnisElsts/plugin-update-checker) library to enable updates directly from GitHub. To contribute:
1. Fork this repository.
2. Clone it to your local machine: `git clone https://github.com/YOUR_USERNAME/eme-arc-core.git`
3. Submit pull requests to the `main` branch.

## License
This plugin is licensed under the [GNU General Public License v2.0](LICENSE).

## Author
Developed by W9MDM.

## Support
For issues or feature requests, please open an [issue](https://github.com/W9MDM/eme-arc-core/issues) on GitHub.