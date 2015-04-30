=== WP Job Manager - Contact Listing ===

Author URI: http://astoundify.com
Plugin URI: https://wordpress.org/plugins/wp-job-manager-contact-listing/
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=contact@appthemer.com&item_name=Donation+for+Astoundify WP Job Manager Contact Listing
Contributors: Astoundify
Tags: job, job listing, job apply, gravity forms, wp job manager, gravity forms, gravityforms, ninja forms, ninjaforms, contact form 7, cf7
Requires at least: 4.1
Tested up to: 4.2.1
Stable Tag: 1.0.5
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

Astoundify has released two themes that are fully integrated with the WP Job Manager plugin. Check out ["Jobify"](http://themeforest.net/item/jobify-job-board-wordpress-theme/5247604?ref=Astoundify) and our WordPress Directory theme ["Listify"](http://themeforest.net/item/listify-wordpress-directory-theme/9602611?ref=Astoundify)

The plugin can also be used on any theme but no extra styling (outside the CSS that comes with the form plugins) is used.

== Frequently Asked Questions ==

= What settings do I need for Gravity Forms? =

**Video Tutorial:** https://vimeo.com/85469722/

You **must** create a *hidden* field with the following specific settings:

* **Label:** Listing ID
* **Allow field to be dynamically populated:** `{entry_id}`

The Job/Resume listing must also have an email address associated with it, not a URL to a website.

**Next**, create a new form notification with the "Send To" field set to "Email" and "no-reply@listingowner.com" as the value. Fill the body with the information you want to send to the listing owner.

= What settings do I need for Ninja Forms? =

**Video Tutorial:** https://vimeo.com/89439524/

You **must** create a *hidden* field with the following specific settings:

* **Label:** `Listing ID`
* **Default Value:** `Post/Page ID (if available)`

The Job/Resume listing must also have an email address associated with it, not a URL to a website.

**Next**, create a new form *email* notification with the "To" field set to "no-reply@listingowner.com". Fill the body with the information you want to send to the listing owner.

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

= 1.0.5: April, 9, 2015 =

* Fix: Don't override Contact Form 7 Mail (2) email notification.

= 1.0.4: September 16, 2014 =

* Fix: Compatibility with Ninja Forms 2.8.0+ notification system. Please review the README and documentation for changes needed.

= 1.0.3.1: August 12, 2014 =

* Fix: Make sure Ninja Forms add_action() abstract doesn't fail.

= 1.0.3: August 12, 2014 =

* Fix: Make sure Ninja Forms add_action() accepts all arguments

= 1.0.2: August 5, 2014 =

* Fix: Make sure the correct instance of Contact Form 7 submission form is always found.
* Fix: Update README to reflect new field settings.

= 1.0.1: July 24, 2014 =

* Fix: Update for compatibility with older PHP versions to avoid errors.

= 1.0.0: July 23, 2014 =

* First official release!
