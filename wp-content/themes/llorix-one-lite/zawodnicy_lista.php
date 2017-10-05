<div>
    <section style="background-image: url('<?php echo get_template_directory_uri()?>/images/tlo.jpg')" id="timer" data-time="<?php echo $startTimeString; ?>">
        <div class="container">
            <div class="row">
                <div class="timer col-xs-12 col-md-8">
                    <div class="timeBlock">
                        <span class="days value"><?php echo $days; ?></span>
                        <span class="days text"><?php _e('dni');?></span>
                    </div>
                    <div class="separator"></div>
                    <div class="timeBlock">
                        <span class="hours value"><?php echo $hours; ?></span>
                        <span class="hours text"><?php _e('godzin');?></span>
                    </div>
                    <div class="separator"></div>
                    <div class="timeBlock">
                        <span class="minuts value"><?php echo $mins; ?></span>
                        <span class="minuts text"><?php _e('minut');?></span>
                    </div>
                    <div class="separator"></div>
                    <div class="timeBlock">
                        <span class="seconds value"><?php echo $secs; ?></span>
                        <span class="seconds text"><?php _e('sekund');?></span>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <h2>Pozostało </br>do turnieju</h2>
                </div>
            </div>
        </div>
    </section>
</div>