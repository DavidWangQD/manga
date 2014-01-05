<?php
class ControllerCommonLess extends Controller {

    public function index() {
        if( CSS_COMPILE ){
            $this->compileLess();
        }

    }

    private function compileLess(){

        $lessc = new lessc();
        $lessIndexPath = DIR_TEMPLATE.'/default/stylesheet/less/index.less';
        $cssIndexPath = DIR_TEMPLATE . '/default/stylesheet/stylesheet.css';

        $lessc->checkedCompile( $lessIndexPath, $cssIndexPath);

    }
}