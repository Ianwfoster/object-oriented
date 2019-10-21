<?php
//load the author class
require_once ("../Classes/autoload.php");

use Ianwfoster\ObjectOriented\Author;


//use the constructor to create a new author
$larry = new Author ("ca8a3786a44748d29578715736f9a80e",
	"ef62dface6ee7bc2c5d50a326861c82d",
	"http://google.com",
	"newauthor@email.com",
	"ef5054c518d9564699100c4140704fb9437e1546a52a133e859875861131e8dfabfead859fd91bfed624c724fd713535d",
	"authorTest");

echo("Author ID ");
echo($larry ->getAuthorId());
echo("<br>Author Activation Token: ");
echo($larry ->getAuthorActivationToken());
echo("<br>Author Avatar Url ");
echo($larry ->getAuthorAvatarUrl());
echo("<br>Author Email: ");
echo($larry ->getAuthorEmail());
echo("<br>Author Hash: ");
echo($larry ->getAuthorHash());
echo("<br>Author Author User Name");
echo($larry ->getauthorUserName());