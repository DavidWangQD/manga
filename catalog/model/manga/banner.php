<?php
class ModelMangaBanner extends Model {

    /**
     * 通过后台设置的名称， 获取相应的banner
     * @param $name
     * @return array
     */
    public function getBannerByName( $name ) {

        $sql = "SELECT
        b.name,
  bc.*
FROM
  dc_banner AS b
  LEFT JOIN " . DB_PREFIX . "banner_image AS bc
    ON b.`banner_id` = bc.`banner_id`
WHERE b.`name` = '" . $name . "'
  AND b.status = '1'";

        $query = $this->db->query($sql);
        if( $query->num_rows > 0){
            return $query->rows;
        }else{
            return array();
        }

    }
}

