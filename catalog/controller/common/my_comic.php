<?php
class ControllerCommonMyComic extends Controller {

    public function index(){

        $this->load->model('manga/');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/my_comic.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/my_comic.tpl';
        } else {
            $this->template = 'default/template/common/my_comic.tpl';
        }

        $this->render();
    }
}