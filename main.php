<?php
echo "<h2>📚 Digital Library Organizer</h2>";

echo "<h3>📁 Recursive Directory Display</h3>";

function displayLibrary($library, $indent = 0) {
    foreach ($library as $category => $items) {
        echo str_repeat('&nbsp;&nbsp;&nbsp;', $indent) . "📂 $category<br>";
        if (is_array($items)) {
            displayLibrary($items, $indent + 1);
        } else {
            echo str_repeat('&nbsp;&nbsp;&nbsp;', $indent + 1) . "📖 $items<br>";
        }
    }
}

$library = [
    "Fiction" => [
        "Harry Potter",
        "The Hobbit",
        "Percy Jackson"
    ],
    "Non-Fiction" => [
        "Brief History of Time",
        "The Selfish Gene"
    ],
    "Biography" => [
        "Steve Jobs",
        "Becoming"
    ]
];

displayLibrary($library);

echo "<hr><h3>📘 Hash Table for Book Details</h3>";

$books = [
    "Harry Potter" => ["author" => "J.K. Rowling", "year" => 1997, "genre" => "Fantasy"],
    "The Hobbit" => ["author" => "J.R.R. Tolkien", "year" => 1937, "genre" => "Fantasy"],
    "Percy Jackson" => ["author" => "Rick Riordan", "year" => 2005, "genre" => "Adventure"],
    "Brief History of Time" => ["author" => "Stephen Hawking", "year" => 1988, "genre" => "Science"],
    "The Selfish Gene" => ["author" => "Richard Dawkins", "year" => 1976, "genre" => "Science"],
    "Steve Jobs" => ["author" => "Walter Isaacson", "year" => 2011, "genre" => "Biography"],
    "Becoming" => ["author" => "Michelle Obama", "year" => 2018, "genre" => "Biography"]
];

function getBookInfo($books, $title) {
    if (array_key_exists($title, $books)) {
        echo "<b>Title:</b> $title<br>";
        echo "<b>Author:</b> " . $books[$title]['author'] . "<br>";
        echo "<b>Year:</b> " . $books[$title]['year'] . "<br>";
        echo "<b>Genre:</b> " . $books[$title]['genre'] . "<br><br>";
    } else {
        echo "❌ Book '$title' not found.<br><br>";
    }
}

getBookInfo($books, "Harry Potter");
getBookInfo($books, "The Hobbit");
getBookInfo($books, "Becoming");

echo "<hr><h3>🔍 Binary Search Tree (BST) for Book Titles</h3>";

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

$bst = new BinarySearchTree();
foreach (array_keys($books) as $title) {
    $bst->insert($title);
}

echo "<b>Books in Alphabetical Order:</b><br>";
$bst->inorder($bst->root);

$searchTitle = "The Hobbit";
echo "<br><b>Searching for '$searchTitle':</b><br>";
echo $bst->search($bst->root, $searchTitle) ? "✅ Found!" : "❌ Not Found!";
?>