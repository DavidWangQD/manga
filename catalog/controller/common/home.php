<?php  
class ControllerCommonHome extends Controller {
	public function index() {

        $this->load->model('manga/manga');

        $this->data['hotComics'] = $this->model_manga_manga->getHotComics();

        $this->template = 'default/template/common/home.tpl';

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