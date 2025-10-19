<?php
echo "<h2>📁 Recursive Directory Display</h2>";

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
?>
?>