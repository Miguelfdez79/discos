{"filter":false,"title":"GestorDisco.php","tooltip":"/clases/manager/GestorDisco.php","undoManager":{"mark":-1,"position":-1,"stack":[[{"start":{"row":66,"column":8},"end":{"row":89,"column":9},"action":"insert","lines":["if($emailpk === null) {","            $emailpk = $objeto->getEmail();","        }","        ","        $campos = $objeto->get();","        if($objeto->getContrasenia() === null || $objeto->getContrasenia() === ''){","            unset($campos['contrasenia']);","        }","","        if ($objeto->getEmail() === null || $objeto->getEmail() === '') {","            unset($campos['email']);","        }","        ","        if ( $objeto->getDepartamento() === null || $objeto->getDepartamento() === '' ||  $objeto->getDepartamento() === '-- selecciona una opción --') {","            unset($campos['departamento']);","        }","        ","        if ( $objeto->getFoto() === null || $objeto->getFoto() === '') {","                unset($campos['foto']);","        }","        ","        if ( $objeto->getAdmin() === null || $objeto->getAdmin() === '' || $objeto->getAdmin() === '-- selecciona una opción --') {","                unset($campos['admin']);","        }"],"id":7}],[{"start":{"row":66,"column":8},"end":{"row":67,"column":0},"action":"insert","lines":["",""],"id":6},{"start":{"row":67,"column":0},"end":{"row":67,"column":8},"action":"insert","lines":["        "]}],[{"start":{"row":65,"column":34},"end":{"row":66,"column":0},"action":"insert","lines":["",""],"id":5},{"start":{"row":66,"column":0},"end":{"row":66,"column":8},"action":"insert","lines":["        "]}]]},"ace":{"folds":[],"scrolltop":781.5454239845276,"scrollleft":0,"selection":{"start":{"row":65,"column":34},"end":{"row":65,"column":34},"isBackwards":false},"options":{"guessTabSize":true,"useWrapMode":false,"wrapToView":true},"firstLineState":0},"timestamp":1488987699934,"hash":"8c70fa2f3a328d66ce96fd2f2aab3c3035b7a79b"}