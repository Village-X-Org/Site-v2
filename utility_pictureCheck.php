<?php
require_once("utilities.php");
$idArray = array();
$result = doQuery("SELECT picture_id, picture_filename FROM pictures");
while ($row = $result->fetch_assoc()) {
	if (!file_exists(PICTURES_DIR.$row['picture_filename'])) {
		array_push($idArray, $row['picture_id']);
	}
}
echo join(',',$idArray);
