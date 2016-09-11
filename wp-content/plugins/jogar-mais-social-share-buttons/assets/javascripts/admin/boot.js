jQuery(function($) {
	var context = $( 'body' );

	SSB.vars = {
		  body   : context
		, prefix : 'ssb-share'
	};

	SSB.Application.init.apply( null, [context] );
});