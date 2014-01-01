<?php
class ModelMangaGenre extends Model {
	public function addGenre($data) {

        //insert to the table genre
        $this->db->query("INSERT INTO " . DB_PREFIX . "genre SET meta_description = '" . $this->db->escape($data['meta_description']) . "', meta_keyword = '" . $this->db->escape($data['meta_keyword']) . "', image = '" . $this->db->escape($data['image']) . "', sort_order = '" . $this->db->escape($data['sort_order']) . "', `show` = '". $this->db->escape($data['show']) . "', date_added=NOW(), date_modified=NOW()");

        $genre_id = $this->db->getLastId();

        //insert to the table genre_description
        if($genre_id) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "genre_description SET genre_id = '" . (int)$genre_id . "', language_id = '" . (int)$this->config->get('config_language_id') . "', title = '" . $this->db->escape($data['title']) . "', description = '" . $this->db->escape($data['description']) . "'");
        }

        //insert into the table seo_keyword
        if ($data['keyword']) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'genre_id=" . (int)$genre_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        }

    }
	
	public function editGenre($genre_id, $data) {
        
        //update the table genre
		$this->db->query("UPDATE " . DB_PREFIX . "genre SET meta_description = '" . $this->db->escape($data['meta_description']) . "', meta_keyword = '" . $this->db->escape($data['meta_keyword']) . "', image = '" . $this->db->escape($data['image']) . "', sort_order = '" . $this->db->escape($data['sort_order']) . "', `show` = '". $this->db->escape($data['show']) . "', date_modified=NOW() WHERE genre_id = '" . (int)$genre_id . "'");

        //update the table genre_description
        $this->db->query("UPDATE " . DB_PREFIX . "genre_description SET title = '" . $this->db->escape($data['title']) . "', description = '" . $this->db->escape($data['description']) . "' WHERE genre_id = '" . (int)$genre_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

        //update seo_keyword
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'genre_id=" . (int)$genre_id. "'");

        if ($data['keyword']) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'genre_id=" . (int)$genre_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        }

    }
	
	public function deleteGenre($genre_id) {

        //delete from the table genre
		$this->db->query("DELETE FROM " . DB_PREFIX . "genre WHERE genre_id = '" . $genre_id . "'");

        //delete from the table genre_description
        $this->db->query("DELETE FROM " . DB_PREFIX . "genre_description WHERE genre_id = '" . $genre_id . "'");

        //delete from the table dc_url_alias
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'genre_id=" . $genre_id . "'");

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
			
	public function getGenre($genre_id) {
		$query = $this->db->query("SELECT g.*, gd.title, gd.description, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'genre_id=".$genre_id."') AS keyword FROM " . DB_PREFIX . "genre AS g LEFT JOIN " . DB_PREFIX . "genre_description AS gd ON g.genre_id = gd.genre_id WHERE g.genre_id ='" . (int)$genre_id . "' AND gd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	} 
	
	public function getGenres($data=array()) {
		$sql = "SELECT g.genre_id, gd.title, g.sort_order FROM " . DB_PREFIX . "genre AS g LEFT JOIN " . DB_PREFIX . "genre_description AS gd ON g.genre_id = gd.genre_id";

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
		
	public function getTotalGenres() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "genre");
		
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