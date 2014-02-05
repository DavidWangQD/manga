<?php
class ControllerModuleMyComic extends Controller {

    public function index(){


        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/my_comic.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/my_comic.tpl';
        } else {
            $this->template = 'default/template/module/my_comic.tpl';
        }

        $this->render();
    }
}