<?php
    while($row = mysqli_fetch_assoc($sql)){
        $sql2 = "SELECT * FROM messages WHERE (incoming_msg_id = {$row['unique_id']}
                OR outgoing_msg_id = {$row['unique_id']}) AND (outgoing_msg_id = {$outgoing_id}
                OR incoming_msg_id = {$outgoing_id}) ORDER BY msg_id DESC LIMIT 1";
        $query2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($query2);
        $role = $row["role"];
        if(mysqli_num_rows($query2) > 0){
            $result = $row2['msg'];
        }else{
            $result = "No message available";
        }

        // Trimming message if word count is greater than 28
        (strlen($result) > 28) ? $msg = substr($result, 0, 28).'...' : $msg = $result;
        // Adding you: text before the message if the message is sent by the user
        if($row2) {
            ($outgoing_id == $row2['outgoing_msg_id']) ? $you = "You: " : $you = "";
        } else {
            $you = "";
        }
        
        if ($row["role"] === "owner") {
            ($role == $row["role"]) ? $role = "Owner" : $role = "";
        } elseif ($row["role"] === "admin") {
            ($role == $row["role"]) ? $role = "Admin" : $role = "";
        } else {
            $role = "";
        }

        
        // Checking if user is online or offline
        ($row['status'] == "Offline now") ? $offline = "offline" : $offline = "";

        $output .= '<a href="chats.php?user_id='.$row['unique_id'].'">
                    <div class="content">
                        <img src="php/images/'. $row['img'] .'" alt="">
                        <div class="details">
                            <span>'. $row['username'] .'</span>
                            <i>'. $role .'</i>
                            <p>'. $you . $msg .'</p>
                        </div>
                    </div>
                    <div class="status-dot '.$offline.'"><i class="fas fa-circle"></i></div>
                    </a>';
    }
?>