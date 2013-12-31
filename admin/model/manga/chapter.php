<?php
class ModelMangaChapter extends Model {
	public function addCategory($data) {
        //insert to the table chapter
        $this->db->query("INSERT INTO " . DB_PREFIX . "chapter SET manga_id = '" . (int)$data['manga_id'] . "', meta_description = '" . $this->db->escape($data['meta_description']) . "', meta_keyword = '" . $this->db->escape($data['meta_keyword']) . "', num = '" . $this->db->escape($data['num']) . "', image = '" . $this->db->escape($data['image']) . "', `show` = '". $this->db->escape($data['show']) . "', date_added=NOW(), date_modified=NOW()");

        $chapter_id = $this->db->getLastId();

        //insert to the table chapter_description
        if($chapter_id) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "chapter_description SET chapter_id = '" . (int)$chapter_id . "', language_id = '" . (int)$this->config->get('config_language_id') . "', title = '" . $this->db->escape($data['title']) . "', description = '" . $this->db->escape($data['description']) . "'");
        }

        //insert into the table seo_keyword
        if ($data['keyword']) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'chapter_id=" . (int)$chapter_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        }

    }
	
	public function editChapter($chapter_id, $data) {

        //update the table chapter
		$this->db->query("UPDATE " . DB_PREFIX . "chapter SET manga_id = '" . (int)$data['manga_id'] . "', meta_description = '" . $this->db->escape($data['meta_description']) . "', meta_keyword = '" . $this->db->escape($data['meta_keyword']) . "', num = '" . $this->db->escape($data['num']) . "', image = '" . $this->db->escape($data['image']) . "', `show` = '". $this->db->escape($data['show']) . "' WHERE chapter_id = '" . (int)$chapter_id . "'");

        //update the table chapter_description
        $this->db->query("UPDATE " . DB_PREFIX . "chapter_description SET title = '" . $this->db->escape($data['title']) . "', description = '" . $this->db->escape($data['description']) . "' WHERE chapter_id = '" . (int)$chapter_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");

        //update seo_keyword
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'chapter_id=" . (int)$chapter_id. "'");

        if ($data['keyword']) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'chapter_id=" . (int)$chapter_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
        }

    }
	
	public function deleteChapter($chapter_id) {

        //delete from the table chapter
		$this->db->query("DELETE FROM " . DB_PREFIX . "chapter WHERE chapter_id = '" . $chapter_id . "'");

        //delete from the table chapter_description
        $this->db->query("DELETE FROM " . DB_PREFIX . "chapter_description WHERE chapter_id = '" . $chapter_id . "'");

        //delete from the table dc_url_alias
        $this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'chapter_id=" . $chapter_id . "'");

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

	/*public function getManga($chapter_id) {
		$query = $this->db->query("SELECT m.*, md.author, md.title, md.description, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'manga_id=".$chapter_id."') AS keyword FROM " . DB_PREFIX . "manga AS m LEFT JOIN " . DB_PREFIX . "manga_description AS md ON m.manga_id = md.manga_id WHERE m.manga_id ='" . (int)$chapter_id . "' AND md.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}*/

    public function getChapterInfo($chapter_id) {
        $query = $this->db->query("SELECT c.*, cd.title, cd.description, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'chapter_id=".$chapter_id."') AS keyword FROM " . DB_PREFIX . "chapter AS c LEFT JOIN " . DB_PREFIX . "chapter_description AS cd ON c.chapter_id = cd.chapter_id WHERE c.chapter_id ='" . (int)$chapter_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

        return $query->row;
    }
	
	public function getChapters($data) {

		$sql = "SELECT c.chapter_id, cd.title, c.num FROM " . DB_PREFIX . "chapter AS c LEFT JOIN " . DB_PREFIX . "chapter_description AS cd ON c.chapter_id = cd.chapter_id";
		
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
		
	public function getTotalChapters() {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "chapter");
		
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