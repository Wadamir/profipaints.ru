<?php
class One_Press_Textinput_Custom_Control extends WP_Customize_Control
{
    public function render_content()
    {
        // var_dump($this->placeholder);
?>
        <input type="text" value="<?php echo esc_attr($this->value()); ?>" />
<?php
    }
}
