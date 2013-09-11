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
    <a class="view-more" href="/shows/">view all shows &rarr;</a>
    <?php endif; ?>
  </section>
</section>

<div id="right">
  <section id="music">
    <h2>music</h2>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
    <div id="player-holder"></div>

    <script type="text/javascript">
      var options = {};
      options.playlistXmlPath = '/playlist';

      var params = {};
      params.allowScriptAccess = "always";

      swfobject.embedSWF("/sites/all/themes/dfm/player/OriginalMusicPlayerPlaylist.swf", "player-holder", "450", "250", "9.0.0",false, options, params, {});
    </script>

  </section>

  <section id="news">
    <h2>check this out...</h2>
    <?php if(count($news) == 0): ?>
      <h3>coming soon!</h3>
    <?php else: ?>
    <ul>
      <?php foreach($news as $news_item): ?>
        <li><?php print render($news_item->field_body); ?></li>
      <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </section>
</div><!-- end right -->
<div class="clear"></div>


<section id="bio">
  <div class="inner">
    <?php print render($homepage['field_top']); ?>
    <div class="bio-image"><?php print render($homepage['field_image']); ?></div>
    <?php print render($homepage['field_bottom']); ?>
  </div><!-- end inner -->
</section>
