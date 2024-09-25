function startup(){
	slider('.slider');
}

document.addEventListener("DOMContentLoaded", startup);

function slider(element){

	if (element){

		add_classes_to_children(element);
		dragging_func(element);
		touching_func(element);

		//keydown event for prev and next
		document.addEventListener("keydown", event => {

		  if (event.isComposing || event.keyCode === 37) {
		    prev_slide();
		  }

		  if (event.isComposing || event.keyCode === 39) {
		    next_slide();
		  }

		});

		document.querySelectorAll('.sliderContainer')[0].addEventListener('click', function(e){

			let x = e.target;

			if ( (x.parentElement.classList.contains("next-slide")) || (x.closest(".next-button")) ){
				next_slide();
			}

			else if (x.parentElement.classList.contains("prev-slide") || (x.closest(".prev-button")) ){
				prev_slide();
			}

		}, {passive: true} );

	}

}

function add_classes_to_children(parentElement){

	let parent = document.querySelectorAll(parentElement)[0];

	for (let i = 0; i < parent.children.length; i++){

		let childElement;

		if ( i < 1 ){
			childElement = parent.children[i].className += 'first-slide ';		
		}


		if ( i == parent.children.length ){
			childElement = parent.children[i].className += 'last-slide ';		
		}

		if (i == 1){
			let activeElement = parent.children[i].className += 'active-slide ';
			style_active_previous_and_next_slides();
		}

		childElement = parent.children[i].className += 'slide-' + i + ' ';
		childElement = parent.children[i].className += 'slide ';

	}

}

function style_active_previous_and_next_slides(){

	let active = document.querySelectorAll('.active-slide')[0];
	
	let prev = active.previousElementSibling;
	let next = active.nextElementSibling;

	prev.className += 'prev-slide ';
	next.className += 'next-slide ';

}

function next_slide(){

	let active = document.querySelectorAll('.active-slide')[0];

	if (active.nextElementSibling){

		let next = active.nextElementSibling;
		let nextnext = next.nextElementSibling;
		let prev = active.previousElementSibling;

		if (prev){
			active.previousElementSibling.classList.remove('prev-slide');
		}

		active.nextElementSibling.classList.remove('next-slide');
		active.classList.remove('active-slide');

		next.className += ' active-slide ';
		active.className += ' prev-slide ';

		if (nextnext){
			next.nextElementSibling.className += ' next-slide ';
		}

	}

}

function prev_slide(){

	let active = document.querySelectorAll('.active-slide')[0];

	if (active.previousElementSibling){

		let prev = active.previousElementSibling;
		let prevprev = prev.previousElementSibling;
		let next = active.nextElementSibling;
		

		if (next){
			active.nextElementSibling.classList.remove('next-slide');
		}

		active.previousElementSibling.classList.remove('prev-slide');
		active.classList.remove('active-slide');

		prev.className += ' active-slide ';
		active.className += ' next-slide ';

		if (prevprev){
			prev.previousElementSibling.className += ' prev-slide ';
		}

	}

}

function dragging_func(element){

	let parentElement = document.querySelectorAll(element)[0];
	let images, i;

	for (i = 0; i < parentElement.childElementCount; i++){

		let slideParents = parentElement.querySelectorAll('.slide')[i];
		let slide = slideParents;

		if (slide){

			slide.onmousedown = function(event){

				let x = event.target;
				let grabbedElement = x.closest(".slide");

				//alert(grabbedElement.classList);

				grabbedElement.className += " grabbed-element";

				let shiftX = event.pageX - slide.getBoundingClientRect().left;
				let shiftY = event.pageY - slide.getBoundingClientRect().top;

				document.body.className += 'grabbing';
				slide.style.position = 'absolute';
				slide.style.cursor = 'grabbing';

				function moveAt(pageX, pageY){
					slide.style.left = (pageX - shiftX / 2) + 100 + 'px';
					slide.style.top = (pageY - shiftY / 2) + 100 + 'px';

					//slide.style.transform = 'translate(-' + (pageX - shiftX) / 2 + 'px, -' + (pageY - shiftY) / 2 + 'px)';
				}

				moveAt(event.pageX, event.pageY);

				function onMouseMove(event) {
					moveAt(event.pageX, event.pageY);
					slide.style.zIndex = 100;
					//slide.style.removeProperty('transition');
				}

				document.addEventListener('mousemove', onMouseMove, {passive: true});

				slide.onmouseup = function() {
					document.removeEventListener('mousemove', onMouseMove);

					grabbedElement.classList.remove('grabbed-element');

					slide.onmouseup = null;
					document.body.classList.remove('grabbing');

					slide.style.removeProperty('position');
					slide.style.removeProperty('z-index');
					slide.style.removeProperty('top');
					slide.style.removeProperty('left');
					slide.style.removeProperty('cursor');
					
				
				}

				slide.onmouseleave = function() {
					document.removeEventListener('mousemove', onMouseMove);

					grabbedElement.classList.remove('grabbed-element');

					slide.onmouseup = null;
					document.body.classList.remove('grabbing');

					slide.style.removeProperty('position');
					slide.style.removeProperty('z-index');
					slide.style.removeProperty('top');
					slide.style.removeProperty('left');
					slide.style.removeProperty('cursor');
					
				
				}

				document.body.onmouseup = function(){
					document.removeEventListener('mousemove', onMouseMove);

					grabbedElement.classList.remove('grabbed-element');

					slide.onmouseup = null;
					document.body.classList.remove('grabbing');

					slide.style.removeProperty('position');
					slide.style.removeProperty('z-index');
					slide.style.removeProperty('top');
					slide.style.removeProperty('left');
					slide.style.removeProperty('cursor');
				}

				document.body.onmouseleave = function(){
					document.removeEventListener('mousemove', onMouseMove);

					grabbedElement.classList.remove('grabbed-element');

					slide.onmouseup = null;
					document.body.classList.remove('grabbing');

					slide.style.removeProperty('position');
					slide.style.removeProperty('z-index');
					slide.style.removeProperty('top');
					slide.style.removeProperty('left');
					slide.style.removeProperty('cursor');

				}

			}

			slide.ondragstart = function() {
				return false;
			};

		}

	}
}

/* 
 * Touch handler - For mobile devices
 * source: https://stackoverflow.com/questions/2264072/detect-a-finger-swipe-through-javascript-on-the-iphone-and-android
 */

function touching_func(element){

	let parentElement = document.querySelectorAll(element)[0];

	parentElement.addEventListener('touchstart', handleTouchStart, {passive: true});        
	parentElement.addEventListener('touchmove', handleTouchMove, {passive: true});

	var xDown = null;                                                        
	var yDown = null;

	function getTouches(evt) {
	  return evt.touches ||             // browser API
	         evt.originalEvent.touches; // jQuery
	}                                                     

	function handleTouchStart(evt) {
	    const firstTouch = getTouches(evt)[0];                                      
	    xDown = firstTouch.clientX;                                      
	    yDown = firstTouch.clientY;                                      
	};                                                

	function handleTouchMove(evt) {
	    if ( ! xDown || ! yDown ) {
	        return;
	    }

	    var xUp = evt.touches[0].clientX;                                    
	    var yUp = evt.touches[0].clientY;

	    var xDiff = xDown - xUp;
	    var yDiff = yDown - yUp;

	    if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) {/*most significant*/
	        if ( xDiff > 0 ) {
	        	/* left swipe */
	           next_slide();
	        } else {
	        	/* right swipe */
	            prev_slide();
	        }                       
	    } else {
	        if ( yDiff > 0 ) {
	            /* up swipe */ 
	        } else { 
	            /* down swipe */
	            location.reload();
	        }                                                                 
	    }
	    /* reset values */
	    xDown = null;
	    yDown = null;                                             
	};

}