<?php
require_once("sec.php");
sec_session_start();

/**
 * Source: http://portal.bluejack.binus.ac.id/tutorials/webchatapplicationusinglong-pollingtechnologywithphpandajax
 */
class MessageHandler {

    protected $db = null;

    public function __construct(){

        try {
            $this->db = new PDO("sqlite:db.db");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOEception $e) {

            die("Something went wrong, try again");
        }

        $mode = $this->fetch('mode');
        
        switch($mode){
            case 'get':
                $this->getMessage();
                break;
            case 'post':
                $this->postMessage();
                break;
        }
    }

    protected function postMessage() {

        $name = $this->fetch('user');
        $message = $this->fetch('message');
        $token = $this->fetch('token');

        if(empty($name) || empty($message)) {

            $this->output(false, "Username and messagefield can't be empty, let's chat!");
            return false;
        }

        if($_SESSION['token'] != $token) {

            session_write_close();
            http_response_code(403);
            die("Something went wrong, try again!");

        } else {

            try {
                $sql = "INSERT INTO messages (message, name) VALUES(?, ?)";
                $query = $this->db->prepare($sql);
                $params = array($message,$name);
                $query->execute($params);

            } catch (PDOException $e) {

                die("Something went wrong, try again!");
            }
        }
    }
    protected function getMessage() {

        $endTime = time() + 20;
        $numberOfMessages = $this->fetch('numberOfMessages');
        $lastTime = $this->fetch('lastTime');
        $currentTime = null;

        while (time() < $endTime) {

            try {

                $sql = "SELECT * FROM messages ORDER BY dateAdded DESC";
                $query = $this->db->prepare($sql);
                $query->execute();
                $result = $query->fetchAll();

                $currentTime = strtotime($result[0]["dateAdded"]);

                if(!empty($result) && $lastTime != $currentTime) {

                    $newMessages = array();
                    $numberOfNewMessages = count($result) - $numberOfMessages;

                    for ($i = 0; $i < $numberOfNewMessages; $i++) {
                        $newMessages[] = $result[$i];
                    }

                    $this->output(true, "", array_reverse($newMessages), $currentTime);
                    break;

                } else {

                    sleep(1);
                }

            } catch (PDOException $e) {

                die("Something went wrong, try again!");
            }
        }
    }

    protected function fetch($name) {

        $val = isset($_POST[$name]) ? $_POST[$name] : "";

        return strip_tags(trim($val));
    }

    protected function output($result, $output, $message = null, $latestTime = null) {

        echo json_encode(array(
            'result' => $result,
            'message' => $message,
            'output' => $output,
            'latestTime' => $latestTime
        ));
    }
}

new MessageHandler();