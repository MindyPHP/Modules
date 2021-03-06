<h2>Uses Details</h2>
<?php foreach($view->uses as $property): ?>
<div class="detailHeader" id="<?php echo $property->name.'-detail'; ?>">
<?php echo $property->name; ?>
<span class="detailHeaderTag">
variable
<?php if(!empty($property->since)): ?>
 (available since v<?php echo $property->since; ?>)
<?php endif; ?>
</span>
</div>

<div class="signature">
<?php echo $this->renderPropertySignature($property); ?>
</div>

<p><?php echo $property->description; ?></p>

<?php echo $this->renderPartial('seeAlso',array('object'=>$property)); ?>

<?php endforeach; ?>
