<?php
class ControllerModuleMyComic extends Controller {

    public function index(){
        $this->load->model('manga/manga');

        $data = array(
            'order' => 'm.date_added',
            'orderType' => 'desc'
        );
        $limit = array(
            'start' => 0,
            'num' => 6
        );
        $this->data['myComics'] = $this->model_manga_manga->getComics( $data , $limit);

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/my_comic.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/my_comic.tpl';
        } else {
            $this->template = 'default/template/module/my_comic.tpl';
        }

        $this->render();
    }
}