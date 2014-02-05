<?php
class ControllerModuleFreeRead extends Controller {

    public function index(){

        $this->load->model('design/layout');
        $this->load->model('catalog/category');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/free_read.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/free_read.tpl';
        } else {
            $this->template = 'default/template/module/free_read.tpl';
        }

        $this->render();
    }



}

