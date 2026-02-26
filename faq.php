<?php
require_once 'config.php';
$page_title = 'Frequently Asked Questions';
include 'includes/header.php';
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="text-center mb-5" style="font-family: var(--font-brand); font-weight: 700;">Frequently Asked Questions</h1>
            
            <div class="accordion accordion-flush" id="faqAccordion">
                
                <!-- Item 1 -->
                <div class="accordion-item border-bottom mb-3">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button collapsed py-4 bg-transparent shadow-none" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="font-family: var(--font-brand); font-size: 1.2rem; font-weight: 600;">
                            What materials do you use?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-mdb-parent="#faqAccordion">
                        <div class="accordion-body pb-4 text-muted">
                            We exclusively use 100% organic Supima cotton for our t-shirts and hoodies. This ensures maximum breathability, durability, and soft feel. All our materials are ethically sourced and processed to meet the highest quality standards.
                        </div>
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="accordion-item border-bottom mb-3">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed py-4 bg-transparent shadow-none" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="font-family: var(--font-brand); font-size: 1.2rem; font-weight: 600;">
                            How do I find my size?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-mdb-parent="#faqAccordion">
                        <div class="accordion-body pb-4 text-muted">
                            Each product page features a distinct size guide. We generally recommend sticking to your usual size for a regular fit, or sizing up if you prefer an oversized aesthetic. If you are unsure, please reach out to our support team.
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="accordion-item border-bottom mb-3">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed py-4 bg-transparent shadow-none" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" style="font-family: var(--font-brand); font-size: 1.2rem; font-weight: 600;">
                            Do you ship internationally?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-mdb-parent="#faqAccordion">
                        <div class="accordion-body pb-4 text-muted">
                            Yes, we ship to over 50 countries worldwide. International shipping rates and delivery times vary by location and will be calculated at checkout. Please note that customs duties may apply depending on your country's regulations.
                        </div>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="accordion-item border-bottom mb-3">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed py-4 bg-transparent shadow-none" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour" style="font-family: var(--font-brand); font-size: 1.2rem; font-weight: 600;">
                            What is your return policy?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-mdb-parent="#faqAccordion">
                        <div class="accordion-body pb-4 text-muted">
                            We accept returns within 14 days of delivery. Items must be unworn, unwashed, and in their original packaging with tags attached. Please visit our <a href="shipping-returns.php" class="text-dark text-decoration-underline">Shipping & Returns</a> page for more details.
                        </div>
                    </div>
                </div>

                <!-- Item 5 -->
                <div class="accordion-item border-bottom mb-3">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed py-4 bg-transparent shadow-none" type="button" data-mdb-toggle="collapse" data-mdb-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive" style="font-family: var(--font-brand); font-size: 1.2rem; font-weight: 600;">
                            How can I track my order?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-mdb-parent="#faqAccordion">
                        <div class="accordion-body pb-4 text-muted">
                            Once your order ships, you will receive an email with a tracking tracking number. You can also use our <a href="track-order.php" class="text-dark text-decoration-underline">Track Order</a> page to check the status of your shipment at any time.
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <p class="text-muted">Still have questions?</p>
                <a href="contact.php" class="btn btn-dark rounded-0 px-4 py-2">CONTACT SUPPORT</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
