<?php if ( isset($contents) && !empty($contents) ): ?>
  <?php foreach ($contents as $content): ?>
    <?php //echo $content['name']; ?>
    <?php echo $content['description']; ?>
  <?php endforeach; ?>
<?php else: ?>
  <?php echo $page->description; ?>
<?php endif; ?>