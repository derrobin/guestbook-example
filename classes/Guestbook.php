<?php
class Guestbook {

	public function remove( $id ) {
		$db = $this->getDb();
		$statement = $db->prepare( "DELETE FROM guestbook WHERE id=?" );
		$statement->bind_param( "s", $id );
		return $this->doQuery( $db, $statement );
	}

	public function add( $entry ) {
		$db = $this->getDb();
		$statement = $db->prepare( "INSERT INTO guestbook ( username, email, title, content, createdAt ) VALUES ( ?, ?, ?, ?, ? )" );
		$statement->bind_param( "sssss",
			mysql_real_escape_string( $entry->username ),
			mysql_real_escape_string( $entry->email ),
			mysql_real_escape_string( $entry->title ),
			mysql_real_escape_string( $entry->content ),
			$entry->date
		);
		return $this->doQuery( $db, $statement );
	}

	public function getAllEntries() {
		$db = $this->getDb();
		$records = $db->query( "SELECT * FROM guestbook ORDER BY createdAt DESC" );
		$data = [];
		while ( $row = $records->fetch_assoc() ) { // instead of $records->fetch_all( MYSQLI_ASSOC ) for downward compatibility to php 5.3.2
			$data[] = $row; 
		}
		mysqli_close( $db );
		return $data;
	}

	private function getDb() {
		return new mysqli( "localhost", "root", "", "guestbook" );
	}

	private function doQuery( $db, $statement ) {
		$return = true;
		//$result = $db->query( $sql );
		$result = $statement->execute();

		if( $result ) {
			if( substr( $statement->sqlstate, 0, 6 ) === "INSERT" ) {
				$return = $result->insert_id;
			} else {
				$return = $result;
			}
		} else {
			$return = false;
		}

		$statement->close();
		mysqli_close( $db );
		return $return;
	}

}
?>