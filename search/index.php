<?php
$pageTitle = __('Search') . ' ' . __('(%s total)', $total_results);
echo head(array('title' => $pageTitle, 'bodyclass' => 'search'));
$searchRecordTypes = get_search_record_types();
?>
<h1><?php echo $pageTitle; ?></h1>
<?php echo search_filters(); ?>
<?php if ($total_results): ?>
<?php echo pagination_links(); ?>

<table id="search-results">
    <!--<thead>
        <tr>-->
            <!--<th><?php echo __('Record Type');?></th>-->
            <!--<th>Collection</th>
            <th><?php echo __('Title');?></th>
        </tr>
    </thead>-->
<br/>
    <tbody>
        <?php $filter = new Zend_Filter_Word_CamelCaseToDash; ?>
        <?php foreach (loop('search_texts') as $searchText): ?>
        <?php $record = get_record_by_id($searchText['record_type'], $searchText['record_id']); ?>
        <?php $recordType = $searchText['record_type']; ?>
        <?php set_current_record($recordType, $record); ?>
        <tr class="<?php echo strtolower($filter->filter($recordType)); ?>">
            <!--<td>
                <?php echo $searchRecordTypes[$recordType]; ?>
            </td>-->
<td>
<?php 
if ('Item' === $recordType): ?>
                <?php if ($recordImage = record_image($recordType, 'square_thumbnail')): ?>
                    <?php echo link_to($record, 'show', $recordImage, array('class' => 'image')); ?>
                <?php endif; ?>
<h4>Interview:</h4><br/><h2><a href="<?php echo record_url($record, 'show'); ?>"><?php echo $searchText['title'] ? $searchText['title'] : '[Unknown]'; ?></a></h2><h3><?php echo link_to_collection_for_item(); ?></h3><br/>
<?php endif; ?>
<?php
if ('Collection' === $recordType): ?>
                <?php if ($recordImage = record_image($recordType, 'square_thumbnail')): ?>
                    <?php echo link_to($record, 'show', $recordImage, array('class' => 'image')); ?>
                <?php endif; ?>
<h4>Project:</h4><h2><a href="<?php echo record_url($record, 'show'); ?>"><?php echo $searchText['title'] ? $searchText['title'] : '[Unknown]'; ?></a></h2><br/><br/>
<?php endif; ?>
</td>
            <!--<td>
                <?php if ($recordImage = record_image($recordType, 'square_thumbnail')): ?>
                    <?php echo link_to($record, 'show', $recordImage, array('class' => 'image')); ?>
                <?php endif; ?>
                
                <h4><a href="<?php echo record_url($record, 'show'); ?>"><?php echo $searchText['title'] ? $searchText['title'] : '[Unknown]'; ?></a></h4>
            </td>-->
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php echo pagination_links(); ?>
<?php else: ?>
<div id="no-results">
    <p><?php echo __('Your query returned no results.');?></p>
</div>
<?php endif; ?>
<?php echo foot(); ?>
