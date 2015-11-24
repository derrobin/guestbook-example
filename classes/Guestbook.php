<?php
class Guestbook {

	public function remove( $id ) {
		return $this->doQuery( "DELETE FROM guestbook WHERE id=" . $id );
	}

	public function add( $entry ) {
		return $this->doQuery( "INSERT INTO guestbook ( username, email, title, content, createdAt ) VALUES ( '".mysql_real_escape_string( $entry->username )."', '".mysql_real_escape_string( $entry->email )."', '".mysql_real_escape_string( $entry->title )."', '".mysql_real_escape_string( $entry->content )."', '".$entry->date."' )" );
	}

	public function getAllEntries() {
		$db = $this->getDb();
		$records = $db->query( "SELECT * FROM guestbook ORDER BY createdAt DESC" );
		$data = [];
		while ( $row = $records->fetch_assoc() ) { // instead of $records->fetch_all( MYSQLI_ASSOC ) for downward compatibility to php 5.3.2
			$data[] = $row; 
		}
		return $data;
	}

	private function getDb() {
		return new mysqli( "localhost", "root", "", "guestbook" );
	}

	private function doQuery( $sql ) {
		$db = $this->getDb();
		$return = true;
		$result = $db->query( $sql );
		if( $result ) {
			if( substr( $sql, 0, 6 ) === "INSERT" ) {
				$return = $db->insert_id;
			} else {
				$return = $result;
			}
		} else {
			$return = false;
		}
		mysqli_close( $db );
		return $return;
	}

}
?>