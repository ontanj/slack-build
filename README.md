# Build

A helper for constructing messages to send to Slack through integrations. Build is a static class that helps you add the parts of your message in the right way. Pass an empty array to start building. Before sending it back to Slack you need to convert it to json using for example `json_encode()`.

## Installation

`composer require ontanj/slack-build`


## Usage 

The static class is called Build and are located in the namespace `SlackBuild`.

To start building your message you pass an empty array to the desired function. The array is passed by reference and everything is added as it goes.

Before sending it to Slack it needs to be converted to a json string, using for example `json_encode()`.

### Available functions 
```
/**
 * Adds an attachment to the message
 * @param array $data message to add the attachment to
 * @param string $fallback message to show if display is unavailable
 * @param string $callback_id id for interactive messages
 * @return int index of added attachment
 */
public static function add_attachment(array &$data, string $fallback, string $callback_id=null) : int

/**
 * Adds a button to a message
 * @param array $data message to add the button to
 * @param int $att_index index of the attachment to add to
 * @param string $name identifiable name for the button
 * @param string $text text shown on the button
 */
public static function add_button(array &$data, int $att_index, string $text, string $name)

/**
 * Adds a field to message
 * @param array $data message to add the field to
 * @param int $att_index index of the attachment to add to
 * @param string $title title of the field
 * @param string $value value of the field
 * @param bool $short whether the field should be short, true for short
 */
public static function add_field(array &$data, int $att_index, string $title, string $value, bool $short=true)

/**
 * Adds a list menu to a message
 * @param array $data message to add the menu to
 * @param int $att_index index of the attachment to add the menu to
 * @param string $name identifiable name for the menu
 * @param string $text text for the menu
 * @return int index of added menu
 */
public static function add_menu(array &$data, int $att_index, string $text, string $name) : int

/**
 * Adds a full list to a list menu, using the text also as value
 * @param array $data message to add the list to
 * @param int $att_index index of the attachment to add to
 * @param int $act_index index of the menu to add to
 * @param array $list array with list entries as element
 */
public static function add_menu_list(array &$data, int $att_index, int $act_index, array $texts, array $values)

/**
 * Adds an option to a list menu
 * @param array $data message to add the option to
 * @param int $att_index index of the attachment to add to
 * @param int $act_index index of the menu to add to
 * @param string $text text of the option
 * @param string $value key of the option
 */
public static function add_menu_option(array &$data, int $att_index, int $act_index, string $text, string $value)

/**
 * Adds a color to an attachment
 * @param array $data message to add the color to
 * @param int $att_index index of the attachment to add the color to
 * @param string $color the color, coded as hex-color with hashtag "#FFFFFF" or 
 * using predefined constants
 */
public static function attachment_color(array &$data, int $att_index, $color=self::random)

/**
 * Adds an attachment text to a message
 * @param array $data message to add the attachment text to
 * @param int $att_index index of the attachment to add to
 * @param string $title
 */
public static function attachment_text(array &$data, int $att_index, string $text)

/**
 * Adds an attachment title to a message
 * @param array $data message to add the attachment title to
 * @param int $att_index index of the attachment to add to
 * @param string $title
 */
public static function attachment_title(array &$data, int $att_index, string $title)

/**
 * Gets one of predefined constant colors
 * @param int $color
 * @return string
 */
private static function get_color(int $color)

/**
 * Adds top-level text to a message
 * @param array $data array to add the text to
 * @param string $text
 */
public static function message_text(array &$data, string $text)

/**
 * Sets the message to replace the original posted message 
 * @param array $data message to set
 * @param bool $replace true is replace, false is don't replace
 */
public static function replace_original(array &$data, bool $replace)

/**
 * Sets the message to delete the original message and post as new
 * @param array $data message to se
 * @param bool $delete true is delete, false is don't
 */
public static function delete_original(array &$data, bool $delete)
```
### Predefined colors

```
const random = 0;
const black = 1;
const white = 2;
const yellow = 3;
const blue = 4;
const green = 5;
const red = 6;
```
