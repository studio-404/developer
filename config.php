<?php

defined('DIR') OR exit;

$c['cmsversion'] = '1.0.1';
$c['website.mode'] = 'UnderDeveloper'; // UnderDeveloper or WorkingMode
$c['developer.message'] = 'Website is under developer !'; // Developer message when under developer
$c['allowes.ips'] = array('176.73.234.42'); // allowed ips when website is under developer
// SITE CONFIGURATION
$c['site.url'] = 'http://developer.404.ge/'; 
$c['site.name'] = 'Developer CMS';

$c['admin.slug'] = 'administrator';
// $c['admin.hash'] = '27afd2e11e171696bb7781eaa1f34ab62527f1a7';

$c['folders.upload'] = DIR . 'files/';
$c['folders.backup'] = 'backup/';
$c['folders.plugins'] = '_plugins/';

$c['database.hostname'] = '127.0.0.1';
$c['database.charset'] = 'UTF8';
$c['database.username'] = 'geoweb_developer';
$c['database.password'] = 'I@Wn9JWJA2LPtZ*F;E';
$c['database.name'] = 'geoweb_developer';
// SITE CONFIGURATION
$c['date.timezone'] = 'Asia/Tbilisi';
$c['date.format'] = 'Y-m-d H:i:s';

$c['output.charset'] = 'UTF-8';
$c['main.language'] = 'ge';
$c['time.limit'] = 300;
$c['execution.time'] = 300;
$c['post.max.size'] = "64M";
$c['upload.max.filesize'] = "64M";
$c['session.expire.time'] = 1200; // 20 minute
//image sizes
$c['admin.photo.dementions'] = "200-130";
$c["product.view.pre.slug"] = "view"; // product page inside
$c["gallery.view.pre.slug"] = "gallery"; // gallery page inside
$c["website.directory"] = "template";
$c["invoice.due.date"] = 259200; // 3 day

return $c;
