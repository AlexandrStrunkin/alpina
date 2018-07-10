function showRec(postid) {
	$.ajax({
		type: "POST",
		url: "/ajax/blog_rec.php",
		data: {postid: postid}
	}).done(function(strResult) {
		$("body").append(strResult);
	});
};
function closeInfo() {
	$('#blogRec').hide();
}

/*
$(document).ready(function() {
	var cycleCheck = false;
	var target = $('.author');
	var targetPos = target.offset().top;
	var winHeight = $(window).height();
	var scrollToElem = targetPos - winHeight;
	var postid = $("#postid").val();

	$(window).scroll(function() {
		var winScrollTop = $(this).scrollTop();

		if (winScrollTop > scrollToElem && !cycleCheck) {
			showRec(postid);
			try {rrApi.addToBasket(postid)} catch(e) {};
			cycleCheck = true;
		}
	}); 
});
 */
function showCats() {
	$(".catsLinks").toggle("fast", function() {
		
	});
}