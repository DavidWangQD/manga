<?php 
class ControllerMangaManga extends Controller { 
	private $error = array();
 
	public function index() {
		$this->language->load('manga/manga');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/manga');
		 
		$this->getList();
	}

	public function insert() {
		$this->language->load('manga/manga');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/manga');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_manga_manga->addCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('manga/manga', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('manga/manga');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/manga');
		
		//if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$this->model_manga_manga->editManga($this->request->get['manga_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->redirect($this->url->link('manga/manga', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('manga/manga');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/manga');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $manga_id) {
				$this->model_manga_manga->deleteCategory($manga_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('manga/manga', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getList();
	}
	
	public function repair() {
		$this->language->load('manga/manga');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('manga/manga');
		
		if ($this->validateRepair()) {
			$this->model_manga_manga->repairCategories();

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('manga/manga', 'token=' . $this->session->data['token'], 'SSL'));
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
			'href'      => $this->url->link('manga/manga', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->link('manga/manga/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('manga/manga/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['repair'] = $this->url->link('manga/manga/repair', 'token=' . $this->session->data['token'] . $url, 'SSL');
		
		$this->data['categories'] = array();
		
		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
				
		$manga_total = $this->model_manga_manga->getTotalMangas();

		$results = $this->model_manga_manga->getMangas($data);

		foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('manga/manga/update', 'token=' . $this->session->data['token'] . '&manga_id=' . $result['manga_id'] . $url, 'SSL')
			);

			$this->data['mangas'][] = array(
				'manga_id'    => $result['manga_id'],
				'title'       => $result['title'],
				'sort_order'  => $result['sort_order'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['manga_id'], $this->request->post['selected']),
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
		$pagination->total = $manga_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('manga/manga', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->template = 'manga/manga_list.tpl';
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
				
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description'] = $this->language->get('entry_description');

		$this->data['entry_author'] = $this->language->get('entry_author');
        $this->data['entry_keyword'] = $this->language->get('entry_keyword');
        $this->data['entry_image'] = $this->language->get('entry_image');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_show'] = $this->language->get('entry_show');
        $this->data['entry_viewed'] = $this->language->get('entry_viewed');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_design'] = $this->language->get('tab_design');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	
 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('manga/manga', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['manga_id'])) {
			$this->data['action'] = $this->url->link('manga/manga/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('manga/manga/update', 'token=' . $this->session->data['token'] . '&manga_id=' . $this->request->get['manga_id'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('manga/manga', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['manga_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$manga_info = $this->model_manga_manga->getManga($this->request->get['manga_id']);
    	}

		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['title'])) {
			$this->data['title'] = $this->request->post['title'];
		} elseif (!empty($manga_info)) {
			$this->data['title'] = $manga_info['title'];
		} else {
			$this->data['title'] = '';
		}
		
		if (isset($this->request->post['meta_description'])) {
			$this->data['meta_description'] = $this->request->post['meta_description'];
		} elseif (!empty($manga_info)) {
			$this->data['meta_description'] = $manga_info['meta_description'];
		} else {
			$this->data['meta_description'] = '';
		}

        if (isset($this->request->post['meta_keyword'])) {
            $this->data['meta_keyword'] = $this->request->post['meta_keyword'];
        } elseif (!empty($manga_info)) {
            $this->data['meta_keyword'] = $manga_info['meta_keyword'];
        } else {
            $this->data['meta_keyword'] = '';
        }

        if (isset($this->request->post['description'])) {
            $this->data['description'] = $this->request->post['description'];
        } elseif (!empty($manga_info)) {
            $this->data['description'] = $manga_info['description'];
        } else {
            $this->data['description'] = '';
        }

        if (isset($this->request->post['author'])) {
            $this->data['author'] = $this->request->post['author'];
        } elseif (!empty($manga_info)) {
            $this->data['author'] = $manga_info['author'];
        } else {
            $this->data['author'] = '';
        }

        if (isset($this->request->post['keyword'])) {
            $this->data['keyword'] = $this->request->post['keyword'];
        } elseif (!empty($manga_info)) {
            $this->data['keyword'] = $manga_info['keyword'];
        } else {
            $this->data['keyword'] = '';
        }

        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (!empty($manga_info)) {
            $this->data['image'] = $manga_info['image'];
        } else {
            $this->data['image'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
            $this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($manga_info) && $manga_info['image'] && file_exists(DIR_IMAGE . $manga_info['image'])) {
            $this->data['thumb'] = $this->model_tool_image->resize($manga_info['image'], 100, 100);
        } else {
            $this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        }

        $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

        if (isset($this->request->post['sort_order'])) {
            $this->data['sort_order'] = $this->request->post['sort_order'];
        } elseif (!empty($manga_info)) {
            $this->data['sort_order'] = $manga_info['sort_order'];
        } else {
            $this->data['sort_order'] = 1;
        }

        if (isset($this->request->post['status'])) {
            $this->data['status'] = $this->request->post['status'];
        } elseif (!empty($manga_info)) {
            $this->data['status'] = $manga_info['status'];
        } else {
            $this->data['status'] = 1;
        }

        if (isset($this->request->post['show'])) {
            $this->data['show'] = $this->request->post['show'];
        } elseif (!empty($manga_info)) {
            $this->data['show'] = $manga_info['show'];
        } else {
            $this->data['show'] = 1;
        }

        if (isset($this->request->post['viewed'])) {
            $this->data['viewed'] = $this->request->post['viewed'];
        } elseif (!empty($manga_info)) {
            $this->data['viewed'] = $manga_info['viewed'];
        } else {
            $this->data['viewed'] = 0;
        }
						
		$this->template = 'manga/manga_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'manga/manga')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		/*foreach ($this->request->post['category_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}*/

        if(utf8_strlen($this->request->post['title']) < 1 || utf8_strlen($this->request->post['title']) > 255) {
            $this->error['name'] = $this->language->get('error_name');
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
		if (!$this->user->hasPermission('modify', 'manga/manga')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
	
	protected function validateRepair() {
		if (!$this->user->hasPermission('modify', 'manga/manga')) {
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
			$this->load->model('manga/manga');
			
			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$results = $this->model_manga_manga->getCategories($data);
				
			foreach ($results as $result) {
				$json[] = array(
					'manga_id' => $result['manga_id'], 
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