<?php
//load the author class
require_once ("../Classes/autoload.php");

use Ianwfoster\ObjectOriented\Author;


//use the constructor to create a new author
$larry = new Author ("c280d4ac-2594-44c4-838a-cd989b567be2",
	"google.com",
	"c280d4ac259444c4838acd989b567be2",
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