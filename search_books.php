<?php
require 'db.php';

$query = "%" . $_GET['query'] . "%";

$stmt = $conn->prepare("SELECT * FROM Book WHERE Title LIKE ? OR Author LIKE ? OR Genre LIKE ?");
$stmt->bind_param("sss", $query, $query, $query);
$stmt->execute();
$result = $stmt->get_result();
?>

<h2>Search Results</h2>
<a href="reader_dashboard.php">🔙 Back to Dashboard</a>
<table border="1">
    <tr><th>Title</th><th>Author</th><th>Genre</th><th>Published Year</th><th>Copies Available</th></tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['Title']); ?></td>
            <td><?php echo htmlspecialchars($row['Author']); ?></td>
            <td><?php echo htmlspecialchars($row['Genre']); ?></td>
            <td><?php echo $row['Published_Year']; ?></td>
            <td><?php echo $row['Copies_Available']; ?></td>
        </tr>
    <?php } ?>
</table>
