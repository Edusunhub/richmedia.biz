//Menu Hover Animation Background
$(document).ready(function(){
	$(".nav-item a.nav-link").on('click', function(event) {
		if (this.hash !== "") {
			event.preventDefault();
			var hash = this.hash;
			$('html, body').animate({
			scrollTop: $(hash).offset().top
			}, 800, function(){
				window.location.hash = hash;
			});
		}
	});
});

//Youtube Video Background
$(function(){
	$('body').vidbacking();
});

//Sticky menu
$(window).scroll(function(){
	if ($(window).scrollTop() >= 300) {
		$('.navbar').addClass('fixed-header');
	}
	else {
		$('.navbar').removeClass('fixed-header');
	}
});

//Counter Number loader
$('.counter .count').each(function () {
  var $this = $(this);
  jQuery({ Counter: 0 }).animate({ Counter: $this.text() }, {
    duration: 1000,
    easing: 'swing',
    step: function () {
      $this.text(Math.ceil(this.Counter));
    }
  });
});