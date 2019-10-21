<?php
//load the author class
require_once ("../Classes/autoload.php");

use Ianwfoster\ObjectOriented\Author;
use Ramsey\Uuid\Uuid;

//use the constructor to create a new author
$author = new Author ("ca8a3786a44748d29578715736f9a80e",
	"ef62dface6ee7bc2c5d50a326861c82d",
	"http://google.com",
	"newauthor@email.com",
	"ef5054c518d9564699100c4140704fb9437e1546a52a133e859875861131e8dfabfead859fd91bfed624c724fd713535d",
	"authorTest");