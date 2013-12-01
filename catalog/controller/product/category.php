<?php 
class ControllerProductCategory extends Controller {  
	public function index() {

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/category.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/category.tpl';
        } else {
            $this->template = 'default/template/product/category.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header'
        );

        $this->response->setOutput($this->render());

    }
}
?>