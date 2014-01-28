<?php
class ControllerCommonTopComic extends Controller {

    public function index(){





        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/top_comic.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/top_comic.tpl';
        } else {
            $this->template = 'default/template/common/top_comic.tpl';
        }

        $this->render();
    }

}