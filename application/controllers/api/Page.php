<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Page
 *
 * @author chenxi10
 */
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'tool/LIB_http.php';
require APPPATH . 'tool/LIB_parse.php';

class Page extends REST_Controller {

    function __construct() {

        parent::__construct();
    }

    function hasNext_get() {

        if (!$this->get('url')) {
            $this->response(array('ERROR' => 'url缺失'), 400);
            exit(0);
        }

        $url = $this->get('url');
        $response = http_get($url, '');

        $return = array();
        if ($this->get('debug')) {
            $return['DEBUG'] = $response;
        }

        if (!$response['FILE']) {
            $return['URL'] = $url;
            $return['HAS_NEXT'] = 3;
            $return['ERROR'] = $response['ERROR'];
            $this->response($return, 401);
            exit(0);
        }

        $encode = mb_detect_encoding($response['FILE'], array("ASCII", 'UTF-8', 'GB2312', "GBK", 'BIG5'));
        $response['FILE'] = mb_convert_encoding($response['FILE'], "UTF-8", $encode);

        foreach ($this->config->item('remove_tag') as $tag) {
            $response['FILE'] = remove($response['FILE'], $tag[0], $tag[1]);
        }

        foreach ($this->config->item('next_page_keyword') as $keyword) {
            if (strstr($response['FILE'], $keyword) != '') {

                $return['URL'] = $url;
                $return['HAS_NEXT'] = 1;
                $return['KEYWORD'] = $keyword;
                $return['DEV'] = $response['FILE'];
                $this->response($return, 201);
                exit(0);
            }
        }

        $return['URL'] = $url;
        $return['HAS_NEXT'] = 0;
        $return['DEV'] = $response['FILE'];
        $this->response($return, 200);
        exit(0);
    }

}
