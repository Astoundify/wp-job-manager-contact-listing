=== WP Job Manager - Contact Listing ===

Author URI: http://astoundify.com
Plugin URI: https://wordpress.org/plugins/wp-job-manager-contact-listing/
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=contact@appthemer.com&item_name=Donation+for+Astoundify WP Job Manager Contact Listing
Contributors: spencerfinnell
Tags: job, job listing, job apply, gravity forms, wp job manager, gravity forms, gravityforms, ninja forms, ninjaforms, contact form 7, cf7
Requires at least: 3.5
Tested up to: 3.9.1
Stable Tag: 1.0.2
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Allow sites using the WP Job Manager plugin to contact listings via their favorite form builder plugin.

== Description ==

Sites using the [WP Job Manager](http://wordpress.org/plugins/wp-job-manager/) plugin can use any of the supported plugins and allow visitors to contact the connected application email (or resume author) directly.

**Supported Form Plugins**

* Gravity Forms
* Ninja Forms
* Contact Form 7

= Where can I use this? =

Astoundify has released the first fully integrated WP Job Manager theme. Check out ["Jobify"](http://themeforest.net/item/jobify-job-board-wordpress-theme/5247604?ref=Astoundify)

The plugin can also be used on any theme but no extra styling (outside the CSS that comes with the form plugins) is used.

== Frequently Asked Questions ==

= What settings do I need for Gravity Forms? =

**Video Tutorial:** https://vimeo.com/85469722/

You **must** create a *hidden* field with the following specific settings:

* **Label:** Listing ID
* **Allow field to be dynamically populated:** `{entry_id}`

The Job/Resume listing must also have an email address associated with it, not a URL to a website.

**Next**, create a new form notification with the "Send To" field set to "Email" and "no-reply@listingowner.com" as the value.

= What settings do I need for Ninja Forms? =

**Video Tutorial:** https://vimeo.com/89439524/

You **must** create a *hidden* field with the following specific settings:

* **Label:** `Listing ID`
* **Default Value:** `Post/Page ID (if available)`

The Job/Resume listing must also have an email address associated with it, not a URL to a website.

In "Administrator Email Settings" add a *dummy* email address as the first email to send a notification to. You can add real email addresses under this if you do need an actual admin confirmation.

= What settings do I need for Contact Form 7? =

No special settings needed.

= I am using Jobify and it's not working =

**Please make sure you have the latest version of Jobify from ThemeForest**

If you have purchased Jobify and still have questions, please post on our dedicated support forum: http://support.astoundify.com

== Installation ==

1. Install and Activate
2. Go to "Job Listings > Settings" and choose the forms you would like to use.
3. Visit the FAQ for specifics on each form plugin.

== Changelog ==

= 1.0.2: August 5, 2014 =

* Fix: Make sure the correct instance of Contact Form 7 submission form is always found.
* Fix: Update README to reflect new field settings.

= 1.0.1: July 24, 2014 =

* Fix: Update for compatibility with older PHP versions to avoid errors.

= 1.0.0: July 23, 2014 =

* First official release!
