$("document").ready(function() {

	$("#submit").click(function() {
		// Make Ajax Request to create
		$.ajax( "create.php" )
		  .done(function() {
		    alert( "success" );
		  })
		  .fail(function() {
		    alert( "error" );
		  })
		  .always(function(response) {
		    console.log(response);
		  });
	});
});
