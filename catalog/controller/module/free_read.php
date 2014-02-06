<?php
class ControllerModuleFreeRead extends Controller {

    public function index(){

        $this->load->model('design/layout');
        $this->load->model('catalog/category');

        $this->load->model('manga/manga');
        $data = array(
            'order' => 'm.date_added',
            'orderType' => 'desc'
        );
        $limit = array(
            'start' => 0,
            'num' => 6
        );
        $this->data['newComics'] = $this->model_manga_manga->getComics( $data , $limit);

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/free_read.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/free_read.tpl';
        } else {
            $this->template = 'default/template/module/free_read.tpl';
        }

        $this->render();
    }



}

