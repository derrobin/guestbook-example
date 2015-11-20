<?php

require( 'classes/Guestbook.php' );
require( 'classes/GuestbookEntry.php' );

if( empty( $_POST[ 'username' ] ) || empty( $_POST[ 'title' ] ) || empty( $_POST[ 'content' ] ) ) {
	echo 'Error: Parameters missing!';
	return false;
}

$entry = GuestbookEntry::createBy( $_POST );
$guestbook = new Guestbook();
$entryId = $guestbook->add( $entry );
if( $entryId !== false ) {
	$entry->id = $entryId;
	echo $entry->renderHtml( $_POST[ 'inverted' ] );
}

?>