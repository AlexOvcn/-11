setTimeout(function(){
	var slideTitle = document.querySelector(".main-title");
	slideTitle.classList.add("slideTitle");
}, 1);

const slideForMobile = window.matchMedia('(max-width: 1195px)')
const slideForDesktop = window.matchMedia('(min-width: 1196px)')

slideForMobile.addListener(slideMobileFunction)
slideMobileFunction(slideForMobile)
slideForDesktop.addListener(slideDesktopFunction)
slideDesktopFunction(slideForDesktop)

function slideMobileFunction(n) {
	if (n.matches) {
		$(function () {
			setTimeout(function(){
				var slide = document.querySelector(".slideRight-first");
				slide.classList.add("slide-visible");
			}, 400);
			$(window).scroll(function() {
			    $('.slideRight').each(function(){
			        var imagePos = $(this).offset().top;
			        var topOfWindow = $(window).scrollTop();
			        if (imagePos < topOfWindow+650) {
			            $(this).addClass("slide-visible");
			        }
			    });
			});
			$(window).scroll(function() {
			    $('.slideLeft').each(function(){
			        var imagePos = $(this).offset().top;
			        var topOfWindow = $(window).scrollTop();
			        if (imagePos < topOfWindow+650) {
			            $(this).addClass("slide-visible");
			        }
			    });
			});
		})
	}
};

function slideDesktopFunction(e) {
	if (e.matches) {
		$(function () {
			setTimeout(function(){
				var slideOneCard = document.querySelector(".slideOneCard");
				slideOneCard.classList.add("slide-visible");
				var slideTwoCard = document.querySelector(".slideTwoCard");
				slideTwoCard.classList.add("slide-visible");
				var slideThreeCard = document.querySelector(".slideThreeCard");
				slideThreeCard.classList.add("slide-visible");
				var slideFourCard = document.querySelector(".slideFourCard");
				slideFourCard.classList.add("slide-visible");
			}, 300);
		})
	}
};