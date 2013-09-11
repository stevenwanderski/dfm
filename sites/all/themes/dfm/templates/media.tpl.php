<div id="main">
  <section id="videos">
    <h2>videos</h2>
    <?php if(count($videos) == 0): ?>
      <h3>coming soon!</h3>
    <?php else: ?>
    <ul>
    <?php foreach($video_images as $nid => $video_image): ?>
      <li>
        <a href="#video-<?php print $nid; ?>"><?php print $video_image; ?></a>
      </li>
    <?php endforeach; ?>
    </ul>
    <div class="clear"></div>
    <?php endif; ?>
  </section>

  <section id="pics">
    <h2>pix</h2>
    <?php if(count($images) == 0): ?>
      <h3>coming soon!</h3>
    <?php else: ?>
    <ul>
    <?php foreach($images as $image): ?>
      <li>
        <a href="<?php print image_style_url('pic_full', $image->field_field_image[0]['raw']['uri']) ?>" rel="gallery"><?php print render($image->field_field_image); ?></a>
      </li>
    <?php endforeach; ?>
    </ul>
    <div class="clear"></div>
    <?php endif; ?>
  </section>

  <section id="tunes">
    <h2>free tunes</h2>
    <?php if(count($downloads) == 0): ?>
      <h3>coming soon!</h3>
    <?php else: ?>
    <ul>
    <?php foreach($downloads as $download): ?>
      <li>
        <h3><?php print $download->node_title ?> - <a href="<?php print file_create_url($download->field_field_file[0]['raw']['uri']) ?>">download now</a></h3>
        <div class="music-file-desc"><?php print render($download->field_field_description); ?></div>
      </li>
    <?php endforeach; ?>
    </ul>
    <?php endif; ?>
  </section>
</div><!-- end main -->

<div style="display:none;">
  <?php if(count($videos) > 0): ?>
    <?php foreach($videos as $video): ?>
      <div id="video-<?php print render($video->nid); ?>">
        <?php print render($video->field_field_video); ?>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</div>