<?php
header("Content-Type: application/json");

echo '[
	{"name": "Mercury", 
	"orbit": 57910000,
	"diameter": 4880,
	"date": "15/02/2007"}, 
	
	{"name": "Venus",
	"orbit": 108200000,
	"diameter": 12103.6,
	"date": "31/03/2008"}, 
	
	{"name": "Earth",
	"orbit": 149600000,
	"diameter": 12756.3,
	"date": "12/02/2009"},
	
	{"name": "Mars",
	"orbit": 227940000,
	"diameter": 6794,
	"date": "10/02/2009"}
]';
?>
