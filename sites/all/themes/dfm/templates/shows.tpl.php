<section id="main">
  <section id="shows">
    <h2>upcoming shows</h2>
    <?php if(count($shows) == 0): ?>
      <h3>coming soon!</h3>
    <?php else: ?>
    <ul>
    <?php foreach($shows as $show): ?>
      <li>
        <span class="show-date"><?php print strip_tags(render($show->field_field_date)); ?> :: <?php print render($show->field_field_time); ?></span>
        <span class="show-venue-name"><?php print $show->node_field_data_field_venue_title; ?></span>
        <span class="show-venue-add1"><?php print render($show->field_field_address_1); ?></span>
        <?php if($show->field_field_address_2): ?>
          <span class="show-venue-add2"><?php print render($show->field_field_address_2); ?></span>
        <?php endif; ?>
        <span class="show-venue-city-state-zip"><?php print render($show->field_field_city); ?>, <?php print render($show->field_field_state); ?> <?php print render($show->field_field_zip); ?></span>
        <?php if($show->field_field_url): ?>
          <span class="show-venue-url"><a href="<?php print render($show->field_field_url); ?>" target="_blank"><?php print render($show->field_field_url); ?></a></span>
        <?php endif; ?>
      </li>
    <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </section>
  <div class="clear"></div>
</section>