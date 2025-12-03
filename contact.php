   <!-- Start Contact Us Section -->
    <section id="contact" class="contact">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title text-center wow fadeInDown" data-wow-duration="2s" data-wow-delay="50ms">
                        <h2>Contact With Us</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <form name="sentMessage" id="contactForm" action="send_message.php" method="POST">
                        <div class="row">
                            <div class="col-md-6 wow fadeInLeft" data-wow-duration="2s" data-wow-delay="600ms">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Your Name *" id="name" name="name" required data-validation-required-message="Please enter your name.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Your Email *" id="email" name="email" required data-validation-required-message="Please enter your email address.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input type="tel" class="form-control" placeholder="Your Phone *" id="phone" name="phone" required data-validation-required-message="Please enter your phone number.">
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6 wow fadeInRight" data-wow-duration="2s" data-wow-delay="600ms">
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Your Message *" id="message" name="message" required data-validation-required-message="Please enter a message."></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-lg-12 text-center wow zoomIn" data-wow-duration="1s" data-wow-delay="600ms">
                                <div id="success"></div>
                                <button type="submit" class="btn btn-primary">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
    </section>

    <div class="google-map" style="display: flex; justify-content: center; align-items: center; width: 100%; height: 100%;">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3941.2336954234815!2d125.52951825!3d8.95060085!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3301c05c6fc2ea35%3A0x79e1fcf8f473c954!2sButuan%20City%20Library%2C%20Jose%20Rosales%20Ave%2C%20Butuan%20City%2C%208600%20Agusan%20Del%20Norte!5e0!3m2!1sen!2sph!4v1746250913399!5m2!1sen!2sph" style="border:0; width: 100%; height: 100%;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>   </div>

    <script>
    document.getElementById('contactForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent the default form submission

        const formData = new FormData(this);

        fetch('send_message.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            // Display the success or error message
            const successDiv = document.getElementById('success');
            successDiv.innerHTML = `<p>${data}</p>`;
            successDiv.style.color = data.includes('successfully') ? 'green' : 'red';
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
    </script>
        
        