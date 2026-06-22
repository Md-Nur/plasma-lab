<?php 
include('head.php');
session_start();
if(isset($_SESSION["sess_username"])){
     header('Location: /dashboard/index.php');
     exit;
}

$msg = '';
$alert_failed = 'display : none';
$alert_success = 'display : none';
$username_tmp = "";
$password_tmp = "";



if(isset($_SESSION["sess_username"])){
     header('Location: /dashboard/index.php');
     exit;
}

if(isset($_GET['change']) && isset($_SESSION["retrive_id"])) {
	$id = $_GET['change'];
     if ($id == $_SESSION['retrive_id']) {
          $msg = 'Password Updated.Please login.';
          $alert_success = '';
          session_unset();
          session_destroy();
     }
	
}



if(isset($_POST['login'])){
     
     $username = $_POST['username'];
     $password = $_POST['password'];
     $password = md5($password);
     $sql = "SELECT * FROM admin_login WHERE username = '$username' and password = '$password' ";
     $result = mysqli_query($db,$sql);
     $rowcount=mysqli_num_rows($result);
     //echo $rowcount;
     
     if ($rowcount == 1){
          
          $rec = mysqli_query($db, $sql);
		      $record = mysqli_fetch_array($rec);
          $_SESSION["sess_username"]= $record['username'];
          $_SESSION['id'] = $record['id'];
          header('Location: /dashboard/index.php');
          exit;
          
     }else {
          $alert_failed = '';
          $msg = "Incorrect Email / Password !";
          
     }
     
     
}

?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
/* Reset and custom layouts for login screen */
body {
    background: radial-gradient(circle at 50% 50%, #111827 0%, #030712 100%) !important;
    font-family: 'Outfit', sans-serif !important;
    color: #f3f4f6 !important;
    min-height: 100vh;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin: 0 !important;
    overflow-x: hidden;
    position: relative;
}

/* Back links/Navbar elements override if needed */
.navbar, .sidebar, .breadcrumbs, .page-header {
    display: none !important;
}

/* Background decorative glowing blobs */
.glow-blob {
    position: absolute;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, rgba(168, 85, 247, 0.05) 50%, rgba(0,0,0,0) 70%);
    border-radius: 50%;
    z-index: 1;
    pointer-events: none;
    filter: blur(60px);
}
.blob-1 {
    top: 10%;
    left: 15%;
}
.blob-2 {
    bottom: 10%;
    right: 15%;
}

.login-wrapper {
    position: relative;
    z-index: 10;
    width: 100%;
    max-width: 440px;
    padding: 20px;
    box-sizing: border-box;
}

.glass-card {
    background: rgba(17, 24, 39, 0.65) !important;
    backdrop-filter: blur(24px) saturate(180%);
    -webkit-backdrop-filter: blur(24px) saturate(180%);
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    border-radius: 24px !important;
    padding: 40px !important;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important;
    width: 100%;
    box-sizing: border-box;
}

.login-header {
    text-align: center;
    margin-bottom: 32px;
}

.login-logo {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, rgba(99, 102, 241, 0.2) 0%, rgba(168, 85, 247, 0.2) 100%);
    border: 1px solid rgba(99, 102, 241, 0.4);
    border-radius: 16px;
    margin: 0 auto 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-logo i {
    font-size: 28px;
    background: linear-gradient(135deg, #a5b4fc 0%, #c084fc 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.login-header h2 {
    font-size: 24px !important;
    font-weight: 700 !important;
    color: #ffffff !important;
    margin: 0 0 8px 0 !important;
    letter-spacing: -0.5px !important;
    background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.login-header p {
    font-size: 14px !important;
    color: #9ca3af !important;
    margin: 0 !important;
}

.modern-alert {
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 24px;
    border: 1px solid;
    animation: fadeIn 0.35s ease;
    box-sizing: border-box;
    width: 100%;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}

.modern-alert-danger {
    background: rgba(239, 68, 68, 0.1) !important;
    border-color: rgba(239, 68, 68, 0.2) !important;
    color: #f87171 !important;
}

.modern-alert-success {
    background: rgba(16, 185, 129, 0.1) !important;
    border-color: rgba(16, 185, 129, 0.2) !important;
    color: #34d399 !important;
}

.modern-form-group {
    position: relative;
    margin-bottom: 20px;
    width: 100%;
}

.modern-form-group label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: #9ca3af;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.input-wrapper {
    position: relative;
    width: 100%;
}

.input-wrapper i.prefix-icon {
    position: absolute;
    left: 16px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    font-size: 16px;
    transition: color 0.2s ease;
}

.modern-input {
    width: 100% !important;
    height: 48px !important;
    padding: 10px 16px 10px 46px !important;
    border-radius: 12px !important;
    background: rgba(15, 23, 42, 0.6) !important;
    border: 1px solid rgba(255, 255, 255, 0.08) !important;
    color: #ffffff !important;
    font-size: 15px !important;
    font-family: inherit !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    box-sizing: border-box !important;
}

.modern-input:focus {
    border-color: #6366f1 !important;
    background: rgba(15, 23, 42, 0.8) !important;
    outline: none !important;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.25) !important;
}

.modern-input:focus + i.prefix-icon {
    color: #818cf8;
}

.password-toggle-btn {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #6b7280;
    padding: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: all 0.2s;
    z-index: 2;
}

.password-toggle-btn:hover {
    color: #d1d5db;
    background: rgba(255, 255, 255, 0.05);
}

.forgot-password-link {
    display: block;
    text-align: right;
    font-size: 13px;
    color: #818cf8;
    text-decoration: none;
    margin-top: 6px;
    transition: color 0.2s;
}

.forgot-password-link:hover {
    color: #a5b4fc;
    text-decoration: underline;
}

.modern-btn {
    width: 100% !important;
    height: 48px !important;
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
    border: none !important;
    border-radius: 12px !important;
    color: #ffffff !important;
    font-size: 15px !important;
    font-weight: 600 !important;
    cursor: pointer !important;
    transition: all 0.25s !important;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.25) !important;
    margin-top: 10px;
    box-sizing: border-box;
}

.modern-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(99, 102, 241, 0.35) !important;
    background: linear-gradient(135deg, #6c6ef5 0%, #544bf0 100%) !important;
}

.modern-btn:active {
    transform: translateY(1px);
    box-shadow: 0 2px 8px rgba(99, 102, 241, 0.15) !important;
}

.hidden {
    display: none !important;
}
</style>

<div class="glow-blob blob-1"></div>
<div class="glow-blob blob-2"></div>

<div class="login-wrapper">
    <div class="glass-card">
        <div class="login-header">
            <div class="login-logo">
                <i class="fa fa-bolt"></i>
            </div>
            <h2>Plasma Energy Laboratory</h2>
            <p>Sign In to your Dashboard</p>
        </div>

        <?php if ($msg !== ''): ?>
            <?php if ($alert_success === ''): ?>
                <div class="modern-alert modern-alert-success">
                    <strong><?php echo $msg; ?></strong>
                </div>
            <?php elseif ($alert_failed === ''): ?>
                <div class="modern-alert modern-alert-danger">
                    <strong><?php echo $msg; ?></strong>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form id="loginform" action="login.php" method="post">
            <div class="modern-form-group">
                <label for="login-username">Username or Email</label>
                <div class="input-wrapper">
                    <input id="login-username" type="text" class="modern-input" name="username" autocomplete="username" placeholder="Enter username or email" required>
                    <i class="fa fa-user prefix-icon"></i>
                </div>
            </div>

            <div class="modern-form-group">
                <label for="login-password">Password</label>
                <div class="input-wrapper">
                    <input id="login-password" type="password" class="modern-input" name="password" autocomplete="current-password" placeholder="Enter password" required>
                    <i class="fa fa-lock prefix-icon"></i>
                    <button id="toggle-password" type="button" class="password-toggle-btn" aria-label="Toggle password visibility">
                        <!-- Eye open icon -->
                        <svg class="eye-icon-on" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <!-- Eye closed icon -->
                        <svg class="eye-icon-off hidden" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
                <a href="forgot_pass.php" class="forgot-password-link">Forgot password?</a>
            </div>

            <button type="submit" name="login" class="modern-btn">Sign In</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePassword = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('login-password');
    
    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            const eyeOn = this.querySelector('.eye-icon-on');
            const eyeOff = this.querySelector('.eye-icon-off');
            
            eyeOn.classList.toggle('hidden');
            eyeOff.classList.toggle('hidden');
        });
    }
});
</script>

<?php include('bottom.php');?>