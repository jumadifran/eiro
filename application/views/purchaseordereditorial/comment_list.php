<?php

if (!empty($comments)) {
    foreach ($comments as $result) {
        echo "<span style='color:blue'>" . $result->user_comment . "</span> <i>Said</i>";
        echo "<p style='background: #e6eef8;padding:1px'>" . nl2br($result->comment) . "</p>";
        echo "<span stye='font-size:9px'>".date('d/m/Y h:i', strtotime($result->time)) . "</span><br/><hr/>";
    }
}