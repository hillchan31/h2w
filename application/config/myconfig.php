<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config['next_page_keyword'] = array(
    '下一页',
    '下一页>',
    '下页',
    '>></a>',
    '>&gt;</a>',
    'http://www.xinhuanet.com/photo/static/articler.gif',
    'http://y0.ifengimg.com/news/detail/nable_right.png',
    '>[2]<',
    '展开全文',
);

/**
 * array($start_string,$end_string)
 */
$config['remove_tag'] = array(
    // remove script
    array('<script', '</script>'),
    // remove comment
    array('<!--', '-->'),
    // remove noise
    array('更', '>>'),
    array('查', '>>'),
    // remove noise
    array('<a id="nextMonth"', '</a>')
);
