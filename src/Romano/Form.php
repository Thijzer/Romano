<?php

class Form
{
    public function add($elem, $args)
    {
        $this->form[$elem] = $args;
    }

    public function parse($errors = null)
    {
        return $this->process($this->form, $errors);
    }

    private function process($elems, $errors = null)
    {
        $temp = '';
        foreach ($elems as $key => $types) {
            // create elements
            $input = Html::elem('input')->class('form-control')->id($key)->name($key)->placeholder($key);
            $label = Html::elem('label')->class('control-label has-feedback')->for($key);
            $div = Html::elem('div')->id('form-group');

            // handle errors
            if ($errors && isset($errors[$key])) {
                $div->class('has-error');
                $label = $label->end($errors[$key]['msg']);
            } elseif ($errors) {
                $div->class('has-success');
                $label = $label->end($key);
            } else {
                $label = $label->end($key);
            }

            //loop over & build up dynamic attributes
            foreach ($types as $name => $value) {
                $input->{$name}($value);
            }

            $temp[$key] = $div->end($label . $input->end());
        }
        return $temp;
    }
}
