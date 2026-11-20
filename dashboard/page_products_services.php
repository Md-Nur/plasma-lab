<?php
include('head.php'); 
include('redirect.php'); 
include('navigation.php'); 

$msg = '';
$alert_success = 'display: none';
$alert_failed = 'display: none';

// Tab selection: 'services' or 'products'
$active_tab = isset($_GET['tab']) && $_GET['tab'] === 'products' ? 'products' : 'services';

// --- SERVICE VARIABLES ---
$s_id = 0;
$s_title = '';
$s_description = '';
$s_tags = '';
$s_icon = 'fa-cogs';
$s_image = '';
$s_status = 'active';
$s_edit_state = false;

// --- PRODUCT VARIABLES ---
$p_id = 0;
$p_name = '';
$p_badge = 'Plasma System';
$p_badge_theme = 'teal';
$p_icon_emoji = '⚡';
$p_image = '';
$p_description = '';
$p_specifications = '';
$p_status = 'active';
$p_edit_state = false;

// ==========================================
// 1. SERVICE ACTIONS
// ==========================================
// Save new service
if (isset($_POST['save_service'])) {
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $tags = mysqli_real_escape_string($db, $_POST['tags']);
    $icon = mysqli_real_escape_string($db, $_POST['icon'] ?: 'fa-cogs');
    $image = mysqli_real_escape_string($db, $_POST['image'] ?? '');
    if (!empty($_FILES['image_file']['name'])) {
        $uploadErr = '';
        $uploaded = upload_dashboard_image($_FILES['image_file'], '../images/activities/', $uploadErr);
        if ($uploaded) {
            $image = preg_match('~^https?://~i', $uploaded) ? $uploaded : ('images/activities/' . $uploaded);
        }
    }
    $status = in_array($_POST['status'] ?? '', ['active', 'inactive']) ? $_POST['status'] : 'active';

    $sql = "INSERT INTO services (title, description, tags, icon, image, status) VALUES ('$title', '$description', '$tags', '$icon', '$image', '$status')";
    if (mysqli_query($db, $sql)) {
        $msg = 'Service added successfully!';
        $alert_success = '';
        $active_tab = 'services';
    } else {
        $msg = 'Failed to add service: ' . mysqli_error($db);
        $alert_failed = '';
        $active_tab = 'services';
    }
}

// Update existing service
if (isset($_POST['update_service'])) {
    $id = (int)$_POST['id'];
    $title = mysqli_real_escape_string($db, $_POST['title']);
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $tags = mysqli_real_escape_string($db, $_POST['tags']);
    $icon = mysqli_real_escape_string($db, $_POST['icon'] ?: 'fa-cogs');
    $image = mysqli_real_escape_string($db, $_POST['image'] ?? '');
    if (!empty($_FILES['image_file']['name'])) {
        $uploadErr = '';
        $uploaded = upload_dashboard_image($_FILES['image_file'], '../images/activities/', $uploadErr);
        if ($uploaded) {
            $image = preg_match('~^https?://~i', $uploaded) ? $uploaded : ('images/activities/' . $uploaded);
        }
    }
    $status = in_array($_POST['status'] ?? '', ['active', 'inactive']) ? $_POST['status'] : 'active';

    $sql = "UPDATE services SET title='$title', description='$description', tags='$tags', icon='$icon', image='$image', status='$status' WHERE id=$id";
    if (mysqli_query($db, $sql)) {
        $msg = 'Service updated successfully!';
        $alert_success = '';
        $active_tab = 'services';
    } else {
        $msg = 'Failed to update service: ' . mysqli_error($db);
        $alert_failed = '';
        $s_edit_state = true;
        $active_tab = 'services';
    }
}

// Delete service
if (isset($_GET['del_service'])) {
    $del_id = (int)$_GET['del_service'];
    if (mysqli_query($db, "DELETE FROM services WHERE id=$del_id")) {
        $msg = 'Service deleted successfully!';
        $alert_success = '';
    } else {
        $msg = 'Failed to delete service.';
        $alert_failed = '';
    }
    $active_tab = 'services';
}

// Fetch service for editing
if (isset($_GET['edit_service'])) {
    $s_id = (int)$_GET['edit_service'];
    $s_edit_state = true;
    $res = mysqli_query($db, "SELECT * FROM services WHERE id=$s_id");
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);
        $s_title = $row['title'];
        $s_description = $row['description'];
        $s_tags = $row['tags'];
        $s_icon = $row['icon'];
        $s_image = $row['image'] ?? '';
        $s_status = $row['status'];
    }
    $active_tab = 'services';
}

// ==========================================
// 2. PRODUCT ACTIONS
// ==========================================
// Save new product
if (isset($_POST['save_product'])) {
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $badge = mysqli_real_escape_string($db, $_POST['badge']);
    $badge_theme = in_array($_POST['badge_theme'] ?? '', ['teal', 'plum', 'coral']) ? $_POST['badge_theme'] : 'teal';
    $icon_emoji = mysqli_real_escape_string($db, $_POST['icon_emoji'] ?: '⚡');
    $image = mysqli_real_escape_string($db, $_POST['image'] ?? '');
    if (!empty($_FILES['image_file']['name'])) {
        $uploadErr = '';
        $uploaded = upload_dashboard_image($_FILES['image_file'], '../images/instruments/', $uploadErr);
        if ($uploaded) {
            $image = preg_match('~^https?://~i', $uploaded) ? $uploaded : ('images/instruments/' . $uploaded);
        }
    }
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $specifications = mysqli_real_escape_string($db, $_POST['specifications']);
    $status = in_array($_POST['status'] ?? '', ['active', 'inactive']) ? $_POST['status'] : 'active';

    $sql = "INSERT INTO products (name, badge, badge_theme, icon_emoji, image, description, specifications, status) VALUES ('$name', '$badge', '$badge_theme', '$icon_emoji', '$image', '$description', '$specifications', '$status')";
    if (mysqli_query($db, $sql)) {
        $msg = 'Product added successfully!';
        $alert_success = '';
        $active_tab = 'products';
    } else {
        $msg = 'Failed to add product: ' . mysqli_error($db);
        $alert_failed = '';
        $active_tab = 'products';
    }
}

// Update existing product
if (isset($_POST['update_product'])) {
    $id = (int)$_POST['id'];
    $name = mysqli_real_escape_string($db, $_POST['name']);
    $badge = mysqli_real_escape_string($db, $_POST['badge']);
    $badge_theme = in_array($_POST['badge_theme'] ?? '', ['teal', 'plum', 'coral']) ? $_POST['badge_theme'] : 'teal';
    $icon_emoji = mysqli_real_escape_string($db, $_POST['icon_emoji'] ?: '⚡');
    $image = mysqli_real_escape_string($db, $_POST['image'] ?? '');
    if (!empty($_FILES['image_file']['name'])) {
        $uploadErr = '';
        $uploaded = upload_dashboard_image($_FILES['image_file'], '../images/instruments/', $uploadErr);
        if ($uploaded) {
            $image = preg_match('~^https?://~i', $uploaded) ? $uploaded : ('images/instruments/' . $uploaded);
        }
    }
    $description = mysqli_real_escape_string($db, $_POST['description']);
    $specifications = mysqli_real_escape_string($db, $_POST['specifications']);
    $status = in_array($_POST['status'] ?? '', ['active', 'inactive']) ? $_POST['status'] : 'active';

    $sql = "UPDATE products SET name='$name', badge='$badge', badge_theme='$badge_theme', icon_emoji='$icon_emoji', image='$image', description='$description', specifications='$specifications', status='$status' WHERE id=$id";
    if (mysqli_query($db, $sql)) {
        $msg = 'Product updated successfully!';
        $alert_success = '';
        $active_tab = 'products';
    } else {
        $msg = 'Failed to update product: ' . mysqli_error($db);
        $alert_failed = '';
        $p_edit_state = true;
        $active_tab = 'products';
    }
}

// Delete product
if (isset($_GET['del_product'])) {
    $del_id = (int)$_GET['del_product'];
    if (mysqli_query($db, "DELETE FROM products WHERE id=$del_id")) {
        $msg = 'Product deleted successfully!';
        $alert_success = '';
    } else {
        $msg = 'Failed to delete product.';
        $alert_failed = '';
    }
    $active_tab = 'products';
}

// Fetch product for editing
if (isset($_GET['edit_product'])) {
    $p_id = (int)$_GET['edit_product'];
    $p_edit_state = true;
    $res = mysqli_query($db, "SELECT * FROM products WHERE id=$p_id");
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);
        $p_name = $row['name'];
        $p_badge = $row['badge'];
        $p_badge_theme = $row['badge_theme'];
        $p_icon_emoji = $row['icon_emoji'];
        $p_image = $row['image'] ?? '';
        $p_description = $row['description'];
        $p_specifications = $row['specifications'];
        $p_status = $row['status'];
    }
    $active_tab = 'products';
}

// Fetch lists
$services_list = mysqli_query($db, "SELECT * FROM services ORDER BY id ASC");
$products_list = mysqli_query($db, "SELECT * FROM products ORDER BY id ASC");
$services_count = $services_list ? mysqli_num_rows($services_list) : 0;
$products_count = $products_list ? mysqli_num_rows($products_list) : 0;
?>

<style>
.tab-nav-btn {
    padding: 10px 24px;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    background: rgba(255,255,255,0.06);
    color: var(--text-muted, #94a3b8);
    transition: all 0.25s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
}
.tab-nav-btn:hover {
    color: #fff;
    background: rgba(255,255,255,0.12);
    text-decoration: none;
}
.tab-nav-btn.active {
    background: var(--primary-gradient, linear-gradient(135deg, #1ca7a8, #7b3d73));
    color: #fff;
    box-shadow: 0 4px 14px rgba(28,167,168,0.3);
}
.tab-badge {
    background: rgba(0,0,0,0.25);
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
}
.card-item-box {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 14px;
    padding: 18px 20px;
    margin-bottom: 16px;
    transition: all 0.25s ease;
}
.card-item-box:hover {
    border-color: rgba(28,167,168,0.3);
    background: rgba(255,255,255,0.06);
}
.tag-pill {
    display: inline-block;
    padding: 2px 8px;
    background: rgba(28,167,168,0.15);
    color: #2dd4bf;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    margin: 2px;
}
.badge-theme-pill {
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}
.badge-theme-teal { background: rgba(45,212,191,0.2); color: #2dd4bf; }
.badge-theme-plum { background: rgba(192,132,252,0.2); color: #c084fc; }
.badge-theme-coral { background: rgba(244,114,182,0.2); color: #f472b6; }
</style>

<div class="container-fluid" style="padding: 20px 24px;">
    <!-- Page Header & Tab Bar -->
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 16px; margin-bottom: 24px;">
        <div>
            <h2 style="font-size: 22px; font-weight: 800; color: #fff; margin: 0 0 6px;">
                <i class="fa fa-cube" style="color: #2dd4bf; margin-right: 8px;"></i> Products & Services Manager
            </h2>
            <p style="color: var(--text-muted, #94a3b8); font-size: 13px; margin: 0;">
                Add, update, or remove analytical services and research equipment shown on the public Products & Services page.
            </p>
        </div>

        <div style="display: flex; gap: 10px;">
            <a href="page_products_services.php?id=page_products_services&tab=services" class="tab-nav-btn <?php echo $active_tab === 'services' ? 'active' : ''; ?>">
                <i class="fa fa-cogs"></i> Services <span class="tab-badge"><?php echo $services_count; ?></span>
            </a>
            <a href="page_products_services.php?id=page_products_services&tab=products" class="tab-nav-btn <?php echo $active_tab === 'products' ? 'active' : ''; ?>">
                <i class="fa fa-flask"></i> Products <span class="tab-badge"><?php echo $products_count; ?></span>
            </a>
            <a href="../products_services.php" target="_blank" class="tab-nav-btn" style="background: rgba(28,167,168,0.2); color: #2dd4bf;">
                <i class="fa fa-external-link"></i> Live Preview
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    <div class="alert alert-success" style="<?php echo $alert_success; ?>; margin-bottom: 20px; border-radius: 10px;">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-check-circle" style="margin-right: 8px;"></i> <?php echo $msg; ?>
    </div>
    <div class="alert alert-danger" style="<?php echo $alert_failed; ?>; margin-bottom: 20px; border-radius: 10px;">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fa fa-exclamation-circle" style="margin-right: 8px;"></i> <?php echo $msg; ?>
    </div>

    <!-- ======================================================== -->
    <!-- TAB 1: SERVICES MANAGEMENT                               -->
    <!-- ======================================================== -->
    <?php if ($active_tab === 'services'): ?>
    <div class="row">
        <!-- Service Form (Left Column) -->
        <div class="col-md-5">
            <div class="card" style="background: var(--card-bg, #1e293b); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <h4 style="color: #fff; font-size: 16px; font-weight: 700; margin-top: 0; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;">
                    <span><?php echo $s_edit_state ? '✏️ Edit Service' : '➕ Add New Service'; ?></span>
                    <?php if ($s_edit_state): ?>
                        <a href="page_products_services.php?id=page_products_services&tab=services" class="btn btn-xs btn-default" style="border-radius: 6px;">Cancel</a>
                    <?php endif; ?>
                </h4>

                <form method="POST" action="page_products_services.php?id=page_products_services&tab=services" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $s_id; ?>">

                    <div class="form-group">
                        <label style="color: #cbd5e1; font-size: 13px;">Service Title *</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Surface Modification & Treatment" value="<?php echo htmlspecialchars($s_title); ?>" required style="background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.12); color: #fff;">
                    </div>

                    <div class="form-group">
                        <label style="color: #cbd5e1; font-size: 13px;">Description *</label>
                        <textarea name="description" rows="4" class="form-control" placeholder="Describe the scientific/analytical service offered..." required style="background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.12); color: #fff;"><?php echo htmlspecialchars($s_description); ?></textarea>
                    </div>

                    <div class="form-group" style="margin-bottom: 18px;">
                        <label style="color: #cbd5e1; font-size: 13px; font-weight: 600; display: block; margin-bottom: 8px;">Service Image</label>
                        <input type="hidden" name="image" value="<?php echo htmlspecialchars($s_image); ?>">
                        <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                            <!-- Preview Box -->
                            <div style="position: relative; width: 72px; height: 72px; border-radius: 12px; overflow: hidden; border: 1px dashed rgba(255,255,255,0.2); background: rgba(0,0,0,0.25); flex-shrink: 0;">
                                <img id="service_preview" src="<?php echo !empty($s_image) ? htmlspecialchars(get_image_url($s_image, '../')) : ''; ?>" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; <?php echo empty($s_image) ? 'display: none;' : ''; ?>">
                                <div id="service_placeholder" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; color: rgba(255,255,255,0.3); <?php echo !empty($s_image) ? 'display: none;' : ''; ?>">
                                    <i class="fa fa-image fa-lg"></i>
                                </div>
                            </div>
                            <!-- Upload Button & File Name -->
                            <div style="flex: 1; min-width: 0;">
                                <div class="photo_post" style="margin-bottom: 6px;">
                                    <input type="file" name="image_file" id="service_image_file" accept="image/jpeg,image/png,image/gif,image/webp" onchange="previewServiceImage(event)">
                                    <label for="service_image_file"><i class="fa fa-upload" style="margin-right: 5px;"></i>Upload Image</label>
                                </div>
                                <span id="service_fileNameDisplay" style="display: block; color: #cbd5e1; font-size: 12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo !empty($s_image) ? ('Current: ' . htmlspecialchars(basename($s_image))) : 'No file chosen'; ?>
                                </span>
                                <span style="display: block; color: var(--text-muted, #94a3b8); font-size: 11px; margin-top: 3px;">Supports JPG, PNG, GIF, WEBP</span>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="color: #cbd5e1; font-size: 13px;">Tags (comma separated)</label>
                        <input type="text" name="tags" class="form-control" placeholder="e.g. DBD Plasma, Wettability, Adhesion" value="<?php echo htmlspecialchars($s_tags); ?>" style="background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.12); color: #fff;">
                        <small style="color: var(--text-muted, #94a3b8);">Badges displayed on the service card.</small>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="color: #cbd5e1; font-size: 13px;">FontAwesome Icon</label>
                                <input type="text" name="icon" class="form-control" placeholder="e.g. fa-bolt, fa-medkit" value="<?php echo htmlspecialchars($s_icon); ?>" style="background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.12); color: #fff;">
                                <small style="color: var(--text-muted, #94a3b8);"><a href="https://fontawesome.com/v4/icons/" target="_blank" style="color: #2dd4bf;">View Icons</a></small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label style="color: #cbd5e1; font-size: 13px;">Status</label>
                                <select name="status" class="form-control" style="background: #1e293b; border-color: rgba(255,255,255,0.12); color: #fff;">
                                    <option value="active" <?php echo ($s_status === 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?php echo ($s_status === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="margin-top: 15px;">
                        <?php if ($s_edit_state): ?>
                            <button type="submit" name="update_service" class="btn btn-warning btn-block" style="font-weight: 700; border-radius: 10px; padding: 10px;">
                                <i class="fa fa-save"></i> Update Service
                            </button>
                        <?php else: ?>
                            <button type="submit" name="save_service" class="btn btn-primary btn-block" style="font-weight: 700; border-radius: 10px; padding: 10px; background: linear-gradient(135deg, #1ca7a8, #0e7490); border: none;">
                                <i class="fa fa-plus-circle"></i> Add Service
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Services List (Right Column) -->
        <div class="col-md-7">
            <div class="card" style="background: var(--card-bg, #1e293b); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 24px;">
                <h4 style="color: #fff; font-size: 16px; font-weight: 700; margin-top: 0; margin-bottom: 20px;">
                    📋 All Services (<?php echo $services_count; ?>)
                </h4>

                <?php if ($services_count === 0): ?>
                    <div style="text-align: center; padding: 40px 20px; color: var(--text-muted, #94a3b8);">
                        <i class="fa fa-cogs fa-3x" style="opacity: 0.3; margin-bottom: 12px;"></i>
                        <p>No services registered yet. Add your first service using the form on the left.</p>
                    </div>
                <?php else: ?>
                    <?php while ($s = mysqli_fetch_array($services_list)): ?>
                    <div class="card-item-box">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">
                            <div style="display: flex; gap: 14px;">
                                <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(28,167,168,0.15); color: #2dd4bf; display: flex; align-items: center; justify-content: center; font-size: 18px; flex-shrink: 0; overflow:hidden;">
                                    <?php if (!empty($s['image']) && (preg_match('~^https?://~i', $s['image']) || file_exists('../' . $s['image']))): ?>
                                        <img src="<?php echo htmlspecialchars(get_image_url($s['image'], '../')); ?>" alt="img" style="width:100%; height:100%; object-fit:cover;">
                                    <?php else: ?>
                                        <i class="fa <?php echo htmlspecialchars($s['icon'] ?: 'fa-cogs'); ?>"></i>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h5 style="color: #fff; font-weight: 700; font-size: 15px; margin: 0 0 6px;">
                                        <?php echo htmlspecialchars($s['title']); ?>
                                        <?php if ($s['status'] === 'inactive'): ?>
                                            <span style="font-size: 10px; background: rgba(239,68,68,0.2); color: #f87171; padding: 2px 6px; border-radius: 8px; margin-left: 6px;">Inactive</span>
                                        <?php else: ?>
                                            <span style="font-size: 10px; background: rgba(34,197,94,0.2); color: #4ade80; padding: 2px 6px; border-radius: 8px; margin-left: 6px;">Active</span>
                                        <?php endif; ?>
                                    </h5>
                                    <p style="color: #cbd5e1; font-size: 13px; line-height: 1.5; margin: 0 0 8px;">
                                        <?php echo nl2br(htmlspecialchars($s['description'])); ?>
                                    </p>
                                    <div>
                                        <?php 
                                        if (!empty($s['tags'])) {
                                            $tag_arr = explode(',', $s['tags']);
                                            foreach ($tag_arr as $t) {
                                                echo '<span class="tag-pill">' . htmlspecialchars(trim($t)) . '</span>';
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; gap: 6px; flex-shrink: 0;">
                                <a href="page_products_services.php?id=page_products_services&tab=services&edit_service=<?php echo $s['id']; ?>" class="btn btn-xs btn-info" style="border-radius: 6px;">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a href="page_products_services.php?id=page_products_services&tab=services&del_service=<?php echo $s['id']; ?>" onclick="return confirm('Are you sure you want to delete this service?');" class="btn btn-xs btn-danger" style="border-radius: 6px;">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- ======================================================== -->
    <!-- TAB 2: PRODUCTS MANAGEMENT                               -->
    <!-- ======================================================== -->
    <?php if ($active_tab === 'products'): ?>
    <div class="row">
        <!-- Product Form (Left Column) -->
        <div class="col-md-5">
            <div class="card" style="background: var(--card-bg, #1e293b); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 24px; box-shadow: 0 4px 20px rgba(0,0,0,0.15);">
                <h4 style="color: #fff; font-size: 16px; font-weight: 700; margin-top: 0; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;">
                    <span><?php echo $p_edit_state ? '✏️ Edit Product' : '➕ Add New Product'; ?></span>
                    <?php if ($p_edit_state): ?>
                        <a href="page_products_services.php?id=page_products_services&tab=products" class="btn btn-xs btn-default" style="border-radius: 6px;">Cancel</a>
                    <?php endif; ?>
                </h4>

                <form method="POST" action="page_products_services.php?id=page_products_services&tab=products" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $p_id; ?>">

                    <div class="form-group">
                        <label style="color: #cbd5e1; font-size: 13px;">Product Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Atmospheric Pressure Plasma Jet (APPJ)" value="<?php echo htmlspecialchars($p_name); ?>" required style="background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.12); color: #fff;">
                    </div>

                    <div class="form-group" style="margin-bottom: 18px;">
                        <label style="color: #cbd5e1; font-size: 13px; font-weight: 600; display: block; margin-bottom: 8px;">Product Image</label>
                        <input type="hidden" name="image" value="<?php echo htmlspecialchars($p_image); ?>">
                        <div style="display: flex; align-items: center; gap: 14px; flex-wrap: wrap;">
                            <!-- Preview Box -->
                            <div style="position: relative; width: 72px; height: 72px; border-radius: 12px; overflow: hidden; border: 1px dashed rgba(255,255,255,0.2); background: rgba(0,0,0,0.25); flex-shrink: 0;">
                                <img id="product_preview" src="<?php echo !empty($p_image) ? htmlspecialchars(get_image_url($p_image, '../')) : ''; ?>" alt="Preview" style="width: 100%; height: 100%; object-fit: cover; <?php echo empty($p_image) ? 'display: none;' : ''; ?>">
                                <div id="product_placeholder" style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; color: rgba(255,255,255,0.3); <?php echo !empty($p_image) ? 'display: none;' : ''; ?>">
                                    <i class="fa fa-image fa-lg"></i>
                                </div>
                            </div>
                            <!-- Upload Button & File Name -->
                            <div style="flex: 1; min-width: 0;">
                                <div class="photo_post" style="margin-bottom: 6px;">
                                    <input type="file" name="image_file" id="product_image_file" accept="image/jpeg,image/png,image/gif,image/webp" onchange="previewProductImage(event)">
                                    <label for="product_image_file"><i class="fa fa-upload" style="margin-right: 5px;"></i>Upload Image</label>
                                </div>
                                <span id="product_fileNameDisplay" style="display: block; color: #cbd5e1; font-size: 12px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <?php echo !empty($p_image) ? ('Current: ' . htmlspecialchars(basename($p_image))) : 'No file chosen'; ?>
                                </span>
                                <span style="display: block; color: var(--text-muted, #94a3b8); font-size: 11px; margin-top: 3px;">Supports JPG, PNG, GIF, WEBP</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label style="color: #cbd5e1; font-size: 13px;">Badge Text</label>
                                <input type="text" name="badge" class="form-control" placeholder="e.g. Plasma System" value="<?php echo htmlspecialchars($p_badge); ?>" style="background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.12); color: #fff;">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label style="color: #cbd5e1; font-size: 13px;">Color Theme</label>
                                <select name="badge_theme" class="form-control" style="background: #1e293b; border-color: rgba(255,255,255,0.12); color: #fff;">
                                    <option value="teal" <?php echo ($p_badge_theme === 'teal') ? 'selected' : ''; ?>>Teal</option>
                                    <option value="plum" <?php echo ($p_badge_theme === 'plum') ? 'selected' : ''; ?>>Plum</option>
                                    <option value="coral" <?php echo ($p_badge_theme === 'coral') ? 'selected' : ''; ?>>Coral</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label style="color: #cbd5e1; font-size: 13px;">Emoji / Icon</label>
                                <input type="text" name="icon_emoji" class="form-control" placeholder="⚡" value="<?php echo htmlspecialchars($p_icon_emoji); ?>" style="background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.12); color: #fff; text-align: center;">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label style="color: #cbd5e1; font-size: 13px;">Description *</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Short description of the product and applications..." required style="background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.12); color: #fff;"><?php echo htmlspecialchars($p_description); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label style="color: #cbd5e1; font-size: 13px;">Key Specifications (one per line)</label>
                        <textarea name="specifications" rows="4" class="form-control" placeholder="Frequency: 1–100 kHz operation&#10;Working gases: He, Ar, N2&#10;Plasma temperature: Near room temperature" style="background: rgba(0,0,0,0.2); border-color: rgba(255,255,255,0.12); color: #fff; font-family: monospace; font-size: 12px;"><?php echo htmlspecialchars($p_specifications); ?></textarea>
                        <small style="color: var(--text-muted, #94a3b8);">Each line will be displayed with a checkmark bullet.</small>
                    </div>

                    <div class="form-group">
                        <label style="color: #cbd5e1; font-size: 13px;">Status</label>
                        <select name="status" class="form-control" style="background: #1e293b; border-color: rgba(255,255,255,0.12); color: #fff;">
                            <option value="active" <?php echo ($p_status === 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($p_status === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>

                    <div style="margin-top: 15px;">
                        <?php if ($p_edit_state): ?>
                            <button type="submit" name="update_product" class="btn btn-warning btn-block" style="font-weight: 700; border-radius: 10px; padding: 10px;">
                                <i class="fa fa-save"></i> Update Product
                            </button>
                        <?php else: ?>
                            <button type="submit" name="save_product" class="btn btn-primary btn-block" style="font-weight: 700; border-radius: 10px; padding: 10px; background: linear-gradient(135deg, #7b3d73, #9d174d); border: none;">
                                <i class="fa fa-plus-circle"></i> Add Product
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Products List (Right Column) -->
        <div class="col-md-7">
            <div class="card" style="background: var(--card-bg, #1e293b); border: 1px solid rgba(255,255,255,0.08); border-radius: 16px; padding: 24px;">
                <h4 style="color: #fff; font-size: 16px; font-weight: 700; margin-top: 0; margin-bottom: 20px;">
                    📦 All Products (<?php echo $products_count; ?>)
                </h4>

                <?php if ($products_count === 0): ?>
                    <div style="text-align: center; padding: 40px 20px; color: var(--text-muted, #94a3b8);">
                        <i class="fa fa-cube fa-3x" style="opacity: 0.3; margin-bottom: 12px;"></i>
                        <p>No products added yet. Add your first product using the form on the left.</p>
                    </div>
                <?php else: ?>
                    <?php while ($p = mysqli_fetch_array($products_list)): ?>
                    <div class="card-item-box">
                        <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 12px;">
                            <div style="display: flex; gap: 14px;">
                                <div style="width: 50px; height: 50px; border-radius: 12px; background: rgba(255,255,255,0.08); display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0; overflow:hidden;">
                                    <?php if (!empty($p['image']) && (preg_match('~^https?://~i', $p['image']) || file_exists('../' . $p['image']))): ?>
                                        <img src="<?php echo htmlspecialchars(get_image_url($p['image'], '../')); ?>" alt="img" style="width:100%; height:100%; object-fit:cover;">
                                    <?php else: ?>
                                        <?php echo htmlspecialchars($p['icon_emoji'] ?: '⚡'); ?>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div style="margin-bottom: 4px;">
                                        <span class="badge-theme-pill badge-theme-<?php echo htmlspecialchars($p['badge_theme'] ?: 'teal'); ?>">
                                            <?php echo htmlspecialchars($p['badge'] ?: 'Plasma System'); ?>
                                        </span>
                                        <?php if ($p['status'] === 'inactive'): ?>
                                            <span style="font-size: 10px; background: rgba(239,68,68,0.2); color: #f87171; padding: 2px 6px; border-radius: 8px; margin-left: 6px;">Inactive</span>
                                        <?php endif; ?>
                                    </div>
                                    <h5 style="color: #fff; font-weight: 700; font-size: 15px; margin: 0 0 6px;">
                                        <?php echo htmlspecialchars($p['name']); ?>
                                    </h5>
                                    <p style="color: #cbd5e1; font-size: 13px; line-height: 1.5; margin: 0 0 8px;">
                                        <?php echo nl2br(htmlspecialchars($p['description'])); ?>
                                    </p>
                                    <?php if (!empty($p['specifications'])): ?>
                                        <div style="background: rgba(0,0,0,0.2); border-radius: 8px; padding: 8px 12px; font-size: 12px; color: var(--text-muted, #94a3b8); margin-top: 6px;">
                                            <strong style="color: #cbd5e1;">Specs:</strong>
                                            <?php 
                                            $specs = explode("\n", trim($p['specifications']));
                                            echo count($specs) . ' item(s)';
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div style="display: flex; gap: 6px; flex-shrink: 0;">
                                <a href="page_products_services.php?id=page_products_services&tab=products&edit_product=<?php echo $p['id']; ?>" class="btn btn-xs btn-info" style="border-radius: 6px;">
                                    <i class="fa fa-pencil"></i> Edit
                                </a>
                                <a href="page_products_services.php?id=page_products_services&tab=products&del_product=<?php echo $p['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');" class="btn btn-xs btn-danger" style="border-radius: 6px;">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<script>
function previewServiceImage(event) {
    var file = event.target.files && event.target.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('service_preview');
            var ph = document.getElementById('service_placeholder');
            if (img) {
                img.src = e.target.result;
                img.style.display = 'block';
            }
            if (ph) {
                ph.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
        var fn = document.getElementById('service_fileNameDisplay');
        if (fn) {
            fn.textContent = file.name;
        }
    }
}

function previewProductImage(event) {
    var file = event.target.files && event.target.files[0];
    if (file) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('product_preview');
            var ph = document.getElementById('product_placeholder');
            if (img) {
                img.src = e.target.result;
                img.style.display = 'block';
            }
            if (ph) {
                ph.style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
        var fn = document.getElementById('product_fileNameDisplay');
        if (fn) {
            fn.textContent = file.name;
        }
    }
}
</script>

<?php include('bottom.php'); ?>
