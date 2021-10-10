<?php
namespace Projet;

require_once './ArrayList.php';

$l = new ArrayList();

$l->add("test1");
$l->add("test2");
$l->add("test3");
$l->add("test4");
$l->add("test5");
$l->add("test5");
$l->add("test5");
$l->add("test6");
$l->add("test7");
$l->add("test8");
$l->add("test9");
$l->add("test10");

$l->dump();

$l->removeAt(8);
$l->dump();

$l->removeFirst("test5");
$l->dump();

$l->insert(8, "test_insert");
$l->dump();

var_dump($l->size());

var_dump($l->get(9));

?>