![Dazzling WordPress Theme](https://cdn.colorlib.com/wp/wp-content/uploads/sites/2/screenshot.png "Dazzling Theme Screenshot")

#About Dazzling WordPress Theme#

Dazzling is a clean, modern, minimal and fully responsive flat design WordPress WooCommerce theme well suited for blogs, static and ecommerce websites. Theme can be used for travel, corporate, portfolio, photography, green thinking, nature, health, personal and any other creative and minimalistic style website. Dazzling theme is highly customizable with unlimited color options, slider, call for action button, several widget areas and much more that can be adjusted via Theme Options. The theme is built using Bootstrap 3, which makes it responsive and mobile friendly. It features infinite scroll, SEO friendly structure, logo upload, full-screen slider, call for action section, social media icons, popular post widget and translation ready setup. This theme supports WooCommerce and Jigoshop ecommerce plugins. Dazzling is also available in Mexican Spanish, Brazilian Portuguese, Finnish, Swedish, Dutch, Hungarian, German, Persian, Lithuanian, Portuguese, Danish, Turkish and Polish. It is Multilingual ready and compatible with WPML plugin. It is probably the best free WordPress theme built for eStores and business websites.

For questions, comments or bug reports, visit [Colorlib support forum](https://colorlib.com/wp/forums).

#Installation#

You can install the theme through the WordPress installer under "Themes" > "Install themes" by searching for "Dazzling".

Alternatively you can download archive file, unzip it and move the unzipped contents to the "wp-content/themes" folder of your WordPress installation. You will then be able to activate the theme.

Afterwards you can continue theme setup and customization via WordPress Dashboard - Appearance - Theme Options. For detailed theme documentation, please [see here](https://colorlib.com/wp/support/dazzling).

#Theme Features#

* Bootstrap 3 integration
* Responsive design
* Unlimited color variations
* SEO friendly
* WordPress Theme Customizer integration
* Image centric approach
* Internationalized & localization
* Drop-down Menu
* Cross-browser compatibility
* Threaded Comments
* Gravatar ready
* Featured slider
* Font Awesome icons
* WooCommerce support
* Jigoshop support

#Documentation#

Theme documentation [is available here](https://colorlib.com/wp/support/dazzling)

#Copyright notice#

* Author: Aigars Silkalns [@AigarsSilkalns](https://twitter.com/AigarsSilkalns)
* Author URI: https://colorlib.com/wp/
* License: GNU General Public License v3.0
* License URI: http://www.gnu.org/licenses/gpl.html
* Dazzling theme, Copyright 2014-2016 https://colorlib.com
* Dazzling WordPress theme is distributed under the terms of the GNU GPL
* Dazzling is based on [Underscores](http://underscores.me/), (C) 2012-2016 Automattic, Inc.

#Credits#

Dazzling theme uses:

* [FontAwesome](http://fontawesome.io) licensed under the SIL OFL 1.1 (http://scripts.sil.org/OFL)
* [Bootstrap](http://getbootstrap.com/) licensed under [MIT license](https://github.com/twbs/bootstrap/blob/master/LICENSE)
* [WP-Bootstrap-NavWalker](https://github.com/twittem/wp-bootstrap-navwalker) licensed under the GPLv2 license
* [FlexSlider](https://github.com/woothemes/FlexSlider) by WooThemes licensed under the GPLv2 license

#Changelog#

####2.2.1 - 11.09.2026####

* Replaced Font Awesome 4.4.0, released in 2015, with a self-hosted Font Awesome 7.3.1. Only woff2 is shipped: the eot, svg, ttf and woff copies could never be downloaded, because a browser takes the first format it supports from the @font-face src list. Bundled icon fonts drop from 700 KB to 356 KB
* No v4 or v5 compatibility shim is loaded. Three classes that Font Awesome 7 does not have were rewritten to native names -- fa-folder-open-o, fa-pencil-square-o and fa-comment-o become fa-regular fa-folder-open, fa-regular fa-pen-to-square and fa-regular fa-comment. All 13 icon classes the theme renders were verified against the bundled name map
* The social icons set a codepoint on a .fa element and relied on Font Awesome 4 keeping every glyph in one family. Version 5 moved brands into a separate family, so under 7 those icons would have rendered nothing. Each rule now names its family: Font Awesome 7 Brands at weight 400 for the 17 brand glyphs, Font Awesome 7 Free at weight 900 for the feed icon, which is not a brand
* The search button used a Bootstrap glyphicon, which pulled Bootstrap's icon font on every page carrying a search form. It uses Font Awesome, already loaded. Menu glyphicon support is untouched

####2.2.0 - 11.09.2026####

Security and maintenance release.

* Security: the Customizer's colour sanitiser returned its input unchanged when validation failed, so arbitrary text could be stored through a colour setting and was then printed into the inline <style> block on every page. Invalid values are rejected, and every colour is re-validated as it is printed, because options saved before this change may still hold arbitrary text
* Security: the per-post layout metabox saved whatever was submitted, and header.php printed that value unescaped into a class attribute -- so a user who could edit a post could store markup that ran for every visitor. The submitted layout is checked against the theme's own list, and the class is escaped where it is printed
* Security: the legacy custom CSS option was run through html_entity_decode(), which turned an escaped "</style><script>" back into live markup. It is stripped of tags instead
* Security: the social widget never overrode update(), so its title was stored exactly as submitted and echoed unescaped. Both widgets now sanitise on save and escape on output
* Security: four title attributes called the_title() rather than the_title_attribute(), so a quote in a post title broke out of the attribute. The call-for-action text and link, and the next-attachment URL in image.php, are escaped
* Updated Bootstrap from 3.3.6 to 3.4.1, which fixes CVE-2019-8331 -- cross-site scripting through the data-template attribute of tooltips and popovers. The bundled copy was not stock: two dropdown rules had been edited into it, and style.css depends on them to reveal sub-menus for keyboard users. Those rules now live in style.css, so the vendored Bootstrap is stock
* Updated FlexSlider from 2.5.0 to 2.7.2
* Dropped Internet Explorer support: html5shiv, Respond.js, the "lt IE 9" conditional comment printed into every page head, and the X-UA-Compatible meta tag. Internet Explorer reached end of support in June 2022
* The repository had been stuck at 2.1.0 since 2017 while WordPress.org shipped 2.1.1 through 2.1.3, so the two were different code. They match again
* $_POST reads in the metabox, and $post->ID in header.php, are guarded -- both warn on PHP 8

####2.1.3 - 11.12.2016####

* Added wp_body_open
* Added License & Copyright
* Added unminified Scripts and styles

####2.1.0 - 30.06.2016####

* Added TGMPA & made Kiwi a recommended plugin
* Updated theme tags as per new w.org regulations
* Fixed numerous errors
* Updated translation files thanks to Vaidas Elksnys

####2.0.4 - 19.03.2016####

* Fixed error in extras.php

####2.0.3 - 18.03.2016####

* Added site tagline support
* Fixed problems with popular posts widget
* Other code tweaks and cleanups

####2.0.2 - 14.01.2016####

* Added Danish translation thanks to Asser Munch
* Improved Italian translation
* Added Turkish translation thanks to Aziz KABA

####2.0.1 - 17.11.2015####

* Removed redundand function

####2.0 - 30.10.2015####

* Removed theme options in favor to WordPress Theme Customizer
* Added layout manager
* Improved social icons
* Code cleanups
* Updated FlexSlider
* Updated Bootstrap to 3.3.5
* Updated Font Awesome library

####1.5.6 - 14.08.2015####

* Added Italian translation thanks to Giulia Costa
* Fixed JavaScript that made FlexSlider height to 0 in some cases.

####1.5.5 - 10.07.2015####

* Improved Custom CSS forum output

####1.5.4 - 04.06.2015####

* Added missing string for translation
* Updated translation files

####1.5.3 - 20.04.2015####

* Fixed layout bug with WooCommerce Cart inside Primary Menu.
* Added missing string for translation

####1.5.2 - 27.04.2015####

* Improved WordPress Customizer Support. Now allows to change site title and its color on the fly.
* Added Portuguese translation thanks to Susana Nova

####1.5.1 - 18.04.2015####

* Fixed JavaScript error for FlexSlider

####1.5.0 - 04.04.2015####

* Added support for WPML multilingual plugin.
* Updated Options Framework
* Improved Theme Options translation for Child Theme
* Other small code cleanups
* Added Lithuanian translation

####1.4.6 - 1.04.2015####

* Fixed JavaScript warning that appeared on Google Chrome Dev Tools
* Improved slider related JavaScript with smooth height adjusting when different size images are used for slider.
* Updated flexslider to 2.4.0

####1.4.5 - 20.03.2015####

* Updated Bootstrap framework to 3.3.4
* Fixed problem with invisible label for color variations in WooCommerce
* Simplified slider function

####1.4.4 - 02.03.2015####

* Added Persian translation thanks to Sajad Dehshiri
* Added German translation thanks to Sebastian Klatte

####1.4.3 - 26.01.2015####

* Added the-title tag support

####1.4.2 - 22.01.2015####

* Updated Bootstrap to 3.3.2
* Social icons now opens in a new tab.

####1.4.1 - 22.12.2014####

* Added Hungarian translation

####1.4.0 - 17.12.2014####

* Jigoshop ecommerce plugin integration
* Other minor improvements

####1.3.8 - 15.11.2014####

* Bootstrap updated to v3.3.1

####1.3.7 - 09.11.2014####

* Added different content width for Full-width template for plugins that depends on it to work properly.

####1.3.6 - 15.10.2014####

* Updated translation files to match the latest update

####1.3.5 - 15.10.2014####

* Improved Flexslider to make it compatible with other FlexSlider powered plugins such as Visual Composer.
* Simplified search form to make it friendlier to use outside widget area by using get_search_form

####1.3.2 - 11.09.2014####

* Updated Font Awesome to 4.2
* Added Slideshare and VK.com social icon
* Created more consistent code on options.php for Options Framework.
* Improved translation files.

####1.3.1 - 03.08.2014####

* Small changed to Options Framework
* Updated theme description to mention Dutch translation

####1.3.0 - 03.08.2014####

* Added Swedish translation thanks to Tommy Larsson
* Added Dutch translation thanks to Paul den Hertog
* Updated Bootstrap to 3.2
* Updated Options Framework to 1.8.2
* Improved Child Theme Support

####1.2.9 - 24.06.2014####

* Added Finnish translation thanks to Antti Vähälummukka
* Default footer copyright text is now translatable

####1.2.8 - 19.05.2014####

* Added Brazilian Portuguese translations thanks to Ariel de Souza (about.me/arieldesouza)

####1.2.7 - 16.05.2014####

* Added Polish translation thanks to Damian Krawczyk
* Updated Font Awesome icons to 4.1

####1.2.6 - 16.05.2014####

* Removed unnecessary archive file.

####1.2.5 - 15.05.2014####

* Updated Options Framework to 1.8.0
* Added Mexican Spanish Translation.
* Updated translation
* Improved Theme Options sidebar

####1.2 - 08.05.2014####
* WooCommerce support
* Small JavaScript improvements

####1.1.1 - 01.05.2014####
* Fixed problems with horizontal scroll
* Fixed social media button color on hover
* Improved consistency with for CSS
* Updated HTML5 Shiv

####1.1 - 10.02.2014####
* Made necessary changes to pass W3 validation without any errors.
* Removed duplicate classes form social network icons
* Updated call for action button to pass validation
* Improved main navigation on mobile
* Improved attachment template image.php
* Added IE8 support by implementing html5shiv.js and respond.js

####1.0.1 - 25.02.2014####
* Simplified dazzling_social function
* Updated copyright information making it translatable
* Popular post widget now uses wp_reset_postdata(); instead of wp_reset_query();
* Added esc_url for home_url inside header.php
* Updated translation file

####1.0 - 22.02.2014####
Initial release
