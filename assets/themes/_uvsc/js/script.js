window.isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i);
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i);
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i);
	},
	Opera: function() {
		return navigator.userAgent.match(/Opera Mini/i);
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i);
	},
	any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
	}
}

!function() {
	const html = document.documentElement;
	const body = document.body;
	const text_light	= "#fafafa";
	const text_dark		= "#2d2d2d";

	
	function noscroll(s) {
		if ( s ) {
			html.classList.add('noscroll');
			body.classList.add('noscroll');
		} else {
			html.classList.remove('noscroll');
			body.classList.remove('noscroll');
		}
	}

	
	let header = {
		trigger		: document.querySelector('.nav-trigger-wrap'),
		navwrap		: document.querySelector('.mobile-menu-master-wrap'),
		ul			: document.getElementById('rp-mobile-navigation'),
		_click		: true,

		animate_burger: function(dir) {
			let spans = this.trigger.querySelectorAll('span');

			if ( !this._click ) return;

			//	disable click
			this._click = false;

			//	get header color scheme
			let header_color = document.body.classList.contains('nav-light') ? text_light : text_dark;

			if ( dir ) {
				//	add classes
				document.body.classList.add('mobile-nav');
				this.trigger.classList.add('active');
				this.navwrap.classList.add('active');

				let open1 = anime.timeline({
					duration : 250,
					easing : "easeOutExpo"
				});

				//	compress burger + spans color
				open1.add({
					targets : spans[0],
					translateY : [ 0, 8 ],
				}).add({
					targets : spans[2],
					translateY : [ 0, -8 ],
				}, 10).add({
					targets : spans,
					background : text_light,
					easing : "linear"
				}, 10);

				
				//	rotate to X
				anime({
					targets : this.trigger,
					rotate : "45deg",
					duration : 500,
					easing : "easeInOutExpo",
					delay : 450
				});
				anime({
					targets : spans[1],
					rotate : "90deg",
					duration : 500,
					easing : "easeInOutExpo",
					delay : 250,
					complete: () => {
						this.trigger.dataset.action = "nav-close";
					}
				});

				//	bring in navigation lis
				anime({
					targets : this.ul.children,
					opacity : 1,
					translateY : [ -10, 0 ],
					duration : 750,
					easing : "easeOutExpo",
					delay : anime.stagger(100, { start : 600, from : 'center' }),
					complete: () => {
						this._click = true;
					}
				});


			} else {
				//	navigation lis out
				anime({
					targets : this.ul.children,
					opacity : 0,
					translateY : [ 0, -10 ],
					duration : 250,
					easing : "easeInExpo",
					delay : anime.stagger(35, { from : 'last' })
				});

				//	rotate to burger
				anime({
					targets : spans[1],
					rotate : [ "90deg", 0 ],
					duration : 250,
					easing : "easeOutExpo",
					complete : function() {
						//	remove classes
						document.body.classList.remove('mobile-nav');
					}
				});
				anime({
					targets : this.trigger,
					rotate : [ "45deg", 0 ],
					duration : 750,
					easing : "easeInOutExpo"
				});

				//	spans color
				anime({
					targets : spans,
					background : header_color,
					duration : 250,
					delay : 500,
					easing : "linear"
				});

				//	restore burger
				anime({
					targets : spans[0],
					translateY : [ "8px", 0 ],
					duration : 400,
					easing : "easeOutExpo",
					delay : 350
				});
				anime({
					targets : spans[2],
					translateY : [ "-8px", 0 ],
					duration : 400,
					easing : "easeOutExpo",
					delay : 350,
					complete: () => {
						this.trigger.dataset.action = "nav-open";

						//	remove classes
						setTimeout(() => { 
							this._click = true;
							this.trigger.classList.remove('active');
							this.navwrap.classList.remove('active');
						}, 500);
					}
				});
			}
		}
	};

	//	home hero things
	let hh = {
		section			: document.querySelector('section.home-hero'),
		peek_c			: document.querySelector('.hh-outerwrap'),
		shift_c			: document.querySelector('.hh-container'),
		factor			: 15,
		scrolled		: false,

		move: function(e) {
			let x = -(((window.innerWidth / 2) - e.pageX) / (window.innerWidth / 2)) * this.factor,
				y = -(((window.innerHeight / 2) - e.pageY) / (window.innerHeight / 2)) * this.factor;

			anime({
				targets : this.shift_c,
				translateX : -x,
				translateY : -y,
				duration : 1500,
				easing : "easeOutQuint"
			});

			//	add peek feature
			// this.peek(e);
		},

		// peek: function(e) {
		// 	if ( this.scrolled ) {
		// 		this.peek_c.classList.remove('peek');
		// 		return;
		// 	}

		// 	e.pageY > window.innerHeight / 2 ? this.peek_c.classList.add('peek') : this.peek_c.classList.remove('peek');
		// }
	};

	if ( hh.shift_c && !window.isMobile.any() ) {
		hh.section.addEventListener('mousemove', function(e) {
			hh.move(e);
		});
	}


	//	board members modal
	let bm_modal = {
		modal		: document.querySelector('.bm-modal'),
		wrap		: document.querySelector('.bm-modal-wrap'),
		scroll_c	: document.querySelector('.bm-modal-right'),
		_click		: true,

		handle_modal: function(e) {
			//	handle clicks
			if ( !this._click ) return
			this._click = false;

			//	open modal
			if ( e.target.dataset.action === "open" ) {

				//	get vars
				let parent = e.target.closest('figure');
				let name = parent.querySelector('.name'),
					position = parent.querySelector('.position'),
					image = parent.querySelector('.bm-imgwrap img').src,
					accent = parent.querySelector('.bm-item-bg').style.backgroundImage,
					bio = parent.querySelector('.bm-biography');

				//	set modal vars
				document.getElementById('bm-modal-name').textContent = name.textContent;
				document.getElementById('bm-modal-position').textContent = position.textContent;
				document.getElementById('bm-modal-bio-image').src = image;
				document.getElementById('bm-modal-left').style.backgroundImage = accent;
				document.getElementById('bm-modal-bio').innerHTML = bio.innerHTML;

				//	activate modal
				this.modal.classList.add('active');

				//	disable body scroll
				noscroll(true);

				let tl = anime.timeline({
					duration : 500,
					easing : "easeOutQuint"
				});

				tl.add({
					targets : this.modal,
					opacity : [ 0, 1 ],
					translateY : [ 15, 0 ],
				}).add({
					targets : this.wrap,
					opacity : [ 0, 1 ],
					translateY : [ 15, 0 ],
					complete : () => {
						this._click = true;
					}
				}, "-=300");
			}

			//	close modal
			if ( e.target.dataset.action === "close" ) {
				anime({
					targets : this.modal,
					opacity : [ 1, 0 ],
					translateY : [ 0, 15 ],
					duration : 500,
					easing : "easeOutCirc",
					complete : () => {
						this._click = true;
						this.modal.classList.remove('active');

						//	restore container scroll to 0
						this.scroll_c.scrollTo(0,0);

						//	enable body scroll
						noscroll(false);
					}
				});
			}
		}
	};


	//	family members modal
	let fm_modal = {
		modal		: document.querySelector('.fm-modal'),
		closeX		: document.querySelector('.fm-modal-close'),
		wrap		: document.querySelector('.fm-modal-wrap'),
		scroll_c	: document.querySelector('.fm-modal-content'),
		_click		: true,

		handle_modal: function(e) {
			//	handle clicks
			if ( !this._click ) return
			this._click = false;

			//	open modal
			if ( e.target.dataset.action === "open" ) {

				//	get vars
				let parent = e.target.closest('figure');
				let name = parent.querySelector('.fm-item-name').textContent,
					image = parent.querySelector('.fm-item-image').style.backgroundImage,
					image_position = parent.querySelector('.fm-item-image').style.backgroundPosition,
					story = parent.querySelector('.fm-item-story').innerHTML;

				//	set vars
				document.getElementById('fm-name').textContent = name;
				document.getElementById('fm-image').style.backgroundImage = image;
				document.getElementById('fm-image').style.backgroundPosition = image_position;
				document.getElementById('fm-story').innerHTML = story;

				//	activate modal
				this.modal.classList.add('active');

				//	disable body scroll
				noscroll(true);

				let tl = anime.timeline({
					duration : 500,
					easing : "easeOutQuint"
				});

				tl.add({
					targets : this.modal,
					opacity : [ 0, 1 ],
					translateY : [ 15, 0 ],
				}).add({
					targets : this.wrap,
					opacity : [ 0, 1 ],
					translateY : [ 15, 0 ],
					complete : () => {
						this._click = true;
					}
				}, "-=300").add({
					targets : this.closeX,
					opacity : [ 0, 1 ],
					scale : [ 0, 1 ]
				});
			}

			//	close modal
			if ( e.target.dataset.action === "close" ) {
				anime({
					targets : this.modal,
					opacity : [ 1, 0 ],
					translateY : [ 0, 15 ],
					duration : 500,
					easing : "easeOutCirc",
					complete : () => {
						this._click = true;
						this.modal.classList.remove('active');

						//	restore container scroll to 0
						this.scroll_c.scrollTo(0,0);

						//	enable body scroll
						noscroll(false);
					}
				});

				//	close X
				anime({
					targets : this.closeX,
					opacity : 0,
					scale : 0,
					delay : 500
				});
			}
		}
	};



	document.addEventListener('click', function(e) {
		//	mobile nav
		if ( e.target.dataset.action === "nav-open" ) {
			header.animate_burger(true);
		}
		if ( e.target.dataset.action === "nav-close" ) {
			header.animate_burger(false);
		}

		//	board members modal
		if ( e.target.dataset.modal === "board" ) bm_modal.handle_modal(e);
		
		//	family members modal
		if ( e.target.dataset.modal === "family" ) fm_modal.handle_modal(e);

	});


	window.addEventListener('scroll', function(e) {

		//	home page hero
		// if ( hh.peek_c ) hh.scrolled = true;

	});


	window.addEventListener('resize', function(e) {

	});
	
}();