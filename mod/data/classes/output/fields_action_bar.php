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

namespace mod_data\output;

use templatable;
use renderable;

/**
 * Renderable class for the action bar elements in the field pages in the database activity.
 *
 * @package    mod_data
 * @copyright  2021 Mihail Geshoski <mihail@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class fields_action_bar implements templatable, renderable {

    /** @var int $id The database module id. */
    private $id;

    /** @var \url_select $urlselect The URL selector object. */
    private $urlselect;

    /** @var \single_select|null $fieldselect The field selector object or null. */
    private $fieldselect;

    /** @var \single_button|null $saveaspresetbutton The save as preset single button object or null. */
    private $saveaspresetbutton;

    /** @var \single_button|null $exportpresetbutton The export preset single button object or null. */
    private $exportpresetbutton;

    /**
     * The class constructor.
     *
     * @param int $id The database module id
     * @param \url_select $urlselect The URL selector object
     * @param null $unused This parameter has been deprecated since 4.0 and should not be used anymore.
     * @param \single_button|null $saveaspresetbutton The save as preset single button object or null
     * @param \single_button|null $exportpresetbutton The export preset single button object or null
     * @param \action_menu|null $fieldselect The field selector object or null
     */
    public function __construct(int $id, \url_select $urlselect, $unused = null,
            ?\single_button $saveaspresetbutton = null, ?\single_button $exportpresetbutton = null,
            ?\action_menu $fieldselect = null) {

        if ($unused !== null) {
            debugging('Deprecated argument passed to fields_action_bar constructor', DEBUG_DEVELOPER);
        }

        $this->id = $id;
        $this->urlselect = $urlselect;
        $this->fieldselect = $fieldselect;
        $this->saveaspresetbutton = $saveaspresetbutton;
        $this->exportpresetbutton = $exportpresetbutton;
    }

    /**
     * Export the data for the mustache template.
     *
     * @param \renderer_base $output The renderer to be used to render the action bar elements.
     * @return array
     */
    public function export_for_template(\renderer_base $output): array {

        $data = [
            'd' => $this->id,
            'urlselect' => $this->urlselect->export_for_template($output),
        ];

        if ($this->fieldselect) {
            $data['fieldselect'] = $this->fieldselect->export_for_template($output);
        }

        $data['saveaspreset'] = $this->saveaspresetbutton;

        if ($this->exportpresetbutton) {
            $data['exportpreset'] = $this->exportpresetbutton->export_for_template($output);
        }

        return $data;
    }
}
