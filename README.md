# Newsletter subscribe plugin - NSP
## Why this?
As many people I wanted to create a newsletter to engage with a community im looking forward to create. This normally needs a form to subscribe and provider usually give you one to embed in your web (allowing 0 configurations or behind a paywall)

Here is were I had one of those 'Aja!' moments that people talk about and decide that I could build a configurable form that people can use free to connect to their providers API.

## How to use it.
1. Download de zip file
2. Upload it in the plugin section
3. Configure plugin using the settings view (HIGLY recommended to configure some css)
4. Add the form where you want it to show using the shortcode `[NSP-form]`

## Custom css
The for os wrapped by a `<div>` so that you have more control over it.
The ids for the css selectors are:
* newsletterSubscribeContainer
* newsletterSubscribeForm
* newsletterSubscriptionEmail
* newsletterSubscribeButton
* newsletterSubscribeMessage


## Current version.
### v0.1-beta
This version is stable in the way that you can configure your **API url, the API key and custom css**.
The current form state is quite ugly. You have to make it look good using css.
