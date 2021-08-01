<div id="ContainerAttendees" class="team-single-text padding-50px-left sm-no-padding-left">
    <h4 class="font-size38 sm-font-size32 xs-font-size30">Attendees (<?= $json["attendeesCount"] ?>) <i
            class="bi bi-people"> </i></h4>
    <br>
    <div class="contact-info-section margin-40px-tb">
        <ul id="attendees" class="list-style9 no-margin">
            <?php foreach($json["attendees"] as $attendee) {?>
            <li>
                <div class="row">
                    <input type="hidden" val="<?= $attendee['id']?>">
                    <div class="col-2">
                        <i class=" d-none d-sm-inline bi bi-person-badge"></i>
                        <strong class="d-sm-inline margin-10px-left">Name:</strong>
                    </div>
                    <div class="col-3">
                        <p><?= $attendee['name']?></p>
                    </div>
                    <div class="col-2">
                        <i class=" d-none d-sm-inline bi bi-building text-green"></i>
                        <strong class="d-sm-inline margin-10px-left">Room:</strong>
                    </div>
                    <div class="col-2">
                        <p><?= $attendee['room']==''?'-' : $attendee['room'] ?></p>
                    </div>
                   
                    <div class="col-3">
                        <p class="<?php switch ($attendee['eventStatus']) {
                            case 'Active':
                               echo "text-green";
                                break;
                            case 'Passive':
                                 echo "text-yellow";
                                 break;
                            case 'Declined':
                                 echo "text-orange";
                                 break;
                            default:
                                  echo "text-black";
                                break;
                        }     ?>">
                            <strong>
                                
                            <?php switch ($attendee['eventStatus']) {
                            case 'Active':
                                echo "<i class='bi bi-calendar2-check'></i>";
                                break;
                            case 'Passive':
                                echo "<i class='bi bi-calendar2-check'></i>";
                                 break;
                            case 'Declined':
                                 echo "<i class='bi bi-calendar-x'></i>";
                                 break;
                            default:
                            echo "<i class='bi bi-calendar'></i>";
                                break;
                        }     ?>
                            
                            <?= $attendee['eventStatus'] ?></strong>
                           
                    </div>
                </div>
            </li>
            <?php } ?>
        </ul>
    </div>

</div>