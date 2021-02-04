<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package filter_vimeoresponsive
 * @author Andrew Hancox <andrewdchancox@googlemail.com>
 * @author Open Source Learning <enquiries@opensourcelearning.co.uk>
 * @link https://opensourcelearning.co.uk
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright 2021, Andrew Hancox
 */

defined('MOODLE_INTERNAL') || die();

class filter_vimeoresponsive extends moodle_text_filter {

    /**
     * Apply the filter to the text
     *
     * @param string $text to be processed by the text
     * @param array $options filter options
     * @return string text after processing
     * @see filter_manager::apply_filter_chain()
     */
    public function filter($text, array $options = array()) {
        if (strpos($text, '{vimeoresponsive_') === false) {
            return $text;
        }

        $matches = [];

        preg_match_all('#{vimeoresponsive_([0-9]+)}#', $text, $matches);
        $results = array_combine($matches[0], $matches[1]);

        foreach ($results as $placeholder => $vimeoid) {
            $text = str_replace("{vimeoresponsive_$vimeoid}", $this->render($vimeoid), $text);
        }

        return $text;
    }

    public function render($vimeoid) {
        return "<div class='resp-container'><iframe class='resp-iframe' src='https://player.vimeo.com/video/$vimeoid' width='426' height='240' frameborder='0' allow='autoplay; fullscreen; picture-in-picture' allowfullscreen=''></iframe></div>";
    }
}
