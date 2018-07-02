<?php
 if(!defined('sugarEntry') || !sugarEntry) die('Not A Valid Entry Point');
/*
 * Your installation or use of this SugarCRM file is subject to the applicable
 * terms available at
 * http://support.sugarcrm.com/06_Customer_Center/10_Master_Subscription_Agreements/.
 * If you do not agree to all of the applicable terms or do not have the
 * authority to bind the entity as an authorized representative, then do not
 * install or use this SugarCRM file.
 *
 * Copyright (C) SugarCRM Inc. All rights reserved.
 */
$viewdefs['Styleguide']['base']['layout']['docs'] = array(
    'components' => array(
        array(
            'layout' => array(
                'components' => array(
                    array(
                        'view' => 'sg-headerpane',
                    ),
                ),
                'type' => 'simple',
                'name' => 'main-pane',
            ),
        ),
        array(
            'layout' => array(
                'components' => array(
                    array(
                        'layout' => 'dashlet-preview',
                    ),
                ),
                'type' => 'simple',
                'name' => 'preview-pane',
            ),
        ),
        'type' => 'simple',
    ),
    'page_data' => array (
        "home" => array (
            "title" => "Styleguide",
            "description" => "Major components of Styleguide.",
            "index" => false,
        ),
        "index" => array (
            "title" => "Core Elements",
            "description" => "Simple and flexible HTML, CSS, and Javascript for popular user interface components and interactions.",
            "index" => false,
        ),
        "field" => array (
            "title" => "Example Sugar7 Fields",
            "description" => "Basic fields that support detail, record, and edit modes with error addons.",
            "index" => false,
        ),
        "base" => array (
            "title" => "Base CSS",
            "description" => "Basic HTML elements styled and enhanced with extensible classes for a fresh, consistent look and feel.",
            "index" => true,
            "pages" => array (
                "typography" => array("label"=>"Typography", "description"=>"Headings, paragraphs, lists, and other inline type elements."),
                "grid" => array("label"=>"Grid system", "description"=>"A responsive 12-column grid including fixed- and fluid-width layouts based on that system."),
                "icons" => array("label"=>"Icons", "description"=>"Font Awesome icon library for scalable font based icons and glyphs for a full array of web-related actions."),
                "mixins" => array("label"=>"Mixins", "description"=>"Include or generate snippets of CSS with parameters."),
                "responsive" => array("label"=>"Responsive design", "description"=>"Media queries for various devices and resolutions."),
                "variables" => array("label"=>"Variables", "description"=>"LESS variables, HTML values, and usage guidelines."),
                "labels" => array("label"=>"Labels", "description"=>"Label and annotate text."),
                "edit" => array("label"=>"Edit Documentation", "description"=>"Instructions for updating Styleguide documentation."),
                "theme" => array("label"=>"Custom Theme Variables", "description"=>"Instructions for modifying theme colors."),
            )
        ),
        "forms" => array (
            "title" => "Form Elements",
            "description" => "Basic form elements and layouts for a consistent editing experience.",
            "index" => true,
            "pages" => array (
                "fields" => array("label"=>"Sugar7 fields", "url"=>"#Styleguide/field/all", "description"=>"Basic fields that support detail, record, and edit modes with error addons."),
                "buttons" => array("label"=>"Buttons", "description"=>"Standard css only button styles."),
                //TODO: remove this page or update
                //"editable" => array("label"=>"Editable", "description"=>"Inline form edit inputs."),
                "layouts" => array("label"=>"Form layouts", "description"=>"Customized layouts of field components."),
                "file" => array("label"=>"File uploader", "description"=>"Avatar file upload widget."),
                "datetime" => array("label"=>"Date-time picker", "description"=>"Lightweight date/time picker."),
                "select2" => array("label"=>"Select2", "description"=>"jQuery plugin replacement for select boxes. It supports searching, remote data sets, and infinite scrolling of results."),
                "jstree" => array("label"=>"jsTree", "description"=>"jQuery plugin cross browser tree component."),
                "range" => array("label"=>"Range Slider", "description"=>"jQuery plugin range picker."),
                "switch" => array("label"=>"Switch", "description"=>"jQuerty plugin turns check boxes into toggle switch."),
            )
        ),
        "components" => array (
            "title" => "Components",
            "description" => "Dozens of reusable components are built in to provide navigation, alerts, popovers, and much more.",
            "index" => true,
            "pages" => array (
                "alerts" => array("label"=>"Alerts", "description"=>"Styles for success, warning, and error messages."),
                "collapse" => array("label"=>"Collapse", "description"=>"Get base styles and flexible support for collapsible components like accordions and navigation."),
                "dropdowns" => array("label"=>"Dropdowns", "description"=>"Add dropdown menus to nearly anything with this simple plugin. Features full dropdown menu support on in the navbar, tabs, and pills."),
                "popovers" => array("label"=>"Popovers", "description"=>"Add small overlays of content, like those on the iPad, to any element for housing secondary information."),
                "progress" => array("label"=>"Progress bars", "description"=>"For loading, redirecting, or action status."),
                "tooltips" => array("label"=>"Tooltips", "description"=>"A new take on the jQuery Tipsy plugin, Tooltips don't rely on images, uss CSS3 for animations, and data-attributes for local title storage."),
                "keybindings" => array("label"=>"Key bindings", "description"=>" "),
            )
        ),
        "layouts" => array (
            "title" => "Layouts & Views",
            "description" => "Modals, navbars, and other layout widgets.",
            "index" => true,
            "pages" => array (
                "list" => array("label"=>"List Tables", "description"=>"For, you guessed it, tabular data."),
                "record" => array("label"=>"Record Views", "url"=>"#Styleguide/create", "description"=>"Detail, edit and create views for records."),
                "drawer" => array("label"=>"Drawers", "description"=>"Drawer is a form of a modal that pushes main content down and expands from the top taking 100% of the screen width."),
                "navbar" => array("label"=>"Navbar", "description"=>"Top level navigation layout."),
                "tabs" => array("label"=>"Tab Navigation", "description"=>"Use this plugin to make tabs and pills more useful by allowing them to toggle through tabbable panes of local content."),
                //TODO: remove these pages or update
                //"modals" => array("label"=>"Modals", "description"=>"A streamlined, but flexible, take on the traditional javascript modal plugin with only the minimum required functionality and smart defaults."),
                //"wizard" => array("label"=>"Wizard", "description"=>"Wizard takes advantage of bootstrap modals and sets up a framework for taking a user through multiple steps to complete a task."),
                //"thumbnails" => array("label"=>"Thumbnails", "description"=>"Grids of images, videos, text, and more."),
                //"scrollspy" => array("label"=>"Scrollspy", "description"=>"Use scrollspy to automatically update the links in your navbar to show the current active link based on scroll position."),
                //"carousel" => array("label"=>"Carousel", "description"=>"Create a merry-go-round of any content you wish to provide an interactive slideshow of content."),
                //"typeahead" => array("label"=>"Typeahead", "description"=>"A basic, easily extended plugin for quickly creating elegant typeaheads with any form text input."),
                //"transitions" => array("label"=>"Transitions", "description"=>"For simple transition effects, include bootstrap-transition.js once to slide in modals or fade out alerts."),
          )
        ),
        "dashboards" => array (
            "title" => "Dashboards",
            "description" => "Documentation and guidelines for dashboards within the app.",
            "index" => true,
            "pages" => array (
                "home" => array("label"=>"Home Module Dashboard", "description"=>"A grid layout for arranging dashlets."),
                "intel" => array("label"=>"Intelligence Pane Dashboard", "description"=>"Special features of the content related right hand side dashboard."),
                "dashlets" => array("label"=>"Dashlets", "description"=> "Patterns, styles, and elements for creating dashlets."),
            )
        ),
        "charts" => array (
            "title" => "Charting",
            "description" => "Standard and custom SVG charts for Sugar7 using the D3 library and the NVD3 framework.",
            "index" => true,
            "pages" => array (
                "circular" => array("label"=>"Circular", "description"=>"Used for comparing parts to a whole."),
                "line" => array("label"=>"Line", "description"=>"Used for comparing data series."),
                "horizontal" => array("label"=>"Horizontal Bar", "description"=>"Used for comparing many values in a single series."),
                "vertical" => array("label"=>"Vertical Bar", "description"=>"Used for comparing multiple series with a few values."),
                "custom" => array("label"=>"Custom", "description"=>"Used for comparing values in a process."),
                "implementation" => array("label"=>"Implementation", "description"=>"Patterns for inserting and configuring charts."),
                "colors" => array("label"=>"Colors", "description"=>"Flexible methods for assigning color maps and fill methods to D3 charts."),
            )
        ),
    ),
);
