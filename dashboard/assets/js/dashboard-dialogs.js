/**
 * Dashboard Dialog & Upload Helpers (DRY)
 */
(function(window) {
  'use strict';

  var Dashboard = window.Dashboard || {};

  /**
   * Initialize a native HTML5 dialog element with open/close triggers and light dismiss fallback.
   */
  Dashboard.initDashboardDialog = function(config) {
    var dialog = document.getElementById(config.dialogId);
    var openBtn = document.getElementById(config.openBtnId);
    if (!dialog) return;

    // Open button listener
    if (openBtn) {
      openBtn.addEventListener('click', function(e) {
        e.preventDefault();
        dialog.showModal();
        if (typeof config.onOpen === 'function') {
          config.onOpen(dialog);
        }
      });
    }

    // Close buttons class listener
    var closeClass = config.closeBtnClass || 'dlg-close-btn';
    var closeButtons = dialog.querySelectorAll('.' + closeClass + ', [data-dismiss="modal"]');
    closeButtons.forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();
        dialog.close();
      });
    });

    // Reset when closed
    dialog.addEventListener('close', function() {
      if (typeof config.onClose === 'function') {
        config.onClose(dialog);
      } else {
        // Default form and preview reset
        var form = dialog.querySelector('form');
        if (form) form.reset();

        var resultEl = dialog.querySelector('.dlg-result, #result');
        if (resultEl) resultEl.textContent = '';

        var previewImg = dialog.querySelector('.dlg-preview img, #output');
        var placeholder = dialog.querySelector('.preview-placeholder, #previewPlaceholder');
        var nameDisplay = dialog.querySelector('.file-name-display, #fileNameDisplay');

        if (previewImg) {
          previewImg.src = '';
          previewImg.style.display = 'none';
        }
        if (placeholder) {
          placeholder.style.display = '';
        }
        if (nameDisplay) {
          nameDisplay.textContent = 'No file selected';
        }
      }
    });

    // Light-dismiss backdrop click fallback for browsers without native closedby support (Safari)
    if (!('closedBy' in HTMLDialogElement.prototype)) {
      dialog.addEventListener('click', function(event) {
        if (event.target !== dialog) return;
        var rect = dialog.getBoundingClientRect();
        var isContentClick = (
          rect.top <= event.clientY && event.clientY <= rect.top + rect.height &&
          rect.left <= event.clientX && event.clientX <= rect.left + rect.width
        );
        if (!isContentClick) {
          dialog.close();
        }
      });
    }
  };

  /**
   * Helper to display sleek Toast Notifications
   */
  /**
   * Active toast auto-hide timer ID (allows reset on rapid successive calls).
   */
  var _toastTimer = null;

  Dashboard.showToast = function(message, type) {
    type = type || 'success';
    var toast = document.getElementById('dashboard-toast');
    if (!toast) {
      toast = document.createElement('div');
      toast.id = 'dashboard-toast';
      document.body.appendChild(toast);
    }

    // Clear any pending auto-hide so new toasts reset the countdown
    if (_toastTimer) {
      clearTimeout(_toastTimer);
      _toastTimer = null;
    }

    toast.className = 'dashboard-toast dashboard-toast-' + type;
    
    var iconClass = type === 'success' ? 'fa-check-circle' : 'fa-times-circle';
    var iconColor = type === 'success' ? '#10b981' : '#ef4444';
    
    toast.innerHTML = '<i class="fa ' + iconClass + '" style="color: ' + iconColor + '"></i>'
      + '<span style="flex:1">' + message + '</span>'
      + '<button type="button" class="toast-close-btn" aria-label="Dismiss">&times;</button>';

    // Bind close button
    var closeBtn = toast.querySelector('.toast-close-btn');
    if (closeBtn) {
      closeBtn.addEventListener('click', function() {
        if (_toastTimer) { clearTimeout(_toastTimer); _toastTimer = null; }
        toast.classList.remove('active');
      });
    }
    
    // Force a reflow then show
    toast.offsetHeight;
    toast.classList.add('active');

    _toastTimer = setTimeout(function() {
      toast.classList.remove('active');
      _toastTimer = null;
    }, 4000);
  };

  /**
   * Hook file inputs to dynamically show preview image
   */
  Dashboard.initImagePreview = function(fileInputId, previewImgId, placeholderId, nameDisplayId) {
    var input = document.getElementById(fileInputId);
    var preview = document.getElementById(previewImgId);
    var placeholder = placeholderId ? document.getElementById(placeholderId) : null;
    var nameDisplay = nameDisplayId ? document.getElementById(nameDisplayId) : null;

    if (!input || !preview) return;

    input.addEventListener('change', function(event) {
      var file = event.target.files[0];
      if (!file) return;

      var reader = new FileReader();
      reader.onload = function() {
        preview.src = reader.result;
        preview.style.display = 'block';
        if (placeholder) {
          placeholder.style.display = 'none';
        }
      };
      reader.readAsDataURL(file);

      if (nameDisplay) {
        nameDisplay.textContent = file.name;
      }
    });
  };

  /**
   * Handle AJAX file uploads with loading state and immediate modal dismissal.
   */
  Dashboard.setupAjaxForm = function(config) {
    var form = document.getElementById(config.formId);
    var dialog = document.getElementById(config.dialogId);
    if (!form) return;

    form.addEventListener('submit', function(e) {
      e.preventDefault();

      var resultEl = form.querySelector('.dlg-result, #result') || document.getElementById('result');
      var submitBtn = form.querySelector('button[type="submit"], input[type="submit"]');
      var originalBtnHtml = submitBtn ? submitBtn.innerHTML || submitBtn.value : '';

      if (config.validate && typeof config.validate === 'function') {
        var error = config.validate(form);
        if (error) {
          if (resultEl) {
            resultEl.style.color = '#ef4444';
            resultEl.textContent = error;
          }
          return;
        }
      }

      // Show loading state
      if (submitBtn) {
        submitBtn.disabled = true;
        if (submitBtn.tagName === 'INPUT') {
          submitBtn.value = 'Uploading...';
        } else {
          submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Uploading...';
        }
      }
      if (resultEl) resultEl.textContent = '';

      var formData = new FormData(form);
      formData.append(config.submitParamName || 'insert', '1');

      var xhr = new XMLHttpRequest();
      xhr.open('POST', config.endpoint || form.getAttribute('action') || window.location.href, true);
      xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

      xhr.onload = function() {
        // Reset submit button state
        if (submitBtn) {
          submitBtn.disabled = false;
          if (submitBtn.tagName === 'INPUT') {
            submitBtn.value = originalBtnHtml;
          } else {
            submitBtn.innerHTML = originalBtnHtml;
          }
        }

        try {
          var resp = JSON.parse(xhr.responseText);
          if (resp.success) {
            // Close dialog immediately so it doesn't block the screen
            if (dialog && typeof dialog.close === 'function') {
              dialog.close();
            }

            // Show Toast notification
            Dashboard.showToast(resp.message || 'Operation completed successfully.', 'success');

            // Refresh grid or reload page
            setTimeout(function() {
              window.location.href = config.redirectUrl || window.location.href;
            }, 1200);
          } else {
            if (resultEl) {
              resultEl.style.color = '#ef4444';
              resultEl.textContent = resp.message || 'Action failed. Please try again.';
            }
          }
        } catch (err) {
          if (resultEl) {
            resultEl.style.color = '#ef4444';
            resultEl.textContent = 'An unexpected server error occurred.';
          }
        }
      };

      xhr.onerror = function() {
        if (submitBtn) {
          submitBtn.disabled = false;
          if (submitBtn.tagName === 'INPUT') {
            submitBtn.value = originalBtnHtml;
          } else {
            submitBtn.innerHTML = originalBtnHtml;
          }
        }
        if (resultEl) {
          resultEl.style.color = '#ef4444';
          resultEl.textContent = 'Network error. Please check your connection.';
        }
      };

      xhr.send(formData);
    });
  };

  window.Dashboard = Dashboard;
})(window);
