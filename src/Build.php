<?php

/**
 * Creates the array needed for input to slack
 * 
 * @author Anton Jeppsson (ontanj)
 *
 */

namespace SlackBuild;

class Build {
    
    /**
     * Predefined colors
     */
    const random = 0;
    const black = 1;
    const white = 2;
    const yellow = 3;
    const blue = 4;
    const green = 5;
    const red = 6;
    
    /**
     * Adds top-level text to a message
     * @param array $data array to add the text to
     * @param string $text
     */
    public static function message_text(array &$data, string $text) {
        $data["text"] = $text;
    }
    
    /**
     * Adds an attachment to the message
     * @param array $data message to add the attachment to
     * @param string $fallback message to show if display is unavailable
     * @param string $callback_id id for interactive messages
     * @return int index of added attachment
     */
    public static function add_attachment(array &$data, string $fallback, string $callback_id=null) : int {
        if (!isset($callback_id)) {
            $data["attachments"][] = Array(
                "fallback" => $fallback
                );
        } else {
            $data["attachments"][] = Array(
                "fallback" => $fallback,
                "callback_id" => $callback_id
                );
        }
        return count($data["attachments"])-1;
    }
    
    /**
     * Adds an attachment title to a message
     * @param array $data message to add the attachment title to
     * @param int $att_index index of the attachment to add to
     * @param string $title
     */
    public static function attachment_title(array &$data, int $att_index, string $title) {
        $data["attachments"][$att_index]["title"] = $title;
    }
    
    /**
     * Adds an attachment text to a message
     * @param array $data message to add the attachment text to
     * @param int $att_index index of the attachment to add to
     * @param string $title
     */
    public static function attachment_text(array &$data, int $att_index, string $text) {
        $data["attachments"][$att_index]["text"] = $text;
    }
    
    /**
     * Adds a button to a message
     * @param array $data message to add the button to
     * @param int $att_index index of the attachment to add to
     * @param string $name identifiable name for the button
     * @param string $text text shown on the button
     */
    public static function add_button(array &$data, int $att_index, string $text, string $name) {
        $data["attachments"][$att_index]["actions"][] = 
            Array(
                "name" => $name,
                "text" => $text,
                "type" => "button");
    }
    
    /**
     * Adds a field to message
     * @param array $data message to add the field to
     * @param int $att_index index of the attachment to add to
     * @param string $title title of the field
     * @param string $value value of the field
     * @param bool $short whether the field should be short, true for short
     */
    public static function add_field(array &$data, int $att_index, string $title, string $value, bool $short=true) {
        if (empty($data["attachments"][$att_index]["fields"])) {
            $key = 0;
        } else {
            $key = count($data["attachments"][$att_index]["fields"]);
        }
        $data["attachments"][$att_index]["fields"][$key]["title"] = $title;
        $data["attachments"][$att_index]["fields"][$key]["value"] = $value;
        $data["attachments"][$att_index]["fields"][$key]["short"] = $short;
    }
    
    /**
     * Adds a list menu to a message
     * @param array $data message to add the menu to
     * @param int $att_index index of the attachment to add the menu to
     * @param string $name identifiable name for the menu
     * @param string $text text for the menu
     * @return int index of added menu
     */
    public static function add_menu(array &$data, int $att_index, string $text, string $name) : int {
        $data["attachments"][$att_index]["actions"][] = 
            Array(
                "name" => $name,
                "text" => $text,
                "type" => "select"
            );
            return count($data["attachments"][$att_index]["actions"]) - 1;
    }
    
    /**
     * Adds a full list to a list menu, using the text also as value
     * @param array $data message to add the list to
     * @param int $att_index index of the attachment to add to
     * @param int $act_index index of the menu to add to
     * @param array $list array with list entries as element
     */
    public static function add_menu_list(array &$data, int $att_index, int $act_index, array $texts, array $values) {
	$index = 0;
        foreach ($texts as $text) {
            self::add_menu_option($data, $att_index, $act_index, $text, $values[$index++]);
        }
    }
    
    /**
     * Adds an option to a list menu
     * @param array $data message to add the option to
     * @param int $att_index index of the attachment to add to
     * @param int $act_index index of the menu to add to
     * @param string $text text of the option
     * @param string $value key of the option
     */
    public static function add_menu_option(array &$data, int $att_index, int $act_index, string $text, string $value) {
        if (empty($data["attachments"][$att_index]["actions"][$act_index]["options"])) {
            $key = 0;    
        } else {
            $key = count($data["attachments"][$att_index]["actions"][$act_index]["options"]);
        }
        $data["attachments"][$att_index]["actions"][$act_index]["options"][$key]["text"] = $text;
        $data["attachments"][$att_index]["actions"][$act_index]["options"][$key]["value"] = $value;
    }
    
    /**
     * Adds a color to an attachment
     * @param array $data message to add the color to
     * @param int $att_index index of the attachment to add the color to
     * @param string $color the color, coded as hex-color with hashtag "#FFFFFF" or 
     * using predefined constants
     */
    public static function attachment_color(array &$data, int $att_index, $color=self::random) {
        if (is_int($color)) {
            $color = self::get_color($color);
        } elseif (!is_string($color)) {
            $color = self::get_color(self::random);
            trigger_error("Unvalid data type");
        }
        $data["attachments"][$att_index]["color"] = $color;
    }
    
    /**
     * Gets one of predefined constant colors
     * @param int $color
     * @return string
     */
    private static function get_color(int $color) {
        switch ($color) {
            case self::red:
                $color = "#FF0000";
                break;
            case self::blue:
                $color = "#0000FF";
                break;
            case self::green:
                $color = "#008000";
                break;
            case self::yellow:
                $color = "#FFFF00";
                break;
            case self::black:
                $color = "#000000";
                break;
            case self::white:
                $color = "#FFFFFF";
                break;
            case self::random:
                $color = "#".dechex(rand(0,16777216));
                break;
        }
        return $color;
    }
    
    /**
     * Sets the message to replace the original posted message 
     * @param array $data message to set
     * @param bool $replace true is replace, false is don't replace
     */
    public static function replace_original(array &$data, bool $replace) {
        $data["replace_original"] = $replace;
    }
    
    /**
     * Sets the message to delete the original message and post as new
     * @param array $data message to se
     * @param bool $delete true is delete, false is don't
     */
    public static function delete_original(array &$data, bool $delete) {
        $data["delete_original"] = $delete;
    }
}
