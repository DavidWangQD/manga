<?php  
class ControllerCommonHome extends Controller {
	public function index() {

        $this->load->model('manga/manga');
        $this->load->model('manga/chapter');

        $this->data['hotComics'] = $this->model_manga_manga->getHotComics();

        $chapters = $this->model_manga_chapter->getChapters();
        $this->refacterChapter( $chapters );
        $this->data['chapters'] = $chapters;
        $this->template = 'default/template/common/home.tpl';

		$this->children = array(
			'common/free_read',
			'common/my_comic',
			'common/free_read',
			'common/free_read',
			'common/footer',
			'common/header'
		);

		$this->response->setOutput($this->render());
	}

    private function refacterChapter( &$chapters ){
        $this->load->model('tool/image');
        foreach($chapters as $key=>$chapter ){

            $timeAgo = time() - strtotime( $chapter['create_date']);
            $chapters[$key]['timeAgo'] = date('H', $timeAgo) .' hours';

            if( is_file(DIR_IMAGE . $chapter['image']) ){
                $chapters[$key]['image'] = $this->model_tool_image->resize( $chapter['image'], 50, 100);
            }else{
                $chapters[$key]['image'] = $this->model_tool_image->resize( DEFAULT_IMAGE, 100, 100);

            }

        }
    }
}
?>