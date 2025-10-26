<?php
class Node {
    public $data;
    public $left;
    public $right;

    public function __construct($data) {
        $this->data = $data;
        $this->left = null;
        $this->right = null;
    }
}

$jsonPath = __DIR__ . "/books.json";
if (!file_exists($jsonPath)) {
    die("Error: books.json file not found at $jsonPath");
}

$books = json_decode(file_get_contents($jsonPath), true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die("Error decoding JSON: " . json_last_error_msg());
}

$hashTable = [];
foreach ($books as $book) {
    $key = md5(strtolower($book['title'] . ' ' . $book['author']));
    $hashTable[$key] = new Node($book);
}

function searchBook($query, $hashTable) {
    $query = strtolower($query);
    $results = [];
    foreach ($hashTable as $node) {
        $book = $node->data;
        if (
            strpos(strtolower($book['title']), $query) !== false ||
            strpos(strtolower($book['author']), $query) !== false
        ) {
            $results[] = $book;
        }
    }
    return $results;
}

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$results = [];
if (!empty($search)) {
    $results = searchBook($search, $hashTable);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Library Hashtable Search</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    * {
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body {
        margin: 0;
        padding: 40px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: radial-gradient(circle at top left, #141E30, #243B55);
        color: #eee;
    }

    h1 {
        font-size: 2.5rem;
        letter-spacing: 1px;
        text-align: center;
        background: linear-gradient(90deg, #00DBDE, #FC00FF);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 25px;
        text-shadow: 0 0 15px rgba(255,255,255,0.2);
    }

    form {
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        padding: 25px 30px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        display: flex;
        gap: 12px;
        width: 100%;
        max-width: 550px;
    }

    input[type="text"] {
        flex: 1;
        padding: 12px 15px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
        outline: none;
        transition: 0.3s;
    }

    input[type="text"]:focus {
        box-shadow: 0 0 10px #00DBDE;
        background: rgba(255, 255, 255, 0.15);
    }

    button {
        background: linear-gradient(135deg, #FC00FF, #00DBDE);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    button:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 0 12px rgba(0,219,222,0.7);
    }

    .results {
        margin-top: 35px;
        width: 100%;
        max-width: 700px;
    }

    h3 {
        color: #00DBDE;
        text-align: center;
        font-weight: 500;
        margin-bottom: 25px;
    }

    .book {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255,255,255,0.1);
        padding: 18px 20px;
        border-radius: 12px;
        margin-bottom: 18px;
        box-shadow: 0 3px 12px rgba(0,0,0,0.25);
        display: flex;
        gap: 18px;
        align-items: flex-start;
        transition: transform 0.25s ease, background 0.3s ease;
    }

    .book:hover {
        transform: scale(1.02);
        background: rgba(255,255,255,0.08);
    }

    .book img {
        width: 90px;
        height: auto;
        border-radius: 8px;
        object-fit: cover;
        box-shadow: 0 0 10px rgba(0,0,0,0.4);
    }

    .book strong {
        color: #00DBDE;
    }

    .book a {
        color: #FC00FF;
        text-decoration: none;
        font-weight: 600;
    }

    .book a:hover {
        text-decoration: underline;
    }

    .no-result {
        background: rgba(255,255,255,0.05);
        padding: 15px;
        border-radius: 10px;
        color: #aaa;
        box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        text-align: center;
        font-style: italic;
    }

    footer {
        margin-top: auto;
        padding: 20px;
        text-align: center;
        color: #888;
        font-size: 14px;
    }
</style>
</head>
<body>
    <h1>🔮 Library Hashtable Search</h1>

    <form method="get">
        <input type="text" name="search" placeholder="Type a title or author..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit"><i class="fa fa-search"></i> Search</button>
    </form>

    <div class="results">
        <?php if (!empty($search)): ?>
            <h3>Results for "<?= htmlspecialchars($search) ?>"</h3>
            <?php if (empty($results)): ?>
                <p class="no-result">No matching books found.</p>
            <?php else: ?>
                <?php foreach ($results as $book): ?>
                    <div class="book">
                        <?php if (!empty($book['imageLink'])): ?>
                            <img src="<?= htmlspecialchars($book['imageLink']) ?>" alt="Book cover">
                        <?php endif; ?>
                        <div>
                            <strong>Title:</strong> <?= htmlspecialchars($book['title']) ?><br>
                            <strong>Author:</strong> <?= htmlspecialchars($book['author']) ?><br>
                            <?php if (!empty($book['category'])): ?>
                                <strong>Category:</strong> <?= htmlspecialchars($book['category']) ?><br>
                            <?php endif; ?>
                            <strong>Language:</strong> <?= htmlspecialchars($book['language']) ?><br>
                            <strong>Year:</strong> <?= htmlspecialchars($book['year']) ?><br>
                            <?php if (!empty($book['link'])): ?>
                                <a href="<?= htmlspecialchars($book['link']) ?>" target="_blank">More info →</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    
</body>
</html>
