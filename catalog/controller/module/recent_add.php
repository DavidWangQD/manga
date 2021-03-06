<?php
class ControllerModuleRecentAdd extends Controller {

    public function index(){

        $this->load->model('manga/manga');
        $sort = array(
            'order'=>'m.date_added',
            'orderType'=>'DESC'
        );
        $recentAdd = $this->model_manga_manga->getComics( $sort );
        $this->data['recentAdd'] = $recentAdd;

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/recent_add.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/module/recent_add.tpl';
        } else {
            $this->template = 'default/template/module/recent_add.tpl';
        }

        $this->render();

    }
}