<?php 
include "../Accesso/connect.php";
session_start();
$stop = mysqli_real_escape_string($mysqli, $_GET['stop']);
if(isset($stop) && $stop==1){
    //Se lo user non è loggato e non è nemmeno un ospite redirect al login
    if ( isset($_SESSION['user'])) {
        $user = $_SESSION['user'];
        $colore1= $_SESSION['colore1'];
        $colore2= $_SESSION['colore2'];
        
        // Below function will convert datetime to time elapsed string
        function time_elapsed_string($datetime, $full = false) {
            $now = new DateTime;
            $ago = new DateTime($datetime);
            $diff = $now->diff($ago);
            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;
            $string = array('y' => 'anni', 'm' => 'mesi', 'w' => 'settimane', 'd' => 'giorni', 'h' => 'ore', 'i' => 'minuti', 's' => 'secondi');
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
                } else {
                    unset($string[$k]);
                }
            }
            if (!$full) $string = array_slice($string, 0, 1);
            return $string ? implode(', ', $string) . ' fa' : 'adesso';
        }
        // This function will populate the comments and comments replies using a loop
        function show_comments($comments, $parent_id, $colore) {
            $html = '';
            if ($parent_id != -1) {
                // If the comments are replies sort them by the "submit_date" column
                array_multisort(array_column($comments, 'DataOra'), SORT_ASC, $comments);
            }
            // Iterate the comments using the foreach loop
            foreach ($comments as $comment) {
                if ($comment['IdParent'] == $parent_id) {
                    // Add the comment to the $html variable
                    $html .= '
                    <div class="comment" style="background-color:'.$colore.';">
                        <div>
                            <h3 class="name">' . htmlspecialchars($comment['Autore'], ENT_QUOTES) . '</h3>
                            <span class="date">' . time_elapsed_string($comment['DataOra']) . '</span>
                        </div>
                        <p class="content">' . nl2br(htmlspecialchars($comment['Testo'], ENT_QUOTES)) . '</p>
                        <a class="reply_comment_btn" href="#" data-comment-id="' . $comment['IdCommento'] . '">Rispondi</a>
                        ' . show_write_comment_form($comment['IdCommento']) . '
                        <div class="replies" >
                        ' . show_comments($comments, $comment['IdCommento'], $colore) . '
                        </div>
                    </div>
                    ';
                }
            }
            return $html;
        }

        // This function is the template for the write comment form
        function show_write_comment_form($parent_id = -1) {
            $html= '
            <div class="write_comment '.$parent_id .'" data-comment-id="' . $parent_id . '">
                <form>
                    <input class="commento_commento" name="parent_id" type="hidden" value=" ' . $parent_id . '">
                    <a name="testo_commento">  </a>
                    <textarea type="text" class="commento" name="content" placeholder="Scrivi il tuo commento qui..." maxlength="125" required></textarea>
                    <button type="submit" onclick="window.location.reload()">Pubblica commento</button>
                </form>
            </div>
            ';
            return $html;
        }
        // Page ID needs to exist, this is used to determine which comments are for which page
        if (isset($_GET['page_id'])) {
            // Check if the submitted form variables exist
            if ( isset($_POST['content'])) {
                // POST variables exist, insert a new comment into the MySQL comments table (user submitted form)
                $page_id = $_GET['page_id'];
                $name = $_SESSION['user'];
                $content = $_POST['content'];
                $id_parent = $_POST['parent_id'];
                //PREPARED STATEMENT 
                $stmt = $mysqli->prepare("INSERT INTO `commento` (Autore, IdParent, IdPage, Testo) VALUES (?,?,?,?)");
                $stmt->bind_param("siis", $name, $id_parent, $page_id, $content);
                $stmt->execute() or trigger_error($stmt->error, E_USER_ERROR);
                $stmt->close();
                exit;
            }
            // Get all comments by the Page ID ordered by the submit date
            $stmt = $mysqli->prepare('SELECT * FROM `commento` WHERE IdPage = ? ORDER BY DataOra DESC');
            $stmt->bind_param('i', $_GET['page_id']);
            $stmt-> execute();
            $result = $stmt->get_result();
            $comments = $result->fetch_all(MYSQLI_ASSOC);
            $count_comments = $result->num_rows;
        } else {
            exit('No page ID specified!');
        }
        ?>
        

        <div class="comment_header">
            <span class="total"><?=$count_comments?> commenti</span>
            <a href="#testo_commento" class="write_comment_btn" data-comment-id="-1">Scrivi commento</a>
        </div>
        <?=show_write_comment_form()?>
        <?=show_comments($comments, -1, $colore2)?>

        
    <?php  
    } else {
        header("Location: ../Accesso/index.php?stop=1");
    }
} else {
    header("Location: ../Accesso/index.php?stop=1");
}

?>
