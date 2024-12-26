<?php

$evidence_list = [
    'emf',
    'fingerprints',
    'freezing',
    'ghost_orb',
    'ghost_writing',
    'spirit_box',
];

$evidence_label_list = [
    'EMF Level 5',
    'Fingerprints',
    'Freezing',
    'Ghost Orb',
    'Ghost Writing',
    'Spirit Box',
];

$evidence_index_emf = array_search('emf', $evidence_list);
$evidence_index_fingerprints = array_search('fingerprints', $evidence_list);
$evidence_index_freezing = array_search('freezing', $evidence_list);
$evidence_index_orb = array_search('ghost_orb', $evidence_list);
$evidence_index_writing = array_search('ghost_writing', $evidence_list);
$evidence_index_spirit_box = array_search('spirit_box', $evidence_list);

$ghost_list = [
    'banshee' => [$evidence_index_emf, $evidence_index_fingerprints, $evidence_index_freezing],
    'demon' => [$evidence_index_freezing, $evidence_index_writing, $evidence_index_spirit_box],
    'jinn' => [$evidence_index_emf, $evidence_index_orb, $evidence_index_spirit_box],
    'mare' => [$evidence_index_freezing, $evidence_index_orb, $evidence_index_spirit_box],
    'oni' => [$evidence_index_emf, $evidence_index_writing, $evidence_index_spirit_box,],
    'phantom' => [$evidence_index_emf, $evidence_index_freezing, $evidence_index_orb],
    'poltergeist' => [$evidence_index_fingerprints, $evidence_index_orb, $evidence_index_spirit_box],
    'revenant' => [$evidence_index_emf, $evidence_index_fingerprints, $evidence_index_writing],
    'shade' => [$evidence_index_emf, $evidence_index_orb, $evidence_index_writing],
    'spirit' => [$evidence_index_fingerprints, $evidence_index_writing, $evidence_index_spirit_box],
    'wraith' => [$evidence_index_fingerprints, $evidence_index_freezing, $evidence_index_spirit_box],
    'yurei' => [$evidence_index_freezing, $evidence_index_orb, $evidence_index_writing],
];

$answer_list = [
    'dont_know',
    'yes',
    'no',
];

$icon_list = [
    'dont_know' => '',
    'yes' => 'fas fa-check',
    'no' => 'fas fa-times',
];

?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Phasmo Helper | @SkotosStudio</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Mine -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet"
          href="https://use.fontawesome.com/releases/v5.7.0/css/all.css"
          integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ"
          crossorigin="anonymous">
</head>
<body class="text-light">
<div class="container">
    <div class="row">
        <div class="col">
            <a href="http://phasmo.skotosstudio.com/">
                <button type="button" class="btn btn-success">New Game</button>
            </a>
        </div>
    </div>
    <hr class="bg-light">
    <div class="row">
        <div class="col-lg-5">
            <fieldset>
                <legend id="evidences">Evidences</legend>
                <form method="get">
                    <table class="table table-striped table-light table-hover">
                        <?php
                        foreach ($evidence_list as $evidence_index => $evidence) { ?>
                            <?php
                            $tr_class = '';
                            if ($_GET[$evidence] === 'yes') {
                                $tr_class = 'table-success';
                            }
                            if ($_GET[$evidence] === 'no') {
                                $tr_class = 'table-danger';
                            }
                            ?>
                            <tr class="<?= $tr_class ?>">
                                <th>
                                    <?= ucfirst($evidence_label_list[$evidence_index]) ?>
                                </th>
                                <?php
                                foreach ($answer_list as $answer_index => $answer) { ?>
                                    <td>
                                        <input class="form-check-input"
                                               type="radio"
                                               id="<?= $evidence ?>_<?= $answer ?>"
                                               name="<?= $evidence ?>"
                                               value="<?= $answer ?>"
                                            <?= $_GET[$evidence] === $answer || $answer === 'dont_know' ? 'checked' : '' ?>
                                               onchange="this.form.submit();">
                                        <label class="form-check-label"
                                               for="<?= $evidence ?>_<?= $answer ?>">
                                            <?= ucfirst($answer) ?>
                                        </label>
                                    </td>
                                <?php
                                } ?>
                            </tr>
                        <?php
                        } ?>
                    </table>
                </form>
            </fieldset>
        </div>
        <div class="col">
            <fieldset>
                <legend>Ghosts</legend>
                <table class="table table-striped table-light table-hover">
                    <?php
                    $ghost_counter = 0; ?>
                    <?php
                    foreach ($ghost_list as $ghost_name => $ghost_evidence_list) { ?>
                        <?php
                        // Skip 'no' evidence
                        foreach ($ghost_evidence_list as $evidence_index) {
                            if ($_GET[$evidence_list[$evidence_index]] === 'no') {
                                continue 2;
                            }
                        }
                        // Skip 'yes' evidence
                        foreach ($evidence_list as $evidence_index => $evidence) {
                            if ($_GET[$evidence] !== 'yes') {
                                continue;
                            }
                            if (!in_array($evidence_index, $ghost_evidence_list, true)) {
                                continue 2;
                            }
                        }
                        ?>
                        <tr>
                            <td class="align-content-center">
                                <?= ++$ghost_counter ?>
                            </td>
                            <th>
                                <?= ucfirst($ghost_name) ?>
                            </th>
                            <?php
                            foreach ($ghost_evidence_list as $evidence_index) { ?>
                                <?php
                                if ($_GET[$evidence_list[$evidence_index]] === 'yes') { ?>
                                    <?php
                                    continue; ?>
                                <?php
                                } ?>
                                <td>
                                    <?= ucfirst($evidence_label_list[$evidence_index]) ?>
                                </td>
                            <?php
                            } ?>
                        </tr>
                    <?php
                    } ?>
                </table>
                Remaining <?= $ghost_counter ?> ghost(s).
            </fieldset>
        </div>
    </div>
    <hr class="bg-light">
    <div class="row">
        <div class="col">
            <fieldset>
                <legend>Photo Evidence</legend>
                <ul>
                    <li><b>Bones</b> (also can be picked up and will not use up an item slot)</li>
                    <li><b>Dead Bodies</b> or when the ghost is killing a teammate</li>
                    <li><b>Fingerprints</b></li>
                    <li><b>Footprints</b></li>
                    <li><b>Ghost Writing book</b> (after it's been written in)</li>
                    <li>Items that have recently been moved by the ghost (i.e. bottles, ghost book, doors, etc.)</li>
                    <li>Login screen in <b>Tanglewood Street House</b>'s boys bedroom computer (click computer monitor to turn it on first)</li>
                    <li><b>Sink</b> full of <b>dirty water</b></li>
                    <li><b>Voodoo doll</b> (Only found within farm houses)</li>
                </ul>
            </fieldset>
        </div>
    </div>
</div>
</body>
</html>