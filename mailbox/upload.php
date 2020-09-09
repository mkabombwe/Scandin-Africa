<?php
	// var_dump($_GET);
	if(isset($_GET['ajax']) and $_GET['ajax']==1){
		require_once('users.class.php');
		require_once('attachments.class.php');
		
		session_start();
		
	}
	
    function traiterFichier($fichier, $tmp, $taille, $token, $mime, $ajax = false){

		$attachments = new Attachments;
		
        $dos     = ($ajax) ? '../attachments/' : 'attachments/';
        $old     = umask(00);
        $suf     = $token.'_'.date('dmYHi');
        $erreurs = array();
        $succes  = array();
        
        $taille_maxi = 10000000;
        $extensions  = array('.jpg', '.jpeg', '.JPG', '.JPEG', '.gif', '.GIF', '.png', '.PNG', '.pdf', '.PDF', '.doc', '.DOC', '.docx', '.DOCX', '.xls', '.XLS', '.xlsx', '.XLSX', '.csv', '.CSV');
        $extension   = strrchr($fichier, '.');
        $fiche       = str_replace($extensions,'',$fichier);
        $fiche       = $attachments::cl($fiche);
        $fc          = str_replace($fiche,$suf.$fiche,$attachments::cl($fichier));
		
		$rep    = array();
		$rep[0] = 0;

        if(empty($fichier)){
            $rep[1] = "Vous devez choisir un fichier";
        }elseif(!empty($fichier) and !in_array($extension, $extensions) or ($mime!="image/jpeg" and $mime!="image/png" and $mime!="application/pdf" and $mime!="text/plain" and $mime!="application/vnd.ms-excel")){
            $rep[1] = "Fichier (".$fichier.") non valide.<br> Vous devez uploader une image de type JPG ou PNG";
        }elseif($taille>$taille_maxi){
            $rep[1] = "Le fichier (".$fichier.") est trop lourd";
        }else{
                if(move_uploaded_file($tmp, $dos.$fc)){
						
						$d = new Attachments;
						
						$d->id           = '';
						$d->messageToken = $token;
						$d->type         = $mime;
						$d->path         = $fc;
						$d->date         = time();
						
						$d->save();
						
						$rep[0] = 1;
                        $rep[1] = "File (".$fichier.") saved successfully!";
                }else{
                    $rep[1] = "Error while saving the file (".$fichier.")";
                }
        }

		return $rep;
    }

	// var_dump($_FILES);
	// exit;
	
    if(isset($_FILES)){
		
        $ndocs = count($_FILES['attachments']['name']);
		
        if($ndocs!=0){
			$r    = array();
			$r[1] = "";
			
            for($i=0; $i<$ndocs; $i++){
                // récupération des documents
				// var_dump($_FILES['document']['tmp_name'][$i]);
                $doc     = str_replace(' ','',basename($_FILES['attachments']['name'][$i]));
                $doc_tmp = str_replace(' ','',$_FILES['attachments']['tmp_name'][$i]);
                $taille  = filesize($_FILES['attachments']['tmp_name'][$i]);
                // $mime1   = @getimagesize($_FILES['attachments']['tmp_name'][$i]);
                
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$mime  = finfo_file($finfo, $_FILES['attachments']['tmp_name'][$i]);
				finfo_close($finfo);
				
                if(!empty($doc)){ 
					$x     = traiterFichier($doc, $doc_tmp, $taille, @$_GET['token'], $mime, @$_GET['ajax']);
					$r[0]  = $x[0];
					$r[1] .= $x[1];
				}
                
            }
			
			echo json_encode($r);
        }
        
    }
?>
