var blogSearch = $('#blogSearch');
var blogSearchSubmit = $('#blogSearchSubmit');
var searchCont = $('#searchCont');

blogSearchSubmit.on("click", blogSearch);

function blogSearch(tags){
	$.ajax({
		url: 'search.php',
		method: 'POST',
	});
	$('#searchDiv').load('search.php');
}