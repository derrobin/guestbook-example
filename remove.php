<?php

require( 'classes/Guestbook.php' );

if( empty( $_POST[ 'id' ] ) ) {
	echo 'Error: id missing!';
	return false;
}

$guestbook = new Guestbook();
$guestbook->remove( $_POST[ 'id' ] );
echo "SUCCEEDED";

?>