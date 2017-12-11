<?php

$cluster   = Cassandra::cluster()                 // connects to localhost by default
				 ->withContactPoints('cassandra')
                 ->build();
try {
	$session = $cluster->connect();
} catch (Cassandra\Exception\RuntimeException $e) {
	echo "Waiting for Cassandra or Connection failure\n";
}

$createKeyspace = <<<EOD
CREATE KEYSPACE projekt1 WITH replication = {
  'class': 'SimpleStrategy',
  'replication_factor': 1
};
EOD;
$useKeyspace = <<<EOD
USE projekt1;
EOD;
$createTable = <<<EOD
CREATE TABLE test (
  id UUID,
  test VARCHAR,
  PRIMARY KEY (id)
);
EOD;
$insertEntry = <<<EOD
INSERT INTO test (id, test) 
VALUES (NOW(), 'test');
EOD;

try {
	$session->execute($createKeyspace);
} catch (Cassandra\Exception\AlreadyExistsException $e) { 
}
try {
	$session = $cluster->connect('projekt1');
	$session->execute($createTable);
} catch (Cassandra\Exception\AlreadyExistsException $e) { 

}
try {
	$session = $cluster->connect('projekt1');
	$session->execute($insertEntry);
} catch (Cassandra\Exception\AlreadyExistsException $e) { 

}

try {
	$session = $cluster->connect('projekt1');
	$future  = $session->executeAsync("SELECT id, test FROM projekt1.test;");
	echo "Result contains " . $future->get()->count() . " rows</br>\n";
	$result  = $future->get();                      // wait for the result, with an optional timeout
	$session->close();

	foreach ($result as $row) {                       // results and rows implement Iterator, Countable and ArrayAccess
	    printf("ID: %36s DATA: \"%s\"</br>\n", $row['id'], $row['test']);
	}
} catch (Cassandra\Exception $e) {
	echo get_class($e) . ": " . $e->getMessage() . "\n";
}

echo "End of page";
