</main>
	</div>
</div>

<script type="text/javascript">
	//For Check All
function select_in(source) {
  checkboxes = document.getElementsByName('chkbox_in[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

function select_sent(source) {
  checkboxes = document.getElementsByName('chkbox_sent[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

function select_draft(source) {
  checkboxes = document.getElementsByName('chkbox_draft[]');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}
</script>

<script>
	function deleteinbox(){

		var e=document.getElementsByName("chkbox_in[]");
		for (i=0;i<e.length;i++){
			if (e[i].checked==true){
				var agree=confirm('Confirm To delete ');
				if (agree){ 
					return true; 
				}
				else{ 
					return false;
				}
			}
		}
		alert('You must select an email address to delete');
		return false;
	}

	function deletesent(){

		var e=document.getElementsByName("chkbox_sent[]");
		for (i=0;i<e.length;i++){
			if (e[i].checked==true){
				var agree=confirm('Confirm To delete ');
				if (agree){ 
					return true; 
				}
				else{ 
					return false;
				}
			}
		}
		alert('You must select an email address to delete');
		return false;
	}

	function deletedraft(){

		var e=document.getElementsByName("chkbox_draft[]");
		for (i=0;i<e.length;i++){
			if (e[i].checked==true){
				var agree=confirm('Confirm To delete ');
				if (agree){ 
					return true; 
				}
				else{ 
					return false;
				}
			}
		}
		alert('You must select an email address to delete');
		return false;
	}
</script>

		<!--[if !IE]> -->
		<script src="assets/js/jquery-2.1.4.min.js"></script>
		

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>

		<!-- page specific plugin scripts -->

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				$('#id-change-style').on(ace.click_event, function() {
					var toggler = $('#menu-toggler');
					var fixed = toggler.hasClass('fixed');
					var display = toggler.hasClass('display');
					
					if(toggler.closest('.navbar').length == 1) {
						$('#menu-toggler').remove();
						toggler = $('#sidebar').before('<a id="menu-toggler" data-target="#sidebar" class="menu-toggler" href="#">\
							<span class="sr-only">Toggle sidebar</span>\
							<span class="toggler-text"></span>\
						 </a>').prev();
			
						 var ace_sidebar = $('#sidebar').ace_sidebar('ref');
						 ace_sidebar.set('mobile_style', 2);
			
						 var icon = $(this).children().detach();
						 $(this).text('Hide older Ace toggle button').prepend(icon);
						 
						 $('#id-push-content').closest('div').hide();
						 $('#id-push-content').removeAttr('checked');
						 $('.sidebar').removeClass('push_away');
					 } else {
						$('#menu-toggler').remove();
						toggler = $('.navbar-brand').before('<button data-target="#sidebar" id="menu-toggler" class="three-bars pull-left menu-toggler navbar-toggle" type="button">\
							<span class="sr-only">Toggle sidebar</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>\
						</button>').prev();
						
						 var ace_sidebar = $('#sidebar').ace_sidebar('ref');
						 ace_sidebar.set('mobile_style', 1);
						
						var icon = $(this).children().detach();
						$(this).text('Show older Ace toggle button').prepend(icon);
						
						$('#id-push-content').closest('div').show();
					 }
			
					 if(fixed) toggler.addClass('fixed');
					 if(display) toggler.addClass('display');
					 
					 $('.sidebar[data-sidebar-hover=true]').ace_sidebar_hover('reset');
					 $('.sidebar[data-sidebar-scroll=true]').ace_sidebar_scroll('reset');
			
					 return false;
				});
				
				$('#id-push-content').removeAttr('checked').on('click', function() {
					$('.sidebar').toggleClass('push_away');
				});
			});
		</script>
		
		<script type="text/javascript">
			document.addEventListener('DOMContentLoaded', function() {
			var menuToggleBtn = document.getElementById('menuToggleBtn');
			var modernSidebar = document.getElementById('modernSidebar');
			var userMenuDropdownBtn = document.getElementById('userMenuDropdownBtn');
			var userDropdownMenu = document.getElementById('userDropdownMenu');
			var sidebarCloseBtn = document.getElementById('sidebarCloseBtn');

			if (menuToggleBtn && modernSidebar) {
				menuToggleBtn.addEventListener('click', function(e) {
					e.stopPropagation();
					modernSidebar.classList.toggle('active');
				});
			}

			// Mobile sidebar close button
			if (sidebarCloseBtn && modernSidebar) {
				sidebarCloseBtn.addEventListener('click', function(e) {
					e.stopPropagation();
					modernSidebar.classList.remove('active');
				});
			}

			if (userMenuDropdownBtn && userDropdownMenu) {
				userMenuDropdownBtn.addEventListener('click', function(e) {
					e.stopPropagation();
					userDropdownMenu.classList.toggle('show');
				});
			}

			document.addEventListener('click', function(e) {
				if (userDropdownMenu && userDropdownMenu.classList.contains('show')) {
					if (!userMenuDropdownBtn.contains(e.target)) {
						userDropdownMenu.classList.remove('show');
					}
				}
				if (modernSidebar && modernSidebar.classList.contains('active')) {
					if (!modernSidebar.contains(e.target) && e.target !== menuToggleBtn && !menuToggleBtn.contains(e.target)) {
						modernSidebar.classList.remove('active');
					}
				}
			});
		});
		</script>

		<!-- Global Dashboard Dialogs (Toast, Dialogs, Image Preview helpers) -->
		<script src="assets/js/dashboard-dialogs.js"></script>

		<!-- Auto-capture PHP inline alerts and show them as floating Toasts -->
		<script>
		document.addEventListener('DOMContentLoaded', function() {
			if (typeof Dashboard === 'undefined' || typeof Dashboard.showToast !== 'function') return;

			// Find any visible success / error alerts rendered by PHP
			var alerts = document.querySelectorAll('.alert-success, .alert-danger');
			for (var i = 0; i < alerts.length; i++) {
				var el = alerts[i];
				// Skip info banners, hidden alerts, and alerts inside modals/dialogs
				if (el.classList.contains('alert-info')) continue;
				if (el.closest('dialog') || el.closest('.modal')) continue;
				var style = window.getComputedStyle(el);
				if (style.display === 'none') continue;

				// Extract the message text
				var msgEl = el.querySelector('strong') || el;
				var msg = (msgEl.textContent || '').trim();
				if (!msg) continue;

				var type = el.classList.contains('alert-success') ? 'success' : 'error';
				// Hide the original inline alert
				el.style.display = 'none';
				// Show as a floating toast instead
				Dashboard.showToast(msg, type);
				// Only show one toast at a time (first visible alert wins)
				break;
			}
		});
		</script>
	</body>
</html>
