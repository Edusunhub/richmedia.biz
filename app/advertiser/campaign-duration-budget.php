<?php
if(isset($_REQUEST['token'])){
  $camdata=$this->getAllCampaignsByEncriptGroupId($_REQUEST['token']); 
}
$camp=$this->getCampaignByIdEncript($_REQUEST['token']);
if(isset($_POST['testpost'])){
    //print_r($_POST);
}
?>
<section class="content">
  <div class="white-wapper">
    <div class="white-layer">
      <h4 class="white-layer-title"><?php echo $_REQUEST['type'] ?> - Campaign Details</h4>
      <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
          <div class="stepwizard-step col-xs-2">
            <?php if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])) { ?>
              <a type="button" class="btn btn-di btn-circle" disabled="disabled">1</a>
            <?php } else{ ?>
                <a type="button" href="?step=1&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">1</a>
            <?php } ?>            
            <p><small>Campaign Details</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <?php if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])) { ?>
              <a type="button" class="btn btn-di btn-circle" disabled="disabled">2</a>
            <?php } else{ ?>
                <a type="button" href="?step=2&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">2</a>
            <?php } ?>            
            <p><small>Targeting</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <?php if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])) { ?>
              <a type="button" class="btn btn-di btn-circle" disabled="disabled">3</a>
            <?php } else{ ?>
                <a type="button" href="?step=3&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">3</a>
            <?php } ?>            
            <p><small>Campaign Type</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <?php if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])) { ?>
              <a type="button" class="btn btn-di btn-circle" disabled="disabled">4</a>
            <?php } else{ ?>
                <a type="button" href="?step=5&type=<?php echo $_REQUEST['type'] ?>&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">4</a>
            <?php } ?>     
            <p><small>Creative Details</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <?php if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])) { ?>
              <a type="button" class="btn btn-di btn-circle" disabled="disabled">5</a>
            <?php } else{ ?>
                <a type="button" href="?step=6&type=<?php echo $_REQUEST['type'] ?>&model=<?php echo $_REQUEST['model'] ?>&token=<?php echo $_REQUEST['token'] ?>" class="btn btn-default btn-circle">5</a>
            <?php } ?>            
            <p><small>Pricing</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" class="active btn btn-default btn-circle">6</a>
            <p><small>Scheduling</small></p>
          </div>
          <div class="stepwizard-step col-xs-2">
            <a type="button" class="btn btn-di btn-circle" disabled="disabled">7</a>
            <p><small>Payment</small></p>
          </div>
        </div>
      </div>
      <form method="post" enctype="multipart/form-data" class="theme-fields-form">
        <div class="row">
          <div class="col-md-6">
            <div class="white-box pt-5 pl-5 pr-5">
              <h4 class="white-box-sub-titile">Duration:</h4>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-4 control-label required-field">Start and End Date: </label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control pull-right" id="reservation" value="<?php if($camp['startdate']!='') { echo $camp['startdate'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.$camp['enddate']; }?>" autocomplete="off" required>
                    <input type="hidden" class="form-control" name="start_date" id="start-datepicker" autocomplete="off" value="<?php echo $camp['startdate']; ?>" required>
                    <input type="hidden" class="form-control enddatepicker" name="end_date" id="end-datepicker" autocomplete="off" value="<?php echo $camp['enddate']; ?>" required>
                    <p><small>Time Zone – UTC</small></p>
                  </div>
                </div>
              </div>
              <h4 class="white-box-sub-titile">Schedule:</h4>
              <table class="table" align="center">
                <thead>
                  <tr>
                    <th width="20%">Days</th>
                    <th class="text-center">Schedule Hours</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>Mon</th>
                    <td class="text-center">
                      <div class="time-select">
                        <select class="hour-select" name="time[mon][start][hour]">
                        <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->mon->start->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[mon][start][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->mon->start->minute; ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                        <small>to</small>
                        <select class="hour-select" name="time[mon][end][hour]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->mon->end->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[mon][end][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->mon->end->minute; ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th>Tue</th>
                    <td class="text-center">
                      <div class="time-select">
                        <select class="hour-select" name="time[tue][start][hour]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->tue->start->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[tue][start][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->tue->start->minute; ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                        <small>to</small>
                        <select class="hour-select" name="time[tue][end][hour]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->tue->end->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[tue][end][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->tue->end->minute; ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th>Wed</th>
                    <td class="text-center">
                      <div class="time-select">
                        <select class="hour-select" name="time[wed][start][hour]">
                        <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->wed->start->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[wed][start][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->wed->start->minute; ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                        <small>to</small>
                        <select class="hour-select" name="time[wed][end][hour]">
                        <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->wed->end->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[wed][end][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->wed->end->minute; ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th>Thu</th>
                    <td class="text-center">
                      <div class="time-select">
                        <select class="hour-select" name="time[thu][start][hour]">
                        <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->thu->start->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[thu][start][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->thu->start->minute; ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                        <small>to</small>
                        <select class="hour-select" name="time[thu][end][hour]">
                        <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->thu->end->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[thu][end][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->thu->end->minute; ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th>Fri</th>
                    <td class="text-center">
                      <div class="time-select">
                        <select class="hour-select" name="time[fri][start][hour]">
                        <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->fri->start->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[fri][start][minute]">
                        <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->fri->start->minute; ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                        <small>to</small>
                        <select class="hour-select" name="time[fri][end][hour]">
                        <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->fri->end->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[fri][end][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->fri->end->minute; ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th>Sat</th>
                    <td class="text-center">
                      <div class="time-select">
                        <select class="hour-select" name="time[sat][start][hour]">
                        <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->sat->start->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[sat][start][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->sat->start->minute; ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                        <small>to</small>
                        <select class="hour-select" name="time[sat][end][hour]">
                        <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->sat->end->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[sat][end][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->sat->end->minute; ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                  <tr>
                    <th>Sun</th>
                    <td class="text-center">
                      <div class="time-select">
                        <select class="hour-select" name="time[sun][start][hour]">
                        <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->sun->start->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[sun][start][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->sun->start->minute ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                        <small>to</small>
                        <select class="hour-select" name="time[sun][end][hour]">
                        <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->sun->end->hour;
                            for($i=0; $i<=23;$i++){
                        ?>
                                <option value="<?php echo $i ?>" <?php echo $j==$i ? 'selected' : '' ?>><?php echo $i ?></option>
                        <?php
                            }
                        ?>
                        </select> : 
                        <select class="minute-select" name="time[sun][end][minute]">
                          <?php 
                            $schedule_time=json_decode($camp['schedule_time']);
                            $j=$schedule_time->sun->end->minute ?>
                            <option value="00" <?php echo $j==00 ? 'selected' : '' ?>>00</option>
                            <option value="30" <?php echo $j==30 ? 'selected' : '' ?>>30</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                </tbody>              
              </table>
            </div>
          </div>
          <div class="col-md-6">
            <div class="white-box pt-5 pl-5 pr-5">
              <h4 class="white-box-sub-titile">Budget:</h4>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-5 control-label required-field">Total Campaign Budget: <small>(USD)</small></label>
                  <div class="col-sm-7">
                    <input type="number" min="100" id="total_budget" <?php if($_REQUEST['token']&&$_REQUEST['edit']){ echo 'disabled style="color:#000;"'; }else{ echo ''; } ?> value="<?php echo $camp['total_budget'];  ?>" class="magicsearch form-control" name="total_budget" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-5 control-label required-field">Daily Amount: <small>(USD)</small></label>
                  <div class="col-sm-7">
                    <input type="number" min="50" id="daily_amount"  value="<?php echo $camp['daily_amount'];  ?>" class="magicsearch form-control" name="daily_amount" required>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <label class="col-sm-5 control-label">Frequency cap 24 hours:</label>
                  <div class="col-sm-7">
                    <input type="text" class="form-control" value="<?php echo $camp['cap'];  ?>" name="cap" id="frequency_cap">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <br/>
          <div class="col-sm-12">
            <input type="hidden" name="step" value="7">
            <input type="hidden" name="type" value="<?php echo $_REQUEST['type']; ?>">
            <input type="hidden" name="typeid"  value="1">
            <input type="submit" value="Next" name="save" class="btn btn-warning pull-right"><?php if(isset($_REQUEST['renew']) && !empty($_REQUEST['renew'])) { ?>
              
            <?php } else{ ?>
                <a class="btn btn-warning pull-left" href="<?php echo baseurl ?>/advertiser/new-campaign.php?step=6&type=<?php echo $_REQUEST['type'] ?>&model=<?php echo $_REQUEST['model'] ?>&token=<?php echo $_REQUEST['token'] ?><?php echo $_REQUEST['edit'] ? '&edit='.$_REQUEST['edit'] : '' ?>">Back</a>
            <?php } ?>            
          </div>
        </div>
      </form>
    </div>
  </div>
</section>