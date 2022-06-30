<?php
/**
 * @var $fields
 */

use GutenbergSidebar\views\MetaboxView; ?>

<div class="gs-options">
	<?php foreach ($fields as $key => $config):
		$output = MetaboxView::getConditionForItem($config);
		$show = !$config['show'] ? 'style="display: none;"' : ''; ?>
        <div class="gs-option" <?php echo $show, $output; ?> id="<?php echo $key; ?>">
            <div class="gs-option-label">
				<?php echo $config['label']; ?>
            </div>
            <div class="gs-option-controls">
				<?php echo MetaboxView::renderOptionControls($key, $config); ?>
            </div>
        </div>
	<?php endforeach; ?>

</div>

