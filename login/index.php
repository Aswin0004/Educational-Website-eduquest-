
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Email Varification</title>

    <style>
        body{
            background-color: #f0f2f5;
            background-image: url(img/cover.jpg);
            background-repeat: no-repeat;
            background-size: cover;
            height: 62vh;
            margin: 0;
            padding-top: 20px;
        }
        .form-container{
            max-width: 450px;
            margin: 60px auto;
            padding: 25px;
            background-color: white;
            border-radius: 15px;
            border: 1px solid #ddd;
            box-shadow: 0 6px 20px rgb(0, 0, 0 / 0.1);
            transition: box-shadow 0.3s ease-in-out;
            margin-top: 170px;
            margin-right: 250px;
        }

        .form-container:hover {
            box-shadow:0 12px 40px rgb(0, 0, 0 / 0.2);
        }

        .form-container h5 {
            text-align: center;
            margin-bottom: 25px;
            color: #343a40;
            border: 2px solid gray;
            border-radius: 10px;
            padding: 5px 10px;
            display: inline-block;
            background-color: #f8f9fa;
            margin-left: 120px;
        }

        .form-control{
            padding-left: 45px;
        }

        .input-group-text{
            width: 40px;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: none;
        }

        .input-group .form-control{
            border-left: none;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h5>Signup-form</h5>
        <form action="send.php" method="post">

        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-user"></i></span>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Your Name" autocomplete="off">
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-phone"></i></span>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter Phone Number" autocomplete="off">
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Your Email" autocomplete="off">
        </div>
        <div class="mb-3 input-group">
            <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="text" name="password" id="password" class="form-control" placeholder="Enter Password" autocomplete="off">
        </div>
        <div class="mb-3 input-group">
            <input type="hidden" name="otp" id="otp" class="form-control" >
            <input type="hidden" name="subject" id="subject" class="form-control" value="Receved OTP">
        </div>

        <button type="submit" name="send" class="btn btn-primary w-100">Signup <i class="fas fa-arrow-right"></i></button>

        </form>
        <br>
        <p>You have an account ? <a href="login.php">Login now</a></p>
    </div>
</body>
</html>

<script>
    function generateRandomNumber(){

        let min = 100000;
        let max = 999999;
        let randomNumber = Math.floor(Math.random() * (max - min +1)) +min ;

        let lastGenerateNumber = localStorage.getItem('lastGeneratedNumber');
        while (randomNumber === parseInt(lastGenerateNumber)) {
            randomNumber = Math.floor(Math.random() * ma(max -min +1)) +min;
        }
        localStorage.setItem('lastGenerateNumber', randomNumber);
        return randomNumber;
    }
    document.getElementById('otp') .value = generateRandomNumber();
</script>