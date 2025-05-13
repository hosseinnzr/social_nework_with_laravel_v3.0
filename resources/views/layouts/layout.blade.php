<!doctype html>
<html lang="en">
  <head>
    <title>@yield('title')</title>
    @notifyCss

	<!-- SHOW modal in moadal bootstrap SATRT -->

	<link href="{{asset("css/bootstrap-modal-bs3patch.css")}}" rel="stylesheet" />
	<link href="{{asset("css/bootstrap-modal.css")}}" rel="stylesheet" />

	<style>
		/* start modal for save chat */
		.modal {
		  display: none;
		  position: fixed;
		  z-index: 1401;
		  left: 0;
		  top: 0;
		  width: 100%;
		  height: 100%;
		  overflow: auto;
		  background-color: rgb(0, 0, 0);
		  background-color: rgba(0, 0, 0, 0.4);
		  padding-top: 60px;
		}
	  
		.modal-content-send-post {
		  border-radius: 5px;
		  width: 45%;
		  height: auto;
		  margin: auto;
		  padding: 0 10 0 10px;
		  border: 1px solid #888;
		  background-color: white;
		}
	  
		/* end modal for save chat */

		@media (max-width: 927px) {
		  .modal-content-send-post {
			width: 70%;
		  }
		}
	  
		@media (max-width: 768px) {
		  .modal-content-send-post {
			width: 80%;
		  }
		}
	  
		@media (max-width: 480px) {
		  .modal-content-send-post {
			width: 80%;
		  }
		}

		.text-center { 
		  text-align: center; 
		}
	  
		.marketing h1 {
		  font-size: 50px;
		  font-weight: lighter;
		  line-height: 1;
		}
  
		.marketing p {
		  font-size: 18px;
		}
	</style>
	<!-- SHOW modal in moadal bootstrap END -->

	<!-- Meta Tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="author" content="Webestica.com">
	<meta name="description" content="Bootstrap 5 based Social Media Network and Community Theme">

	<!-- Favicon -->
	<link rel="shortcut icon" href="{{asset("assets/images/favicon.png")}}">

	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
  	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

	<!-- Plugins CSS -->
	<link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/font-awesome/css/all.min.css")}}">
	<link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/bootstrap-icons/bootstrap-icons.css")}}">
  	<link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/dropzone/dist/dropzone.css")}}" />
  	<link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/glightbox-master/dist/css/glightbox.min.css")}}">
  	<link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/choices.js/public/assets/styles/choices.min.css")}}">
  	<link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/flatpickr/dist/flatpickr.min.css")}}">

	<link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/OverlayScrollbars-master/css/OverlayScrollbars.min.css")}}" />

	<link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/tiny-slider/dist/tiny-slider.css")}}">
	<link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/flatpickr/dist/flatpickr.css")}}" />
	<link rel="stylesheet" type="text/css" href="{{asset("assets/vendor/plyr/plyr.css")}}" />

	<!-- Theme CSS -->
	<link id="style-switch" rel="stylesheet" type="text/css" href="{{asset("assets/css/style.css")}}">

	<!-- liveWire -->
	@livewireStyles

  </head>

  <body>
	<div style="position: absolute; z-index:9000" class="notifications bottom-right">
		<x-notify::notify />
		@notifyJs
	</div>

	@auth
		@include('include.header')
	@endauth

	<br>
	<br>
	<br>

    @yield('content')

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const theme = localStorage.getItem('data-theme');
			const style = document.getElementById("style-switch");
			const dir = document.getElementsByTagName("html")[0].getAttribute('dir');

			const changeThemeToDark = () => {
				document.documentElement.setAttribute("data-theme", "dark");

					style.setAttribute('href', '{{ asset("assets/css/style-dark.css") }}');
				
				localStorage.setItem("data-theme", "dark");
			}

			const changeThemeToLight = () => {
				document.documentElement.setAttribute("data-theme", "light");

					style.setAttribute('href', '{{ asset("assets/css/style.css") }}');
				
				localStorage.setItem("data-theme", 'light');
			}

			if (theme === 'dark') {
				changeThemeToDark();
			} else {
				changeThemeToLight();
			}

			const dms = document.getElementById('darkModeSwitch');
			if (dms) {
				dms.addEventListener('click', () => {
					const currentTheme = localStorage.getItem('data-theme');
					if (currentTheme === 'dark') {
						changeThemeToLight();
					} else {
						changeThemeToDark();
					}
				});
			}
		});
	</script>

	<!-- Bootstrap JS -->
	<script src="{{asset("assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js")}}"></script>

	<!-- Vendors -->

	<script src="{{	asset("assets/vendor/dropzone/dist/dropzone.js")}}"></script>
	<script src="{{	asset("assets/vendor/choices.js/public/assets/scripts/choices.min.js")}}"></script>
	<script src="{{	asset("assets/vendor/glightbox-master/dist/js/glightbox.min.js")}}"></script>
	<script src="{{	asset("assets/vendor/flatpickr/dist/flatpickr.min.js")}}"></script>
	<script src="{{	asset("assets/vendor/OverlayScrollbars-master/js/OverlayScrollbars.min.js")}}"></script>
	
	<script src="{{	asset("assets/vendor/tiny-slider/dist/tiny-slider.js")}}"></script>
	<script src="{{	asset("assets/vendor/plyr/plyr.js")}}"></script>
	<script src="{{	asset("assets/vendor/dropzone/dist/min/dropzone.min.js")}}"></script>

	<!-- Template Functions -->
	<script src="{{asset("assets/js/functions.js")}}"></script>


	<!-- liveWire -->
    @livewireScripts

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const searchToggle = document.getElementById('searchToggle');
			const searchBox = document.getElementById('searchBox');

			searchToggle.addEventListener('click', function() {
				if (!searchBox.classList.contains('show')) {
					searchBox.classList.add('show');
				}
			});

			searchBox.addEventListener('keyup', function(event) {
				// Do nothing for now, or add any additional functionality for search
			});
		});
	</script>
	
  </body>
</html>