<?php

try {

	$objDb = new PDO('mysql:dbname=gallery;host=localhost', 'root', 'password', array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
		PDO::ATTR_PERSISTENT => true
	));
	
	$sql = "SELECT `c`.`id`, `c`.`name` AS `category_name`,
			`i`.`id`, `i`.`image`
			FROM `categories` `c`
			JOIN `images` `i`
				ON `c`.`id` = `i`.`category`
			ORDER BY `c`.`name`, `i`.`order` ASC";
			
	$statement = $objDb->prepare($sql);
	$statement->execute();
	
	if ($statement) {
	
		$result = $statement->fetchAll(PDO::FETCH_ASSOC|PDO::FETCH_GROUP);
		
		if ($result !== false) {
			
			foreach($result as $key => $rows) {
				if (!empty($rows)) {
					$i = 1;					
					foreach($rows as $row) {						
						if ($i == 1) {
							echo '<h1>'.$row['category_name'].'</h1>';
						}
						echo $row['image'].'<br />';
						$i++;
					}
				}
			}
		
		} else {
			throw new PDOException('There are no records');
		}
	
	} else {
		throw new PDOException('Something went wrong with the statement');
	}

} catch (PDOException $e) {
	echo $e->getMessage();
}