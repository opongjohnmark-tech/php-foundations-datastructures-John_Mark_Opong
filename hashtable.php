<?php
echo "<h2>📘 Hash Table for Book Details</h2>";

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
?>