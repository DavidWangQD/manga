<?php
class ModelMangaChapter extends Model {

    /**
     * 获得章节目录
     * @return array
     */
    public function getChapters(){

        $sql = "SELECT
  cpt.`chapter_id`,
  cpt.`image`,
  cptd.`title` AS chapter_title,
  cpt.`date_added` AS create_date,
   mgd.`title` AS manga_title,
   mgd.`author`,

   GROUP_CONCAT(gend.`title`) AS genre_title
FROM
  " . DB_PREFIX . "chapter AS cpt
  LEFT JOIN " . DB_PREFIX . "chapter_description AS cptd
      ON cpt.`chapter_id`=cptd.`chapter_id`

  LEFT JOIN " . DB_PREFIX . "manga AS mg
    ON cpt.`manga_id` = mg.`manga_id`

LEFT JOIN " . DB_PREFIX . "manga_description AS mgd
    ON mg.`manga_id`=mgd.`manga_id`

    LEFT JOIN " . DB_PREFIX . "manga_to_genre AS mtg
    ON mtg.`manga_id` = mg.`manga_id`

    LEFT JOIN " . DB_PREFIX . "genre AS gen
    ON gen.`genre_id`=mtg.`genre_id`

    LEFT JOIN " . DB_PREFIX . "genre_description AS gend
    ON gend.`genre_id`=gen.`genre_id`


    GROUP BY cpt.`chapter_id`
ORDER BY cpt.date_added DESC ";

        $query = $this->db->query( $sql );
        if( $query->num_rows > 0){
            return $query->rows;
        }else{
            return array();
        }
    }
}




