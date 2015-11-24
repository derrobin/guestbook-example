<?php
class GuestbookEntry {

	private static $dateFormat = 'Y-m-d H:i:s';

	public $id;
	public $username;
	public $title;
	public $email;
	public $content;
	public $date;

	public static function createBy( $array ) {
		$o = new GuestbookEntry();
		$o->id = isset( $array[ 'id' ] ) ? $array[ 'id' ] : '';
		$o->username = strip_tags( $array[ 'username' ] );
		$o->title = strip_tags( $array[ 'title' ] );
		$o->email = strip_tags( $array[ 'email' ] );
		$o->content = strip_tags( $array[ 'content' ] );
		$o->date = isset( $array ) && isset( $array[ 'createdAt' ] )
			? $array[ 'createdAt' ]
			: date( self::$dateFormat );
		return $o;
	}

	public function renderHtml( $inverted ) {
		$class = $inverted == "false" ? 'timeline-inverted' : '';
		$dateFormatted = DateTime::createFromFormat( self::$dateFormat, $this->date )->format( 'd. F Y' );
		$html = <<<EOD
<li class="{$class}">
    <div class="timeline-panel">
        <div class="timeline-heading">
            <h4>{$this->title} <span class="delete-entry glyphicon glyphicon-remove" data-id="{$this->id}" aria-hidden="true"></span></h4>
        </div>
        <div class="timeline-body">
            <p class="text-muted">{$this->content}</p>
        </div>
        <div class="timeline-heading">
            <h4 class="subheading">{$dateFormatted}</h4>
            <h4 class="subheading">von <b>{$this->username}</b></h4>
        </div>
    </div>
</li>
EOD;
		return $html;	
	}
}
?>