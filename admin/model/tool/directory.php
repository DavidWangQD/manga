<?php
class ModelToolDirectory extends Model {

    public function deleteDir($dirPath) {

        if(is_dir($dirPath)) {

            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                $dirPath .= '/';
            }
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    $this->deleteDir($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($dirPath);

        }

    }
}
?>