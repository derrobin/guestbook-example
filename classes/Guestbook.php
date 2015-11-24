<?php
class Guestbook {

	private function getDb() {
		return new mysqli( "localhost", "root", "", "guestbook" );
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

	public function add( $entry ) {
		$db = $this->getDb();
		$statement = $db->prepare( "INSERT INTO guestbook ( username, email, title, content, createdAt ) VALUES ( ?, ?, ?, ?, ? )" );
		$statement->bind_param( "sssss",
			$entry->username,
			$entry->email,
			$entry->title,
			$entry->content,
			$entry->date
		);
		$statement->execute();
		$insertId = $statement->insert_id;
		$statement->close();
		mysqli_close( $db );
		return $insertId;
	}

	public function remove( $id ) {
		$db = $this->getDb();
		$statement = $db->prepare( "DELETE FROM guestbook WHERE id=?" );
		$statement->bind_param( "s", $id );
		$statement->execute();
		$statement->close();
		mysqli_close( $db );
	}

}
?>