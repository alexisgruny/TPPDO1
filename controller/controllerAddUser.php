<?php
// Instanciation de la classe service()
$service = NEW service();
// Appel de la methode selectService()
$selectService = $service->selectService();
// Déclaration d'un tableau d'érreur
$formError = array();
// Déclaration des regex pour la sécurité des champs 
// Déclaration regex numéro de téléphone
$regexPhone = '/^[0-9]{10}$/';
// Déclaration regex nom
$regexName = '/^[a-zA-Zàáâãäåçèéêëìíîïðòóôõöùúûüýÿ\-]+$/';
// Déclaration regex date
$regexDate = '/^\d\d\d\d-(0?[1-9]|1[0-2])-(0?[1-9]|[12][0-9]|3[01])$/';
// Déclaration regex adresse
$regexAdress = '/^[A-z0-9àáâãäåçèéêëìíîïðòóôõöùúûüýÿ\- ]+$/';
// Déclaration regex nombre et lettre
$regexPostalCode = '/^[0-9]{5}+$/';
// Déclaration regex Service  , compris entre 1 et 4
$regexService = '/^[1234]{1}$/';
if (isset($_POST['submit'])) {
    // Instanciation de la classe user()
    $newUser = NEW user();
    // Sécurité Nom
    if (!empty($_POST['lastname'])) {
        if (preg_match($regexName, $_POST['lastname'])) {
            $newUser->lastname = htmlspecialchars($_POST['lastname']);
        } else {
            $formError['lastname'] = 'Nom invalide.';
        }
    } else {
        $formError['lastname'] = 'Nom obligatoire.';
    }
    // Sécurité Prénom
    if (!empty($_POST['firstname'])) {
        if (preg_match($regexName, $_POST['firstname'])) {
            $newUser->firstname = htmlspecialchars($_POST['firstname']);
        } else {
            $formError['firstname'] = 'Prénom invalide.';
        }
    } else {
        $formError['firstname'] = 'Prénom obligatoire.';
    }
    // Sécurité Date de naissance
    if (!empty($_POST['birthDate'])) {
        if (preg_match($regexDate, $_POST['birthDate'])) {
            $newUser->birthDate = htmlspecialchars($_POST['birthDate']);
        } else {
            $formError['birthDate'] = 'Date de naissance invalide.';
        }
    } else {
        $formError['birthDate'] = 'Date de naissance obligatoire.';
    }
    // Sécurité service
    if (!empty($_POST['adress'])) {
        if (preg_match($regexAdress, $_POST['adress'])) {
            $newUser->adress = htmlspecialchars($_POST['adress']);
        } else {
            $formError['adress'] = 'Adresse invalide.';
        }
    } else {
        $formError['adress'] = 'Adresse obligatoire.';
    }
    // Sécurité Code postal
    if (!empty($_POST['postalCode'])) {
        if (preg_match($regexPostalCode, $_POST['postalCode'])) {
            $newUser->postalCode = htmlspecialchars($_POST['postalCode']);
        } else {
            $formError['postalCode'] = 'Code postal invalide.';
        }
    } else {
        $formError['postalCode'] = 'Code postal obligatoire.';
    }
    // Sécurité Numéro de téléphone
    if (!empty($_POST['phone'])) {
        if (preg_match($regexPhone, $_POST['phone'])) {
            $newUser->phone = htmlspecialchars($_POST['phone']);
        } else {
            $formError['phone'] = 'Numéro de téléphone invalide.';
        }
    } else {
        $formError['phone'] = 'Numéro de téléphone obligatoire.';
    }
    // Sécurité Service
    if (!empty($_POST['service'])) {
        if (preg_match($regexService, $_POST['service'])) {
            $newUser->service = htmlspecialchars($_POST['service']);
        } else {
            $formError['service'] = 'Service invalide.';
        }
    } else {
        $formError['service'] = 'Service obligatoire.';
    }
    if (count($formError) == 0) {
        $check = $newUser->checkIfUserExist();
        if ($check === '0') {
            if (!$newUser->addUser()) {
                //$formError['submit'] = 'Il y a eu un problème';
            }
        } else if ($check === FALSE) {
            $formError['submit'] = 'Il y a eu un problème';
        }
         else {
            $formError['submit'] = 'le rendez-vous est déjà pris';
        }
    } 
}

?>