<?php  
class ControllerCommonHome extends Controller {
	public function index() {

        $this->load->model('manga/manga');
        $this->load->model('manga/chapter');

        $hotComics = $this->model_manga_manga->getHotComics();
        $this->refacterComics( $hotComics );
        $this->data['hotComics'] = $hotComics;

        $chapters = $this->model_manga_chapter->getChapters();
        $this->refacterChapter( $chapters );
        $this->data['chapters'] = $chapters;
        $this->data['banner'] = $this->getBannerByName( 'Manga' );

        $this->template = 'default/template/common/home.tpl';
        $this->children = array(
            'common/column_right',
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

    private function refacterComics( &$comics ){
        $this->load->model('tool/image');
        foreach($comics as $key=>$comic ){

            if( is_file(DIR_IMAGE . $comic['image']) ){
                $comics[$key]['image'] = $this->model_tool_image->resize( $comic['image'], 100, 165);
            }else{
                $comics[$key]['image'] = $this->model_tool_image->resize( COVER_IMAGE, 100, 165);

            }
        }

    }

    private function getBannerByName( $name ){

        $this->load->model('manga/banner');
        $banner = $this->model_manga_banner->getBannerByName( $name );
        foreach($banner as $key=>$ban ){

            if( is_file(DIR_IMAGE . $ban['image']) ){
                $banner[$key]['image'] = $this->model_tool_image->resize( $ban['image'], 750, 300);
            }else{
                $banner[$key]['image'] = $this->model_tool_image->resize( DEFAULT_IMAGE, 750, 300);
            }

        }

        return $banner;

    }
}
?>