<?php

function sw_starship_options_mb($post)
{
    $starship = new Starwars\WP\Plugin\Entity\Starship();
    $starship->generate_from_meta($post->ID, 'starship_info');
    ?>
    <div class="form-group">
        <label>Name</label>
        <input readonly="readonly" type="text" class="form-control"
               value="<?php echo $starship->get_name(); ?>">
    </div>
    <div class="form-group">
        <label>Model</label>
        <input readonly="readonly" type="text" class="form-control"
               value="<?php echo $starship->get_model(); ?>">
    </div>
    <div class="form-group">
        <label>Manufacturer</label>
        <input readonly="readonly" type="text" class="form-control"
               value="<?php echo $starship->get_manufacturer(); ?>">
    </div>
    <div class="form-group">
        <label>Cost in credits</label>
        <input readonly="readonly" type="text" class="form-control"
               value="<?php echo $starship->get_cost_in_credits(); ?>">
    </div>
    <div class="form-group">
        <label>Length</label>
        <input readonly="readonly" type="text" class="form-control"
               value="<?php echo $starship->get_length(); ?>">
    </div>
    <div class="form-group">
        <label>Max atmosphering speed</label>
        <input readonly="readonly" type="text" class="form-control"
               value="<?php echo $starship->get_max_atmosphering_speed(); ?>">
    </div>
    <div class="form-group">
        <label>Crew</label>
        <input readonly="readonly" type="text" class="form-control"
               value="<?php echo $starship->get_crew(); ?>">
    </div>
    <div class="form-group">
        <label>Passengers</label>
        <input readonly="readonly" type="text" class="form-control"
               value="<?php echo $starship->get_passengers(); ?>">
    </div>
    <div class="form-group">
        <label>Cargo capacity</label>
        <input readonly="readonly" type="text" class="form-control"
               value="<?php echo $starship->get_cargo_capacity(); ?>">
    </div>
    <div class="form-group">
        <label>Hyperdrive rating</label>
        <input readonly="readonly" type="text" class="form-control"
               value="<?php echo $starship->get_hyperdrive_rating(); ?>">
    </div>
    <div class="form-group">
        <label>MGLT</label>
        <input readonly="readonly" type="text" class="form-control"
               value="<?php echo $starship->get_mglt(); ?>">
    </div>
    <div class="form-group">
        <label>Class</label>
        <input readonly="readonly" type="text" class="form-control"
               value="<?php echo $starship->get_class(); ?>">
    </div>
    <?php
}
