<?php

// Instanciation de la classe user()
$userList = NEW user();
$countPage = $userList->pageCount();
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    $prevPage = isset($page) ? $page - 1 : '';
    $nextPage = isset($page) ? $page + 1 : $page;
    $maxPage = $countPage / 5;
    $userList->limitMin = $page * 5;
    $userList->limitMax = $page * 5 - 5;
// Appel de la méthode showUser()
    $showUser = $userList->showUserLimit();
} else {
    $userList->limitMax = 0;
    $showUser = $userList->showUserLimit();
}
// Instanciation de la classe service()
$service = NEW service();
// Appel de la methode selectService()
$selectService = $service->selectService();
$regexService = '/^[1234]{1}$/';

function age($date) {
    $dna = strtotime($date);
    $now = time();

    $age = date('Y', $now) - date('Y', $dna);
    if (strcmp(date('md', $dna), date('md', $now)) > 0)
        $age--;

    return $age;
}

if (isset($_GET['id'])) {
    $deleteUser = NEW user();
    $deleteUser->id = $_GET['id'];
    $deleteUserDone = $deleteUser->userDelete();
    $showUser = NEW user();
    $showUserList = $showUser->showUser();
}
if (isset($_POST['select'])) {
    if (!empty($_POST['service'])) {
        if (preg_match($regexService, $_POST['service'])) {
            $userList->service = htmlspecialchars($_POST['service']);
        } else {
            $formError['service'] = 'Service invalide.';
        }
    }
    $showUser = $userList->showSelectedUser();
}
?>