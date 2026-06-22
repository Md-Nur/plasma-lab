<!-- Dialog -->
<dialog id="contact-dialog" closedby="any" class="modern-dialog">
	<div class="dialog-header">
		<h3 class="dialog-title">Leave a Message</h3>
		<button class="dialog-close-btn" onclick="document.getElementById('contact-dialog').close();" aria-label="Close dialog">&times;</button>
	</div>
	<div class="dialog-body">
		<div class="contact">
			<div class="contact_body">
				<form id="myform" action="" method="post">
					<fieldset class="form-group">
						<input class="form-control" placeholder="Your name" type="text" name="name" value="" tabindex="1" required style="border-radius: 8px; border: 1px solid var(--lab-line); padding: 12px 16px; height: auto;">
					</fieldset>

					<fieldset class="form-group">
						<input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" tabindex="2" required style="border-radius: 8px; border: 1px solid var(--lab-line); padding: 12px 16px; height: auto;" />
					</fieldset>

					<fieldset class="form-group">
						<input class="form-control" placeholder="Message subject..." type="text" name="subject" value="" tabindex="4" required style="border-radius: 8px; border: 1px solid var(--lab-line); padding: 12px 16px; height: auto;">
					</fieldset>

					<fieldset class="form-group">
						<textarea class="form-control" name="message" placeholder="Write a message..." id="contact-message-text" cols="150" rows="6" required style="border-radius: 8px; border: 1px solid var(--lab-line); padding: 12px 16px; height: auto; resize: vertical;"></textarea>
					</fieldset>

					<fieldset class="form-group" style="margin-bottom: 0;">
						<button onclick="return validateform()" name="submit" type="submit" id="contact-submit" class="submit_btn" style="width: 100%; background: var(--lab-teal-dark); color: #fff; border: 0; padding: 12px; border-radius: 8px; font-weight: 800; font-size: 16px; box-shadow: 0 4px 12px rgba(8,125,130,0.2); transition: background 0.2s ease;">Send Message</button>
					</fieldset>
					<div id='result' style="margin-top: 14px; font-weight: 700; text-align: center;"></div>
				</form>
			</div>
		</div>
	</div>
	<div class="dialog-footer">
		<button class="btn btn-default" onclick="document.getElementById('contact-dialog').close();" style="border-radius: 8px;">Close</button>
	</div>
</dialog>

<script type="text/javascript">
	function validateform() {

		var a = document.forms["myform"]["name"].value;
		if (a == null || a == "") {
			document.getElementById("result").innerHTML = " Error : Name field must be filled...";
			return false;
		}

		var x = document.forms["myform"]["email"].value;
		var atpos = x.indexOf("@");
		var dotpos = x.lastIndexOf(".");

		var b = document.forms["myform"]["email"].value;
		if (b == null || b == "") {
			document.getElementById("result").innerHTML = " Error : Email field must be filled...";
			return false;
		} else {
			if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
				document.getElementById("result").innerHTML = " Error : Please Enter a valid Email Address .........";
				return false;
			}
		}

		if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= x.length) {
			document.getElementById("result").innerHTML = " Error : Please Enter a valid Email Address .........";
			return false;
		}

		var c = document.forms["myform"]["subject"].value;
		if (c == null || c == "") {
			document.getElementById("result").innerHTML = " Error : Subject field must be filled...";
			return false;
		}
		var d = document.forms["myform"]["message"].value;
		if (d == null || d == "") {
			document.getElementById("result").innerHTML = " Error : Please write a message .........";
			return false;
		}
		var elem = document.getElementById("result");
		elem.innerHTML = "Message is sending";
		elem.style.color = "#00BEFD";

		return (true);
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
				$("#myform").trigger("reset");
			});
		});
	});
</script>
