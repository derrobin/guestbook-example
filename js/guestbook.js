$(function() {

    function bindings() {
        $( '.delete-entry' ).unbind( 'click' );
        $( '.delete-entry' ).bind( 'click', function( event ) {
            var id = $( event.currentTarget ).data( 'id' );
            $.ajax({
                url: "remove.php",
                type: "POST",
                data: { id: id },                
                success: function( data ) {
                    var el = $( event.currentTarget ).parent().parent().parent().parent();
                    $( el ).fadeOut( 350 );
                    setTimeout( function() { el.remove(); }, 400 );
                }
            });
        });
    }

    $.ajax({
        url: "entries.php",
        type: "GET",
        success: function( data ) {
            $( '.timeline' ).html( data );
            bindings();
        },
        error: function() {
        }
    });

    $( "input,textarea" ).jqBootstrapValidation({
        preventSubmit: true,
        submitSuccess: function( $form, event ) {
            event.preventDefault();
            $.ajax({
                url: "add.php",
                type: "POST",
                data: {
                    username: $( "input#username" ).val(),
                    email: $( "input#email" ).val(),
                    title: $( "input#title" ).val(),
                    content: $("textarea#content" ).val(),
                    inverted: $( '.timeline li:first-child' ).hasClass( 'timeline-inverted' )
                },
                cache: false,
                success: function( data ) {
                    if( data.indexOf( 'timeline' ) == -1 ) {
                        $('#success > .alert-danger.alert-not-added').fadeIn();
                        setTimeout( function() { $('#success > .alert-danger.alert-not-added').fadeOut(); }, 2500 );
                        return;
                    }

                    $( '#contactForm' ).trigger( "reset" );
                    $( 'html, body' ).stop().animate({ scrollTop: $( '#guestbook' ).offset().top }, 400, 'easeInOutExpo' );
                    setTimeout( function() {
                        $( '.timeline' ).prepend( data );
                        bindings();
                    }, 200 );
                    $( '.alert.alert-success' ).fadeIn();
                    setTimeout( function() { $( '.alert.alert-success' ).fadeOut(); }, 2500 );
                },
                error: function() {
                    $('#success > .alert-danger').fadeIn();
                    setTimeout( function() { $('#success > .alert-danger').fadeOut(); }, 2500 );
                },
            })
        },
        filter: function() {
            return $( this ).is( ":visible" );
        },
    });

    $( '#name' ).focus( function() {
        $( '#success' ).html( '' );
    });

    $( 'a.page-scroll' ).bind( 'click', function(event) {
        var $anchor = $( this );
        $( 'html, body' ).stop().animate({ scrollTop: $( $anchor.attr( 'href' ) ).offset().top }, 1500, 'easeInOutExpo' );
        event.preventDefault();
    });

    $( "a[data-toggle=\"tab\"]" ).click( function( e ) {
        e.preventDefault();
        $( this ).tab( "show" );
    });
});

$( 'body' ).scrollspy({
    target: '.navbar-fixed-top'
})

$( '.navbar-collapse ul li a' ).click( function() {
    $('.navbar-toggle:visible').click();
});