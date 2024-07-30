<?php
/*-----------------------------------------------------------------------------------*/
/*  ProfiPaints Customizer Controls
/*-----------------------------------------------------------------------------------*/

class ProfiPaints_Misc_Control extends WP_Customize_Control
{


    public $settings = 'blogname';
    public $description = '';
    public $group = '';


    /**
     * Render the description and title for the sections
     */
    public function render_content()
    {
        switch ($this->type) {
            default:

            case 'heading':
                echo '<span class="customize-control-title">' . $this->label . '</span>';
                break;

            case 'custom_message':
                echo '<p class="description">' . $this->description . '</p>';
                break;

            case 'hr':
                echo '<hr />';
                break;

            case 'subheader':
                echo '<span class="customize-control-title" style="font-size: 1.5em">' . $this->label . '</span>';
                break;

            case 'hr-bold':
                echo '<hr style="border-color:#000000" />';
                break;
        }
    }
}
