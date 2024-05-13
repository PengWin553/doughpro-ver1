<?php 
    session_start();
    include('connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_name = $_POST['user_name']; 
        $user_email = $_POST['user_email']; 
    
        // get the salted value from the user that matches the gmail input of the user here:
        try {

            '
                <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
                
                <label for="sendername">Sender Name :</label>
                <input type="text" id="sendername" value="Doughpro"> <br>
            
                <label for="to">To (Email) :</label>
                <input type="text" id="to" value="<?php echo $user_email; ?>"> <br>
            
                <label for="subject">Subject :</label>
                <input type="text" id="subject" value="Verification Code"> <br>
            
                <label for="replyto">Reply To (Email) :</label>
                <input type="text" id="replyto" value="<?php echo $user_email; ?>" > <br>
            
                <label for="message">Message :</label>
                <textarea cols="30" rows="10" id="message" value="sample_verification_code_string123"></textarea> <br>
            
                <button onclick="sendMail()">Send</button>
            
                <script src="js/send-verification-code.js"></script>
            ';

            echo json_encode(["res" => "success", "message" => "Login successful!"]);

        } catch (PDOException $th) {
            echo json_encode(['res' => 'error', 'message' => $th->getMessage()]);
        }
    } else {
        echo json_encode(['res' => 'error', 'message' => 'Invalid request method']);
    }

?>