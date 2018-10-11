<?php
include '../model/database.php';
include '../model/user.php';
include '../model/service.php';
include '../controller/controllerModifyUser.php';
include_once '../view/header.php';
?>
<body>
    <div class="container-fluid">
        <div class="col-md-6 offset-md-3 card grey lighten-3 mt-5">
            <h2 class="font-weight-bold "> Formulaire d'ajout d'un utilisateur </h2>
            <?php if (isset($_POST['submit']) && (count($formError) == 0)) { ?>
                <p class="text-center font-weight-bold">Votre formulaire a bien étais envoyé</p>
                <!--Sinon affiche le formulaire-->
            <?php } else if (isset($_POST['submit']) && (isset($formError['submit']))) { ?>
                <p> <?= $formError['submit'] ?> </p>  
            <?php } else { ?>
                <form action="../view/modifyUser.php?id=<?= $userProfile->id ?>" method="POST">
                    <div class="form-group font-text font-weight-bold">
                        <label for="lastname">Nom</label>
                        <input class="form-control"  id="lastname" type="text" name="lastname" value="<?= isset($userProfile->lastname) ? $userProfile->lastname : '' ?>" />
                        <p class="text-danger"><?= isset($formError['lastname']) ? $formError['lastname'] : ''; ?></p>
                        <label for="firstname">Prénom</label>
                        <input class="form-control" id="firstname" type="text" name="firstname" value="<?= isset($userProfile->firstname) ? $userProfile->firstname : '' ?>" />
                        <p class="text-danger"><?= isset($formError['firstname']) ? $formError['firstname'] : ''; ?></p>
                        <label for="birthDate">Date de naissance</label>
                        <input type="date" class="form-control" id="birthDate" name="birthDate" value="<?= isset($userProfile->birthDate) ? $userProfile->birthDate : '' ?>" />
                        <p class="text-danger"><?= isset($formError['birthDate']) ? $formError['birthDate'] : ''; ?></p>
                        <label for="adress">Adresse</label>
                        <input class="form-control" id="adress" type="text" name="adress" value="<?= isset($userProfile->adress) ? $userProfile->adress : '' ?>" />
                        <p class="text-danger"><?= isset($formError['adress']) ? $formError['adress'] : ''; ?></p>
                        <label for="postalCode">Code postal</label>
                        <input class="form-control" id="postalCode" type="text" name="postalCode" value="<?= isset($userProfile->postalCode) ? $userProfile->postalCode : '' ?>" />
                        <p class="text-danger"><?= isset($formError['postalCode']) ? $formError['postalCode'] : ''; ?></p>
                        <label for="phone">Téléphone</label>
                        <input class="form-control" id="phone" name="phone" value="<?= isset($userProfile->phone) ? $userProfile->phone : '' ?>" />
                        <p class="text-danger"><?= isset($formError['phone']) ? $formError['phone'] : ''; ?></p>
                        <label for="service">Service</label>
                        <select class="custom-select" name="service" id="service">
                            <option selected disabled> Choissisez un service</option>
                            <?php foreach ($selectService as $selectService) { ?>
                                <option value="<?= $selectService['id'] ?>" > <?= $selectService['serviceName'] ?></option>
                            <?php }
                            ?>
                        </select>
                        <input class="w-100 card mt-5 font-title font-weight-bold" type="submit" value="Envoyer" name="submit"/>
                    </div>
                </form>
            <?php } ?>
        </div> 
    </div>
</body>
<?php include '../view/footer.php' ?>