<?php

	@session_start();
	if (isset($_SESSION['usuario_id'])) {
		session_destroy();
		header("location: ../"); //estemos donde estemos nos redirije al index
	}else{
            header('location: ../');
        }