<?php
class ControllerModuleTopComic extends Controller {

    public function index(){

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/top_comic.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/top_comic.tpl';
        } else {
            $this->template = 'default/template/module/top_comic.tpl';
        }

        $this->render();
    }

}