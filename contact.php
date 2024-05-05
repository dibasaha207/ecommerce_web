<?php include "components/connect.php";
if (isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];
} else {
    $user_id = '';
}
if (isset($_POST['send'])) {
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $number = $_POST['number'];
    $number = filter_var($number, FILTER_SANITIZE_STRING);
    $msg = $_POST['msg'];
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);
    $select_msg = $conn->prepare("SELECT * FROM `messages` WHERE name=? AND email = ? AND number = ? AND message = ?");
    $select_msg->execute([$name, $email, $number, $msg]);
    if ($select_msg->rowCount() > 0) {
        $message[] = "Message already sent!";
    } else {
        $insert_msg = $conn->prepare("INSERT INTO `messages` (user_id,name,email,number,message) VALUES(?,?,?,?,?)");
        $insert_msg->execute([$user_id, $name, $email, $number, $msg]);
        $message[] = "message sent successfully!";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include "components/user_header.php"; ?>
    <section class="contact">
        <form action="" method="post">
            <input type="text" name="name" required class="box" placeholder="Enter your name" maxlength="20">
            <input type="email" name="email" required class="box" placeholder="Enter your email" maxlength="20">
            <input type="number" name="number" required class="box" placeholder="Enter your number" min="0" max="99999999999" onkeypress="if(this.value.length == 11)return false">
            <textarea name="msg" class="box" cols="30" rows="10" placeholder="enter your messgae"></textarea>
            <input type="submit" name="send" value="send message" class="btn">

        </form>
    </section>
    <?php include "components/footer.php";?>
    <script src="js/script.js"></script>
</body>

</html>