<!-- Contact Dialog -->
<dialog id="contact-dialog" closedby="any" class="modern-dialog" style="max-width: 720px; width: 95vw;">
	<div class="dialog-header">
		<h3 class="dialog-title"><i class="fa fa-envelope" style="margin-right:8px; color:var(--lab-teal);"></i>Contact Us</h3>
		<button class="dialog-close-btn" onclick="document.getElementById('contact-dialog').close();" aria-label="Close dialog">&times;</button>
	</div>
	<div class="dialog-body" style="padding: 0;">

		<!-- Quick Contact Bar -->
		<div id="contact-quick-bar" style="display:flex; flex-wrap:wrap; gap:10px; padding: 18px 24px; background: linear-gradient(135deg, rgba(28,167,168,0.06), rgba(123,61,115,0.06)); border-bottom: 1px solid var(--lab-line);">
			<a href="mailto:pel.ru.bd@gmail.com" id="quick-email-link" style="flex:1; min-width:200px; display:flex; align-items:center; gap:12px; background:#fff; border:1px solid var(--lab-line); border-radius:12px; padding:12px 16px; text-decoration:none; transition:all 0.2s ease; box-shadow: 0 2px 8px rgba(23,33,47,0.06);">
				<div style="width:38px; height:38px; border-radius:10px; background:rgba(28,167,168,0.12); color:var(--lab-teal-dark); display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
					<i class="fa fa-envelope"></i>
				</div>
				<div>
					<div style="font-size:11px; font-weight:700; color:var(--lab-muted); text-transform:uppercase; letter-spacing:0.08em; margin-bottom:2px;">Email Us Directly</div>
					<div style="font-size:13px; font-weight:700; color:var(--lab-teal-dark);">pel.ru.bd@gmail.com</div>
				</div>
			</a>
			<a href="https://www.facebook.com/profile.php?id=100064134276504" id="quick-facebook-link" target="_blank" rel="noopener" style="flex:1; min-width:200px; display:flex; align-items:center; gap:12px; background:#fff; border:1px solid var(--lab-line); border-radius:12px; padding:12px 16px; text-decoration:none; transition:all 0.2s ease; box-shadow: 0 2px 8px rgba(23,33,47,0.06);">
				<div style="width:38px; height:38px; border-radius:10px; background:rgba(24,119,242,0.10); color:#1877F2; display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0;">
					<i class="fa fa-facebook"></i>
				</div>
				<div>
					<div style="font-size:11px; font-weight:700; color:var(--lab-muted); text-transform:uppercase; letter-spacing:0.08em; margin-bottom:2px;">Follow & Message</div>
					<div style="font-size:13px; font-weight:700; color:#1877F2;">PEL Facebook Page</div>
				</div>
			</a>
		</div>

		<!-- Message & Booking Form -->
		<div style="padding: 22px 24px;">
			<div style="font-size:13px; font-weight:700; color:var(--lab-muted); text-transform:uppercase; letter-spacing:0.08em; margin-bottom:14px;">
				<i class="fa fa-pencil" style="margin-right:6px;"></i>Send a Message or Book an Appointment
			</div>

			<div class="contact">
				<div class="contact_body">
					<form id="myform" action="" method="post">

						<!-- Inquiry Type -->
						<fieldset class="form-group" style="margin-bottom:14px;">
							<select id="inquiry-type" name="inquiry_type" class="form-control" style="border-radius: 8px; border: 1px solid var(--lab-line); padding: 11px 14px; height: auto; font-size:14px; color:var(--lab-ink); cursor:pointer;">
								<option value="general">💬 General Message</option>
								<option value="consultation">🤝 Book a Consultation</option>
								<option value="lab_visit">🔬 Schedule a Lab Visit</option>
								<option value="product_service">📦 Request Product / Service Info</option>
							</select>
						</fieldset>

						<!-- Booking fields (shown conditionally) -->
						<div id="booking-fields" style="display:none; margin-bottom:14px;">
							<div style="display:grid; grid-template-columns:1fr 1fr; gap:12px;">
								<fieldset class="form-group" style="margin-bottom:0;">
									<label style="font-size:12px; font-weight:700; color:var(--lab-muted); display:block; margin-bottom:5px;"><i class="fa fa-calendar" style="margin-right:4px;"></i>Preferred Date</label>
									<input id="booking-date" name="booking_date" type="date" class="form-control" style="border-radius: 8px; border: 1px solid var(--lab-line); padding: 11px 14px; height: auto; font-size:14px;">
								</fieldset>
								<fieldset class="form-group" style="margin-bottom:0;">
									<label style="font-size:12px; font-weight:700; color:var(--lab-muted); display:block; margin-bottom:5px;"><i class="fa fa-clock-o" style="margin-right:4px;"></i>Preferred Time</label>
									<select id="booking-time" name="booking_time" class="form-control" style="border-radius: 8px; border: 1px solid var(--lab-line); padding: 11px 14px; height: auto; font-size:14px; cursor:pointer;">
										<option value="">Select Time</option>
										<option value="09:00 AM">09:00 AM</option>
										<option value="10:00 AM">10:00 AM</option>
										<option value="11:00 AM">11:00 AM</option>
										<option value="12:00 PM">12:00 PM</option>
										<option value="02:00 PM">02:00 PM</option>
										<option value="03:00 PM">03:00 PM</option>
										<option value="04:00 PM">04:00 PM</option>
									</select>
								</fieldset>
							</div>
						</div>

						<div style="display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:14px;">
							<fieldset class="form-group" style="margin-bottom:0;">
								<input class="form-control" placeholder="Your Name" type="text" name="name" value="" tabindex="1" required style="border-radius: 8px; border: 1px solid var(--lab-line); padding: 12px 16px; height: auto;">
							</fieldset>
							<fieldset class="form-group" style="margin-bottom:0;">
								<input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" tabindex="2" required style="border-radius: 8px; border: 1px solid var(--lab-line); padding: 12px 16px; height: auto;" />
							</fieldset>
						</div>

						<fieldset class="form-group" style="margin-bottom:14px;">
							<input class="form-control" placeholder="Message subject..." type="text" name="subject" value="" tabindex="4" required style="border-radius: 8px; border: 1px solid var(--lab-line); padding: 12px 16px; height: auto;">
						</fieldset>

						<fieldset class="form-group" style="margin-bottom:14px;">
							<textarea class="form-control" name="message" placeholder="Write your message or describe what you need..." id="contact-message-text" cols="150" rows="4" required style="border-radius: 8px; border: 1px solid var(--lab-line); padding: 12px 16px; height: auto; resize: vertical;"></textarea>
						</fieldset>

						<fieldset class="form-group" style="margin-bottom: 0;">
							<button onclick="return validateform()" name="submit" type="submit" id="contact-submit" class="submit_btn" style="width: 100%; background: linear-gradient(135deg, var(--lab-teal-dark), var(--lab-teal)); color: #fff; border: 0; padding: 13px; border-radius: 10px; font-weight: 800; font-size: 16px; box-shadow: 0 4px 14px rgba(8,125,130,0.25); transition: all 0.2s ease; cursor:pointer;">
								<i class="fa fa-paper-plane" style="margin-right:8px;"></i>Send Message
							</button>
						</fieldset>
						<div id='result' style="margin-top: 14px; font-weight: 700; text-align: center;"></div>
					</form>
				</div>
			</div>
		</div>

	</div>
	<div class="dialog-footer" style="padding: 12px 24px; border-top: 1px solid var(--lab-line); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
		<span style="font-size:12px; color:var(--lab-muted);"><i class="fa fa-lock" style="margin-right:4px;"></i>Your information is kept confidential</span>
		<button class="btn btn-default" onclick="document.getElementById('contact-dialog').close();" style="border-radius: 8px; font-weight:600;">Close</button>
	</div>
</dialog>

<style>
	#quick-email-link:hover { border-color: var(--lab-teal) !important; box-shadow: 0 4px 14px rgba(28,167,168,0.15) !important; transform: translateY(-1px); }
	#quick-facebook-link:hover { border-color: #1877F2 !important; box-shadow: 0 4px 14px rgba(24,119,242,0.15) !important; transform: translateY(-1px); }
	#booking-fields { animation: slideDown 0.25s ease; }
	@keyframes slideDown {
		from { opacity:0; transform: translateY(-8px); }
		to   { opacity:1; transform: translateY(0); }
	}
	@media (max-width: 520px) {
		#contact-quick-bar { flex-direction: column; }
		#contact-quick-bar a { min-width: unset; }
		#myform .form-group-row { grid-template-columns: 1fr !important; }
	}
</style>

<script type="text/javascript">
	function validateform() {
		var a = document.forms["myform"]["name"].value;
		if (a == null || a == "") {
			document.getElementById("result").innerHTML = "<span style='color:#e85d75;'>&#9888; Name field must be filled...</span>";
			return false;
		}

		var x = document.forms["myform"]["email"].value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");

		var b = document.forms["myform"]["email"].value;
		if (b == null || b == "") {
			document.getElementById("result").innerHTML = "<span style='color:#e85d75;'>&#9888; Email field must be filled...</span>";
			return false;
		} else {
			if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
				document.getElementById("result").innerHTML = "<span style='color:#e85d75;'>&#9888; Please enter a valid email address...</span>";
				return false;
			}
		}

		var c = document.forms["myform"]["subject"].value;
		if (c == null || c == "") {
			document.getElementById("result").innerHTML = "<span style='color:#e85d75;'>&#9888; Subject field must be filled...</span>";
			return false;
		}

		var d = document.forms["myform"]["message"].value;
		if (d == null || d == "") {
			document.getElementById("result").innerHTML = "<span style='color:#e85d75;'>&#9888; Please write a message...</span>";
			return false;
		}

		// Prepend booking info to message if booking fields are shown
		var bookingFields = document.getElementById('booking-fields');
		if (bookingFields && bookingFields.style.display !== 'none') {
			var inquiryType  = document.getElementById('inquiry-type');
			var bookingDate  = document.getElementById('booking-date');
			var bookingTime  = document.getElementById('booking-time');
			var msgArea      = document.getElementById('contact-message-text');

			var typeLabel = inquiryType ? inquiryType.options[inquiryType.selectedIndex].text.replace(/^[^\w]+/, '') : '';
			var dateVal   = bookingDate  ? bookingDate.value  : '';
			var timeVal   = bookingTime  ? bookingTime.value  : '';

			if (typeLabel || dateVal || timeVal) {
				var bookingHeader = '[INQUIRY: ' + typeLabel;
				if (dateVal) bookingHeader += ' | DATE: ' + dateVal;
				if (timeVal) bookingHeader += ' | TIME: ' + timeVal;
				bookingHeader += ']\n\n';
				if (msgArea.value.indexOf('[INQUIRY:') === -1) {
					msgArea.value = bookingHeader + msgArea.value;
				}
			}
		}

		var elem = document.getElementById("result");
		elem.innerHTML = "<span style='color:var(--lab-teal);'><i class='fa fa-spinner fa-spin' style='margin-right:6px;'></i>Sending your message...</span>";
		return true;
	}
</script>

<script>
	$(document).ready(function() {
		// Fallback for browsers without closedby support
		const dialog = document.getElementById('contact-dialog');
		if (dialog && !('closedBy' in HTMLDialogElement.prototype)) {
			dialog.addEventListener('click', (event) => {
				if (event.target !== dialog) return;
				const rect = dialog.getBoundingClientRect();
				const isInside = (
					rect.top <= event.clientY &&
					event.clientY <= rect.top + rect.height &&
					rect.left <= event.clientX &&
					event.clientX <= rect.left + rect.width
				);
				if (!isInside) dialog.close();
			});
		}

		// Booking fields visibility toggle
		$('#inquiry-type').on('change', function() {
			var val = $(this).val();
			if (val === 'consultation' || val === 'lab_visit') {
				$('#booking-fields').slideDown(220);
			} else {
				$('#booking-fields').slideUp(180);
			}
		});

		// Set min date to today for the booking date picker
		var today = new Date().toISOString().split('T')[0];
		$('#booking-date').attr('min', today);

		$('#myform').submit(function(event) {
			event.preventDefault();
			$.ajax({
				type: "POST",
				url: "contact-form.php",
				data: $(this).serialize(),
				success: function(data) {
					$('#result').html(data);
				}
			}).done(function() {
				// Reset only non-booking fields; keep dialog open to show success
				$("#myform input[name='name']").val('');
				$("#myform input[name='email']").val('');
				$("#myform input[name='subject']").val('');
				$("#contact-message-text").val('');
				$('#inquiry-type').val('general').trigger('change');
			});
		});
	});
</script>
