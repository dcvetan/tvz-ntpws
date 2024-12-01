<?php
print '
<main>
    <h1>Contact Us</h1>
    <div class="contact-container">
        <div class="contact-form">
            <h2>Send us a message</h2>
            <form action="process.php" method="post">
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>
                
                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="country">Country:</label>
                    <select id="country" name="country" required>
                        <option value="">Select a country</option>
                        <option value="HR">Croatia</option>
                        <option value="SI">Slovenia</option>
                        <option value="AT">Austria</option>
                        <option value="HU">Hungary</option>
                        <option value="RS">Serbia</option>
                        <option value="BA">Bosnia and Herzegovina</option>
                        <option value="ME">Montenegro</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" rows="5" required></textarea>
                </div>
                
                <button type="submit">Send Message</button>
            </form>
        </div>
        
        <div class="map-container">
            <h2>Find Us</h2>
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2781.7974754461987!2d15.967324476777662!3d45.795392712700095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4765d68b5d094979%3A0xda8bfa8459b67560!2sVeleučilište%20Velika%20Gorica!5e0!3m2!1shr!2shr!4v1709334005322!5m2!1shr!2shr"
                width="100%" 
                height="450" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</main>';
?>