<?php
require_once("utilities.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Project Description Check</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        tr:hover { background-color: #f9f9f9; }
        a { color: #0066cc; text-decoration: none; }
        a:hover { text-decoration: underline; }
        .no-results { padding: 20px; color: #666; }
        .placeholder { background-color: #ffffcc; color: #cc8800; }
    </style>
</head>
<body>
    <h1>Project Description Check</h1>
    <p>Projects with placeholder text in descriptions:</p>

    <?php
    $result = doUnprotectedQuery("SELECT project_id, project_name, project_summary, project_community_problem, project_impact, project_community_partners FROM `projects` WHERE project_summary LIKE 'Insert%Here' OR project_community_problem LIKE 'Insert%Here' OR project_impact LIKE 'Insert%Here' OR project_community_partners LIKE 'Insert%Here';");

    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

    if (count($rows) == 0) {
        echo "<p class='no-results'>No projects with placeholder text found. All descriptions look good!</p>";
    } else {
        echo "<table>";
        echo "<tr>";
        echo "<th>Project Name</th>";
        echo "<th>Summary</th>";
        echo "<th>Community Problem</th>";
        echo "<th>Impact</th>";
        echo "<th>Community Partners</th>";
        echo "</tr>";

        foreach ($rows as $row) {
            echo "<tr>";
            echo "<td><a href='project.php?id=" . htmlspecialchars($row['project_id']) . "' target='_blank'>" . htmlspecialchars($row['project_name']) . "</a></td>";
            echo "<td>" . (stripos($row['project_summary'], 'Insert') !== false ? "<span class='placeholder'>" . htmlspecialchars($row['project_summary']) . "</span>" : htmlspecialchars($row['project_summary'])) . "</td>";
            echo "<td>" . (stripos($row['project_community_problem'], 'Insert') !== false ? "<span class='placeholder'>" . htmlspecialchars($row['project_community_problem']) . "</span>" : htmlspecialchars($row['project_community_problem'])) . "</td>";
            echo "<td>" . (stripos($row['project_impact'], 'Insert') !== false ? "<span class='placeholder'>" . htmlspecialchars($row['project_impact']) . "</span>" : htmlspecialchars($row['project_impact'])) . "</td>";
            echo "<td>" . (stripos($row['project_community_partners'], 'Insert') !== false ? "<span class='placeholder'>" . htmlspecialchars($row['project_community_partners']) . "</span>" : htmlspecialchars($row['project_community_partners'])) . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "<p>Total: " . count($rows) . " project(s) with placeholder text.</p>";
    }
    ?>
</body>
</html>
