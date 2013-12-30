<?php
class ModelMangaStatus extends Model {
	public function addStatus($data) {

        //insert to the table manga
        $this->db->query("INSERT INTO " . DB_PREFIX . "manga_status SET value = '" . $this->db->escape($data['name']) . "', sort_order = '" . $this->db->escape($data['sort_order']) . "', language_id = '" . (int)$this->config->get('config_language_id') . "'");

    }
	
	public function editStatus($manga_status_id, $data) {

        //update the table managa_status
		$this->db->query("UPDATE " . DB_PREFIX . "manga_status SET value = '" . $this->db->escape($data['name']) . "', sort_order = '" . $this->db->escape($data['sort_order']) . "' WHERE manga_status_id = '" . (int)$manga_status_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

    }
	
	public function deleteStatus($manga_status_id) {

        //delete from the table manga_status
		$this->db->query("DELETE FROM " . DB_PREFIX . "manga_status WHERE manga_status_id = '" . $manga_status_id . "'");

    }
	
	// Function to repair any erroneous categories that are not in the category path table.
	public function repairCategories($parent_id = 0) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category WHERE parent_id = '" . (int)$parent_id . "'");
		
		foreach ($query->rows as $category) {
			// Delete the path below the current one
			$this->db->query("DELETE FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$category['category_id'] . "'");
			
			// Fix for records with no paths
			$level = 0;
			
			$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "category_path` WHERE category_id = '" . (int)$parent_id . "' ORDER BY level ASC");
			
			foreach ($query->rows as $result) {
				$this->db->query("INSERT INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$result['path_id'] . "', level = '" . (int)$level . "'");
				
				$level++;
			}
			
			$this->db->query("REPLACE INTO `" . DB_PREFIX . "category_path` SET category_id = '" . (int)$category['category_id'] . "', `path_id` = '" . (int)$category['category_id'] . "', level = '" . (int)$level . "'");
						
			$this->repairCategories($category['category_id']);
		}
	}
			
	public function getStatus($manga_status_id) {
		$query = $this->db->query("SELECT * FROM dc_manga_status WHERE manga_status_id = '" . (int)$manga_status_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	} 
	
	public function getAllStatus($data=array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "manga_status";

        if(isset($data['order'])) {
            if(strtolower($data['order']) === 'desc') {
                $order = 'DESC';
            }else{
                $order = 'ASC';
            }

            $sql .= " ORDER BY sort_order " . $order;
        }

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
		 
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
						
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
				
	public function getCategoryDescriptions($category_id) {
		$category_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$category_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_keyword'     => $result['meta_keyword'],
				'meta_description' => $result['meta_description'],
				'description'      => $result['description']
			);
		}
		
		return $category_description_data;
	}	
	
	public function getCategoryFilters($category_id) {
		$category_filter_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$category_filter_data[] = $result['filter_id'];
		}

		return $category_filter_data;
	}

	
	public function getCategoryStores($category_id) {
		$category_store_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_store WHERE category_id = '" . (int)$category_id . "'");

		foreach ($query->rows as $result) {
			$category_store_data[] = $result['store_id'];
		}
		
		return $category_store_data;
	}

	public function getCategoryLayouts($category_id) {
		$category_layout_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int)$category_id . "'");
		
		foreach ($query->rows as $result) {
			$category_layout_data[$result['store_id']] = $result['layout_id'];
		}
		
		return $category_layout_data;
	}
		
	public function getTotalStatus() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "manga_status");
		
		return $query->row['total'];
	}	
		
	public function getTotalCategoriesByImageId($image_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category WHERE image_id = '" . (int)$image_id . "'");
		
		return $query->row['total'];
	}

	public function getTotalCategoriesByLayoutId($layout_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category_to_layout WHERE layout_id = '" . (int)$layout_id . "'");

		return $query->row['total'];
	}		
}
?>