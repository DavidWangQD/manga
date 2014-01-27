<?php
class ModelMangaManga extends Model {

    /**
     * 获得热门漫画
     *
     */
    function getHotComics(){

        $sql = "SELECT m.manga_id, md.title, m.sort_order FROM " . DB_PREFIX . "manga AS m
        LEFT JOIN " . DB_PREFIX . "manga_description AS md
        ON m.manga_id = md.manga_id";

        $query = $this->db->query( $sql );
        if( $query->num_rows > 0){
            return $query->rows;
        }else{
            return array();
        }
    }


}
?>