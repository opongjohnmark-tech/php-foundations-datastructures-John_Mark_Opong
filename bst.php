<?php
echo "<h2>🔍 Binary Search Tree (BST) for Book Titles</h2>";

class Node {
    public $title;
    public $left;
    public $right;
    public function __construct($title) {
        $this->title = $title;
        $this->left = null;
        $this->right = null;
    }
}

class BinarySearchTree {
    public $root = null;
    public function insert($title) {
        $this->root = $this->insertRec($this->root, $title);
    }
    private function insertRec($node, $title) {
        if ($node == null) return new Node($title);
        if ($title < $node->title) $node->left = $this->insertRec($node->left, $title);
        else $node->right = $this->insertRec($node->right, $title);
        return $node;
    }
    public function inorder($node) {
        if ($node != null) {
            $this->inorder($node->left);
            echo "📗 " . $node->title . "<br>";
            $this->inorder($node->right);
        }
    }
    public function search($node, $title) {
        if ($node == null) return false;
        if ($node->title == $title) return true;
        if ($title < $node->title)
            return $this->search($node->left, $title);
        else
            return $this->search($node->right, $title);
    }
}

$books = ["Harry Potter", "The Hobbit", "Percy Jackson", "Brief History of Time", "The Selfish Gene", "Steve Jobs", "Becoming"];

$bst = new BinarySearchTree();
foreach ($books as $title) {
    $bst->insert($title);
}

echo "<b>Books in Alphabetical Order:</b><br>";
$bst->inorder($bst->root);

$searchTitle = "The Hobbit";
echo "<br><b>Searching for '$searchTitle':</b><br>";
echo $bst->search($bst->root, $searchTitle) ? "✅ Found!" : "❌ Not Found!";
?>