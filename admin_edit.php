<?php
require_once("utilities.php");
if (!$session_is_admin) {
	print "not logged in.";
	die(0);
}

$id = param('id');
$value = param('value');
$idColumn = param('idColumn');

$parts = explode(':', $id);
if (!$session_is_admin) {
	print "id improperly formatted";
	die(0);
}
$table = $parts[0];
$id = $parts[1];
$column = $parts[2];

$str = "UPDATE $table SET $column=? WHERE $idColumn=?";
print $str.'\n';
$stmt = prepare($str);
$stmt->bind_param('si', $value, $id);
execute($stmt);
$stmt->close();


/* UPDATE projects a INNER JOIN project_types b ON a.project_type = b.pt_label SET a.project_type_id=b.pt_id


CREATE TABLE `project_types` (
  `pt_id` int NOT NULL,
  `pt_label` varchar(20) NOT NULL,
  `pt_sample_image` int NOT NULL
);


INSERT INTO `project_types` (`pt_id`, `pt_label`, `pt_sample_image`) VALUES
(1, 'house', 2174),
(2, 'livestock', 2164),
(3, 'farm', 2186),
(4, 'nursery', 2166),
(5, 'school', 2166),
(6, 'water', 2172),
(7, 'business', 2511),
(8, 'clinic', 3259);

ALTER TABLE `project_types`
  ADD PRIMARY KEY (`pt_id`);

ALTER TABLE `project_types`
  MODIFY `pt_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;
*/
?>
