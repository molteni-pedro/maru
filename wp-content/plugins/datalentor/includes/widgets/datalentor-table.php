<?php

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * Class Comparison Table
 */

class Datalentor_Data_Table_Widget extends Widget_Base {

    // Function for get the slug of the element name.
    public function get_name() {
        return 'datalentor_table';
    }

    // Function for get the name of the element.
    public function get_title() {
        return __('DL Data Table', DTLE_DOMAIN);
    }

    // Function for get the icon of the element.
    public function get_icon() {
        return 'eicon-table';
    }

    //Function for include element into the category.
    public function get_categories() {
        return ['datalentor'];
    }

    /*
    * Adding the controls fields for the Data Table Elements
    */

    protected function register_controls() {

        $this->start_controls_section(
            'section_layout', array(
                'label'         => __('Header', DTLE_DOMAIN),
            )
        );
        $repeater = new Repeater();
        $repeater->add_control(
            'dtle_data_table_header_col', [
                'label'         => __('Column Name', DTLE_DOMAIN),
                'type'          => Controls_Manager::TEXT,
                'default'       => __('Table Header', DTLE_DOMAIN),
                'label_block'   => false,
            ]
        );
        $repeater->add_control(
            'dtle_data_table_header_col_span', [
                'label'         => __('Column Span', DTLE_DOMAIN),
                'default'       => '',
                'type'          => Controls_Manager::TEXT,
                'label_block'   => false,
            ]
        );
        $repeater->add_control(
            'dtle_data_table_header_col_icon_enabled', [
                'label'         => __('Enable Header Icon', DTLE_DOMAIN),
                'type'          => Controls_Manager::SWITCHER,
                'label_on'      => __('Yes', DTLE_DOMAIN),
                'label_off'     => __('No', DTLE_DOMAIN),
                'default'       => 'false',
                'return_value'  => 'true',
            ]
        );
        $repeater->add_control(
            'dtle_data_table_header_icon_type', [
                'label'         => __('Header Icon Type', DTLE_DOMAIN),
                'type'          => Controls_Manager::CHOOSE,
                'options'       => [
                    'none'      => [
                        'title' => __('None', DTLE_DOMAIN),
                        'icon'  => 'eicon-ban',
                    ],
                    'icon'      => [
                        'title' => __('Icon', DTLE_DOMAIN),
                        'icon'  => 'eicon-star',
                    ],
                    'image'     => [
                        'title' => __('Image', DTLE_DOMAIN),
                        'icon'  => 'eicon-image',
                    ],
                ],
                'default'       => 'icon',
                'condition'     => [
                    'dtle_data_table_header_col_icon_enabled' => 'true'
                ]
            ]
        );
        $repeater->add_control(
            'dtle_data_table_header_col_icon_new', [
                'label'         => __('Icon', DTLE_DOMAIN),
                'type'          => Controls_Manager::ICONS,
                'default'       => [
                    'value'     => 'fas fa-circle',
                    'library'   => 'fa-solid',
                ],
                'recommended'   => [
                    'fa-solid'  => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                    'fa-regular' => [
                        'circle',
                        'dot-circle',
                        'square-full',
                    ],
                ],
                'condition'     => [
                    'dtle_data_table_header_col_icon_enabled' => 'true',
                    'dtle_data_table_header_icon_type' => 'icon'
                ]
            ]
        );
        $repeater->add_control(
            'dtle_data_table_header_col_img', [
                'label'         => __('Image', DTLE_DOMAIN),
                'type'          => Controls_Manager::MEDIA,
                'default'       => [
                    'url'       => Utils::get_placeholder_image_src(),
                ],
                'condition'     => [
                    'dtle_data_table_header_icon_type' => 'image'
                ]
            ]
        );
        $repeater->add_control(
            'dtle_data_table_header_col_img_size', [
                'label'         => __('Image Size(px)', DTLE_DOMAIN),
                'default'       => '25',
                'type'          => Controls_Manager::NUMBER,
                'label_block'   => false,
                'condition'     => [
                    'dtle_data_table_header_icon_type' => 'image'
                ]
            ]
        );
        $repeater->add_control(
            'dtle_data_table_header_col_svg_img_size', [
                'label'         => __('SVG Image Size(px)', DTLE_DOMAIN),
                'default'       => '15',
                'type'          => Controls_Manager::NUMBER,
                'label_block'   => false,
                'condition'     => [
                    'dtle_data_table_header_icon_type' => 'icon',
                    'dtle_data_table_header_col_icon_new' => '',
                ]
            ]
        );

        $repeater->add_control(
            'dtle_data_table_header_css_class', [
                'label'         => __('CSS Class', DTLE_DOMAIN),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => false,
            ]
            );
        $repeater->add_control(
            'dtle_data_table_header_css_id', [
                'label'         => __('CSS ID', DTLE_DOMAIN),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => false,
            ]
        );

        $this->add_control(
            'dtle_data_table_header_cols_data', [
                'type'          => Controls_Manager::REPEATER,
                'separator'     => 'before',
                'fields'        => $repeater->get_controls(),
                'default'       => [
                    ['dtle_data_table_header_col' => __('Table Header', DTLE_DOMAIN)],
                    ['dtle_data_table_header_col' => __('Table Header', DTLE_DOMAIN)],
                    ['dtle_data_table_header_col' => __('Table Header', DTLE_DOMAIN)],
                    ['dtle_data_table_header_col' => __('Table Header', DTLE_DOMAIN)],
                ],
                'title_field'   => '{{dtle_data_table_header_col}}', 
            ]       
        );

        $this->end_controls_section();

        /**
         * Data Table Content
         */
        $this->start_controls_section(
            'dtle_section_data_table_content', [
                'label'            => __('Content', DTLE_DOMAIN)
            ]
        );
        $repeater = new Repeater();

            $repeater->add_control(
                'dtle_data_table_content_row_type', [
                    'label'         => __( 'New Row', DTLE_DOMAIN ),
                    'type'          => Controls_Manager::SWITCHER,
                    'default'       => 'no',
                    'label_block'   => false,
                    'label_off'     => __( 'Col', DTLE_DOMAIN ),
                    'label_on'      => __( 'Row', DTLE_DOMAIN ),
                ]
            );
            $repeater->add_control(
                'dtle_data_table_content_row_colspan', [
                    'label'         => __('Col Span', DTLE_DOMAIN),
                    'type'          => Controls_Manager::NUMBER,
                    'description'   => __('Default: 1 (optional).'),
                    'default'       => 1,
                    'min'           => 1,
                    'label_block'   => true
                ]
            );
            $repeater->add_control(
                'dtle_data_table_content_row_rowspan', [
                    'label'         => __('Row Span', DTLE_DOMAIN),
                    'type'          => Controls_Manager::NUMBER,
                    'description'   => __('Default: 1 (optional).'),
                    'default'       => 1,
                    'min'           => 1,
                    'label_block'   => true
                ]
            );
            $repeater->add_control(
                'dtle_data_table_content_type', [
                    'label'         => __('Content Type', DTLE_DOMAIN),
                    'type'          => Controls_Manager::CHOOSE,
                    'options'       => [
                        'textarea'  => [
                            'title' => __('Textarea', DTLE_DOMAIN),
                            'icon'  => 'eicon-text',
                        ],
                        'image'     => [
                            'title' => __('Image', DTLE_DOMAIN),
                            'icon'  => 'eicon-image',
                        ],
                        'template'  => [
                            'title' => __('Templates', DTLE_DOMAIN),
                            'icon'  => 'eicon-document-file',
                        ],
                        'button'    => [
                            'title' => __('Button', DTLE_DOMAIN),
                            'icon'  => 'eicon-button',
                        ]
                    ],
                    'default'       => 'textarea'
                ]
            );

            $repeater->add_control(
                'dtle_data_table_custom_button_text', [
                    'label'         => __('Button Text', DTLE_DOMAIN),
                    'default'       => __('Click here', DTLE_DOMAIN),
                    'type'          => Controls_Manager::TEXT,
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button',
                    ],
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_link', [
                    'label'         => __('Button Link', DTLE_DOMAIN),
                    'type'          => Controls_Manager::URL,
                    'label_block'   => true,
                    'default'       => [
                        'url'       => '',
                        'is_external' => '',
                    ],
                    'show_external' => true,
                    'separator'     => 'before',
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ],
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_align', [
                    'label'         => __('Button Alignment', DTLE_DOMAIN),
                    'type'          => Controls_Manager::CHOOSE,
                    'options'       => [
                        'left'      => [
                            'title' => __('Left', 'elementor'),
                            'icon'  => 'eicon-text-align-left',
                        ],
                        'center'    => [
                            'title' => __('Center', 'elementor'),
                            'icon'  => 'eicon-text-align-center',
                        ],
                        'right'     => [
                            'title' => __('Right', 'elementor'),
                            'icon'  => 'eicon-text-align-right',
                        ],
                        'justify'   => [
                            'title' => __('Justified', 'elementor'),
                            'icon'  => 'eicon-text-align-justify',
                        ],
                    ],
                    'prefix_class'  => 'elementor%s-align-',
                    'default'       => 'left',
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table {{CURRENT_ITEM}} .dtle-content-button' => 'text-align: {{VALUE}};'
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ],
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_color', [
                    'label'         => __('Button Text Color', DTLE_DOMAIN),
                    'type'          => Controls_Manager::COLOR,
                    'default'       => '#fff',
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table-wrap {{CURRENT_ITEM}} a' => 'color: {{VALUE}};'
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_bg_color', [
                    'label'         => __('Button Background Color', DTLE_DOMAIN),
                    'type'          => Controls_Manager::COLOR,
                    'default'       => '#61ce70',
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table-wrap {{CURRENT_ITEM}} a' => 'background-color: {{VALUE}};'
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );

            $repeater->add_control(
                'dtle_data_table_custom_button_border', [
                    'label'         => __('Button Border', DTLE_DOMAIN),
                    'type'          => Controls_Manager::SELECT,
                    'label_block'   => false,
                    'default'       => 'none',
                    'options'       => [
                        'none'      => __('None', DTLE_DOMAIN),
                        'solid'     => __('Solid', DTLE_DOMAIN),
                        'double'    => __('Double', DTLE_DOMAIN),
                        'dotted'    => __('Dotted', DTLE_DOMAIN),
                        'dashed'    => __('Dashed', DTLE_DOMAIN),
                        'groove'    => __('Groove', DTLE_DOMAIN),
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_border_radius', [
                    'label'         => __('Button Border Radius', DTLE_DOMAIN),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', '%'],
                    'default'       => [
                        'top'       => 3,
                        'right'     => 3,
                        'bottom'    => 3,
                        'left'      => 3,
                        'isLinked'  => true,
                        'unit'      => 'px'
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table-wrap {{CURRENT_ITEM}} a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );

            $repeater->add_control(
                'dtle_data_table_custom_button_border_width', [
                    'label'         => __('Button Border Width', DTLE_DOMAIN),
                    'type'          => Controls_Manager::NUMBER,
                    'min'           => 1,
                    'max'           => 50,
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table-wrap {{CURRENT_ITEM}} a' => 'border-width: {{VALUE}}px;'
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_border_color', [
                    'label'         => __('Button Border Color', DTLE_DOMAIN),
                    'type'          => Controls_Manager::COLOR,
                    'default'       => '#333',
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table-wrap {{CURRENT_ITEM}} a' => 'border-color: {{VALUE}};'
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_hover_color', [
                    'label'         => __('Button Text Hover Color', DTLE_DOMAIN),
                    'type'          => Controls_Manager::COLOR,
                    'default'       => '#fff',
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table-wrap {{CURRENT_ITEM}} a:hover' => 'color: {{VALUE}};'
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_hover_bg_color', [
                    'label'         => __('Button Hover Background Color', DTLE_DOMAIN),
                    'type'          => Controls_Manager::COLOR,
                    'default'       => '#333',
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table-wrap {{CURRENT_ITEM}} a:hover' => 'background-color: {{VALUE}};'
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_hover_border_color', [
                    'label'         => __('Button Hover Border Color', DTLE_DOMAIN),
                    'type'          => Controls_Manager::COLOR,
                    'default'       => '#333',
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table-wrap {{CURRENT_ITEM}} a:hover' => 'border-color: {{VALUE}};'
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_text_padding', [
                    'label'         => __('Button Padding', DTLE_DOMAIN),
                    'type'          => Controls_Manager::DIMENSIONS,
                    'size_units'    => ['px', 'em'],
                    'default'       => [
                        'top'       => 12,
                        'right'     => 24,
                        'bottom'    => 12,
                        'left'      => 24,
                        'isLinked'  => true,
                        'unit'      => 'px'
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table-wrap {{CURRENT_ITEM}} a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_icon_type', [
                    'label'         => __('Button Icon Type', DTLE_DOMAIN),
                    'type'          => Controls_Manager::CHOOSE,
                    'options'       => [
                        'none'      => [
                            'title' => __('None', DTLE_DOMAIN),
                            'icon'  => 'eicon-ban',
                        ],
                        'icon'      => [
                            'title' => __('Icon', DTLE_DOMAIN),
                            'icon'  => 'eicon-star',
                        ],
                        'image'     => [
                            'title' => __('Image', DTLE_DOMAIN),
                            'icon'  => 'eicon-image',
                        ],
                    ],
                    'default'       => 'icon',
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_icon_value', [
                    'label'         => __('Button Icon', DTLE_DOMAIN),
                    'type'          => Controls_Manager::ICONS,
                    'default'       => [
                        'value'     => 'fas fa-circle',
                        'library'   => 'fa-solid',
                    ],
                    'recommended'   => [
                        'fa-solid'  => [
                            'circle',
                            'dot-circle',
                            'square-full',
                        ],
                        'fa-regular' => [
                            'circle',
                            'dot-circle',
                            'square-full',
                        ],
                    ],
                    'condition'     => [
                        'dtle_data_table_custom_button_icon_type' => 'icon',
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );

            $repeater->add_control(
                'dtle_data_table_custom_button_image_value', [
                    'label'         => __('Button Image', DTLE_DOMAIN),
                    'type'          => Controls_Manager::MEDIA,
                    'default'       => [
                        'url'       => Utils::get_placeholder_image_src(),
                    ],
                    'condition'     => [
                        'dtle_data_table_custom_button_icon_type' => 'image',
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_image_size', [
                    'label'         => __('Button Image Size(px)', DTLE_DOMAIN),
                    'default'       => '25',
                    'type'          => Controls_Manager::NUMBER,
                    'label_block'   => false,
                    'condition'     => [
                        'dtle_data_table_custom_button_icon_type' => 'image',
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_icon_align', [
                    'label'         => __('Button Icon Position', DTLE_DOMAIN),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => 'left',
                    'options'       => [
                        'left'      => __('Before', DTLE_DOMAIN),
                        'right'     => __('After', DTLE_DOMAIN),
                    ],
                    'condition'     => [
                        'dtle_data_table_custom_button_icon_type' => 'icon',
                        'dtle_data_table_custom_button_icon_value' => '',
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );

            $repeater->add_control(
                'dtle_data_table_custom_button_icon_indent', [
                    'label'         => __('Button Icon Spacing', DTLE_DOMAIN),
                    'type'          => Controls_Manager::NUMBER,
                    'min'           => 1,
                    'max'           => 50,
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-content-button .elementor-align-icon-right' => 'margin-left: {{SIZE}}px;',
                        '{{WRAPPER}} .dtle-content-button .elementor-align-icon-left' => 'margin-right: {{SIZE}}px;',
                    ],
                    'condition'     => [
                        'dtle_data_table_custom_button_icon_type' => 'icon',
                        'dtle_data_table_custom_button_icon_value' => '',
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_text_decoration', [
                    'label'         => __('Button Text Decoration', DTLE_DOMAIN),
                    'type'          => Controls_Manager::SELECT,
                    'options'       => [
                        ''          => __('Default', DTLE_DOMAIN),
                        'underline' => __('Underline', DTLE_DOMAIN),
                        'overline'  => __('Overline', DTLE_DOMAIN),
                        'line-through' => __('Line Through', DTLE_DOMAIN),
                        'none'      => __('None', DTLE_DOMAIN),
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table-wrap {{CURRENT_ITEM}} a' => 'text-decoration: {{VALUE}};',
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_text_transform', [
                    'label'         => __('Button Text Transform', DTLE_DOMAIN),
                    'type'          => Controls_Manager::SELECT,
                    'options'       => [
                        ''          => __('Default', DTLE_DOMAIN),
                        'uppercase' => __('Uppercase', DTLE_DOMAIN),
                        'lowercase' => __('Lowercase', DTLE_DOMAIN),
                        'capitalize' => __('Capatilize', DTLE_DOMAIN),
                        'none'      => __('Normal', DTLE_DOMAIN),
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table-wrap {{CURRENT_ITEM}} a' => 'text-transform: {{VALUE}};',
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_font_weight', [
                    'label'         => __('Button Font Weight', DTLE_DOMAIN),
                    'type'          => Controls_Manager::SELECT,
                    'default'       => '500',
                    'options'       => [
                        ''          => __('Default', DTLE_DOMAIN),
                        '100'       => __('100', DTLE_DOMAIN),
                        '200'       => __('200', DTLE_DOMAIN),
                        '300'       => __('300', DTLE_DOMAIN),
                        '400'       => __('400', DTLE_DOMAIN),
                        '500'       => __('500', DTLE_DOMAIN),
                        '600'       => __('600', DTLE_DOMAIN),
                        '700'       => __('700', DTLE_DOMAIN),
                        '800'       => __('800', DTLE_DOMAIN),
                        '900'       => __('900', DTLE_DOMAIN),
                        'normal'    => __('Normal', DTLE_DOMAIN),
                        'bold'      => __('Bold', DTLE_DOMAIN),
                    ],
                    'selectors'     => [
                        '{{WRAPPER}} .dtle-data-table-wrap {{CURRENT_ITEM}} a' => 'font-weight: {{VALUE}};',
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_custom_button_id', [
                    'label'         => __('Button Id', DTLE_DOMAIN),
                    'type'          => Controls_Manager::TEXT,
                    'dynamic'       => [
                        'active'    => true,
                    ],
                    'default'       => '',
                    'title'         => __('Add your custom id WITHOUT the Pound key. e.g: my-button-id', DTLE_DOMAIN),
                    'label_block'   => false,
                    'description'   => __('Please make sure the ID is unique and not used elsewhere on the page this form is displayed. This field allows <code>A-z 0-9</code> & underscore chars without spaces.', DTLE_DOMAIN),
                    'separator'     => 'before',
                    'condition'     => [
                        'dtle_data_table_content_type' => 'button'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_primary_templates_for_tables', [
                    'label'         => __('Choose Template', DTLE_DOMAIN),
                    'type'          => Controls_Manager::SELECT,
                    'options'       => dtle_get_page_templates(),
                    'condition'     => [
                        'dtle_data_table_content_type' => 'template',
                    ],
                ]
            );
            $repeater->add_control(
                'dtle_data_table_content_row_title', [
                    'label'         => __('Cell Text', DTLE_DOMAIN),
                    'type'          => Controls_Manager::TEXTAREA,
                    'label_block'   => true,
                    'default'       => __('Content', DTLE_DOMAIN),
                    'condition'     => [
                        'dtle_data_table_content_type' => 'textarea'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_content_row_content', [
                    'label'         => __('Image', DTLE_DOMAIN),
                    'type'          => Controls_Manager::MEDIA,
                    'default'       => [
                        'url'       => Utils::get_placeholder_image_src(),
                    ],
                    'condition'     => [
                        'dtle_data_table_content_type' => 'image'
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_content_image_size', [
                    'label'         => __('Content Image Size(px)', DTLE_DOMAIN),
                    'default'       => '30',
                    'type'          => Controls_Manager::NUMBER,
                    'label_block'   => false,
                    'condition'     => [
                        'dtle_data_table_content_type' => 'image',
                    ]
                ]
            );
            $repeater->add_control(
                'dtle_data_table_content_row_title_link', [
                    'label'         => __('Link', DTLE_DOMAIN),
                    'type'          => Controls_Manager::URL,
                    'label_block'   => true,
                    'default'       => [
                        'url'       => '',
                        'is_external' => '',
                    ],
                    'show_external' => true,
                    'separator'     => 'before',
                    'condition'     => [
                        'dtle_data_table_content_type' => 'textarea'
                    ],
                ]
            );
            $repeater->add_control(
                'dtle_data_table_content_row_css_class', [
                    'label'         => __('CSS Class', DTLE_DOMAIN),
                    'type'          => Controls_Manager::TEXT,
                    'label_block'   => false
                ]
            );
            $repeater->add_control(
                'dtle_data_table_content_row_css_id', [
                    'label'         => __('CSS ID', DTLE_DOMAIN),
                    'type'          => Controls_Manager::TEXT,
                    'label_block'   => false
                ]
                
            );
            
            $this->add_control(
                'dtle_data_table_content_rows', [
                    'type'          => Controls_Manager::REPEATER ,
                    'separator'     => 'before',
                    'fields'        => $repeater->get_controls(),
                    'default'       => [
                        ['dtle_data_table_content_row_type' => 'col'],
                        ['dtle_data_table_content_row_type' => 'col'],
                        ['dtle_data_table_content_row_type' => 'col'],
                        ['dtle_data_table_content_row_type' => 'col'],
                    ],
                    'title_field' => '{{dtle_data_table_content_row_title || dtle_data_table_custom_button_text}}',
                ]
            );

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style (Data Table Style)
         * -------------------------------------------
         */
        $this->start_controls_section(
            'dtle_section_data_table_style_settings', [
                'label'             => __('General Style', DTLE_DOMAIN),
                'tab'               => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_responsive_control(
            'table_width', [
                'label'             => __('Width', DTLE_DOMAIN),
                'type'              => Controls_Manager::SLIDER,
                'default'           => [
                    'size'          => 100,
                    'unit'          => '%',
                ],
                'size_units'        => ['%', 'px'],
                'range'             => [
                    '%'             => [
                        'min'       => 1,
                        'max'       => 100,
                    ],
                    'px'            => [
                        'min'       => 1,
                        'max'       => 1200,
                    ],
                ],
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'table_alignment', [
                'label'             => __('Alignment', DTLE_DOMAIN),
                'type'              => Controls_Manager::CHOOSE,
                'label_block'       => false,
                'default'           => 'center',
                'options'           => [
                    'left'          => [
                        'title'     => __('Left', DTLE_DOMAIN),
                        'icon'      => 'eicon-h-align-left',
                    ],
                    'center'        => [
                        'title'     => __('Center', DTLE_DOMAIN),
                        'icon'      => 'eicon-h-align-center',
                    ],
                    'right'         => [
                        'title'     => __('Right', DTLE_DOMAIN),
                        'icon'      => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class'      => 'dtle-table-align-',
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table-wrap' => 'justify-content:{{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style (Data Table Header Style)
         * -------------------------------------------
         */
        $this->start_controls_section(
            'dtle_section_data_table_title_style_settings', [
                'label'             => __('Header Style', DTLE_DOMAIN),
                'tab'               => Controls_Manager::TAB_STYLE
            ]
        );


        $this->add_control(
            'dtle_section_data_table_header_radius', [
                'label'             => __('Header Border Radius', DTLE_DOMAIN),
                'type'              => Controls_Manager::SLIDER,
                'range'             => [
                    'px'            => [
                        'max'       => 50,
                    ],
                ],
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table thead tr th:first-child' => 'border-radius: {{SIZE}}px 0px 0px 0px;',
                    '{{WRAPPER}} .dtle-data-table thead tr th:last-child' => 'border-radius: 0px {{SIZE}}px 0px 0px;',
                ],
            ]
        );

        $this->add_responsive_control(
            'dtle_data_table_each_header_padding', [
                'label'             => __('Padding', DTLE_DOMAIN),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em'],
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table .table-header th' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .dtle-data-table tbody tr td .th-mobile-screen' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('dtle_data_table_header_title_clrbg');

        $this->start_controls_tab('dtle_data_table_header_title_normal', ['label' => __('Normal', DTLE_DOMAIN)]);

        $this->add_control(
            'dtle_data_table_header_title_color', [
                'label'             => __('Color', DTLE_DOMAIN),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#fff',
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table thead tr th' => 'color: {{VALUE}};',
                    '{{WRAPPER}} table.dataTable thead .sorting:after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} table.dataTable thead .sorting_asc:after' => 'color: {{VALUE}};',
                    '{{WRAPPER}} table.dataTable thead .sorting_desc:after' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dtle_data_table_header_title_bg_color', [
                'label'             => __('Background Color', DTLE_DOMAIN),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#4a4893',
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table thead tr th' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name'              => 'dtle_data_table_header_border',
                'label'             => __('Border', DTLE_DOMAIN),
                'selector'          => '{{WRAPPER}} .dtle-data-table thead tr th'
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('dtle_data_table_header_title_hover', ['label' => __('Hover', DTLE_DOMAIN)]);

        $this->add_control(
            'dtle_data_table_header_title_hover_color', [
                'label'             => __('Color', DTLE_DOMAIN),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#fff',
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table thead tr th:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} table.dataTable thead .sorting:after:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} table.dataTable thead .sorting_asc:after:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} table.dataTable thead .sorting_desc:after:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dtle_data_table_header_title_hover_bg_color', [
                'label'             => __('Background Color', DTLE_DOMAIN),
                'type'              => Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table thead tr th:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name'              => 'dtle_data_table_header_hover_border',
                'label'             => __('Border', DTLE_DOMAIN),
                'selector'          => '{{WRAPPER}} .dtle-data-table thead tr th:hover',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'              => 'dtle_data_table_header_title_typography',
                'selector'          => '{{WRAPPER}} .dtle-data-table thead > tr th',
            ]
        );

        $this->add_responsive_control(
            'dtle_data_table_header_title_alignment', [
                'label'             => __('Title Alignment', DTLE_DOMAIN),
                'type'              => Controls_Manager::CHOOSE,
                'label_block'       => true,
                'options'           => [
                    'left'          => [
                        'title'     => __('Left', DTLE_DOMAIN),
                        'icon'      => 'fa fa-align-left',
                    ],
                    'center'        => [
                        'title'     => __('Center', DTLE_DOMAIN),
                        'icon'      => 'fa fa-align-center',
                    ],
                    'right'         => [
                        'title'     => __('Right', DTLE_DOMAIN),
                        'icon'      => 'fa fa-align-right',
                    ],
                ],
                'default'           => 'left',
                'prefix_class'      => 'dtle-dt-th-align-',
            ]
        );

        $this->end_controls_section();

        /**
         * -------------------------------------------
         * Tab Style (Data Table Content Style)
         * -------------------------------------------
         */
        $this->start_controls_section(
            'dtle_section_data_table_content_style_settings', [
                'label'             => __('Content Style', DTLE_DOMAIN),
                'tab'               => Controls_Manager::TAB_STYLE
            ]
        );

        $this->start_controls_tabs('dtle_data_table_content_row_cell_styles');

        $this->start_controls_tab('dtle_data_table_odd_cell_style', ['label' => __('Normal', DTLE_DOMAIN)]);

        $this->add_control(
            'dtle_data_table_content_odd_style_heading', [
                'label'             => __('ODD Cell', DTLE_DOMAIN),
                'type'              => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'dtle_data_table_content_color_odd', [
                'label'             => __('Color ( Odd Row )', DTLE_DOMAIN),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#6d7882',
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table tbody > tr:nth-child(2n) td' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dtle_data_table_content_bg_odd', [
                'label'             => __('Background ( Odd Row )', DTLE_DOMAIN),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#f2f2f2',
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table tbody > tr:nth-child(2n) td' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dtle_data_table_content_even_style_heading', [
                'label'             => __('Even Cell', DTLE_DOMAIN),
                'type'              => Controls_Manager::HEADING,
                'separator'         => 'before'
            ]
        );

        $this->add_control(
            'dtle_data_table_content_even_color', [
                'label'             => __('Color ( Even Row )', DTLE_DOMAIN),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#6d7882',
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table tbody > tr:nth-child(2n+1) td' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dtle_data_table_content_bg_even_color', [
                'label'             => __('Background Color (Even Row)', DTLE_DOMAIN),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table tbody > tr:nth-child(2n+1) td' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(), [
                'name'              => 'dtle_data_table_cell_border',
                'label'             => __('Border', DTLE_DOMAIN),
                'selector'          => '{{WRAPPER}} .dtle-data-table tbody tr td',
                'separator'         => 'before'
            ]
        );

        $this->add_responsive_control(
            'dtle_data_table_each_cell_padding', [
                'label'             => __('Padding', DTLE_DOMAIN),
                'type'              => Controls_Manager::DIMENSIONS,
                'size_units'        => ['px', 'em'],
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table tbody tr td' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('dtle_data_table_odd_cell_hover_style', ['label' => __('Hover', DTLE_DOMAIN)]);

        $this->add_control(
            'dtle_data_table_content_hover_color_odd', [
                'label'             => __('Color ( Odd Row )', DTLE_DOMAIN),
                'type'              => Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table tbody > tr:nth-child(2n) td:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dtle_data_table_content_hover_bg_odd', [
                'label'             => __('Background ( Odd Row )', DTLE_DOMAIN),
                'type'              => Controls_Manager::COLOR,
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table tbody > tr:nth-child(2n) td:hover' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dtle_data_table_content_even_hover_style_heading', [
                'label'             => __('Even Cell', DTLE_DOMAIN),
                'type'              => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'dtle_data_table_content_hover_color_even', [
                'label'             => __('Color ( Even Row )', DTLE_DOMAIN),
                'type'              => Controls_Manager::COLOR,
                'default'           => '#6d7882',
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table tbody > tr:nth-child(2n+1) td:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'dtle_data_table_content_bg_even_hover_color', [
                'label'             => __('Background Color (Even Row)', DTLE_DOMAIN),
                'type'              => Controls_Manager::COLOR,
                'default'           => '',
                'selectors'         => [
                    '{{WRAPPER}} .dtle-data-table tbody > tr:nth-child(2n+1) td:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Typography::get_type(), [
                'name'              => 'dtle_data_table_content_typography',
                'selector'          => '{{WRAPPER}} .dtle-data-table .td-content',
            ]
        );

        $this->add_responsive_control(
            'dtle_data_table_content_alignment', [
                'label'             => __('Content Alignment', DTLE_DOMAIN),
                'type'              => Controls_Manager::CHOOSE,
                'label_block'       => true,
                'options'           => [
                    'left'          => [
                        'title'     => __('Left', DTLE_DOMAIN),
                        'icon'      => 'fa fa-align-left',
                    ],
                    'center'        => [
                        'title'     => __('Center', DTLE_DOMAIN),
                        'icon'      => 'fa fa-align-center',
                    ],
                    'right'         => [
                        'title'     => __('Right', DTLE_DOMAIN),
                        'icon'      => 'fa fa-align-right',
                    ],
                ],
                'default'           => 'left',
                'prefix_class'      => 'dtle-dt-td-align-',
                'selectors'         => [
					'{{WRAPPER}} .dtle-data-table tbody tr td' => 'text-align: {{VALUE}};',
				],
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Render Datalentor widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @access protected
     */
    protected function render() {

        $settings = $this->get_settings();
        $table_td = [];

        // Storing Data table content values
        foreach ($settings['dtle_data_table_content_rows'] as $content_row) {

            $target = $content_row['dtle_data_table_content_row_title_link']['is_external'] ? 'target="_blank"' : '';
            $nofollow = $content_row['dtle_data_table_content_row_title_link']['nofollow'] ? 'rel="nofollow"' : '';
            $tbody_content =  $content_row['dtle_data_table_content_row_title'];

            if ($content_row['dtle_data_table_content_type'] == 'button') {
                $tbody_content = $content_row['dtle_data_table_custom_button_text'];
            }

            $table_td[] = [
                '_id' => $content_row['_id'],
                'type' => $content_row['dtle_data_table_content_row_type'],
                'content_type' => $content_row['dtle_data_table_content_type'],
                'template' => $content_row['dtle_primary_templates_for_tables'],
                'image' => $content_row['dtle_data_table_content_row_content'],
                'content_image_size' => $content_row['dtle_data_table_content_image_size'],
                'button_text' => $content_row['dtle_data_table_custom_button_text'],
                'button_link' => $content_row['dtle_data_table_custom_button_link']['url'],
                'button_icon_type' => $content_row['dtle_data_table_custom_button_icon_type'],
                'button_icon' => $content_row['dtle_data_table_custom_button_icon_value'],
                'button_image' => $content_row['dtle_data_table_custom_button_image_value'],
                'button_size' => $content_row['dtle_data_table_custom_button_image_size'],
                'button_align' => $content_row['dtle_data_table_custom_button_icon_align'],
                'button_id' => $content_row['dtle_data_table_custom_button_id'],
                'button_alignment' => $content_row['dtle_data_table_custom_button_align'],
                'button_border' => $content_row['dtle_data_table_custom_button_border'],
                'title' => $tbody_content,
                'link_url' => $content_row['dtle_data_table_content_row_title_link']['url'],
                'link_target' => $target,
                'nofollow' => $nofollow,
                'colspan' => $content_row['dtle_data_table_content_row_colspan'],
                'rowspan' => $content_row['dtle_data_table_content_row_rowspan'],
                'tr_class' => $content_row['dtle_data_table_content_row_css_class'],
                'tr_id' => $content_row['dtle_data_table_content_row_css_id']
            ];
        }
        $table_th_count = count($settings['dtle_data_table_header_cols_data']);
        $this->add_render_attribute('dtle_data_table_wrap', [
            'class' => 'dtle-data-table-wrap',
            'data-table_id' => esc_attr($this->get_id()),
        ]);
        if (isset($settings['dtle_section_data_table_enabled']) && $settings['dtle_section_data_table_enabled']) {
            $this->add_render_attribute('dtle_data_table_wrap', 'data-table_enabled', 'true');
        }
        $this->add_render_attribute('dtle_data_table', [
            'class' => ['tablesorter dtle-data-table', esc_attr($settings['table_alignment'])],
            'id' => 'dtle-data-table-' . esc_attr($this->get_id())
        ]);

        $this->add_render_attribute('td_content', [
            'class' => 'td-content'
        ]);?>
        <div <?php echo $this->get_render_attribute_string('dtle_data_table_wrap'); ?>>
            <table <?php echo $this->get_render_attribute_string('dtle_data_table'); ?>>
                <thead>
                    <tr class="table-header">
                        <?php
                        $i = 0;
                        foreach ($settings['dtle_data_table_header_cols_data'] as $header_title) :
                            $this->add_render_attribute('th_class' . $i, [
                                'class' => [$header_title['dtle_data_table_header_css_class']],
                                'id' => $header_title['dtle_data_table_header_css_id'],
                                'colspan' => $header_title['dtle_data_table_header_col_span']
                            ]);
                            ?>
                            <th <?php echo $this->get_render_attribute_string('th_class' . $i); ?>>
                                <span class="elementor-header-section">
                                    <span class="elementor-button-content-wrapper">
                                        <span class="elementor-button-icon">
                                            <?php if ($header_title['dtle_data_table_header_col_icon_enabled'] == 'true' && $header_title['dtle_data_table_header_icon_type'] == 'icon') : ?>
                                                <?php if (( empty($header_title['dtle_data_table_header_col_icon']) || isset($header_title['dtle_data_table_header_col_icon_new']) ) && empty($header_title['dtle_data_table_header_col_icon_new']['value']['url'])) { 
                                                    \Elementor\Icons_Manager::render_icon($header_title['dtle_data_table_header_col_icon_new']);
                                                } 
                                                else if ($header_title['dtle_data_table_header_col_icon_new']['value']['url'] != "") { ?>
                                                    <img width="<?php echo esc_attr($header_title["dtle_data_table_header_col_svg_img_size"]); ?>" class="data-header-svg" src="<?php echo esc_url($header_title['dtle_data_table_header_col_icon_new']['value']['url']); ?>" />
                                                <?php } else { ?>
                                                    <i class="<?php echo esc_attr($header_title['dtle_data_table_header_col_icon']); ?> dtle-data-header-icon"></i>
                                                <?php } ?>
                                            <?php endif; ?>
                                            <?php
                                            if ($header_title['dtle_data_table_header_col_icon_enabled'] == 'true' && $header_title['dtle_data_table_header_icon_type'] == 'image') :
                                                $this->add_render_attribute('data_table_th_img' . $i, [
                                                    'src' => esc_url($header_title['dtle_data_table_header_col_img']['url']),
                                                    'class' => 'dtle-data-table-th-img',
                                                    'style' => "width:{$header_title['dtle_data_table_header_col_img_size']}px;",
                                                    'alt' => esc_attr(get_post_meta($header_title['dtle_data_table_header_col_img']['id'], '_wp_attachment_image_alt', true))
                                                ]);
                                                ?>
                                                <img <?php echo $this->get_render_attribute_string('data_table_th_img' . $i); ?>>
                                            <?php endif; ?>
                                        </span>
                                        <span class="elementor-button-text elementor-inline-editing">
                                            <?php esc_html_e($header_title['dtle_data_table_header_col']); ?>
                                        </span>
                                    </span>
                                </span>
                            </th>
                            <?php
                            $i++;
                        endforeach;
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $j = 0;
                        foreach ($settings['dtle_data_table_content_rows'] as $content_row) {
                            if($table_td[$j]['type'] == 'yes'){
                                echo '</tr><tr>';
                            }
                            $this->add_render_attribute('table_inside_td' . $j, [
                                'colspan' => $table_td[$j]['colspan'] > 1 ? $table_td[$j]['colspan'] : '',
                                'rowspan' => $table_td[$j]['rowspan'] > 1 ? $table_td[$j]['rowspan'] : '',
                                'class' => $table_td[$j]['tr_class'],
                                'id' => $table_td[$j]['tr_id']
                                    ]
                            );
                            ?>
                            <?php if ($table_td[$j]['content_type'] == 'textarea' && !empty($table_td[$j]['link_url'])) : ?>
                                <td <?php echo $this->get_render_attribute_string('table_inside_td' . $j); ?>>
                                    <div class="td-content-wrapper">
                                        <a href="<?php echo esc_url($table_td[$j]['link_url']); ?>" <?php echo esc_attr($table_td[$j]['link_target']); ?> <?php echo esc_attr($table_td[$j]['nofollow']); ?>><?php echo wp_kses_post($table_td[$j]['title']); ?></a>
                                    </div>
                                </td>
                                <?php elseif ($table_td[$j]['content_type'] == 'image' && !empty($table_td[$j]['image']['url'])) : ?>
                                <td <?php echo $this->get_render_attribute_string('table_inside_td' . $j); ?>>
                                    <div class="td-content-wrapper">
                                        <img class="data-content-img" width="<?php echo esc_attr($table_td[$j]['content_image_size']); ?>"src="<?php echo esc_url($table_td[$j]['image']['url']);?>" />
                                    </div>
                                </td>
                            <?php elseif ($table_td[$j]['content_type'] == 'template' && !empty($table_td[$j]['template'])) : ?>
                                <td <?php echo $this->get_render_attribute_string('table_inside_td' . $j); ?>>
                                    <div class="td-content-wrapper">
                                        <div <?php echo $this->get_render_attribute_string('td_content'); ?>>
                                            <?php
                                            $dtle_frontend = new Frontend;
                                            echo ($dtle_frontend->get_builder_content(intval($table_td[$j]['template']), true));
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            <?php elseif ($table_td[$j]['content_type'] == 'button' && !empty($table_td[$j]['button_text'])) : ?>
                                <td <?php echo $this->get_render_attribute_string('table_inside_td' . $j); ?>>
                                    <div class="td-content-wrapper elementor-button-wrapper elementor-repeater-item-<?php echo esc_attr($table_td[$j]['_id']); ?>">
                                        <div class="td-content-wrapper dtle-content-button td-content-button <?php echo esc_attr($table_td[$j]['button_alignment']); ?> <?php echo esc_attr($table_td[$j]['button_border']); ?>">
                                            <a id="<?php echo esc_attr($table_td[$j]['button_id']); ?>" class="elementor-button-link elementor-button" href="<?php echo esc_url($table_td[$j]['button_link']); ?>">
                                                <span class="elementor-button-content-wrapper">
                                                    <span class="elementor-button-icon elementor-align-icon-<?php echo esc_attr($table_td[$j]['button_align']); ?>">
                                                        <?php if (!empty($table_td[$j]['button_icon']) && $table_td[$j]['button_icon_type'] == "icon" && empty($table_td[$j]['button_icon']['url'])) { ?>
                                                            <?php \Elementor\Icons_Manager::render_icon($table_td[$j]['button_icon']) ?>
                                                        <?php } ?>
                                                        <?php if (!empty($table_td[$j]['button_icon']['url']) && $table_td[$j]['button_icon_type'] == "icon") { ?>
                                                            <img width="15" class="elementor-svg-button elementor-button-img" src="<?php echo esc_url($table_td[$j]['button_icon']['url']); ?>" />
                                                        <?php } ?>
                                                        <?php if (!empty($table_td[$j]['button_image']['url']) && $table_td[$j]['button_icon_type'] == "image") { ?>
                                                            <img class="elementor-button-img" width="<?php echo esc_attr($table_td[$j]['button_size']); ?>" src="<?php echo esc_url($table_td[$j]['button_image']['url']); ?>" />
                                                        <?php } ?>
                                                    </span>
                                                    <span class="elementor-button-text elementor-inline-editing">
                                                        <?php echo wp_kses_post($table_td[$j]['button_text']); ?>
                                                    </span>
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            <?php else: ?>
                                <td <?php echo $this->get_render_attribute_string('table_inside_td' . $j); ?>>
                                    <div class="td-content-wrapper"><div <?php echo $this->get_render_attribute_string('td_content'); ?>><?php esc_html_e($table_td[$j]['title']); ?></div></div>
                                </td>
                            <?php endif; ?>
                            <?php
                            $j++;
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register(new Datalentor_Data_Table_Widget());
