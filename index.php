<?php
include 'model/database.php';
include 'model/user.php';
include 'model/service.php';
include 'controller/controllerUserList.php';
include_once 'view/header.php';
?>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mt-5">
                <div class="col-md-3">
                    <form action="index.php" method="POST">
                        <select class="custom-select" name="service" id="service">
                            <option selected disabled>Filtrer par service</option>
                            <?php foreach ($selectService as $selectService) { ?>
                                <option value="<?= $selectService['id'] ?>" > <?= $selectService['serviceName'] ?></option>
                            <?php }
                            ?>
                        </select>
                        <p class="text-danger"><?= isset($formError['service']) ? $formError['service'] : ''; ?></p>
                        <input class="w-100 card mt-2 font-text font-weight-bold" type="submit" value="Filtrer" name="select"/>
                    </form>
                </div>
                <table class="table table-striped table-light text-center mt-5 grey lighten-3">
                    <h2>Liste des utilisateurs</h2>
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Âge</th>
                            <th>Adresse</th>
                            <th>Numéro de téléphone</th>
                            <th>Service et Description</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>     
                    </thead> 
                    <tbody>
                        <?php foreach ($showUser as $profil) { ?> 
                            <tr>
                                <td><?= $profil->lastname ?></td>
                                <td><?= $profil->firstname ?></td>
                                <td><?= age($profil->birthDate) ?></td>
                                <td><?= $profil->adress . ' ' . $profil->postalCode ?></td>
                                <td><?= $profil->phone ?></td>
                                <td><?= $profil->serviceName . ' : ' . $profil->description ?></td>
                                <td><a href="view/modifyUser.php?id=<?= $profil->id ?>"><img src="/assets/image/modif.png" style="width: 25px;" /></a></td>
                                <td><a href="index.php?id=<?= $profil->id ?>"><img src="/assets/image/delete.png" style="width: 25px;" /></a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-2 offset-5">
                <?php if(isset($page) && ($page  >= '2')) {?>
                        <a href="index.php?page=<?= $prevPage ?>"><img src="assets/image/prev.png" style="width: 40px;" /></a>
                    <?php } ?>
                <?php if(!isset($page)) { ?>
                    <a href="index.php?page=2"><img src="assets/image/next.png" style="width: 40px;" class="ml-5" /></a>
                    <?php } else if ($page <= $maxPage) { ?>
                    <a href="index.php?page=<?= $nextPage ?>"><img src="assets/image/next.png" style="width: 40px;" class="ml-5" /></a>
<?php } ?>
            </div>
        </div>
    </div>
</body>
<?php include 'view/footer.php' ?>