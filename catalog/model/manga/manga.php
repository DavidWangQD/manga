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

    /**
     * 根据条件 搜索
     * @param array $sorts(order, orderType)
     * @param array $limit(start, num)
     * @return array
     */
    function getComics( $sorts = null, $limit = null){

        $sql = "SELECT m.manga_id, md.title, m.sort_order FROM " . DB_PREFIX . "manga AS m
        LEFT JOIN " . DB_PREFIX . "manga_description AS md
        ON m.manga_id = md.manga_id";

        if( !empty( $sorts ) ){

            $sql .= " order by " . $sorts['order'] . ' ' . $sorts['orderType'];
        }

        if( !empty( $limit )){
            $sql .= "limit " . $limit['start'] . ', ' .$limit['num'];
        }


        $query = $this->db->query( $sql );
        if( $query->num_rows > 0){
            return $query->rows;
        }else{
            return array();
        }

    }

}
?>