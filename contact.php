<?php
require_once 'config.php';

$success = '';
$error = '';

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? 'General Inquiry');
    $message = trim($_POST['message'] ?? '');

    // Simple validation
    if (empty($name) || empty($email) || empty($message)) {
        $error = 'Please fill in all required fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            $stmt = $pdo->prepare("
                INSERT INTO contact_messages (name, email, subject, message)
                VALUES (:name, :email, :subject, :message)
            ");
            $stmt->execute([
                ':name'    => htmlspecialchars($name),
                ':email'   => htmlspecialchars($email),
                ':subject' => htmlspecialchars($subject),
                ':message' => htmlspecialchars($message),
            ]);
            $success = 'Thank you for contacting us! We will get back to you shortly.';
        } catch (PDOException $e) {
            $error = 'Something went wrong. Please try again later.';
        }
    }
}

$page_title = 'Contact Us';
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row">
        <!-- Contact Info -->
        <div class="col-lg-5 mb-5 mb-lg-0">
            <h1 class="font-brand display-5 mb-4">Get in Touch</h1>
            <p class="text-muted mb-5">Have a question about your order, our products, or just want to say hello? We'd love to hear from you.</p>

            <!-- Visit Us removed -->

            <div class="d-flex mb-4">
                <div class="me-3">
                    <i class="material-icons text-primary" style="font-size: 28px;">email</i>
                </div>
                <div>
                    <h5 class="mb-1">Email Us</h5>
                    <p class="text-muted mb-0">contact.venaro@gmail.com</p>
                </div>
            </div>

            <div class="d-flex mb-4">
                <div class="me-3">
                    <i class="material-icons text-primary" style="font-size: 28px;">phone</i>
                </div>
                <div>
                    <h5 class="mb-1">Call Us</h5>
                    <p class="text-muted mb-0">+91 96659 97194<br>Mon - Sat, 10am - 8pm</p>
                </div>
            </div>

            <div class="d-flex mt-5 gap-3">
                <a href="#" class="btn btn-outline-dark rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="material-icons" style="font-size: 20px;">facebook</i></a>
                <a href="https://www.instagram.com/venaro_apparel/" target="_blank" class="btn btn-outline-dark rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="material-icons" style="font-size: 20px;">camera_alt</i></a>
                <a href="mailto:contact.venaro@gmail.com" class="btn btn-outline-dark rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="material-icons" style="font-size: 20px;">alternate_email</i></a>
            </div>
        </div>

        <!-- Contact Form -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">
                    <h3 class="font-brand mb-4">Send us a Message</h3>

                    <?php if ($success): ?>
                        <div class="alert alert-success d-flex align-items-center">
                            <i class="material-icons me-2">check_circle</i>
                            <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($error): ?>
                        <div class="alert alert-danger d-flex align-items-center">
                            <i class="material-icons me-2">error</i>
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Your Name</label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Your Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Subject</label>
                            <select class="form-select browser-default" name="subject">
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="Order Status">Order Status</option>
                                <option value="Returns & Exchanges">Returns & Exchanges</option>
                                <option value="Product Information">Product Information</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Message</label>
                            <textarea class="form-control" name="message" rows="5" required></textarea>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 py-2">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>