<?php
    $data[0] = array(
    	"title" => "Ticket (New): Navigation",
    	"abstract" => "Hello!, I'm trying to connect to a_blacklisturl, but the page always show server too busy...",
    	"date" => "Apr 01, 2013@21:28",
    	"origin" => "user ip 192.168.0.32");
    $data[1] = array(
    	"title" => "Ticket (Request): New Client",
    	"abstract" => "Hi colleague!, I found a new client that want get involved with our Internet service, their...",
    	"date" => "Apr 01, 2013@22:14",
    	"origin" => "SubAdmin:Charles");
    $data[2] = array(
    	"title" => "Ticket (Closed): North AP issue",
    	"abstract" => "Hello, I replace the faulty AP (serial #2234231) with AP #0134299 in our north node, I sent ...",
    	"date" => "Apr 01, 2013@22:14",
    	"origin" => "Empl.:Dave");
    echo json_encode($data);
?>