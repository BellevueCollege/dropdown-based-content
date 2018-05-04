# Dropdown Based Content
Display content based on combobox selection

## Shortcodes
This plugin uses a rather complex shortcode structure to create the dropdown box and associated content. 

The following shortcodes and attributes are available:

* `[dbc label="Label Text"] ... [/dbc]`
   * Should surround the entire area. `label` attribute is used to set the combobox label. 
* `[dbc_options button="Button Text" placeholder="Text Area Placeholder"] ... [/dbc_options]`
   * Should surround options in dropdown. Placeholder text appears in text area (entry hints, etc), and the button text appears in the main submit button.
* `[dbc_option title="Option Title" content_id="target-id" /]`
   * Each option in the comboxbox is created with a dbc_option shortcode. It is self-closing, and does not need a closing shortcode. Title will display in the dropdown, as the option available for selection. The content_id needs to match the ID set on one of the `[dbc_content]` shortcodes.
* `[dbc_content id="unique-id"] ... [/dbc_content]`
   * Should be inside of the main `[dbc]` tag, but not inside of `[dbc_options]`. Each one should have a **unique** ID set, which should be lowercase, and not contain spaces or special characters. All content to display should be contained in one of these. 

### Example implementation
```
[dbc label="Select a type of fruit"]
  [dbc_options placeholder="Search or Select" button="Go!"]
    [dbc_option title="Red Apples" content_id="red-apple" /]
    [dbc_option title="Green Apples" content_id="green-apple" /]
    [dbc_option title="Oranges" content_id="orange" /]
    [dbc_option title="Kiwis" content_id="kiwi" /]
  [/dbc_options]

  [dbc_content id="red-apple"]

    Red apples can be okay, but green apples are better!

  [/dbc_content]
  [dbc_content id="green-apple"]

    Green apples are very tasty!

  [/dbc_content]
  [dbc_content id="orange"]

    Oranges are good in season!

  [/dbc_content]
  [dbc_content id="kiwi"]

    Kiwis are very soft, and bruise easily...

  [/dbc_content]
[/dbc]
```

## Gutenberg
This project's Gutenberg functionality is based on [Ahmad Awais's Create Guten Block framework](https://github.com/ahmadawais/create-guten-block).

Available commands as part of this are:
* `npm start` - Watch folders and compile
* `npm run build` - Compile for production use

`npm install` should be used to set up this project. Node and NPM are required.