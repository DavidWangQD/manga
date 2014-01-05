<?php 
class ControllerMangaDataCollection extends Controller { 
	private $error = array();
 
	public function index() {

		$this->language->load('manga/dataCollection');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/dataCollection');
		 
		$this->getForm();
	}

	public function insert() {
		$this->language->load('manga/dataCollection');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/dataCollection');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_manga_dataCollection->addGenre($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('manga/dataCollection', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('manga/dataCollection');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/dataCollection');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_manga_dataCollection->editGenre($this->request->get['genre_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('manga/dataCollection', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('manga/dataCollection');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/dataCollection');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $genre_id) {
				$this->model_manga_dataCollection->deleteGenre($genre_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('manga/dataCollection', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getList();
	}
	
	public function repair() {
		$this->language->load('manga/dataCollection');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/dataCollection');
		
		if ($this->validateRepair()) {
			$this->model_manga_dataCollection->repairCategories();

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('manga/dataCollection', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->getList();	
	}
	
	protected function getList() {
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
						
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('manga/dataCollection', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->link('manga/dataCollection/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('manga/dataCollection/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['repair'] = $this->url->link('manga/dataCollection/repair', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['categories'] = array();
		
		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
				
		$genre_total = $this->model_manga_dataCollection->getTotalGenres();

		$results = $this->model_manga_dataCollection->getGenres($data);

		foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('manga/dataCollection/update', 'token=' . $this->session->data['token'] . '&genre_id=' . $result['genre_id'] . $url, 'SSL')
			);

			$this->data['genres'][] = array(
				'genre_id'    => $result['genre_id'],
				'title'       => $result['title'],
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['genre_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 		$this->data['button_repair'] = $this->language->get('button_repair');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$pagination = new Pagination();
		$pagination->total = $genre_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('manga/dataCollection', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'manga/dataCollection_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
				
		$this->data['entry_url'] = $this->language->get('entry_url');
		$this->data['entry_manga'] = $this->language->get('entry_manga');
		$this->data['entry_matching_type'] = $this->language->get('entry_matching_type');
		$this->data['entry_matching_stuck'] = $this->language->get('entry_matching_stuck');
		$this->data['entry_matching_regExp'] = $this->language->get('entry_matching_regExp');
		$this->data['entry_chapter_variable'] = $this->language->get('entry_chapter_variable');
		$this->data['entry_chapter_range'] = $this->language->get('entry_chapter_range');
        $this->data['entry_page_variable'] = $this->language->get('entry_page_variable');
        $this->data['entry_page_range'] = $this->language->get('entry_page_range');
        $this->data['entry_progress'] = $this->language->get('entry_progress');
		
		$this->data['button_start'] = $this->language->get('button_start');

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('manga/dataCollection', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

        $this->load->model('manga/manga');
        $this->data['mangas'] = $this->model_manga_manga->getMangas();

        $this->data['token'] = $this->session->data['token'];

		$this->template = 'manga/dataCollection_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

    public function dataCollect() {

        set_time_limit(0);

        $url = $this->request->post['url'];
        $manga = $this->request->post['manga'];
        $lastImage = "";

        $matchingType = $this->request->post['matching_type'];
        $matchingRegExp = $this->request->post['matching_regExp'];
        //$matchingStuckStart = $this->request->post['matching_stuck_start'];
        //$matchingStuckEnd = $this->request->post['matching_stuck_end'];
        $currentChapter = $this->request->post['currentChapter'];
        $pageVariable = $this->request->post['page_variable'];
        $pageStart = $this->request->post['page_start'];
        $pageEnd = $this->request->post['page_end'];

        if(!file_exists(DIR_IMAGE."data/$manga/$currentChapter")) {

            for($i = $pageStart;$i < $pageEnd+1;$i++) {

                $generatedURL = str_replace($pageVariable,$i,$url);

                $html = @file_get_contents($generatedURL);

                $result = preg_match($matchingRegExp,$html,$macthingImg);

                if($result) {

                    if($macthingImg[0] == $lastImage) {
                        break;
                    }

                    $lastImage = $macthingImg[0];
                    $pathinfo = pathinfo($macthingImg[0]);
                    $extension = $pathinfo['extension'];

                    $image  = file_get_contents($macthingImg[0]);

                    if(!file_exists(DIR_IMAGE."data/$manga/$currentChapter")) {
                        @mkdir(DIR_IMAGE."data/$manga/$currentChapter",0777,true);
                    }

                    file_put_contents(DIR_IMAGE."data/$manga/$currentChapter/$i.$extension",$image);
                }else{
                    break;
                }

            }

            $this->insertChapterToDB($this->request->post,$extension);

        }

        die(json_encode('succeed'));

    }

    protected function insertChapterToDB($data,$extension) {

        $params = array(
            'manga_id'          =>  $data['manga_id'],
            'meta_description'  =>  '',
            'meta_keyword'      =>  '',
            'num'               =>  $data['currentChapter'],
            'image'             =>  "data/".$data['manga']."/".$data['currentChapter']."/0.$extension",
            'show'              =>  1,
            'title'             =>  $data['manga'] . '-' . $data['currentChapter'],
            'description'       =>  '',
            'keyword'           =>  '',
        );

        $this->load->model('manga/chapter');
        $this->model_manga_chapter->addChapter($params);
    }

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'manga/dataCollection')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

        if(utf8_strlen($this->request->post['title']) < 1 || utf8_strlen($this->request->post['title']) > 255) {
            $this->error['title'] = $this->language->get('error_title');
        }
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
	
	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'manga/dataCollection')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
	
	protected function validateRepair() {
		if (!$this->user->hasPermission('modify', 'manga/dataCollection')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
			
	public function autocomplete() {

		$json = array();
		
		if (isset($this->request->get['filter_name'])) {
			$this->load->model('manga/dataCollection');
			
			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$results = $this->model_manga_dataCollection->getGenres($data);
				
			foreach ($results as $result) {
				$json[] = array(
					'genre_id'    => $result['genre_id'],
					'title'       => $result['title'],
					'sort_order'  => $result['sort_order'],
				);
			}
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['sort_order'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}		
}
?>