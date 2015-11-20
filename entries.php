<?php

require( 'classes/Guestbook.php' );
require( 'classes/GuestbookEntry.php' );

$guestbook = new Guestbook();
$entries = $guestbook->getAllEntries();

$odd = true;
foreach ( $entries as $key => $entry ) {
	$o = GuestbookEntry::createBy( $entry );
	echo $o->renderHtml( $odd );
	$odd = ! $odd;
}

?>