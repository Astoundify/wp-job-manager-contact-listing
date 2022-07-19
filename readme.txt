=== Contact Listing for WP Job Manager ===
Author URI: http://astoundify.com
Plugin URI: https://astoundify.com/products/wp-job-manager-contact-listing/
Donate link: https://www.paypal.me/astoundify
Contributors: Astoundify
Tags: job, job listing, job apply, gravity forms, wp job manager, gravity forms, gravityforms, ninja forms, ninjaforms, contact form 7, cf7
Requires at least: 4.7.0
Tested up to: 6.0.1
Stable Tag: 1.4.3
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
* **Allow field to be dynamically populated:** `{embed_post:ID}`

The Job/Resume listing must also have an email address associated with it, not a URL to a website.

**Next**, create a new form notification with the "Send To" field set to "Email" and "no-reply@listingowner.com" as the value. Fill the body with the information you want to send to the listing owner.

= What settings do I need for Ninja Forms? =

**Video Tutorial:** https://vimeo.com/89439524/

You **must** create a *hidden* field with the following specific settings:

* **Label:** `Contact Email`
* **Default Value:** `{contact-email}`

The Job/Resume listing must also have an email address associated with it, not a URL to a website.

**Next**, create a new form *email* notification with the "To" field set to the value of the **Contact Email** hidden field you created. Fill the body with the information you want to send to the listing owner.

= What settings do I need for Contact Form 7? =

No special settings needed.

= I am using Jobify and it's not working =

**Please make sure you have the latest version of Jobify from ThemeForest**

If you have purchased Jobify and still have questions, please post on our dedicated support forum: http://support.astoundify.com

== Installation ==

1. Install and Activate
2. Go to "Job Listings > Settings" and choose the forms you would like to use.
3. Visit the FAQ for specifics on each form plugin.

== Our Products ==

If you like this plugin, consider exploring our other themes and plugins:

* [Appointify](https://wordpress.org/plugins/appointify/) Appointify App, is the first Appointments Planner for WordPress, for Busy Enterpreneurs and Founders. Appointify allows you to share your calendar and have your funnel start by others planning appointments on top of it – with their own calendar authorized.

* [Regions for WP Job Manager](https://wordpress.org/plugins/wp-job-manager-locations/) Adds a “Job Region” taxonomy so the site administrator can control a set of predefined regions listings can be assigned to.

* [Job Colors for WP Job Manager](https://wordpress.org/plugins/wp-job-manager-colors/) Select the color of each existing job type in the Job Listings’ settings. Can set the color to be the background color, or text color.

* [WP Job Manager – Company Profiles](https://wordpress.org/plugins/wp-job-manager-companies/) Outputs a list of all companies that have submitted jobs with links to their listings and profile.

* [WP Modal Popup with Cookie Integration](https://wordpress.org/plugins/wp-modal-popup-with-cookie-integration/) Create and manage powerful promotion popups for your WordPress blog or website. Easy to use popup plugin that will help you to grab your visitor’s attention to introduce him offers, discounts or other kind of promotional notices.

* [Simple Registration for WooCommerce](https://wordpress.org/plugins/woocommerce-simple-registration/) A simple plugin to add a [woocommerce_simple_registration] shortcode to display the registration form on a separate page.

* [Elementify Visual Widgets](https://wordpress.org/plugins/elementify-visual-widgets/) Elementify Visual Widgets is a free plugin packed with stunning elements to extend Elementor Page Builder functionality and make your website look like it is designed by a Professional Web Designer.

* [Easy Digital Downloads – Frontend Submissions Product Details](https://wordpress.org/plugins/easy-digital-downloads-frontend-submissions-product-details-widget/) Specify and display frontend submission data as “product details” in a widget.


* [Simple Social Login](https://wordpress.org/plugins/simple-social-login/) Social login options for WordPress. Currently supports: Facebook, Twitter, Google.

* [reCAPTCHA](https://wordpress.org/plugins/astoundify-recaptcha/) Google reCAPTCHA for WordPress. Currently supports: WordPress Login/Register, WooCommerce Login/Register, WP Job Manager (Submission Form), Claim Listing for WP Job Manager, Gravity Forms, Ninja Forms, Contact Form 7.

== Changelog ==

= 1.4.3: July 19, 2022 =

* Update: Compatibility check with latest WordPress v6.0.1.
* Update: Compatibility check with latest WP Job Manager v1.36.2.

= 1.4.2: May 10, 2022 =

* Update: Compatibility check with latest WordPress v5.9.3.

= 1.4.1: November 25, 2020 =

* Update: Compatibility check with latest WordPress v5.5.3.
* Update: Compatibility check with Latest WP Job Manager v1.34.3.
* Update: Compatibility check with the latest PHP v7.4.10.

= 1.4.0: April 12, 2017 =

* New: Update README

= 1.3.0: September 29, 2016 =

* New: Ninja Forms THREE merge tag for routing emails to the listing or candidate email address. Update your existing hidden field with the merge tag {contact-email} and update your "To" email notification field to be the value of your hidden field.

See: http://docs.astoundify.com/article/81-ninja-form 

= 1.2.3: September 12, 2016 = 

* Ninja Forms compatibility.

= 1.2.2: June 22, 2016 = 

* Ninja Forms compatibility.

= 1.2.1: June 21, 2016 = 

* Ninja Forms compatibility.

= 1.2.0: June 16, 2016 = 

* Ninja Forms compatibility.

= 1.1.0: February 25, 2016 =

* New: Fall back to the listing owner's user account email if no `_application` field value exists.

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
