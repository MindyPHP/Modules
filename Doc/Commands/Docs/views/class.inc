<h1><?php echo $class->name; ?></h1>
<div id="nav">
    {{index|All Packages}}
    <?php if (!empty($class->properties)): ?>
        | <a href="#properties">Properties</a>
    <?php endif; ?>
    <?php if (!empty($class->methods)): ?>
        | <a href="#methods">Methods</a>
    <?php endif; ?>
    <?php if (!empty($class->events)): ?>
        | <a href="#events">Events</a>
    <?php endif; ?>
</div>

<?php echo $this->renderPartial('classSummary', array('class' => $class)); ?>

<a name="properties"></a>
<?php echo $this->renderPartial('propertySummary', array('class' => $class, 'protected' => false)); ?>
<?php echo $this->renderPartial('propertySummary', array('class' => $class, 'protected' => true)); ?>

<a name="methods"></a>
<?php echo $this->renderPartial('methodSummary', array('class' => $class, 'protected' => false)); ?>
<?php echo $this->renderPartial('methodSummary', array('class' => $class, 'protected' => true)); ?>

<a name="events"></a>
<?php echo $this->renderPartial('eventSummary', array('class' => $class)); ?>

<?php echo $this->renderPartial('propertyDetails', array('class' => $class)); ?>
<?php echo $this->renderPartial('methodDetails', array('class' => $class)); ?>
