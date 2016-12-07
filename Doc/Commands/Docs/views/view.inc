<h1><?php echo $view->sourcePath; ?></h1>
<div id="nav">
{{index|All Packages}}
<?php if(!empty($view->uses)): ?>
| <a href="#uses">Uses</a>
<?php endif; ?>
</div>
<?php echo $this->renderPartial('viewSummary',array('view'=>$view)); ?>

<a name="uses"></a>
<?php echo $this->renderPartial('usesSummary',array('view'=>$view)); ?>
<?php echo $this->renderPartial('usesDetails',array('view'=>$view)); ?>