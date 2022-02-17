
# FormsBootstrap

[By Sébastien L'haire](http://sebastien.lhaire.org)

A Laravel library to generate forms based on Laravel Collective [Forms & HTML](https://laravelcollective.com/docs/6.0/html), [Boostrap](https://getbootstrap.com/) 5 CSS Framework. RichText editor, and  Icons provided by [FontAwesome](https://fontawesome.com/)

# Installation

composer require seblhaire/formabootstrap

Add in config/app.php
```php
  'providers' => [
Collective\Html\HtmlServiceProvider::class,
Seb\FormsBootstrap\FormsBootstrapServiceProvider::class,
]
```
JQuery.
Install Bootstrap. Install FontAwesome

You can publish templates, config file, translation files, and/or js file in case you need to modifiy it.

``` sh
$ php artisan vendor:publish
```
NB: js file can be either packed in Webpack files or published in public directory.

# Javascript ans stylesheets

On a webpage, every JS library and CSS stylesheets can be linked separately. If you choose this classical way, first dowload and install above mentioned libraries or use Content Delivery Network (CDN) links as in the example page in last section. Then publish package files as explained above and put following tags in your template:

```html
<script type="text/javascript" src="formsbootstrap/js/seb.formsbootstrap.js"></script>
```

But websites often use many libraries and stylesheets and browser must download many files before the site can be rendered properly. Modern websites come with a single compressed Javascript file which concatenates necessary scripts; same principle for stylesheets. With Laravel you can use [Laravel Mix](https://github.com/JeffreyWay/laravel-mix) to compile files.

Use [NPM](https://www.npmjs.com/) package manager :
`npm install bootstrap jquery @fortawesome/fontawesome-free`

Then your js source file should be something like this:

```js
global.jQuery = require('jquery');
var $ = global.jQuery;
var jQuery = global.JQuery;
window.$ = $;
window.jQuery = jQuery;
require('bootstrap');
require('../../vendor/seblhaire/formsbootstrap/js/seb.formsbootstrap.js');

```
For your stylesheet:

```css
@import '~bootstrap/scss/bootstrap';
@import "~@fortawesome/fontawesome-free/scss/fontawesome";
@import "~@fortawesome/fontawesome-free/scss/regular";
@import "~@fortawesome/fontawesome-free/scss/solid";
@import "~@fortawesome/fontawesome-free/scss/brands";
```
# Config files

Accessible through

```php
config('formsbootstrap')
```

Section `formsbootstrap.mandatory` gives mandatory parameters for each form tag, whereas `formsbootstrap.defaults` contains default parameters.
 If you need eg. define your own classes  or define your own translation files, this is where you can change it.

# Translation keys

Laravel loads config files very early in process. Therefore config files cannot contain `__('translation.key')`. Therefore, we made an helper either to print directly strings or to send translation key to translation helper. Translation keys can be delimited by character #- Ex: `"#formsbootstrap::messages.required#"`.

In templates, helper is called by eg: `FormsBootstrapUtils::translateOrPrint($data['oldpass']['labeltext']);`

# FORM

```php
Form::bsOpen(array $data)
Form::bsClose();
```
Prints and end `<form>` tag and add hidden token.

## Parameters

* `data` array parameter
	* `id`: **mandatory** form id tag.
	* `action`: route to form script. Default `null`.
	* `validate`: add validation to form. Default: `true`.
	* `class`: css class(es). Default: empty.
	* `options`: additional options. Default: `[]`

# INPUT HIDDEN
```php
Form::hidden(string $id, int|string $value, (int|string[] $options))
```

Prints  `<input type="hidden">`

## Parameters:

* `id`: **mandatory** name of field.
* `value`: **mandatory** string or numeral values.
* `options`: array of values to be added to input.

# INPUT TEXT

```php
Forms::bsText(array $data)
```

Prints `<input type="text">`

## Parameters

* `data`: array parameter. Content:
  * `name`: **mandatory** id and name of input.
  * `labeltext`: **mandatory** label of input.
  * `value`: prefilled value in input. Default `null`.
  * `required`: the input must be filled to validate form. Default `false`.
  * `input_in_div`: sets if label and input should be contained in a `<div>`. Default `true`.
  * `divclass`: class to be added to div tag containing label and input. Default: `"mb-3"`. Not useful if parameter `input_in_div` is false.
  * `helptext`: text to help, to be inserted above field. Default: empty string.
  * `inputclass`: class of input tag. Default `"form-control"`.
  * `labelclass`: class of label tag. Default `"form-label"`.
  * `attributes`: array of input tag attributes to be added to default ones, Default: empty array.
  * `labelattributes`: array of label tag attributes to be added to default ones. Default: empty array.
  * `invalid-feedback`: text to be displayed if mandatory input is not filled. Default: translation key `formsbootstrap::messages.required`: "This field is required".
  * `valid-feedback`: text to be displayed if mandatory input is filled. Default: empty string.

# TEXTAREA

```php
Forms::bsTextarea(array $data)
```
Prints `<textarea>`

## Parameters

* `data`: array parameter. Content:
  * `name`: **mandatory** id and name of input.
  * `labeltext`: **mandatory** label of input.
  * `value`: prefilled value in input. Default `null`.
  * `required`: the input must be filled to validate form. Default `false`.
  * `input_in_div`: sets if label and input should be contained in a `<div>`. Default `true`.
  * `divclass`: class to be added to div tag containing label and input. Default: `"mb-3"`. Not useful if parameter `input_in_div` is false.
  * `helptext`: text to help, to be inserted above field. Default: empty string.
  * `inputclass`: class of input tag. Default `"form-control"`.
  * `labelclass`: class of label tag. Default `"form-label"`.
  * `attributes`: array of input tag attributes to be added to default ones, Default: empty array.
  * `labelattributes`: array of label tag attributes to be added to default ones. Default: empty array.
  * `invalid-feedback`: text to be displayed if mandatory input is not filled. Default: translation key `formsbootstrap::messages.required`: "This field is required".
  * `valid-feedback`: text to be displayed if mandatory input is filled. Default: empty string.

# INPUT EMAIL

```php
Forms::bsEmail(array $data)
```
Prints `<input type="email">`

## Parameters


* `data`: array parameter. Content:
  * `name`: id and name of input. Default `"email"`.
  * `labeltext`:  label of input. Default, content of translation key `formsbootstrap::messages.email`: "E-mail".
  * `value`: prefilled value in input. Default `null`.
  * `required`: the input must be filled to validate form. Default `false`.
  * `input_in_div`: sets if label and input should be contained in a `<div>`. Default `true`.
  * `divclass`: class to be added to div tag containing label and input. Default: `"mb-3"`. Not useful if parameter `input_in_div` is false.
  * `helptext`: text to help, to be inserted above field. Default: empty string.
  * `inputclass`: class of input tag. Default `"form-control"`.
  * `labelclass`: class of label tag. Default `"form-label"`.
  * `attributes`: array of input tag attributes to be added to default ones, Default: empty array.
  * `labelattributes`: array of label tag attributes to be added to default ones. Default: empty array.
  * `invalid-feedback`: text to be displayed if mandatory input is not filled. Default: translation key `formsbootstrap::messages.required`: "This field is required".
  * `valid-feedback`: text to be displayed if mandatory input is filled. Default: empty string.
  * `email_regex`: regular expression used to verify password. Cf below. Set empty if
you don't want to verify email.

## Email verification

Email fields are automatically verified by regular expression. This expression can be found in `config('formsbootstrap.defaults.email,email_regex')`. It only verifies that a valid email address is used, but not that a mailbox exists and that the person who entered it in the form is a legal user.

To do so, in your main code, as in standard Laravel subscription method, you may verify this address by sending an email which contains a link to a callback function in your code. Then email address is validated since the user must have access to the mailbox to read the validation mail.

# INPUT PASSWORD

We offer two methods. The first one provides a simple `<input type="password">` whereas the second outputs a complete password change procedure, with (optional) old password, new password and password confirmation. Options also allow passwords to be displayed in clear and to generate a new password.

```php
Form::bsPassword(array $data)
Form::bsPasswordWithConfirm(array $data)
```
## Common parameters to both methods

* `invalid-feedback`: text to be displayed if mandatory input is not filled. Default: translation key `formsbootstrap::messages.required`: "This field is required".
* `valid-feedback`: text to be displayed if mandatory input is filled. Default: empty string.
* `input_in_div`: sets if label and input should be contained in a `<div>`. Default `true`.
* `divclass`: class to be added to div tag containing label and input. Default: `"mb-3"`. Not useful if parameter `input_in_div` is false.
* `helptext`: text to help, to be inserted above field. Default: empty string.


## Parameters of password alone

* `name`: field name and id. Default : `"password"`.
* `labeltext`:  label of input. By default: translation key `formsbootstrap::messages.password`: "Password".
* `required`: the input must be filled to validate form. Default `false`.
* `inputclass`: class of input tag. Default `"form-control"`.
* `labelclass`: class of label tag. Default `"form-label"`.
* `attributes`: array of input tag attributes to be added to default ones, Default: empty array.
* `labelattributes`: array of label tag attributes to be added to default ones. Default: empty array.

## Parameters of password with confirm

* `oldpass`: parameters for old password field. Content:
  * `name`: field name and id. Default: `"old_password"`.
  * `labeltext`:  label of input. By default, translation key `formsbootstrap::messages.old_password`: "Old password".
  * `inputclass`: class of input tag. Default `"form-control"`.
  * `labelclass`: class of label tag. Default `"form-label"`.
  * `attributes`: array of input tag attributes to be added to default ones, Default: empty array.
  * `labelattributes`: array of label tag attributes to be added to default ones. Default: empty array.
* `newpass`: parameters for new password field. Content:
  * `name`: field name and id. Default: `"password"`.
  * `labeltext`:  label of input. By default, translation key `formsbootstrap::messages.new_password`: "New password".
  * `inputclass`: class of input tag. Default `"form-control"`.
  * `labelclass`: class of label tag. Default `"form-label"`.
  * `attributes`: array of input tag attributes to be added to default ones, Default: empty array.
  * `labelattributes`: array of label tag attributes to be added to default ones. Default: empty array.
* `newpassclear`: parameters for new password field in clear. Content:
  * `name`: field name and id. Default: `"password-clear"`.
  * `inputclass`: class of input tag. Default `"form-control"`.
  * `attributes`: array of input tag attributes to be added to default ones, Default: empty array.
* `confirmpass`: parameters for confirm password field. Content:
  * `name`: field name and id. Default: `"password_confirmation"`.
  * `labeltext`:  label of input. By default, translation key `formsbootstrap::messages.confirm_password`: "Confirm Password".
  * `inputclass`: class of input tag. Default `"form-control"`.
  * `labelclass`: class of label tag. Default `"form-label"`.
  * `attributes`: array of input tag attributes to be added to default ones, Default: empty array.
  * `labelattributes`: array of label tag attributes to be added to default ones. Default: empty array.
* `pwdhiddenzone-id`: id of `<div>` containing the password hidden by dots. Default: `"password-hidden-div"`.
* `pwdclearzone-id`: id of `<div>` containing the password in clear. Default: `"password-clear-div"`.
* `show_old`: must show the field "old password". Default: `true`.
* `show_generate`: show the generate password button and the hide/show password button. Default `true`.
* `show_clear`: show the hide/show password button. Default: `true`. Value false works only
if `show_generate` option is also `false`.
* `pwdbtngroup-class`: class of inline buttons group in field "new-password". Default: `"input-group"`.
* `pwdbtn-class`: class of inline button in field "new-password". Default: `"input-group-append"`.
* `togglebtn-id`: id of button to show password. Default: `"toggle-pwd-btn"`.
* `togglebtn-id-clear`: id of button to hide password. Default: `"toggle-pwd-btn-clear"`,
* `togglebtn-class`: class of hide/show buttons. Default: `"btn btn-info"`.
* `toggledbtn-title`: content of hide/show button to be displayed on mouse hover. Default: translation key `"formsbootstrap::messages.display_pwd"`: "Display password".
* `toggledbtn-icon-on`: icon to button "show password". Default: `<i class="far fa-eye"></i>`. This icon is provided by Font Awesome package.
* `toggledbtn-icon-off`: icon to button "hide password". Default: `<i class="far fa-eye-slash"></i>`. This icon is provided by Font Awesome package
* `generatepwdbtn-id`: id of "Generate password" button in hidden password field. Default: `"generate-pwd-btn"`.
* `generatepwdbtn-id-clear`: id of "Generate password" button in clear password field. Default: `generate-pwd-btn-clear"`.
* `generatepwdbtn-class`: class of "Generate password" button. Default: `"btn btn-outline-secondary"`,
* `generatepwdbtn-lbl`: text of "Generate password" button. Default translation key: `formsbootstrap::messages.generate`: "Generate".
* `generatepwdbtn-title`: title of "Generate password" button to be displayed on mouse hover. Default translation key: `formsbootstrap::messages.generate_long`: "Generate new password".

# SELECT

```php
Forms::bsSelect(array $data)
```
Prints `<select><option>`

# Parameters

* `data`: array parameter. Content:
  * `name`: **mandatory** id and name of input.
  * `values`: array of options (key => values).
  * `default`: key of default value.
  * `input_in_div`: sets if label and input should be contained in a `<div>`. Default `true`.
  * `divclass`: class to be added to div tag containing label and input. Default: `"mb-3"`. Not useful if parameter `input_in_div` is false.
  * `helptext`: text to help, to be inserted above field. Default: empty string.
  * `inputclass`: class of input tag. Default `"form-control"`.
  * `labelclass`: class of label tag. Default `"form-label"`.
  * `attributes`: array of input tag attributes to be added to default ones, Default: empty array.
  * `labelattributes`: array of label tag attributes to be added to default ones. Default: empty array.
  * `invalid-feedback`: text to be displayed if mandatory input is not filled. Default: translation key `formsbootstrap::messages.required`: "This field is required".
  * `valid-feedback`: text to be displayed if mandatory input is filled. Default: empty string.

# INPUT CHECKBOX

```php
Forms::bsCheckbox(array $data)
```
Prints  `<input type="checkbox">`

## Parameters

* `data`: array parameter. Content:
  * `name`: **mandatory** id and name of input.
  * `values`: **mandatory** array of options (key => values).
  * `checkedvalue`: value to be checked. Default `null`.
  * `required`: the input must be filled to validate form. Default `false`.
  * `attributes`: array of input tag attributes to be added to default ones, Default: empty array.
  * `mainlabel`: label including all checkbox inputs
  * `mainlabelclass`: class of main label. Default: `"form-label"`
  * `inputclass`: class of input tag. Default `"form-control"`.
  * `labelclass`: class of label tag. Default `"form-label"`.
  * `mainattr`: array of attributes of main div. Default: empty array.
  * `invalid-feedback`: text to be displayed if mandatory input is not filled. Default: translation key `formsbootstrap::messages.required`: "This field is required".
  * `valid-feedback`: text to be displayed if mandatory input is filled. Default: empty string.
  * `divclass`: main `<div>` class. Default: `"mb-3"`
  * `divelt`: `<div>` class including each input. Default: `"form-check form-check-inline"`.

# INPUT RADIO
```php
Forms::bsRadio(array $data)
```

Prints `<input type="radio">`

## Parameters

* `data`: array parameter. Content:
  * `name`: **mandatory** id and name of input.
  * `values`: **mandatory** array of options (key => values).
  * `checkedvalue`: value to be checked. Default `null`.
  * `required`: the input must be filled to validate form. Default `false`.
  * `attributes`: array of input tag attributes to be added to default ones, Default: empty array.
  * `mainlabel`: label including all radio inputs
  * `mainlabelclass`: class of main label. Default: `"form-label"`
  * `inputclass`: class of input tag. Default `"form-control"`.
  * `labelclass`: class of label tag. Default `"form-label"`.
  * `mainattr`: array of attributes of main div. Default: empty array.
  * `invalid-feedback`: text to be displayed if mandatory input is not filled. Default: translation key `formsbootstrap::messages.required`: "This field is required".
  * `valid-feedback`: text to be displayed if mandatory input is filled. Default: empty string.
  * `divclass`: main `<div>` class. Default: `"mb-3"`
  * `divelt`: `<div>` class including each input. Default: `"form-check form-check-inline"`.

# INPUT SUBMIT

```php
Forms::bsSubmit(array $data)
```

Prints `<input type="submit">`

## Parameters

* `data`: array parameter. Content:
  * `id`: id of input. Default: `"submit"`
  * `label`: button text. Default: translation key `formsbootstrap::messages.send`: "Send".
  * `class`: button class. Default: `"btn btn-primary"`.
  * `attributes`: array of input tag attributes to be added to default ones, Default: empty array.

# INPUT BUTTON

```php
Forms::bsButton(array $data)
```
Prints `<input type="button">`

## Parameters

* `data`: array parameter. Content:
  * `id`: **mandatory**. id and name of input.
  * `label`: **mandatory**. Button label.
  * `class`: button class. Default: `"btn btn-default"`.
  * `attributes`: array of input tag attributes to be added to default ones, Default: empty array.
