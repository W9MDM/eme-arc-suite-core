# EME ARC Suite

A comprehensive WordPress plugin suite for amateur radio club management, built on top of Events Made Easy (EME). Features include membership management, event and member check-ins, propagation forecasts, attendance cards, membership renewals, and callsign-based username enforcement.

## Features
- **Membership Admin**: Manage callsigns, memberships, CSV imports, discount codes, and email generation.
- **Event Check-In**: Check into EME events with real-time attendance display (`[eme_event_checkin]`).
- **Member Check-In**: Record general attendance with callsign verification (`[eme_member_checkin]`).
- **Membership Renewal**: Check and renew membership status (`[eme_membership_renewal]`).
- **Propagation Widget**: Display real-time propagation forecasts for Porter County, IN (`[arc_propagation]`).
- **Attendance Cards**: Generate PDF cards for members with QR codes.
- **Callsign Usernames**: Enforce WordPress usernames to match EME callsigns.

## Requirements
- WordPress 5.0+
- [Events Made Easy](https://wordpress.org/plugins/events-made-easy/)
- [EME ARC Suite - Core](https://github.com/W9MDM/eme-arc-suite-core) (download and activate first)
- PHP 7.4+ (for DomPDF compatibility)
- Internet access (for HamDB API and propagation data)

## Installation
See `INSTALLATION.md` for detailed steps. Basic overview:
1. Install and activate [EME ARC Suite - Core](https://github.com/W9MDM/eme-arc-suite-core) first.
2. Upload the `eme-arc-suite` folder to `wp-content/plugins/`.
3. Activate the plugin via the WordPress admin panel.
4. Ensure dependencies (Events Made Easy and EME ARC Suite - Core) are installed and activated.
5. Place shortcodes in pages/posts as needed (see `shortcodes.txt`).

## Usage
- Use shortcodes in pages/posts (e.g., `[eme_event_checkin]`).
- Access admin features under "EME ARC Management" in the WordPress dashboard.
- Configure settings via submenus (e.g., Membership Settings).

## Contributing
- Fork the repository at [https://github.com/W9MDM/eme-arc-suite](https://github.com/W9MDM/eme-arc-suite).
- Create a feature branch (`git checkout -b feature/your-feature`).
- Commit changes (`git commit -am 'Add feature'`).
- Push to the branch (`git push origin feature/your-feature`).
- Open a pull request.

## License
GPL-2.0+ (see plugin header for details).

## Author
W9MDM