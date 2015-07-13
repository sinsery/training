<?php
namespace training;

/*
 * Node Class
 */
class Node
{
	public function __construct($value){
		$this->value = $value;
	}
	public $leftNode;
	public $rightNode;
	public $value;
}

/* init data*/
$node1 = new Node('1');
$node2 = new Node('2');
$node3 = new Node('3');
$node4 = new Node('4');
$node5 = new Node('5');

$node2->leftNode = $node4;
$node2->rightNode = $node5;

$node1->leftNode = $node2;
$node1->rightNode = $node3;


print_r($node1);

/*
 * reverse function
 */
function reverseNodeByRecursion($node)
{
	$tmpNode = $node->leftNode;
	$node->leftNode = $node->rightNode;
	$node->rightNode = $tmpNode;
	if ( !empty($node->leftNode) ) {
		reverseNodeByRecursion($node->leftNode);
	}
	if ( !empty($node->rightNode) ) {
		reverseNodeByRecursion($node->rightNode);
	}
}

/* execute reverse */
reverseNodeByRecursion($node1); 

print_r($node1);

/* 
看过"白板编程没写出反转二叉树，Homebrew 作者被谷歌拒掉了"一说, 吓得我赶紧写了一个反转二叉树，其实是很基础的，但是在白板上无差的写出来确实还是有点难度， 其实在白板上直接写任何算法都会有点难度吧 哈哈
 */