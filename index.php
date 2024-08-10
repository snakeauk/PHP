<?php 

    $comment_array = array();

    //connect to DB
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=bbs', "root", );
    } catch (PDOException $e) {
        echo $e->getMessage();
    }

    // when enter form
    if (!empty($_POST["submitButton"])) {
        $postDate = date("Y-m-d H:i:s");

        try {
            $stmt = $pdo->prepare("INSERT INTO `bbs_table` (`username`, `comment`, `postDate`) VALUES (:username, :comment, :postDate)");
            $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
            $stmt->bindParam(':comment', $_POST["comment"], PDO::PARAM_STR);
            $stmt->bindParam(":postDate", $postDate, PDO::PARAM_STR);

            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    $sql = "SELECT `id`, `username`, `comment`, `postDate` FROM `bbs_table`;";
    $comment_array = $pdo->query($sql);

    //disconnect to DB
    $pdo = null;

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>掲示板</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1 class="title">掲示板</h1>
        <hr>
        <div class="boardWrapper">
            <section>
                <?php foreach($comment_array as $comment): ?>
                    <article>
                        <div class="wrapper">
                            <div class="nameArea">
                                <span>名前 : </span>
                                <p class="username"><?php echo $comment["username"]; ?></p>
                                <time>:<?php echo $comment["postDate"]?></time>
                            </div>
                        </div>
                        <p class="comment"><?php echo $comment["comment"]; ?></p>
                    </article>
                <?php endforeach; ?>
            </section>
            <form class="formWrapper" method="POST">
                <div>
                    <input type="submit" value="書き込む" name="submitButton">
                    <label for="">名前 : </label>
                    <input type="text" name="username">
                    <div>
                        <textarea class="commentTextArea" name="comment"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>