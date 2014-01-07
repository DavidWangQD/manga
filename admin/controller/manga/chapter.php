<?php 
class ControllerMangaChapter extends Controller {
	private $error = array();
 
	public function index() {
		$this->language->load('manga/chapter');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/chapter');
		 
		$this->getList();
	}

	public function insert() {
		$this->language->load('manga/chapter');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/chapter');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_manga_chapter->addChapter($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('manga/chapter', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('manga/chapter');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/chapter');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_manga_chapter->editChapter($this->request->get['chapter_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('manga/chapter', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('manga/chapter');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/chapter');
        $this->load->model('tool/directory');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {

			foreach ($this->request->post['selected'] as $chapter_info) {
                $chapter_info = explode("#",$chapter_info);
				$this->model_manga_chapter->deleteChapter($chapter_info[0]);

                if($this->request->post['delWithFiles']) {
                    $chapter_info = explode("-",$chapter_info[1]);
                    if(!empty($chapter_info[0]) && !empty($chapter_info[1])) {
                        $chapter_path = DIR_IMAGE .'data/'. $chapter_info[0] . '/' . $chapter_info[1];
                        $this->model_tool_directory->deleteDir($chapter_path);
                    }
                }

			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('manga/chapter', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getList();
	}
	
	public function repair() {
		$this->language->load('manga/chapter');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/chapter');
		
		if ($this->validateRepair()) {
			$this->model_manga_chapter->repairCategories();

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('manga/chapter', 'token=' . $this->session->data['token'], 'SSL'));
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
			'href'      => $this->url->link('manga/chapter', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->link('manga/chapter/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('manga/chapter/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['repair'] = $this->url->link('manga/chapter/repair', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['categories'] = array();
		
		$data = array(
            'sort'  => 'cd.title',
            'order' =>  'ASC',
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit'),
		);
				
		$chapter_total = $this->model_manga_chapter->getTotalChapters();

		$results = $this->model_manga_chapter->getChapters($data);

		foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('manga/chapter/update', 'token=' . $this->session->data['token'] . '&chapter_id=' . $result['chapter_id'] . $url, 'SSL')
			);

			$this->data['chapters'][] = array(
				'chapter_id'  => $result['chapter_id'],
				'title'       => $result['title'],
				'num'         => $result['num'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['chapter_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_title'] = $this->language->get('column_title');
		$this->data['column_num'] = $this->language->get('column_num');
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
		$pagination->total = $chapter_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('manga/chapter', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'manga/chapter_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
    	$this->data['text_yes'] = $this->language->get('text_yes');
    	$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');
				
		$this->data['entry_title'] = $this->language->get('entry_title');
        $this->data['entry_num'] = $this->language->get('entry_num');
        $this->data['entry_manga'] = $this->language->get('entry_manga');
        $this->data['entry_keyword'] = $this->language->get('entry_keyword');
        $this->data['entry_image'] = $this->language->get('entry_image');
        $this->data['entry_show'] = $this->language->get('entry_show');
        $this->data['entry_viewed'] = $this->language->get('entry_viewed');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description'] = $this->language->get('entry_description');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['title'])) {
			$this->data['error_title'] = $this->error['title'];
		} else {
			$this->data['error_title'] = '';
		}

        if (isset($this->error['chapter_id'])) {
            $this->data['error_chapter_id'] = $this->error['chapter_id'];
        } else {
            $this->data['error_chapter_id'] = '';
        }

        if (isset($this->error['num'])) {
            $this->data['error_num'] = $this->error['num'];
        } else {
            $this->data['error_num'] = '';
        }

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('manga/chapter', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

        if(isset($this->request->get['chapter_id'])) {
            $this->data['action'] = $this->url->link('manga/chapter/update', 'token=' . $this->session->data['token'] . '&chapter_id=' . $this->request->get['chapter_id'], 'SSL');
        }else{
            $this->data['action'] = $this->url->link('manga/chapter/insert', 'token=' . $this->session->data['token'], 'SSL');
        }
		
		$this->data['cancel'] = $this->url->link('manga/chapter', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['chapter_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$chapter_info = $this->model_manga_chapter->getChapterInfo($this->request->get['chapter_id']);
    	}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['title'])) {
			$this->data['title'] = $this->request->post['title'];
		} elseif (!empty($chapter_info)) {
			$this->data['title'] = $chapter_info['title'];
		} else {
			$this->data['title'] = '';
		}

        $this->load->model('manga/manga');
        $params = array(
            'order' =>  'ASC',
        );
        $this->data['mangas'] = $this->model_manga_manga->getMangas($params);

        if (isset($this->request->post['manga_id'])) {
            $this->data['manga_id'] = $this->request->post['manga_id'];
        } elseif (!empty($chapter_info)) {
            $this->data['manga_id'] = $chapter_info['manga_id'];
        } else {
            $this->data['manga_id'] = '';
        }

        if (isset($this->request->post['num'])) {
            $this->data['num'] = $this->request->post['num'];
        } elseif (!empty($chapter_info)) {
            $this->data['num'] = $chapter_info['num'];
        } else {
            $this->data['num'] = '';
        }

        if (isset($this->request->post['keyword'])) {
            $this->data['keyword'] = $this->request->post['keyword'];
        } elseif (!empty($chapter_info)) {
            $this->data['keyword'] = $chapter_info['keyword'];
        } else {
            $this->data['keyword'] = '';
        }

        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (!empty($chapter_info)) {
            $this->data['image'] = $chapter_info['image'];
        } else {
            $this->data['image'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
            $this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($chapter_info) && $chapter_info['image'] && file_exists(DIR_IMAGE . $chapter_info['image'])) {
            $this->data['thumb'] = $this->model_tool_image->resize($chapter_info['image'], 100, 100);
        } else {
            $this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        }

        $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

        if (isset($this->request->post['show'])) {
            $this->data['show'] = $this->request->post['show'];
        } elseif (!empty($chapter_info)) {
            $this->data['show'] = $chapter_info['show'];
        } else {
            $this->data['show'] = 1;
        }

        if (isset($this->request->post['viewed'])) {
            $this->data['viewed'] = $this->request->post['viewed'];
        } elseif (!empty($chapter_info)) {
            $this->data['viewed'] = $chapter_info['viewed'];
        } else {
            $this->data['viewed'] = 0;
        }

		if (isset($this->request->post['meta_description'])) {
			$this->data['meta_description'] = $this->request->post['meta_description'];
		} elseif (!empty($chapter_info)) {
			$this->data['meta_description'] = $chapter_info['meta_description'];
		} else {
			$this->data['meta_description'] = '';
		}

        if (isset($this->request->post['meta_keyword'])) {
            $this->data['meta_keyword'] = $this->request->post['meta_keyword'];
        } elseif (!empty($chapter_info)) {
            $this->data['meta_keyword'] = $chapter_info['meta_keyword'];
        } else {
            $this->data['meta_keyword'] = '';
        }

        if (isset($this->request->post['description'])) {
            $this->data['description'] = $this->request->post['description'];
        } elseif (!empty($chapter_info)) {
            $this->data['description'] = $chapter_info['description'];
        } else {
            $this->data['description'] = '';
        }
						
		$this->template = 'manga/chapter_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'manga/chapter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

        if(utf8_strlen($this->request->post['title']) < 1 || utf8_strlen($this->request->post['title']) > 255) {
            $this->error['title'] = $this->language->get('error_title');
        }

        if($this->request->post['chapter_id'] == 'none') {
            $this->error['chapter_id'] = $this->language->get('error_chapter_id');
        }

        if(!is_numeric($this->request->post['num'])) {
            $this->error['num'] = $this->language->get('error_num');
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
		if (!$this->user->hasPermission('modify', 'manga/chapter')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
	
	protected function validateRepair() {
		if (!$this->user->hasPermission('modify', 'manga/chapter')) {
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
			$this->load->model('manga/chapter');
			
			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$results = $this->model_manga_chapter->getCategories($data);
				
			foreach ($results as $result) {
				$json[] = array(
					'chapter_id' => $result['chapter_id'], 
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}		
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}		
}
?>