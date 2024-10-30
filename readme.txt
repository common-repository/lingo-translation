=== LinGO Translation ===
Contributors: webdevtsu
Tags: ajax translator, automatic translator, google, google language translator, google translate, google translator, jquery translator, language translate, language translator, Multi language, plugin, sidebar, translate, translation, widget
Requires at least: 2.6.0
Tested up to: 4.4.2
Stable tag: trunk
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Translate your text instantly and on-page, with full control of the translated text from your registered Ackuna.com account.

== Description ==

LinGO is the fastest, easiest way to translate your WordPress blog into over 100 languages instantly!
  
Only LinGO offers instant, on-site translation with no redirects, no additional URLs or pages embedded in third-party website frames, and full control over the translated text and language options available to visitors.

The LinGO Translation plugin works by connecting to the translate service provided by [Ackuna](http://ackuna.com/), the internet's leading translation crowdsourcing platform.

= How does it work? =

LinGO works "out of the box," but can also be fully customized to control the plugin's look and feel on your site, and to perfect the quality of the translations for your blog's text.

* You don't have to upload, add, or manage the text yourself. **Everything is done automatically** to give you and your users the best and easiest experience possible.
* When a user clicks one of the alternate languages from your blog's plugin, your blog is instantly translated into that language, with **no redirects or third-party frames** added anywhere.
* LinGO uses **machine translation to "fill in the blanks"** for your website, so your text will never go untranslated; you can access all of your original strings and the translations for each language from your admin panel to edit them and make them as accurate as you want.
* And even if you **modify the text on your blog** or don't have custom translations saved, LinGO will automatically pull and display the best translations available from Google.

== Installation ==

Getting started with LinGO is simple. Just follow these 3 easy steps:

1. Enable LinGO on your [registered Ackuna account](http://ackuna.com/lingo).
1. **Add your blog's URL** to your account and pick your language options.
1. **Install the LinGO plugin** on your WordPress blog and enter your username.

If you are using any caching plugins, such as WP Super Cache, you will need to clear your cached pages after installing LinGO.

By using the LinGO Translation plugin, you agree to its terms and conditions as outlined during the signup process at Ackuna, and that the plugin may make external AJAX requests, link back to the LinGO website, and offload any required files from the LinGO server for required functionality and to keep the update process as simple as possible.

== Screenshots ==

1. The LinGO button's default state.
2. Easy language selection via dropdown.
3. The completed translation.
4. Viewing statistics and other data from the admin panel.
5. Editing the site's translations.

== Changelog ==

= 1.2.0 =
* Now loading all scripts over HTTPS.

= 1.1.0 =
* Updated some paths for remotely-loaded files.

= 1.0.0 =
* Initial launch!

== Upgrade Notice ==

= 1.1.0 =
* Scripts are now loaded over HTTPS.

= 1.1.0 =
* Paths for required CSS files updated.

= 1.0.0 =
* Initial launch!

== Frequently Asked Questions ==

= When will you be adding support for new languages? =

Since the button uses Google Translate as a backup service for new text, we try to keep our language options in sync with their service. Once Google does add a new language, we try to add support for that language as quickly as possible.

= Google Translate added a new language, and it's not available through LinGO Translation. Why is that? =

When Google Translate adds a new language it is not automatically available through LinGO. This is because we must make internal changes to our plugin script telling it the language is available and how to handle it, as well as adding appropriate flag images for that language, etc. We make every effort to keep the plugin's available language list as up to date as possible.